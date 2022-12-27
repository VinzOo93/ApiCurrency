<?php

declare(strict_types=1);

namespace App\Tests\CashMachine;

use App\CashMachine\Exception\CannotChangeException;
use Generator;

class YenCashMachineTest extends CashMachineTestCase
{
    public function testCurrency(): void
    {
        $machine = $this->getCashMachine('JPY');
        $currency = $machine->getCurrency();
        self::assertSame('JPY', $currency->getCode());
        self::assertSame('¥', $currency->getSymbol());
    }

    public function testChangeNegativeAmount(): void
    {
        $this->expectException(CannotChangeException::class);

        $this->getCashMachine('JPY')->getChangeEnveloppe(-10);
    }

    public function testChangeImpossibleAmount(): void
    {
        $this->expectException(CannotChangeException::class);

        $this->getCashMachine('JPY')->getChangeEnveloppe(0.5);
    }

    /**
     * @dataProvider valid
     */
    public function testChangeValidAmount(float $amount, array $expectations): void
    {
        $envelope = $this->getCashMachine('JPY')->getChangeEnveloppe($amount);
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
