<?php

declare(strict_types=1);

namespace App\Tests\CashMachine;

use App\CashMachine\Exception\CannotChangeException;
use Generator;

class EuroCashMachineTest extends CashMachineTestCase
{
    public function testCurrency(): void
    {
        $machine = $this->getCashMachine('EUR');
        $currency = $machine->getCurrency();
        self::assertSame('EUR', $currency->getCode());
        self::assertSame('€', $currency->getSymbol());
    }

    public function testChangeNegativeAmount(): void
    {
        $this->expectException(CannotChangeException::class);

        $this->getCashMachine('EUR')->getChangeEnveloppe(-10);
    }

    public function testChangeImpossibleAmount(): void
    {
        $this->expectException(CannotChangeException::class);

        $this->getCashMachine('EUR')->getChangeEnveloppe(0.005);
    }

    /**
     * @dataProvider valid
     */
    public function testChangeValidAmount(float $amount, array $expectations): void
    {
        $envelope = $this->getCashMachine('EUR')->getChangeEnveloppe($amount);
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
