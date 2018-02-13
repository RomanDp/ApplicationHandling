<?php

namespace AppBundle\Controller\Manager;

use AppBundle\Entity\Application;
use AppBundle\Model\ApplicationHandlingDTO;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class ApplicationsController extends Controller
{

    /**
     * @Route("/applications/{id}/handle", name="application_handling")
     * @ParamConverter("application", class="AppBundle:Application", options={"id" = "id"})
     * @param Application $application
     *
     * @return Response
     */
    public function handleAction(Application $application)
    {
        if ($application->getIsProcessed()) {
            $this->addFlash('error', 'Заявка уже обработана');

            return $this->redirectToRoute('homepage');
        }

        $dto = new ApplicationHandlingDTO($application);

        $flow = $this->get('app.form_application_handling.handling_application_form_flow');

        $flow->bind($dto);

        $form = $flow->createForm();
        if ($flow->isValid($form)) {
            $flow->saveCurrentStepData($form);

            if ($flow->nextStep()) {
                // form for the next step
                $form = $flow->createForm();
            } else {
                // flow finished
                $em = $this->getDoctrine()->getManager();
                $conference = $application->getConference();
                $this->get('app.companies')->addToCompanyFilledPersonsFromDto($dto, $application);
                $em->persist($dto->targetCompany);

                $this
                    ->get('app.participants_companies')
                    ->createParticipantsCompaniesByAdditionalTypes(
                        $dto->targetApplicationParticipationType,
                        $conference
                    );

                $application->setIsProcessed(true);
                $this->get('app.participants')->setCompanyConferenceDetails($dto, $conference);

                $em->flush();

                $flow->reset();
                $this->addFlash('notice', 'Заявка обработана');

                if ($conference->getUseAutoInvitations()) {
                    $personsToSend = [];
                    foreach ($dto->targetParticipants as $targetParticipant) {
                        $personsToSend[] = $targetParticipant->targetPerson;
                    }
                    $this->get('app.persons')->sendNotificationPersonsAboutNewConference($personsToSend, $application);
                }

                return $this->redirectToRoute('homepage');
            }
        }

        $templatesToSteps = [
            1 => 'application/handling-application-company.html.twig',
            2 => 'application/handling-application-participants.html.twig',
        ];

        return $this->render($templatesToSteps[$flow->getCurrentStepNumber()], [
            'form' => $form->createView(),
            'flow' => $flow,
            'application' => $application,
        ]);
    }
}
