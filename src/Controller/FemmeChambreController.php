<?php

namespace App\Controller;

use App\Entity\FemmeChambre;
use App\Repository\ChambreRepository;
use App\Repository\FemmeChambreRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/femme_chambre")
 */
class FemmeChambreController extends AbstractController
{
    /**
     * @Route("/", name="femme_chambre_index", methods={"GET"})
     */
    public function index(FemmeChambreRepository $femmeChambreRepository): Response
    {
        return $this->render('femme_chambre/index.html.twig', [
            'femme_chambres' => $femmeChambreRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}/miseajourheure")
     */
    public function updateheure(Request $request): Response
    {
        $manager=$this->getDoctrine()->getManager();
        $em=$this->getDoctrine()->getManager();
        if($request->isXmlHttpRequest() || $request->getMethod()=='POST')
        {
            $numcli=$request->request->get('id');
            $adresse= $request->request->get('adresse');
            $liste=$manager->getRepository('App\Entity\Chambre')->find($numcli);
            $liste->setHeureMenage($adresse);
            $em->persist($liste);
            $em->flush();
            return new JsonResponse(['code'=>200, 'message'=>'Client modifié'],200);
        }
    }
     /**
     * @Route("/miseajourheureindex")
     */
    public function updateheureindex(Request $request): Response
    {
        $manager=$this->getDoctrine()->getManager();
        $em=$this->getDoctrine()->getManager();
        if($request->isXmlHttpRequest() || $request->getMethod()=='POST')
        {
            $numcli=$request->request->get('id');
            $adresse= $request->request->get('adresse');
            $liste=$manager->getRepository('App\Entity\Chambre')->find($numcli);
            $liste->setHeureMenage($adresse);
            $em->persist($liste);
            $em->flush();
            return new JsonResponse(['code'=>200, 'message'=>'Client modifié'],200);
        }
    }

      /**
     * @Route("/{id}/editestate")
     */
    public function updatestatemMenage($id)
    {
             $em=$this->getDoctrine()->getManager();
             $liste=$em->getRepository('App\Entity\Chambre')->find($id);
             $liste->setStateMenage('true');
             $em->persist($liste);
             $em->flush();
             $retour=$id;

             return new JsonResponse(['code'=>200,'client'=>$retour],200);
    }
   
    /**
     * @Route("/femme_chambre_new")
     */
    public function new(Request $request): Response
    {
        $femmeChambre = new FemmeChambre();
        if($request->isXmlHttpRequest() || $request->getMethod()=='POST')
        {
            $name= $request->request->get('nom');
            $prenom=$request->request->get('prenom');
            $adresse= $request->request->get('adresse');
            $phone=$request->request->get('phone');
          //  $acc=$request->request->get('accompagne');

            $femmeChambre->setNom($name);
            $femmeChambre->setPrenom($prenom);
            $femmeChambre->setAdresse($adresse);
            $femmeChambre->setTelephone($phone);

           // $client->setAccompagne($acc);
            $em=$this->getDoctrine()->getManager();
            $em->persist($femmeChambre);
            $em->flush();
            $numero=['num'=>$femmeChambre->getId()];
            //$response=new Response();
            //$response->headers->set('content-Type',application/json);
            //
            return new JsonResponse(['code'=>$numero, 'mesage'=>'okay'], 200);
        }
    }

    /**
     * @Route("/menage", name="menage_index", methods={"GET"})
     */
    public function indexmenage(ChambreRepository $chambreRepository): Response
    {
        return $this->render('femme_chambre/menage.html.twig', [
            'menages' => $chambreRepository->menagechambre(),
        ]);
    }
  
    /**
     * @Route("/{id}/showing", name="menage_chambre", methods={"GET"})
     */
    public function menagechambre(FemmeChambre $femmeChambre, ChambreRepository $chambreRepository): Response
    {
        $manager=$this->getDoctrine()->getManager();
        $liste=$manager->getRepository('App\Entity\FemmeChambre')->find($femmeChambre);
        $nom=$liste->getNom();
        $prenom=$liste->getPrenom();
        return $this->render('categorie/menagechambre.html.twig', [
            'menages' => $chambreRepository->findByChambre($femmeChambre),
            'nom'=>$nom,
            'prenom'=>$prenom,
        ]);
    }
     /**
     * @Route("/{id}/edit")
     */
    public function show($id)
    {
        $em=$this->getDoctrine()->getManager();
             $liste=$em->getRepository('App\Entity\FemmeChambre')->find($id);
             $retour=array(
                 'id'=>$liste->getId(),
                 'nom' =>$liste->getNom(),
                 'prenom' =>$liste->getPrenom(),
                 'adresse'=>$liste->getAdresse(),
                 'phone' =>$liste->getTelephone(),
             );
             return new JsonResponse(['code'=>200,'client'=>$retour],200);
    }
   

    /**
     * @Route("/miseajourfemme")
     */
    public function updateblinderie(Request $request): Response
    {
        $manager=$this->getDoctrine()->getManager();
        $em=$this->getDoctrine()->getManager();
        if($request->isXmlHttpRequest() || $request->getMethod()=='POST')
        {
            $numcli=$request->request->get('id'); 
            $name= $request->request->get('nom');
            $prenom=$request->request->get('prenom');
            $adresse= $request->request->get('adresse');
            $phone=$request->request->get('phone');
           // $acc=$request->request->get('accompagne');

            $femmeChambre=$manager->getRepository('App\Entity\FemmeChambre')->find($numcli);

            $femmeChambre->setNom($name);
            $femmeChambre->setPrenom($prenom);
            $femmeChambre->setAdresse($adresse);
            $femmeChambre->setTelephone($phone);

          //  $client->setAccompagne($acc);
            $em->persist($femmeChambre);
            $em->flush();

            return new JsonResponse(['code'=>200, 'message'=>'Client modifié'],200);
        }
    }

     /**
     * @Route("/{id}")
     */
    public function delete($id)
    {
        //if ($this->isCsrfTokenValid('delete'.$client->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $cli=$entityManager->getRepository('App\Entity\FemmeChambre')->find($id);
            $em=$this->getDoctrine()->getManager();
            $em->remove($cli);
            $em->flush();
            return new JsonResponse(['code'=>200],200);
      //  }
       // return $this->redirectToRoute('client_index');
    }
}
