<?php

declare(strict_types=1);

namespace VladFilimon\MultiNewsletterPlugin\Listener;

use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

final class AccountMenuListener
{
    public function addAccountMenuItems(MenuBuilderEvent $event): void
    {
        $menu = $event->getMenu();

        $menu
            ->addChild('new', ['route' => 'multinewsletter_account_dashboard'])
            ->setLabel('Multi Newsletters')
            ->setLabelAttribute('icon', 'star');
    }
}
