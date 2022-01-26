<?php

declare(strict_types=1);

namespace VladFilimon\MultiNewsletterPlugin;

use Sylius\Bundle\CoreBundle\Application\SyliusPluginTrait;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use VladFilimon\MultiNewsletterPlugin\DependencyInjection\VladFilimonMultiNewsletterPluginExtension;

final class VladFilimonMultiNewsletterPluginBundle extends Bundle
{
    use SyliusPluginTrait;

    /**
     * Returns the plugin's container extension.
     *
     * @throws LogicException
     *
     * @return ExtensionInterface|null The container extension
     */
    public function getContainerExtension(): ?ExtensionInterface
    {
        return new VladFilimonMultiNewsletterPluginExtension();
    }

    public function getParent()
    {
        return 'SyliusUserBundle';
    }
}
