<?php

declare(strict_types=1);

namespace VladFilimon\MultiNewsletterPlugin\Controller;

use Doctrine\Persistence\ObjectManager;
use Sylius\Bundle\ResourceBundle\Controller\AuthorizationCheckerInterface;
use Sylius\Bundle\ResourceBundle\Controller\EventDispatcherInterface;
use Sylius\Bundle\ResourceBundle\Controller\FlashHelperInterface;
use Sylius\Bundle\ResourceBundle\Controller\NewResourceFactoryInterface;
use Sylius\Bundle\ResourceBundle\Controller\RedirectHandlerInterface;
use Sylius\Bundle\ResourceBundle\Controller\RequestConfigurationFactoryInterface;
use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Sylius\Bundle\ResourceBundle\Controller\ResourceDeleteHandlerInterface;
use Sylius\Bundle\ResourceBundle\Controller\ResourceFormFactoryInterface;
use Sylius\Bundle\ResourceBundle\Controller\ResourcesCollectionProviderInterface;
use Sylius\Bundle\ResourceBundle\Controller\ResourceUpdateHandlerInterface;
use Sylius\Bundle\ResourceBundle\Controller\SingleResourceProviderInterface;
use Sylius\Bundle\ResourceBundle\Controller\StateMachineInterface;
use Sylius\Bundle\ResourceBundle\Controller\ViewHandlerInterface;
use Sylius\Component\Grid\View\GridView;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\Component\Resource\Metadata\MetadataInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Sylius\Component\Resource\ResourceActions;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomerResourceController extends ResourceController
{
    public function __construct(MetadataInterface $metadata, RequestConfigurationFactoryInterface $requestConfigurationFactory, ?ViewHandlerInterface $viewHandler, RepositoryInterface $repository, FactoryInterface $factory, NewResourceFactoryInterface $newResourceFactory, ObjectManager $manager, SingleResourceProviderInterface $singleResourceProvider, ResourcesCollectionProviderInterface $resourcesFinder, ResourceFormFactoryInterface $resourceFormFactory, RedirectHandlerInterface $redirectHandler, FlashHelperInterface $flashHelper, AuthorizationCheckerInterface $authorizationChecker, EventDispatcherInterface $eventDispatcher, ?StateMachineInterface $stateMachine, ResourceUpdateHandlerInterface $resourceUpdateHandler, ResourceDeleteHandlerInterface $resourceDeleteHandler)
    {
        parent::__construct($metadata, $requestConfigurationFactory, $viewHandler, $repository, $factory, $newResourceFactory, $manager, $singleResourceProvider, $resourcesFinder, $resourceFormFactory, $redirectHandler, $flashHelper, $authorizationChecker, $eventDispatcher, $stateMachine, $resourceUpdateHandler, $resourceDeleteHandler);
    }

    public function showAction(Request $request): Response
    {
        $configuration = $this->requestConfigurationFactory->create($this->metadata, $request);

        $this->isGrantedOr403($configuration, ResourceActions::SHOW);
        $resource = $this->findOr404($configuration);

        $this->eventDispatcher->dispatch(ResourceActions::SHOW, $configuration, $resource);

        $newsletterRepo = $this->get('app.repository.newsletter');
        if ($configuration->isHtmlRequest()) {
            return $this->render($configuration->getTemplate(ResourceActions::SHOW.'.html'), [
                'configuration' => $configuration,
                'metadata' => $this->metadata,
                'resource' => $resource,
                'newsletters' => $newsletterRepo->findByShopUser($resource),
                //'gridview' => $gridview,
                $this->metadata->getName() => $resource,
            ]);
        }

        return $this->createRestView($configuration, $resource);
    }
}
