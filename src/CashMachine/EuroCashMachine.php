<?php

namespace App\CashMachine;

use App\CashMachine\Base\BaseCashMachine;
use App\CashMachine\Exception\CannotChangeException;
use App\CashMachine\Manager\CashMachineManager;
use App\CashMachine\Model\ChangeEnvelope;
use App\CashMachine\Model\Currency;
use App\Interface\CashMachineInterface;

class EuroCashMachine extends BaseCashMachine implements CashMachineInterface
{

    /**
     * @var array<float>
     */
    private array $eurosCash = [
        500,
        200,
        20,
        5,
        2,
        1,
        0.50,
        0.20,
        0.02,
        0.01,
    ];


    /**
     *
     */
    public function __construct(CashMachineManager $cashMachineManager)
    {
        parent::__construct($cashMachineManager);
        $this->currency = new Currency(
            'EUR',
            '€'
        );
    }

    /**
     * @return Currency
     */
    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    /**
     * @param float $amount
     * @return ChangeEnvelope
     */
    public function getChangeEnveloppe(float $amount): ChangeEnvelope
    {
        if ($amount >= 0 && !preg_match('/\.\d{3,}/', strval($amount))) {
            $amount = round($amount, 2);
            $changes = $this->cashMachineManager->getChange($this->eurosCash, $amount);
            $changeEnvelop = new ChangeEnvelope($changes);
        } else {
            throw new CannotChangeException();
        }

        return $changeEnvelop;
    }
}
