<?php

declare(strict_types=1);

namespace App\Tests\CashMachine;

use App\Interface\CashMachineInterface;
use App\CashMachine\CashMachineRegistry;
use App\CashMachine\Exception\NotRegisteredException;
use App\CashMachine\Model\Change;
use App\CashMachine\Model\ChangeEnvelope;
use PHPUnit\Framework\ExpectationFailedException;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;

class CashMachineTestCase extends KernelTestCase
{
    public function setUp(): void
    {
        self::bootKernel();
    }

    public static function assertEnvelopeContent(array $expectations, ChangeEnvelope $envelope): void
    {
        self::assertCount(count($expectations), $content = $envelope->getContent());
        foreach ($expectations as [$amount, $quantity]) {
            self::assertNotNull($change = self::findChange($content, $amount));
            self::assertSame($quantity, $change->getQuantity());
        }
    }

    private static function findChange(array $envelopeContent, float $amount): ?Change
    {
        /** @var Change $change */
        foreach ($envelopeContent as $change) {
            if ($change->getAmount() == $amount) {
                return $change;
            }
        }

        return null;
    }

    protected function getCashMachine(string $currency): CashMachineInterface
    {
        try {
            /** @var CashMachineRegistry $registry */
            $registry = self::getContainer()->get(CashMachineRegistry::class);
        } catch (ServiceNotFoundException $exception) {
            throw new ExpectationFailedException(
                'Unable to get cash machine registry from container.',
                null,
                $exception
            );
        }

        self::assertInstanceOf(CashMachineRegistry::class, $registry);

        try {
            return $registry->get($currency);
        } catch (NotRegisteredException $exception) {
            throw new ExpectationFailedException(
                'Unable to get ' . $currency . ' cash machine from registry.',
                null,
                $exception
            );
        }
    }
}
