<?php
/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusAdyenPlugin\Processor\PaymentResponseProcessor;

use Sylius\Component\Core\Model\PaymentInterface;
use Symfony\Component\HttpFoundation\Request;

interface ProcessorInterface
{
    public function accepts(Request $request, ?PaymentInterface $payment): bool;

    public function process(string $code, Request $request, PaymentInterface $payment): string;
}
