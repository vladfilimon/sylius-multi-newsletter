<?php

declare(strict_types=1);

namespace VladFilimon\MultiNewsletterPlugin\Block\Service;

use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Block\Service\AbstractBlockService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class CustomerNewsletterBlockService extends AbstractBlockService
{
    public function execute(BlockContextInterface $blockContext, ?Response $response = null): Response
    {
        return $this->renderResponse($blockContext->getTemplate(), [
            'feeds' => [],
            'block' => $blockContext->getBlock(),
            'settings' => [],
        ], $response);
    }

    public function configureSettings(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'url' => false,
            'title' => 'Insert the rss title',
        ]);
    }
}
