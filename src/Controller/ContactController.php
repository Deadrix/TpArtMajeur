<?php

namespace App\Controller;

use App\Entity\Internaute;
use App\Entity\Question;

use App\Form\ContactFormType;
use App\Repository\InternauteRepository;
use App\Repository\QuestionRepository;
use App\Service\JsonGenerator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        return $this->render('contact/index.html.twig', []);
    }

    /**
     * @Route("/test", name="test")
     */
    public function test(): Response
    {
        return $this->render('contact/test.html.twig', []);
    }

    /**
     * @Route("/new", name="new")
     */
    public function new(Request $request, InternauteRepository $internauteRepository, EntityManagerInterface $entityManager, JsonGenerator $jsonGenerator): Response{

        $question = new Question();
        $internaute = new Internaute();

        $form = $this->createForm(ContactFormType::class, $internaute);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $internaute = $internauteRepository->findOneBy(['email' => $form->get("email")->getData()]);

            if(!$internaute) {
                $internaute = $form->getData();
            }
            $question->setContent($form->get("question")->getData());
            $internaute->addQuestion($question);

            $entityManager->persist($internaute);
            $entityManager->flush();

            $jsonGenerator->generateJsonFile("../", $internaute->getEmail(), $internaute->getName(), $question->getContent(), $question->getId());

            $this->addFlash('success', 'Votre demande à bien été transmise, nous revenons vers vous au plus vite');

            return $this->redirectToRoute('index');

        }

        return $this->render('contact/new.html.twig', [
            'form' => $form->createView(),
        ]);

    }

    /**
     * @Route("/backOffice", name="backOffice")
     */
    public function backOffice(Request $request, InternauteRepository $internauteRepository, QuestionRepository $questionRepository, EntityManagerInterface $entityManager): Response{

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        if ($request->isXmlHttpRequest()) {
            $question = $questionRepository->find($request->request->get('questionId'));
            $question->setChecked(!$question->getChecked());
            $entityManager->persist($question);
            $entityManager->flush();
        }

        return $this->render('contact/backOffice.html.twig', [
            'controller_function' => 'Back Office',
            'internautes' => $internauteRepository->findAll(),
            'questions' => $questionRepository->findAll(),
        ]);

    }
}
