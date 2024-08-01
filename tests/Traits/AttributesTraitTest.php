<?php   // phpcs:ignore

declare(strict_types=1);

namespace Macocci7\PhpLorenzCurve\Traits;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Macocci7\PhpLorenzCurve\Traits\AttributesTrait;
use Macocci7\PhpLorenzCurve\Traits\JudgeTrait;
use Nette\Neon\Neon;

final class AttributesTraitTest extends TestCase
{
    // phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps
    // phpcs:disable Generic.Files.LineLength.TooLong

    public static function provide_size_can_return_size_correctly(): array
    {
        return [
            ['size' => ['width' => 0, 'height' => 0]],
            ['size' => ['width' => 100, 'height' => 200]],
            ['size' => ['width' => 300, 'height' => 400]],
            ['size' => ['width' => 600, 'height' => 500]],
        ];
    }

    #[DataProvider('provide_size_can_return_size_correctly')]
    public function test_size_can_return_size_correctly(array $size): void
    {
        $o = new class (...$size) {
            use AttributesTrait;
            use JudgeTrait;

            public function __construct($width, $height)
            {
                $this->canvasSize = ['width' => $width, 'height' => $height];
            }
        };
        $this->assertSame($size, $o->size());
    }

    public static function provide_resize_can_resize_correctly(): array
    {
        return [
            [
                'size' => ['width' => 100, 'height' => 200],
                'resize' => ['width' => 50, 'height' => 50],
                'expected' => ['width' => 50, 'height' => 50],
            ],
            [
                'size' => ['width' => 100, 'height' => 200],
                'resize' => ['width' => 200, 'height' => 300],
                'expected' => ['width' => 200, 'height' => 300],
            ],
        ];
    }

    #[DataProvider('provide_resize_can_resize_correctly')]
    public function test_resize_can_resize_correctly(array $size, array $resize, array $expected): void
    {
        $o = new class (...$size) {
            use AttributesTrait;
            use JudgeTrait;

            public function __construct($width, $height)
            {
                $this->canvasSize = ['width' => $width, 'height' => $height];
            }
        };
        $this->assertSame($expected, $o->resize(...$resize)->size());
    }

    public static function provide_plotarea_can_set_plotarea_correctly(): array
    {
        return [
            [
                'plotarea' => [
                    'offset' => [0, 0],
                ],
                'expected' => [
                    'offset' => [0, 0],
                    'backgroundColor' => null,
                ],
            ],
            [
                'plotarea' => [
                    'offset' => [10, 20],
                ],
                'expected' => [
                    'offset' => [10, 20],
                    'backgroundColor' => null,
                ],
            ],
            [
                'plotarea' => [
                    'width' => 200,
                ],
                'expected' => [
                    'width' => 200,
                    'backgroundColor' => null,
                ],
            ],
            [
                'plotarea' => [
                    'height' => 500,
                ],
                'expected' => [
                    'height' => 500,
                    'backgroundColor' => null,
                ],
            ],
            [
                'plotarea' => [
                    'backgroundColor' => '#aabbcc',
                ],
                'expected' => [
                    'backgroundColor' => '#aabbcc',
                ],
            ],
            [
                'plotarea' => [
                    'offset' => [10, 20],
                    'width' => 200,
                ],
                'expected' => [
                    'offset' => [10, 20],
                    'width' => 200,
                    'backgroundColor' => null,
                ],
            ],
            [
                'plotarea' => [
                    'offset' => [10, 20],
                    'height' => 100,
                ],
                'expected' => [
                    'offset' => [10, 20],
                    'height' => 100,
                    'backgroundColor' => null,
                ],
            ],
            [
                'plotarea' => [
                    'offset' => [10, 20],
                    'backgroundColor' => '#aabbcc',
                ],
                'expected' => [
                    'offset' => [10, 20],
                    'backgroundColor' => '#aabbcc',
                ],
            ],
            [
                'plotarea' => [
                    'width' => 100,
                    'height' => 200,
                ],
                'expected' => [
                    'width' => 100,
                    'height' => 200,
                    'backgroundColor' => null,
                ],
            ],
            [
                'plotarea' => [
                    'width' => 100,
                    'backgroundColor' => '#aabbcc',
                ],
                'expected' => [
                    'width' => 100,
                    'backgroundColor' => '#aabbcc',
                ],
            ],
            [
                'plotarea' => [
                    'height' => 100,
                    'backgroundColor' => '#aabbcc',
                ],
                'expected' => [
                    'height' => 100,
                    'backgroundColor' => '#aabbcc',
                ],
            ],
            [
                'plotarea' => [
                    'offset' => [10, 20],
                    'width' => 100,
                    'height' => 200,
                ],
                'expected' => [
                    'offset' => [10, 20],
                    'width' => 100,
                    'height' => 200,
                    'backgroundColor' => null,
                ],
            ],
            [
                'plotarea' => [
                    'offset' => [10, 20],
                    'width' => 100,
                    'backgroundColor' => '#aabbcc',
                ],
                'expected' => [
                    'offset' => [10, 20],
                    'width' => 100,
                    'backgroundColor' => '#aabbcc',
                ],
            ],
            [
                'plotarea' => [
                    'offset' => [10, 20],
                    'height' => 100,
                    'backgroundColor' => '#aabbcc',
                ],
                'expected' => [
                    'offset' => [10, 20],
                    'height' => 100,
                    'backgroundColor' => '#aabbcc',
                ],
            ],
            [
                'plotarea' => [
                    'offset' => [10, 20],
                    'width' => 100,
                    'height' => 200,
                    'backgroundColor' => '#aabbcc',
                ],
                'expected' => [
                    'offset' => [10, 20],
                    'width' => 100,
                    'height' => 200,
                    'backgroundColor' => '#aabbcc',
                ],
            ],
        ];
    }

    #[DataProvider('provide_plotarea_can_set_plotarea_correctly')]
    public function test_plotarea_can_set_plotarea_correctly(array $plotarea, array $expected): void
    {
        $o = new class {
            use AttributesTrait;
            use JudgeTrait;

            public function getPlotarea()
            {
                return $this->plotarea;
            }
        };
        $this->assertSame($expected, $o->plotarea(...$plotarea)->getPlotarea());
    }
}
