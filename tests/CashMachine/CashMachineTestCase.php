<?php declare(strict_types=1);

namespace App\Tests\CashMachine;

use App\CashMachine\Model\Change;
use App\CashMachine\Model\ChangeEnvelope;
use PHPUnit\Framework\TestCase;

class CashMachineTestCase extends TestCase
{
    public static function assertEnvelopeContent(array $expectations, ChangeEnvelope $envelope): void
    {
        self::assertCount(count($expectations), $content = $envelope->content());
        foreach ($expectations as [$amount, $quantity]) {
            self::assertNotNull($change = self::findChange($content, $amount));
            self::assertSame($quantity, $change->quantity());
        }
    }

    private static function findChange(array $envelopeContent, float $amount): ?Change
    {
        /** @var Change $change */
        foreach ($envelopeContent as $change) {
            if ($change->amount() == $amount) {
                return $change;
            }
        }

        return null;
    }
}
