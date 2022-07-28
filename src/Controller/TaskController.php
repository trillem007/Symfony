<?php

namespace App\Controller;
use App\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use App\Form\CrearTasca;
use App\Form\EditarTasca;

use Symfony\Component\Security\Core\User\UserInterface;
class TaskController extends AbstractController
{

    public function index(ManagerRegistry $doctrine): Response
    {
        $eM= $doctrine->getRepository(Task::class);
        $tasks=$eM->findAll();
        
        $array=[];
        
        
        return $this->render('./index.html.twig',['tasks'=>$tasks]);    
    }
    public function detail(Task $task): Response{
        if (!$task){
            return $this->redirectToRoute('tasks');
        }else{
            return $this->render('detail.html.twig',[
                'task' => $task
            ]);
        }
    }
    public function crear(Request $request, UserInterface $usuari){
        $tasca=new Task();
        
        $form=$this->createForm(CrearTasca::class,$tasca);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $tasca->setCreatedAt(new \DateTime('now'));
            $tasca->setUser($usuari);
            $em=$this->getDoctrine()->getManager();
            $em->persist($tasca);
            $em->flush();
            $tasca->getUser($usuari);
           
            return $this->redirect(
                $this->generateUrl('tasks')
            );
        }
        return $this->render('tasca/crear-tasca.html.twig',[
            'form'=> $form->createView()
        ]);
        
    }
    public function edit(Request $request, UserInterface $usuari,Task $tasca){
        if(!$usuari || ($usuari->getId() != $tasca->getUser()->getId())){
            return $this->redirectToRoute('tasks');
        }else{
            $form=$this->createForm(EditarTasca::class,$tasca);
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()){
                $tasca->setCreatedAt(new \DateTime('now'));
                $tasca->setUser($usuari);
                $em=$this->getDoctrine()->getManager();
                $em->persist($tasca);
                $em->flush();
                
            return $this->redirect(
                $this->generateUrl('tasks')
            );
            }
        }
        
        return $this->render('tasca/crear-tasca.html.twig',[
            'edit'=>true,
            'form'=> $form->createView()
        ]);
        
    }
    public function delete($id, Task $task) {
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository(Task::class)->find($id);
        $em->remove($product);
        $em->flush();

        return $this->redirectToRoute('tasks');
    }
    }

?>