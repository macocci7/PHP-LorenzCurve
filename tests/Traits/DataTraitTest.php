<?php   // phpcs:ignore

declare(strict_types=1);

namespace Macocci7\PhpLorenzCurve\Traits;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Macocci7\PhpFrequencyTable\FrequencyTable;
use Macocci7\PhpLorenzCurve\Traits\DataTrait;
use Nette\Neon\Neon;

final class DataTraitTest extends TestCase
{
    // phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps
    // phpcs:disable Generic.Files.LineLength.TooLong

    private $epsilon = 0.00001;

    private function isAlmostSame(float|null $a, float|null $b): bool
    {
        return (is_null($a) && is_null($b))
            || abs($a - $b) < $this->epsilon;
    }

    public static function provide_setData_getData_can_work_correctly(): array
    {
        return [
            ['data' => [0]],
            ['data' => [0, 1]],
            ['data' => [0, 1, 2]],
        ];
    }

    #[DataProvider('provide_setData_getData_can_work_correctly')]
    public function test_setData_getData_can_work_correctly(array $data): void
    {
        $o = new class {
            use DataTrait;

            protected FrequencyTable $ft;

            public function __construct()
            {
                $this->ft = new FrequencyTable();
            }
        };
        $this->assertSame($data, $o->setData($data)->getData());
    }

    public static function provide_setClassRange_can_work_correctly(): array
    {
        return [
            [ 'classRange' => 1, ],
            [ 'classRange' => 1.5, ],
            [ 'classRange' => 2, ],
            [ 'classRange' => 2.5, ],
        ];
    }

    #[DataProvider('provide_setClassRange_can_work_correctly')]
    public function test_setClassRange_can_work_correctly(int|float $classRange): void
    {
        $o = new class {
            use DataTrait;

            protected FrequencyTable $ft;

            public function __construct()
            {
                $this->ft = new FrequencyTable();
            }

            public function getClassRange()
            {
                return $this->ft->getClassRange();
            }
        };
        $this->assertSame(
            $classRange,
            $o->setClassRange($classRange)->getClassRange()
        );
    }

    public static function provide_reverseClasses_can_work_correctly(): array
    {
        return [
            [
                'data' => [0],
                'classRange' => 5,
                'expected' => [
                    ['bottom' => 0, 'top' => 5, ],
                ]
            ],
            [
                'data' => [0, 5],
                'classRange' => 5,
                'expected' => [
                    ['bottom' => 5, 'top' => 10, ],
                    ['bottom' => 0, 'top' => 5, ],
                ]
            ],
            [
                'data' => [0, 5, 10],
                'classRange' => 5,
                'expected' => [
                    ['bottom' => 10, 'top' => 15, ],
                    ['bottom' => 5, 'top' => 10, ],
                    ['bottom' => 0, 'top' => 5, ],
                ]
            ],
        ];
    }

    #[DataProvider('provide_reverseClasses_can_work_correctly')]
    public function test_reverseClasses_can_work_correctly(array $data, int|float $classRange, array $expected): void
    {
        $o = new class {
            use DataTrait;

            protected FrequencyTable $ft;

            public function __construct()
            {
                $this->ft = new FrequencyTable();
            }

            public function getClasses()
            {
                return $this->ft->getClasses();
            }
        };
        $this->assertSame(
            $expected,
            $o
                ->setData($data)
                ->setClassRange($classRange)
                ->reverseClasses()
                ->getClasses()
        );
    }

    public static function provide_getPoints_can_work_correctly(): array
    {
        return [
            [
                'data' => [1],
                'classRange' => 5,
                'expected' => [[1, 0], [1, 1]],
            ],
            [
                'data' => [0, 1, 2, ],
                'classRange' => 5,
                'expected' => [[1, 1]],
            ],
            [
                'data' => [0, 5, ],
                'classRange' => 5,
                'expected' => [[0.5, 0], [1.0, 1]],
            ],
        ];
    }

    #[DataProvider('provide_getPoints_can_work_correctly')]
    public function test_getPoints_can_work_correctly(array $data, int|float $classRange, array $expected): void
    {
        $o = new class ($data, $classRange) {
            use DataTrait;

            protected FrequencyTable $ft;

            public function __construct($data, $classRange)
            {
                $this->ft = new FrequencyTable();
                $this->ft->setData($data);
                $this->ft->setClassRange($classRange);
                $this->parsed = $this->ft->parse();
            }
        };
        $this->assertSame(
            $expected,
            $o->getPoints()
        );
    }

    public static function provide_getGinisCoefficient_can_work_correctly(): array
    {
        return [
            [
                'data' => [1],
                'classRange' => 5,
                'expected' => 1.0,
            ],
            [
                'data' => [0, 1, 2, 3, 4, ],
                'classRange' => 5,
                'expected' => 0,
            ],
            [
                'data' => [1, 5, 10, 15, 20, ],
                'classRange' => 5,
                'expected' => 0.37647058823529,
            ],
            [
                'data' => [0, 5 ],
                'classRange' => 5,
                'expected' => 0.5,
            ],
        ];
    }

    #[DataProvider('provide_getGinisCoefficient_can_work_correctly')]
    public function test_getGinisCoefficient_can_work_correctly(array $data, int|float $classRange, int|float $expected): void
    {
        $o = new class ($data, $classRange) {
            use DataTrait;

            protected FrequencyTable $ft;

            public function __construct($data, $classRange)
            {
                $this->ft = new FrequencyTable();
                $this->ft->setData($data);
                $this->ft->setClassRange($classRange);
                $this->parsed = $this->ft->parse();
            }
        };
        $this->assertTrue(
            $this->isAlmostSame(
                $expected,
                $o->getGinisCoefficient()
            )
        );
    }
}
