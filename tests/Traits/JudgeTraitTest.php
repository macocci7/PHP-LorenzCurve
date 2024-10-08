<?php   // phpcs:ignore

declare(strict_types=1);

namespace Macocci7\PhpLorenzCurve\Traits;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Macocci7\PhpLorenzCurve\Traits\JudgeTrait;
use Nette\Neon\Neon;

final class JudgeTraitTest extends TestCase
{
    // phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps
    // phpcs:disable Generic.Files.LineLength.TooLong

    public static function provide_isNumber_can_judge_correctly(): array
    {
        return [
            [ 'item' => null, 'expect' => false, ],
            [ 'item' => true, 'expect' => false, ],
            [ 'item' => false, 'expect' => false, ],
            [ 'item' => '', 'expect' => false, ],
            [ 'item' => [], 'expect' => false, ],
            [ 'item' => 0, 'expect' => true, ],
            [ 'item' => -100, 'expect' => true, ],
            [ 'item' => 100, 'expect' => true, ],
            [ 'item' => 0.0, 'expect' => true, ],
            [ 'item' => -100.5, 'expect' => true, ],
            [ 'item' => 100.5, 'expect' => true, ],
            [ 'item' => '0', 'expect' => false, ],
            [ 'item' => '-100', 'expect' => false, ],
            [ 'item' => '100', 'expect' => false, ],
            [ 'item' => '0.0', 'expect' => false, ],
            [ 'item' => '-100.5', 'expect' => false, ],
            [ 'item' => '100.5', 'expect' => false, ],
        ];
    }

    #[DataProvider('provide_isNumber_can_judge_correctly')]
    public function test_isNumber_can_judge_correctly(mixed $item, bool $expect): void
    {
        $o = new class {
            use JudgeTrait;
        };
        $this->assertSame($expect, $o->isNumber($item));
    }

    public static function provide_isColorCode_can_judge_correctly(): array
    {
        return [
            ['color' => '', 'expect' => false, ],
            ['color' => 'red', 'expect' => false, ],
            ['color' => 'ffffff', 'expect' => false, ],
            ['color' => '#ff', 'expect' => false, ],
            ['color' => '#00', 'expect' => false, ],
            ['color' => '#ffg', 'expect' => false, ],
            ['color' => '#fff', 'expect' => true, ],
            ['color' => '#000', 'expect' => true, ],
            ['color' => '#ffff', 'expect' => false, ],
            ['color' => '#0000', 'expect' => false, ],
            ['color' => '#fffff', 'expect' => false, ],
            ['color' => '#00000', 'expect' => false, ],
            ['color' => '#fffffg', 'expect' => false, ],
            ['color' => '#ffffff', 'expect' => true, ],
            ['color' => '#000000', 'expect' => true, ],
            ['color' => '#f0f0f0', 'expect' => true, ],
            ['color' => '#0f0f0f', 'expect' => true, ],
            ['color' => '#fffffff', 'expect' => false, ],
            ['color' => '#0000000', 'expect' => false, ],
        ];
    }

    #[DataProvider('provide_isColorCode_can_judge_correctly')]
    public function test_isColorCode_can_judge_correctly(string $color, bool $expect): void
    {
        $o = new class {
            use JudgeTrait;
        };
        $this->assertSame($expect, $o->isColorCode($color));
    }
}
