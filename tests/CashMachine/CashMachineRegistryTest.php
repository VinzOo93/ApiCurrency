<?php

namespace App\Tests\CashMachine;

use App\CashMachine\CashMachineRegistry;
use App\CashMachine\Exception\NotRegisteredException;
use PHPUnit\Framework\ExpectationFailedException;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;

final class CashMachineRegistryTest extends KernelTestCase
{
    public function setUp(): void
    {
        self::bootKernel();
    }

    public function testRegistry(): void
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
            $registry->get('EUR');
        } catch (NotRegisteredException $exception) {
            throw new ExpectationFailedException('Unable to get EUR cash machine from registry.', null, $exception);
        }

        try {
            $registry->get('JPY');
        } catch (NotRegisteredException $exception) {
            throw new ExpectationFailedException('Unable to get JPY cash machine from registry.', null, $exception);
        }

        try {
            $registry->get('FOO');
            throw new ExpectationFailedException('FOO cash machine should not have been developed.');
        } catch (NotRegisteredException $exception) {
        }
    }
}
