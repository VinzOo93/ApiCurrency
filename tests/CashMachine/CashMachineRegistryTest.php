<?php

namespace App\Tests\CashMachine;

use App\CashMachine\CashMachineRegistry;
use App\CashMachine\EuroCashMachine;
use App\CashMachine\Exception\NotRegistered;
use App\CashMachine\YenCashMachine;
use PHPUnit\Framework\ExpectationFailedException;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;

final class CashMachineRegistryTest extends KernelTestCase
{
    public static function setUpBeforeClass(): void
    {
        self::bootKernel();
    }

    public function testRegistry(): void
    {
        try {
            /** @var CashMachineRegistry $registry */
            $registry = self::$container->get(CashMachineRegistry::class);
        } catch (ServiceNotFoundException $exception) {
            throw new ExpectationFailedException(
                'Unable to get cash machine registry from container.',
                null,
                $exception
            );
        }

        self::assertInstanceOf(CashMachineRegistry::class, $registry);

        try {
            $eur = $registry->get('EUR');
        } catch (NotRegistered $exception) {
            throw new ExpectationFailedException('Unable to get EUR cash machine from registry.', null, $exception);
        }

        try {
            $jpy = $registry->get('JPY');
        } catch (NotRegistered $exception) {
            throw new ExpectationFailedException('Unable to get JPY cash machine from registry.', null, $exception);
        }

        self::assertInstanceOf(EuroCashMachine::class, $eur);
        self::assertInstanceOf(YenCashMachine::class, $jpy);
    }
}
