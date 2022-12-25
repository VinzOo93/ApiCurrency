<?php

namespace App\CashMachine;

use App\CashMachine\Base\BaseCashMachine;
use App\CashMachine\Model\ChangeEnvelope;
use App\CashMachine\Model\Currency;
use App\Interface\CashMachineInterface;

class EuroCashMachine extends BaseCashMachine implements CashMachineInterface
{
    /**
     */
    public function __construct()
    {
        $this->currency = new Currency(
            'EUR',
            '€'
        );
    }

    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    public function getChange(float $amount): ChangeEnvelope
    {
        // TODO: Implement change() method.
    }
}
