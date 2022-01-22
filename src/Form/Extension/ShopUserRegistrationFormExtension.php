<?php

declare(strict_types=1);

namespace VladFilimon\MultiNewsletterPlugin\Form\Extension;

use Doctrine\ORM\EntityManagerInterface;
use Sylius\Bundle\CoreBundle\Form\Type\User\ShopUserRegistrationType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Event\PostSubmitEvent;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use VladFilimon\MultiNewsletterPlugin\Repository\NewsletterRepository;

final class ShopUserRegistrationFormExtension extends AbstractTypeExtension
{
    protected $newsletterRepo;

    protected $em;

    public function __construct(NewsletterRepository $newsletterRepo, EntityManagerInterface $em)
    {
        $this->newsletterRepo = $newsletterRepo;
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        //parent::buildForm($builder, $options);
        $newsletters = $this->newsletterRepo->findBy(['enabled' => true]);
        $nlOptions = [];

        if (count($newsletters)) {
            foreach ($newsletters as $newsletter) {
                $nlOptions[$newsletter->getName()] = $newsletter->getId();
            }

            $builder->add('newsletters', ChoiceType::class, [
                'required' => false,
                'multiple' => true,
                'mapped' => false,
                'choices' => $nlOptions,
                'label' => 'app.form.customer.newsletters',
            ]);
        }

        $builder->addEventListener(FormEvents::POST_SUBMIT, function (PostSubmitEvent $event) {
            if (!$event->getForm()->has('newsletters')) {
                return;
            }
            foreach ($event->getForm()->get('newsletters')->getData() as $key => $newsletterId) {
                $newsletter = $this->newsletterRepo->find($newsletterId);
                $event->getData()->addNewsletter($newsletter);
            }
        });
    }

    public function getBlockPrefix(): string
    {
        return 'sylius_shop_user_registration';
    }

    public static function getExtendedTypes(): iterable
    {
        return [ShopUserRegistrationType::class];
    }
}
