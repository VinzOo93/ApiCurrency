<?php

namespace App\CashMachine\Service;

use App\CashMachine\Exception\NotRegisteredException;
use App\CashMachine\Model\Currency;
use App\Interface\CashMachineInterface;
use Exception;
use Traversable;

class CashMachineGenerator
{
    /**
     * @var array<int, array<string>> $currencies
     */
    private array $currencies;

    /**
     * @var CashMachineInterface []
     */
    private array $cashMachines;

    /**
     * @param array<int, array<string>> $currencies
     * @param Traversable<CashMachineInterface> $cashMachines
     */
    public function __construct(array $currencies, Traversable $cashMachines)
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
            throw new NotRegisteredException("$currency cash machine should not have been developed.");
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
        throw new NotRegisteredException("Unable to get $code cash machine from registry.");
    }
}
