<?php

namespace App\CashMachine\Base;

use App\CashMachine\Manager\CashMachineManager;
use App\CashMachine\Model\Currency;
use App\Interface\CashMachineInterface;

abstract class BaseCashMachine implements CashMachineInterface
{
    protected Currency $currency;

    protected CashMachineManager $cashMachineManager;

    /**
     * @param CashMachineManager $cashMachineManager
     */
    public function __construct(CashMachineManager $cashMachineManager)
    {
        $this->cashMachineManager = $cashMachineManager;
    }
}
