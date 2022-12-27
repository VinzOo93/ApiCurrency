<?php

namespace App\CashMachine;

use App\CashMachine\Base\BaseCashMachine;
use App\CashMachine\Exception\CannotChangeException;
use App\CashMachine\Manager\CashMachineManager;
use App\CashMachine\Model\ChangeEnvelope;
use App\CashMachine\Model\Currency;
use App\Interface\CashMachineInterface;

class YenCashMachine extends BaseCashMachine implements CashMachineInterface
{
    /**
     * @var array|int[]
     */
    private array $yenCash = [
                10000,
                2000,
                1000,
                500,
                100,
                10,
                1
            ];

    /**
     *
     */
    public function __construct(CashMachineManager $cashMachineManager)
    {
        parent::__construct($cashMachineManager);
        $this->currency = new Currency(
            'JPY',
            '¥'
        );
    }

    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    public function getChangeEnveloppe(float $amount): ChangeEnvelope
    {
        if ($amount >= 0  && !strpos(strval($amount), '.')) {
            $amount = round($amount, 2);
            $changes = $this->cashMachineManager->getChange($this->yenCash, $amount);
            $changeEnvelop = new ChangeEnvelope($changes);
        } else {
            throw new CannotChangeException();
        }

        return $changeEnvelop;
    }
}
