<?php

declare(strict_types=1);

namespace VladFilimon\MultiNewsletterPlugin\Listener;

final class RegisterFormListener
{
    public function onBlockEvent($event)
    {
        /** @var \Symfony\Component\Form\FormView $formView */
        $formView = $event->getSetting('form');

        return;
    }
}
