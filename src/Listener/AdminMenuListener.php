<?php

declare(strict_types=1);

namespace VladFilimon\MultiNewsletterPlugin\Listener;

use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

final class AdminMenuListener
{
    public function addAdminMenuItem(MenuBuilderEvent $event): void
    {
        $menu = $event->getMenu();

        if (!$content = $menu->getChild('app-multinewsletter')) {
            $content = $menu
                ->addChild('app-multinewsletter')
                ->setLabel('app-multinewsletter.ui.newsletters')
            ;
        }

        $content->addChild('app-multinewsletter-page', ['route' => 'app_admin_newsletter_index'])
            ->setLabel('app_multinewsletter_page.ui.newsletters')
            ->setLabelAttribute('icon', 'file alternate')
        ;
    }
}
