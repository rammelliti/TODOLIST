<?php 
namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use Symfony\bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\component\Routing\Annotation\Route;

/**
 * @Route("/{listingId}/task", name="task_", requirements={"listingId"="\d+"})
 */

 class TaskController extends AbstractController
 {
     /**
    * @Route("/new", name="create")
    */
    public function create ($listinId)
    {
$task =new Task();
$form = $this->createform(TaskType::class, $task);
return $this->render('task.html.twig',['form'=>$form->createView()]);

    }
 }