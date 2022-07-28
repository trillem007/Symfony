<?php

namespace App\Controller;
use App\Entity\User;
use App\Form\RegistreUsuari;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserController extends AbstractController
{

    public function crear(Request $request, UserPasswordEncoderInterface $encoder){
        $usuari=new User();
        $form=$this->createForm(RegistreUsuari::class,$usuari);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $usuari->setRole('ROLE_USER');
            $usuari->setCreatedAt(new \DateTime('now'));
            $encoded=$encoder->encodePassword($usuari,$usuari->getPassword());
            $usuari->setPassword($encoded);
            $em=$this->getDoctrine()->getManager();
            $em->persist($usuari);
            $em->flush();

            $session=new Session();
            $session->getFlashBag()->add('message','Usuari afegit correctament a la BBDD');
            var_dump($usuari);

            return $this->redirectToRoute('usuari_crear');
        }
        return $this->render('usuari/crear-usuari.html.twig',[
            'form'=> $form->createView()
        ]);
        return new Response("Ruta crear");
    }
    public function login(AuthenticationUtils $authentificationUtils){
        $error = $authentificationUtils->getLastAuthenticationError();
        $lastUsername=$authentificationUtils->getLastUsername();
        return $this->render('usuari/login.html.twig',[
                'error' => $error,
                'lastUsername' => $lastUsername
                
        ]);
    }
}
?>