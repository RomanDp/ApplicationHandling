<?php

namespace AppBundle\Form\ApplicationHandling;

use Craue\FormFlowBundle\Form\FormFlow;

class HandlingApplicationFormFlow extends FormFlow
{

    protected $revalidatePreviousSteps = false;

    protected function loadStepsConfig()
    {
        return [
            [
                'label' => 'Компания',
                'form_type' => ApplicationCompanyType::class,
                'form_options' => [
                    'validation_groups' => ['ApplicationCompany'],
                ],
            ],
            [
                'label' => 'Сотрудники',
                'form_type' => ApplicationParticipantsType::class,
                'form_options' => [
                    'validation_groups' => ['ApplicationParticipants'],
                ],
            ],
        ];
    }
}
