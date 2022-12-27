<?php

namespace App\CashMachine\Manager;

use App\CashMachine\Model\Change;

class CashMachineManager
{
    /**
     * @var int
     */
    private int $quantity = 0;

    /**
     * @param array<float> $currencyCash
     * @param float $amount
     * @return array<int, Change>
     */
    public function getChange(array $currencyCash, float $amount): array
    {
        $changes = [];
        if ($amount > 0) {
            foreach ($currencyCash as $cash) {
                while ($amount >= 0 && $amount - $cash >= 0) {
                    $this->quantity++;
                    $amount = round($amount - $cash, 2);
                }
                $changes[] = new Change($cash, $this->quantity);
                $this->quantity = 0;
            }
        }
        return $changes;
    }
}
