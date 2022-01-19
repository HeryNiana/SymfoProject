<?php

namespace App\Controller;

use App\Entity\Categorie1;
use App\Repository\ChambreRepository;
use App\Repository\Categorie1Repository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/categorie")
 */
class CategorieController extends AbstractController
{
    /**
     * @Route("/", name="categorie_index", methods={"GET"})
     */
    public function index(Categorie1Repository $categorieRepository): Response
    {
        return $this->render('categorie/index.html.twig', [
            'categories' => $categorieRepository->findAll(),
        ]);
    }

    /**
     * @Route("/categorie_new")
     */
    public function new(Request $request): Response
    {
        $client = new Categorie1();
        if($request->isXmlHttpRequest() || $request->getMethod()=='POST')
        {
            //$name= $request->request->get('name');
            $adresse= $request->request->get('adresse');
           // $client->setCapacite($name);
            $client->setType($adresse);
            $em=$this->getDoctrine()->getManager();
            $em->persist($client);
            $em->flush();
            $numero=['num'=>$client->getId()];
            //$response=new Response();
            //$response->headers->set('content-Type',application/json);
            //
            return new JsonResponse(['code'=>$numero, 'mesage'=>'okay'], 200);
        }
    } 
    
    /**
     * @Route("/miseajourcateg")
     */
    public function updatecli(Request $request): Response
    {
        $manager=$this->getDoctrine()->getManager();
        $em=$this->getDoctrine()->getManager();
        if($request->isXmlHttpRequest() || $request->getMethod()=='POST')
        {
            $numcli=$request->request->get('id'); 
           // $name= $request->request->get('name');
            $adresse= $request->request->get('adresse');
            $liste=$manager->getRepository('App\Entity\Categorie1')->find($numcli);
          //  $liste->setCapacite($name);
            $liste->setType($adresse);
            $em->persist($liste);
            $em->flush();

            return new JsonResponse(['code'=>200, 'message'=>'Client modifié'],200);
        }
    }

    /**
     * @Route("/{id}/edit")
     */
    public function show( $id)
    {
        $em=$this->getDoctrine()->getManager();
       // if($request->isXmlHttpRequest() || $request->getMethod()=='GET')
       // {
            //$numcli= $request->request->get("id");
            $liste=$em->getRepository('App\Entity\Categorie1')->find($id);
            $retour=array(
                'id'=>$liste->getId(),
                //'name' =>$liste->getCapacite(),
                'adresse'=>$liste->getType()
            );
            return new JsonResponse(['code'=>200,'client'=>$retour],200);
        //}
    }


    /**
     * @Route("/{id}")
     */
    public function delete($id)
    {
        //if ($this->isCsrfTokenValid('delete'.$client->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $cli=$entityManager->getRepository('App\Entity\Categorie1')->find($id);
            $em=$this->getDoctrine()->getManager();
            $em->remove($cli);
            $em->flush();
            return new JsonResponse(['code'=>200],200);
      //  }
       // return $this->redirectToRoute('client_index');
    }
}
