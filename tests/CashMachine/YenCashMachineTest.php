<?php

declare(strict_types=1);

namespace App\Tests\CashMachine;

use App\CashMachine\YenCashMachine;
use Generator;

class YenCashMachineTest extends CashMachineTestCase
{
    public function testCurrency(): void
    {
        $currency = (new YenCashMachine())->currency();
        self::assertSame('JPY', $currency->code());
        self::assertSame('¥', $currency->symbol());
    }

    /**
     * @expectedException \App\CashMachine\Exception\CannotChange
     */
    public function testChangeNegativeAmount(): void
    {
        (new YenCashMachine())->change(-10);
    }

    /**
     * @expectedException \App\CashMachine\Exception\CannotChange
     */
    public function testChangeImpossibleAmount(): void
    {
        (new YenCashMachine())->change(0.5);
    }

    /**
     * @dataProvider valid
     */
    public function testChangeValidAmount(float $amount, array $expectations): void
    {
        $envelope = (new YenCashMachine())->change($amount);
        self::assertEnvelopeContent($expectations, $envelope);
    }

    public function valid(): Generator
    {
        yield 'Valid change of 0¥' => [
            0,
            [],
        ];
        yield 'Valid change of 13 843¥' => [
            13843,
            [
                [10000, 1],
                [2000, 1],
                [1000, 1],
                [500, 1],
                [100, 3],
                [10, 4],
                [1, 3],
            ],
        ];
    }
}
