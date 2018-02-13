<?php

namespace AppBundle\Form\ApplicationHandling;

use AppBundle\Model\ApplicationHandlingDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ApplicationParticipantsType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var $dto ApplicationHandlingDTO */
        $dto = $options['data'];

        $builder
            ->add('targetParticipants', CollectionType::class, [
                'entry_type' => ApplicationParticipantType::class,
                'entry_options' => [
                    'conference' => $dto->application->getConference(),
                    'company' => $dto->targetCompany,
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ApplicationHandlingDTO::class,
        ]);
    }
}
