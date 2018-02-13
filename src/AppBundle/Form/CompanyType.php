<?php

namespace AppBundle\Form;

use AppBundle\Entity\Company;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;

class CompanyType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nameUk', TextType::class, [
                'label' => 'Название (укр.)',
            ])
            ->add('nameRu', TextType::class, [
                'label' => 'Название (рус.)',
            ])
            ->add('nameEn', TextType::class, [
                'label' => 'Название (англ.)',
            ])
            ->add('crmId', TextType::class, [
                'label' => 'CRM Id',
            ])
            ->add('director', TextType::class, [
                'label' => 'ФИО директора',
            ])
            ->add('activitiesUk', TextType::class, [
                'label' => 'Направления деятельности (укр.)',
                'required' => false,
            ])
            ->add('activitiesRu', TextType::class, [
                'label' => 'Направления деятельности (рус.)',
                'required' => false,
            ])
            ->add('activitiesEn', TextType::class, [
                'label' => 'Направления деятельности (англ.)',
                'required' => false,
            ])
            ->add('contact', TextType::class, [
                'label' => 'label.contact',
            ])
            ->add('phone', TextType::class, [
                'label' => 'Контактный телефон',
            ])
            ->add('email', TextType::class, [
                'label' => 'Контактный Email',
            ]);

        if ($options['company_edit']) {
            $builder
                ->add('addressUk', TextType::class, [
                    'label' => 'Адрес (укр.)',
                    'required' => false,
                ])
                ->add('addressRu', TextType::class, [
                    'label' => 'Адрес (рус.)',
                    'required' => false,
                ])
                ->add('addressEn', TextType::class, [
                    'label' => 'Адрес (англ.)',
                    'required' => false,
                ]);
        }

        $builder
            ->add('legalCompanyName', TextType::class, [
                'label' => 'Наименование компании для документов',
            ])
            ->add('country', CountryType::class, [
                'label' => 'Страна',
                'required' => false,
            ])
            ->add('legalAddress', TextType::class, [
                'label' => 'Юридический адрес',
                'required' => false,
            ])
            ->add('mailAddress', TextType::class, [
                'label' => 'Почтовый адрес',
                'required' => false,
            ])
            ->add('legalId', TextType::class, [
                'label' => 'Регистрационный код компании',
            ])
            ->add('taxId', TextType::class, [
                'label' => 'Налоговый номер',
                'required' => false
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Company::class,
            'company_edit' => false,
        ));
    }
}
