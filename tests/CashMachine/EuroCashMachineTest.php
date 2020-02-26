<?php

declare(strict_types=1);

namespace App\Tests\CashMachine;

use App\CashMachine\EuroCashMachine;
use Generator;

class EuroCashMachineTest extends CashMachineTestCase
{
    public function testCurrency(): void
    {
        $currency = (new EuroCashMachine())->currency();
        self::assertSame('EUR', $currency->code());
        self::assertSame('€', $currency->symbol());
    }

    /**
     * @expectedException \App\CashMachine\Exception\CannotChange
     */
    public function testChangeNegativeAmount(): void
    {
        (new EuroCashMachine())->change(-10);
    }

    /**
     * @expectedException \App\CashMachine\Exception\CannotChange
     */
    public function testChangeImpossibleAmount(): void
    {
        (new EuroCashMachine())->change(0.005);
    }

    /**
     * @dataProvider valid
     */
    public function testChangeValidAmount(float $amount, array $expectations): void
    {
        $envelope = (new EuroCashMachine())->change($amount);
        self::assertEnvelopeContent($expectations, $envelope);
    }

    public function valid(): Generator
    {
        yield 'Valid change of 0€' => [
            0,
            [],
        ];
        yield 'Valid change of 728.93€' => [
            728.93,
            [
                [500, 1],
                [200, 1],
                [20, 1],
                [5, 1],
                [2, 1],
                [1, 1],
                [0.50, 1],
                [0.20, 2],
                [0.02, 1],
                [0.01, 1],
            ],
        ];
    }
}
