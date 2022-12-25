<?php

namespace App\CashMachine;

use App\CashMachine\Base\BaseCashMachine;
use App\CashMachine\Model\ChangeEnvelope;
use App\CashMachine\Model\Currency;
use App\Interface\CashMachineInterface;

class YenCashMachine extends BaseCashMachine implements CashMachineInterface
{
    /**
     */
    public function __construct()
    {
        $this->currency = new Currency(
            'JPY',
            '¥'
        );
    }

    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    public function getChange(float $amount): ChangeEnvelope
    {
        // TODO: Implement getChange() method.
    }
}
