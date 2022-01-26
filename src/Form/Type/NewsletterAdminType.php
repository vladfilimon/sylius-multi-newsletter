<?php

declare(strict_types=1);

namespace VladFilimon\MultiNewsletterPlugin\Form\Type;

use Sylius\Bundle\ResourceBundle\Form\DataTransformer\ResourceToIdentifierTransformer;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Sylius\Bundle\ResourceBundle\Form\Type\ResourceAutocompleteChoiceType;
use Sylius\Component\User\Repository\UserRepositoryInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\ReversedTransformer;
use VladFilimon\MultiNewsletterPlugin\Repository\NewsletterRepository;

final class NewsletterAdminType extends AbstractResourceType
{
    protected $shopUserRepository;
    protected $newsletterRepository;

    public function __construct(string $dataClass, array $validationGroups = [], UserRepositoryInterface $shopUserRepository, NewsletterRepository $newsletterRepository)
    {
        $this->shopUserRepository = $shopUserRepository;
        $this->newsletterRepository = $newsletterRepository;

        parent::__construct($dataClass, $validationGroups);
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'sylius.multinewsletter.admin.form.name',
            ])
            ->add('description', TextType::class, [
                'label' => 'sylius.multinewsletter.admin.form.description',
            ])
            ->add('enabled', CheckboxType::class, [
                'label' => 'sylius.multinewsletter.admin.form.enabled',
            ])
            ->add('shopUsers', EntityType::class, [
                'label' => 'sylius.multinewsletter.admin.form.shopUsers',
                'class' => 'App\\Entity\\User\\ShopUser',
                'multiple' => true,
                'expanded' => true,
                'required' => false,
            ])
        ;
    }

    public function getBlockPrefix(): string
    {
        return 'sylius_customer_profile';
    }
}
