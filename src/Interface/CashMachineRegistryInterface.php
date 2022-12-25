<?php

declare(strict_types=1);

namespace App\Interface;

use App\CashMachine\Exception\NotRegistered;

interface CashMachineRegistryInterface
{
    /**
     * Get a cash machine from this registry.
     *
     * @param string $currency The currency code
     *
     * @return CashMachineInterface The cash machine object
     * @throws NotRegistered If this cash machine name have not been registered yet.
     */
    public function get(string $currency): CashMachineInterface;
}
