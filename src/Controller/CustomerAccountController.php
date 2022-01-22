<?php

declare(strict_types=1);

namespace VladFilimon\MultiNewsletterPlugin\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use VladFilimon\MultiNewsletterPlugin\Repository\NewsletterRepository;

class CustomerAccountController extends AbstractController
{
    protected $newsletterRepository;
    protected $tokenStorage;
    protected $em;

    public function __construct(NewsletterRepository $newsletterRepository, TokenStorageInterface $tokenStorage, EntityManagerInterface $em)
    {
        $this->newsletterRepository = $newsletterRepository;
        $this->tokenStorage = $tokenStorage;
        $this->em = $em;
    }

    public function newsletterAction(Request $request)
    {
        $shopUser = $this->tokenStorage->getToken()->getUser();

        //\assert($shopUser instanceof User);
        $form = $this->createFormBuilder(['allow_extra_fields' => true,
            'class' => 'ui loadable form', ]);
        $enabledNewsletters = $this->newsletterRepository->findBy(['enabled' => true]);

        foreach ($enabledNewsletters as $newsletter) {
            $options = [
                'required' => false,
                 'label' => $newsletter->getName(),
            ];
            if ($shopUser->getNewsletters()->contains($newsletter)) {
                $options['data'] = true;
            }
            $form->add($newsletter->getId(), CheckboxType::class, $options);
        }

        $form->add('Update', SubmitType::class, ['attr' => ['class' => 'ui large primary button']]);

        $form = $form->getForm();
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $data = $form->getData();
                $shopUser->getNewsletters()->clear();
                foreach ($data as $newsletterId => $subscribed) {
                    if (!is_int($newsletterId)) {
                        continue;
                    }

                    if ($subscribed) {
                        $res = array_filter(array_map(function ($nl) use ($newsletterId) {
                            if ($nl->getId() === $newsletterId) {
                                return $nl;
                            }
                        }, $enabledNewsletters));

                        foreach ($res as $newsletterToSubscribe) {
                            $shopUser->addNewsletter($newsletterToSubscribe);
                            $this->em->persist($shopUser);
                        }
                    }
                }

                $this->addFlash('success', 'Newsletter preferences have been updated');
                $this->em->flush();
            }
        }

        return $this->render('@VladFilimonMultiNewsletterPluginBundle/CustomerAccount/newsletter.html.twig', ['form' => $form->createView()]);
    }

    public function searchShopUserAction()
    {
        $enabledNewsletters = $this->newsletterRepository->findBy(['enabled' => true]);

        return $this->json($enabledNewsletters);
    }
}
