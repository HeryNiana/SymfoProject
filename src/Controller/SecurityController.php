<?php

namespace App\Controller;
use App\Entity\User;
use App\Entity\Chambre;
use App\Form\Chambre1Type;
use App\Form\RegistrationType;
use App\Repository\ChambreRepository;
use App\Repository\HebergeRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
 
/**
 * @Route("/")
 */
class SecurityController extends AbstractController
{
    /**
     * @Route("/connexion", name="security_links")
     */
    public function registration(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $user=new User();   
        $form= $this->createForm(RegistrationType::class , $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
 
          return $this->redirectToRoute('home');
        }
        return $this->render('security/login.html.twig',
        ['form' => $form->createView()]);
    }

    /**
     * @Route("/", name="home")
     */
    public function login()
    {
       
    }

     /**
     * @Route("/editer", name="editprofile")
     */
    public function editer()
    {
        //$form=$this->createForm(EditUserType::class,$this->getUser());
        return $this->render('article/editname.html.twig');
    }

    /**
     * @Route("/editerPassword", name="editpassword")
     */
    public function editerpass()
    {
        //$form=$this->createForm(EditUserType::class,$this->getUser());
        return $this->render('article/editpass.html.twig');
    }


    /**
     * @Route("/editerPasswordnew", name="editpasswordnew")
     */
    public function editerpassNew(Request $request, UserPasswordEncoderInterface $okay): Response
    {
        $user=$this->getUser();
        //$passwordEncoder = $this->container->get('security.password_encoder');
        $oldpass=$request->request->get("old_pass");
        $verify=$okay->isPasswordValid($user, $oldpass);
        if ($verify===true)
        {
            $newpass=$request->request->get("password");
            $newpass1=$request->request->get("password1");
            if($newpass==$newpass1){
                
                $hash = $okay->encodePassword($user, $newpass);
                $user->setPassword($hash);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();
                $this->addFlash('message','mot de passe modifié avec succéss');
            return $this->redirectToRoute('editpassword');
            }
            else{
                $this->addFlash('message','mot de passe non correcte');
            return $this->redirectToRoute('editpassword');
            }
        }
        else{
            $this->addFlash('message','Ancien mot de passe  incorrecte');
            return $this->redirectToRoute('editpassword');
        }
        
    }

    /**
     * @Route("/editername", name="editprofileone",  methods={"GET","POST"})
     */
    public function editername(Request $request)
    {
        $user=$this->getUser();
        if($request->request->Count() > 0){
            $name=$request->request->get("new_name");
            $email=$request->request->get("new_email");
            $user->setUsername($name);
            $user->setEmail($email);
            $em=$this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            

            return $this->redirectToRoute('home');
        }
        
        
        return $this->render('article/editnameone.html.twig');
    }

    /**
     * @Route("/deconnexion", name="security_logout")
     */
    public function logout()
    { }

    /**
     * @Route("/", name="home",  methods={"GET","POST"})
     */
    public function index(): Response
    {
       
            return $this->redirectToRoute('chambre_index');    
   }
}

