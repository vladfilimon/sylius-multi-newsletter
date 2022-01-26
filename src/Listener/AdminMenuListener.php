<?php

declare(strict_types=1);

namespace VladFilimon\MultiNewsletterPlugin\Listener;

use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

final class AdminMenuListener
{
    public function addAdminMenuItem(MenuBuilderEvent $event): void
    {
        $menu = $event->getMenu();

        if (!$content = $menu->getChild('marketing')) {
            $content = $menu
                ->addChild('marketing')
                ->setLabel('sylius.menu.admin.main.marketing.header')
            ;
        }

        $content->addChild('app-multinewsletter-page', ['route' => 'app_admin_newsletter_index'])
            ->setLabel('sylius.multinewsletter.ui.menu')
            ->setLabelAttribute('icon', 'file alternate')
        ;
    }
}
