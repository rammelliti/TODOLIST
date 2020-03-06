<?php 
namespace App\Controller;

use App\Entity\Task;
use App\Entity\Listing;
use App\Form\TaskType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\component\Routing\Annotation\Route;

/**
 * @Route("/{listingId}/task", name="task_", requirements={"listingId"="\d+"})
 */

 class TaskController extends AbstractController
 {
     /**
    * @Route("/new", name="create")
    */
    public function create (EntityManagerInterface $entityManager,
                            Request $request,
                            $listingId)
    {
        $listing=$entityManager->getRepository(Listing::class)->find($listingId);

        $task =new Task();
        $task->setListing($listing);

        $form = $this->createform(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($task);
            $entityManager->flush();
            return $this->redirectToRoute('listing_show',['listingId'=>$listingId]);
        }

        

    return $this->render('task.html.twig',['form'=>$form->createView()]);

    }
 }