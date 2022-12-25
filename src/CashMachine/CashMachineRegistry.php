<?php

namespace App\CashMachine;

use Symfony\Component\DependencyInjection\Container;
use App\CashMachine\Model\Currency;
use App\CashMachine\Service\CashMachineGenerator;
use App\Interface\CashMachineInterface;
use App\Interface\CashMachineRegistryInterface;

class CashMachineRegistry implements CashMachineRegistryInterface
{
    private CashMachineGenerator $cacheMachineGenerator;
    private Currency $currency;

    /**
     * @param CashMachineGenerator $cacheMachineGenerator
     * @param Currency $currency
     */
    public function __construct(CashMachineGenerator $cacheMachineGenerator, Currency $currency)
    {
        $this->cacheMachineGenerator = $cacheMachineGenerator;
        $this->currency = $currency;
    }


    /**
     * @throws \Exception
     */
    public function get(string $currency): CashMachineInterface
    {
        $this->currency = $this->cacheMachineGenerator->getCashMachinesCurrency($currency);
        $this->cacheMachineGenerator->getCashMachines($this->currency);

        return $this->cacheMachineGenerator->getCashMachines($this->currency);
    }
}
