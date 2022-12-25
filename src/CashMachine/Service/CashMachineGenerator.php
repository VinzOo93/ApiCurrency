<?php

namespace App\CashMachine\Service;

use App\CashMachine\Exception\NotRegistered;
use App\CashMachine\Model\Currency;
use App\Interface\CashMachineInterface;
use Exception;

/**
 *
 */
class CashMachineGenerator
{
    /**
     * @var array
     */
    private array $currencies;

    /**
     * @var CashMachineInterface []
     */
    private array $cashMachines;

    /**
     * @param array $currencies
     * @param iterable $cashMachines
     */
    public function __construct(array $currencies, iterable $cashMachines)
    {
        $this->currencies = $currencies;
        $this->cashMachines = iterator_to_array($cashMachines);
    }

    /**
     * @param string $currency
     * @return Currency
     */
    public function getCashMachinesCurrency(string $currency): Currency
    {
        $currencies = [];
        try {
            foreach ($this->currencies as $currencyArray) {
                $object = new Currency(
                    $currencyArray[0]['code'],
                    $currencyArray[1]['symbol'],
                );
                $currencies[$currencyArray[0]['code']] = $object;
            }
            $item = $currencies[$currency];
        } catch (Exception $exception) {
            throw new NotRegistered("$currency cash machine should not have been developed.");
        }
        return $item;
    }

    /**
     * @param Currency $currency
     * @return CashMachineInterface
     * @throws Exception
     */
    public function getCashMachines(Currency $currency): CashMachineInterface
    {
        $code = $currency->getCode();
        foreach ($this->cashMachines as $cashMachine) {
            if ($cashMachine->getCurrency()->getCode() === $code) {
                return $cashMachine;
            }
        }
        throw new NotRegistered("Unable to get $code cash machine from registry.");
    }
}
