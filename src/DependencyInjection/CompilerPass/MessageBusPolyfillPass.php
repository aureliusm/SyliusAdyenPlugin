<?php
/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusAdyenPlugin\DependencyInjection\CompilerPass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class MessageBusPolyfillPass implements CompilerPassInterface
{
    public const TAG_FALLBACK = [
        'sylius.command_bus' => 'sylius_default.bus',
        'sylius.event_bus' => 'sylius_event.bus',
    ];
    public const COMMAND_BUS_TAG = 'bitbag.sylius_adyen_plugin.command_bus';

    private function setupDefaultCommandBus(array $buses, ContainerBuilder $container): void
    {
        $targetBusName = in_array('sylius.command_bus', $buses, true) ? 'sylius.command_bus' : 'sylius_default.bus';
        $container->setAlias(
            self::COMMAND_BUS_TAG,
            $targetBusName
        );
    }

    public function process(ContainerBuilder $container): void
    {
        /**
         * @var array<string, array> $handlers
         */
        $handlers = $container->findTaggedServiceIds(self::COMMAND_BUS_TAG);
        $buses = array_keys($container->findTaggedServiceIds('messenger.bus'));
        $this->setupDefaultCommandBus($buses, $container);

        foreach ($handlers as $handler => $tagData) {
            if (!isset($tagData[0]['bus'])) {
                continue;
            }

            $busName = (string) $tagData[0]['bus'];

            $def = $container->findDefinition($handler);
            $def->addTag('messenger.message_handler', [
                'bus' => in_array($busName, $buses, true) ? $busName : self::TAG_FALLBACK[$busName],
            ]);
        }
    }
}
