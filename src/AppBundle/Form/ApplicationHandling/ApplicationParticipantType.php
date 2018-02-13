<?php

namespace AppBundle\Form\ApplicationHandling;

use AppBundle\Entity\Company;
use AppBundle\Entity\Conference;
use AppBundle\Entity\ParticipationType;
use AppBundle\Entity\Person;
use AppBundle\Form\PersonType;
use AppBundle\Model\ApplicationHandlingDTO;
use AppBundle\Model\ApplicationParticipantHandlingDTO;
use AppBundle\Service\Participants;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ApplicationParticipantType extends AbstractType
{

    private $doctrine;

    private $urlGenerator;

    private $participantsService;

    public function __construct(Registry $doctrine, UrlGeneratorInterface $urlGenerator, Participants $participantsService)
    {
        $this->doctrine = $doctrine;
        $this->urlGenerator = $urlGenerator;
        $this->participantsService = $participantsService;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $company = $options['company'];

        $qb = null;
        $choices = null;
        if ($company->getId()) {
            $qb = function (EntityRepository $repo) use ($company) {

                return $repo
                    ->createQueryBuilder('p')
                    ->andWhere('p.company = :company')
                    ->setParameter('company', $company);
            };
        } else {
            $choices = [];
        }

        $builder
            ->add('person', EntityType::class, [
                'property_path' => 'targetParticipant.person',
                'class' => Person::class,
                'query_builder' => $qb,
                'choices' => $choices,
                'choice_attr' => function (Person $person) {
                    return [
                        'data-load-url' => $this
                            ->urlGenerator
                            ->generate('serialize_person', ['id' => $person->getId()]),
                    ];
                },
                //TODO: depends on language?
                'choice_label' => 'nameRu',
                'placeholder' => 'label.add_new',
                'label' => 'Сотрудник',
            ])
            ->add('participationType', EntityType::class, [
                'property_path' => 'targetParticipant.type',
                'class' => ParticipationType::class,
                'query_builder' => function (EntityRepository $repo) use ($options) {
                    return $repo
                        ->createQueryBuilder('pt')
                        ->andWhere('pt.conference = :conference')
                        ->setParameter('conference', $options['conference']);
                },
                'choice_label' => 'titleRu',
                'label' => 'Тип участия',
            ])
            ->add('crmId', ChoiceType::class, [
                'property_path' => 'targetParticipant.crmId',
                'label' => 'CrmId',
                'required' => false,
                'choices' => $this->participantsService->getAvailableCRMIds(
                    $options['conference'],
                    $options['company']
                ),
                'placeholder' => '----',
            ])
            ->add('targetPerson', PersonType::class, [
                'display_company' => false,
                'display_position' => true,
                'display_crm_id' => false
            ]);

        //@see https://github.com/symfony/symfony/issues/20770
        $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
            // заменяем целевую персону, которую редактируем на основании выбранной из списка
            $data = $event->getData();
            if ($data['person']) {
                $person = $this->doctrine->getManagerForClass(Person::class)->find(Person::class, $data['person']);
            } else {
                $person = new Person();
            }

            /** @var $dto ApplicationParticipantHandlingDTO */
            $dto = $event->getForm()->getData();

            if ($data['crmId']) {

                $existsParticipant = $this->doctrine
                    ->getRepository('AppBundle:Participant')
                    ->findOneBy(
                        [
                            'crmId' => $data['crmId'],
                        ]
                    );

                if ($existsParticipant) {
                    $fields = [
                        'person',
                        'type',
                        'email',
                        'phone',
                        'position',
                    ];

                    ApplicationHandlingDTO::mergeData($existsParticipant, $dto->targetParticipant, $fields);
                    $dto->targetParticipant = $existsParticipant;
                }
            }

            $dto->targetPerson = $person;
            $event->getForm()->setData($dto);
        });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'data_class' => ApplicationParticipantHandlingDTO::class,
                'conference' => null,
                'company' => null,
            ])
            ->setAllowedTypes('company', ['null', Company::class])
            ->setAllowedTypes('conference', ['null', Conference::class]);
    }
}
