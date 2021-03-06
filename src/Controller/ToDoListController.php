<?php

namespace App\Controller;

use App\Entity\Task;
use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ToDoListController extends AbstractController
{
    /**
     * @Route("/to/do/list", name="app_to_do_list")
     */
    public function index(TaskRepository $taskRepository): Response
    {
        return $this->render('to_do_list/index.html.twig', [
            'tasks' => $taskRepository->findAll(),
        ]);
    }


    /**
     * @Route("/create", name="create_task")
     */
    public function create(Request $request)
    {
        $title = trim($request->request->get('title'));
        if (empty($title))
            return $this->redirectToRoute('app_to_do_list');

        $entityManager = $this->getDoctrine()->getManager();
        $task = new Task();
        $task->setTitle($title);
        $entityManager->persist($task);
        $entityManager->flush();
        return $this->redirectToRoute('app_to_do_list');

    }

    /**
     * @Route("/switch_status/{id}", name="switch_status")
     */
    public function switchStatus($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $task = $entityManager->getRepository(Task::class)->find($id);
        $task->setStatus(!$task->getStatus());
        $entityManager->flush();
        return $this->redirectToRoute('app_to_do_list');

    }

    /**
     * @Route("/delete/{id}", name="app_task_delete")
     */
    public function delete(Task $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($id);
        $entityManager->flush();
        return $this->redirectToRoute('app_to_do_list');
    }

}
