<?php

declare(strict_types=1);

namespace App\Interface;

use App\CashMachine\Exception\CannotChangeException;
use App\CashMachine\Model\ChangeEnvelope;
use App\CashMachine\Model\Currency;

interface CashMachineInterface
{
    /**
     * Fetch this cash machine supported currency.
     *
     * @return Currency The supported currency
     */
    public function getCurrency(): Currency;

    /**
     * Perform change operation.
     *
     * @param float $amount The amount of money to turn into change
     *
     * @return ChangeEnvelope The change envelope
     * @throws CannotChangeException If the amount cannot be refund
     */
    public function getChangeEnveloppe(float $amount): ChangeEnvelope;
}
