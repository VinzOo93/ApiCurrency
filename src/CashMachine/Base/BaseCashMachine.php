<?php

namespace App\CashMachine\Base;

use App\CashMachine\Model\Currency;
use App\Interface\CashMachineInterface;

abstract class BaseCashMachine implements CashMachineInterface
{
    protected Currency $currency;
}
