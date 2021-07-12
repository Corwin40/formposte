<?php

namespace App\Controller\Webapp;

use App\Entity\Webapp\Question;
use App\Form\Webapp\QuestionType;
use App\Repository\Webapp\QuestionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class QuestionController extends AbstractController
{
    /**
     * @Route("/op_admin/questions/", name="webapp_question_index", methods={"GET"})
     */
    public function index(QuestionRepository $questionRepository): Response
    {
        return $this->render('webapp/question/index.html.twig', [
            'questions' => $questionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/op_admin/questions/new", name="webapp_question_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $question = new Question();
        $form = $this->createForm(QuestionType::class, $question);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($question);
            $entityManager->flush();

            return $this->redirectToRoute('webapp_question_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('webapp/question/new.html.twig', [
            'question' => $question,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/op_admin/questions/{id}", name="webapp_question_show", methods={"GET"})
     */
    public function show(Question $question): Response
    {
        return $this->render('webapp/question/show.html.twig', [
            'question' => $question,
        ]);
    }

    /**
     * @Route("/op_admin/questions/{id}/edit", name="webapp_question_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Question $question): Response
    {
        $form = $this->createForm(QuestionType::class, $question);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('webapp_question_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('webapp/question/edit.html.twig', [
            'question' => $question,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/op_admin/questions/{id}", name="webapp_question_delete", methods={"POST"})
     */
    public function delete(Request $request, Question $question): Response
    {
        if ($this->isCsrfTokenValid('delete'.$question->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($question);
            $entityManager->flush();
        }

        return $this->redirectToRoute('webapp_question_index', [], Response::HTTP_SEE_OTHER);
    }
}
