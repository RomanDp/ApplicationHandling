<?php

namespace AppBundle\Form\ApplicationHandling;

use AppBundle\Entity\ApplicationParticipationType;
use AppBundle\Entity\Company;
use AppBundle\Form\CompanyType;
use AppBundle\Model\ApplicationHandlingDTO;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ApplicationCompanyType extends AbstractType
{

    private $doctrine;

    private $urlGenerator;

    public function __construct(Registry $doctrine, UrlGeneratorInterface $urlGenerator)
    {
        $this->doctrine = $doctrine;
        $this->urlGenerator = $urlGenerator;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var ApplicationHandlingDTO $dto */
        $dto = $options['data'];

        $builder
            ->add('company', EntityType::class, [
                'class' => Company::class,
                'choice_value' => 'id',
                'choice_label' => function (Company $company) use ($dto) {
                    return  $company->getFullName($dto->application->getLanguage());
                },
                'choice_attr' => function (Company $company) {
                    return [
                        'data-load-url' => $this
                            ->urlGenerator
                            ->generate('serialize_company', ['id' => $company->getId()]),
                    ];
                },
                'placeholder' => 'label.add_new',
            ])
            ->add('currencyName', TextType::class, [
                'disabled' => true,
                'label' => 'label.currency'
            ])
            ->add('targetCompany', CompanyType::class)
            ->add('targetApplicationParticipationType', ChoiceType::class, [
                'expanded' => true,
                'multiple' => true,
                'label' => 'Дополнительные услуги',
                'choices' => $dto->application->getAdditionalApplicationParticipationTypes(),
                'choice_label' => function (ApplicationParticipationType $type) {
                    return $type->getParticipationType()->getTitle($type->getApplication()->getLanguage());
                },
            ]);

        //@see https://github.com/symfony/symfony/issues/20770
        $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
            // заменяем целевую компанию, которую редактируем на основании выбранной из списка
            $data = $event->getData();
            if ($data['company']) {
                $company = $this->doctrine->getManagerForClass(Company::class)->find(Company::class, $data['company']);
            } else {
                $company = new Company();
            }

            /** @var $dto ApplicationHandlingDTO */
            $dto = $event->getForm()->getData();

            $dto->targetCompany = $company;
            $event->getForm()->setData($dto);
        });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ApplicationHandlingDTO::class,
        ]);
    }
}
