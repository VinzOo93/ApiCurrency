<?php

declare(strict_types=1);

namespace App\CashMachine\Model;

use InvalidArgumentException;

final class ChangeEnvelope
{
    /**
     * The envelope content
     * @var Change[]
     */
    private array $change;

    /**
     * @param Change[] $change The envelope content
     */
    public function __construct(array $change)
    {
        $amounts = [];
        foreach ($change as $idx => $item) {
            if (!$item instanceof Change) {
                throw new InvalidArgumentException(
                    sprintf(
                        'Expecting that %s $change parameter as a collection of %s object. Got %s at index %s.',
                        __METHOD__,
                        Change::class,
                        get_class($item),
                        $idx
                    )
                );
            }

            $amountKey = number_format($item->getAmount(), 2);
            if (array_key_exists($amountKey, $amounts)) {
                throw new InvalidArgumentException(
                    sprintf(
                        'Expecting that %s $change parameter contains collection of change with unique amounts. '
                        . 'Already registered %s at index %s but trying to registered at %s.',
                        __METHOD__,
                        $amounts[$amountKey],
                        $amountKey,
                        $idx
                    )
                );
            }

            $amounts[$amountKey] = $idx;
        }

        $this->change = $change;
    }

    /**
     * Fetch the envelope content
     *
     * @return Change[] The content of the envelope
     */
    public function getContent(): array
    {
        return $this->change;
    }

    /**
     * Add change member to envelope
     *
     * @param Change $change The change to add
     *
     * @return ChangeEnvelope The new envelope
     */
    public function addChange(Change $change): self
    {
        return new self(array_merge($this->change, [$change]));
    }
}
