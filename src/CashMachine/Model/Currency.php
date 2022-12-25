<?php

declare(strict_types=1);

namespace App\CashMachine\Model;

final class Currency
{
    /**
     * The currency ISO code
     * @var string
     */
    private string $code;

    /**
     * The currency symbol
     * @var string
     */
    private string $symbol;

    /**
     * @param string $code   The currency ISO code
     * @param string $symbol The currency symbol
     */
    public function __construct(string $code, string $symbol)
    {
        $this->code = $code;
        $this->symbol = $symbol;
    }

    /**
     * Fetch this currency code
     *
     * @return string The currency code
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * Fetch this currency symbol
     *
     * @return string The currency symbol
     */
    public function getSymbol(): string
    {
        return $this->symbol;
    }
}
