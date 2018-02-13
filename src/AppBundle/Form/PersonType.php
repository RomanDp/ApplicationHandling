<?php

namespace AppBundle\Form;

use AppBundle\Entity\Person;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if ($options['display_company']) {
            $builder
                ->add('company', EntityType::class, [
                    'class' => 'AppBundle:Company',
                    'choice_label' => 'fullName',
                    'multiple' => false,
                    'label' => 'Компания',
                ]);
        }

        if ($options['display_position']) {
            $builder
                ->add('positionRu', TextType::class, [
                    'label' => 'Должность (рус)',
                ])
                ->add('positionUk', TextType::class, [
                    'label' => 'Должность (укр)',
                ])
                ->add('positionEn', TextType::class, [
                    'label' => 'Должность (анг)',
                ]);
        }

        $builder
            ->add('firstNameRu', TextType::class, [
                'label' => 'Имя (рус)',
            ])
            ->add('lastNameRu', TextType::class, [
                'label' => 'Фамилия (рус)',
            ])
            ->add('firstNameEn', TextType::class, [
                'label' => 'Имя (анг)',
            ])
            ->add('lastNameEn', TextType::class, [
                'label' => 'Фамилия (анг)',
            ])
            ->add('firstNameUk', TextType::class, [
                'label' => 'Имя (укр)',
            ])
            ->add('lastNameUk', TextType::class, [
                'label' => 'Фамилия (укр)',
            ])
            ->add('email', TextType::class, [
                'label' => 'Email',
            ])
            ->add('phone', TextType::class, [
                'label' => 'Телефон',
            ]);

        if ($options['display_crm_id']) {
            $builder
                ->add('crmId', TextType::class, [
                    'label' => 'CRM Id',
                ]);
        }

        if ($options['redirect_to']) {
            $builder->add('redirectTo', HiddenType::class, [
                'mapped' => false,
                'attr' => [
                    'value' => $options['redirect_to'],
                ]
            ]);
        }
    }

    /**
     * @param OptionsResolver $resolver
     *
     * @throws \Symfony\Component\OptionsResolver\Exception\AccessException
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'data_class' => Person::class,
                'display_company' => true,
                'display_position' => false,
                'display_crm_id' => true,
                'redirect_to' => null,
            ]);
    }
}
