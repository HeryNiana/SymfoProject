<?php

namespace App\Controller;

use App\Entity\Chambre;
use App\Entity\Cliente;
use App\Entity\Heberge;
use App\Repository\ClienteRepository;
use App\Repository\HebergeRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/client")
 */
class ClientController extends AbstractController
{
    /**
     * @Route("/", name="client_index", methods={"GET","POST"})
     */
    public function index(ClienteRepository $clientRepository, Request $request): Response
    {

        $client = new Cliente();
       // $form = $this->createForm(ClientType::class, $client);
       /* $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($client);
            $entityManager->flush();

            return $this->redirectToRoute('client_index');
        }*/

        return $this->render('client/index.html.twig', [
            'client' => $client,
           // 'form' => $form->createView(),
            'clients' => $clientRepository->findBy(
                array(),
                array('id'=>'ASC')
            ),
        ]);

       /* return $this->render('client/index.html.twig', [
            'clients' => $clientRepository->findAll(),
        ]);*/
    }

    /**
     * @Route("/newone")
     */
    public function new(Request $request): Response
    {
        $client = new Cliente();
        if($request->isXmlHttpRequest() || $request->getMethod()=='POST')
        {
            $name= strtoupper($request->request->get('nom'));
            $prenom=$request->request->get('prenom');
            $adresse= $request->request->get('adresse');
            $age=$request->request->get('age');
            $sexe=$request->request->get('sexe');
            $civil=$request->request->get('civil');
            $phone=$request->request->get('phone');
            $national=$request->request->get('national');
            $categorie=$request->request->get('categorie');
          //  $acc=$request->request->get('accompagne');

            $client->setNom($name);
            $client->setPrenom($prenom);
            $client->setAdresse($adresse);
            $client->setAge($age);
            $client->setSexe($sexe);
            $client->setCivil($civil);
            $client->setTelephone($phone);
            $client->setNational($national);
            $client->setCategorie($categorie);
           // $client->setAccompagne($acc);
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
     * @Route("/miseajourcli")
     */
    public function updatecli(Request $request): Response
    {
        $manager=$this->getDoctrine()->getManager();
        $em=$this->getDoctrine()->getManager();
        if($request->isXmlHttpRequest() || $request->getMethod()=='POST')
        {
            $numcli=$request->request->get('id'); 
            $name= strtoupper($request->request->get('nom'));
            $prenom=$request->request->get('prenom');
            $adresse= $request->request->get('adresse');
            $age=$request->request->get('age');
            $sexe=$request->request->get('sexe');
            $civil=$request->request->get('civil');
            $phone=$request->request->get('phone');
            $national=$request->request->get('national');
            $categorie=$request->request->get('categorie');
           // $acc=$request->request->get('accompagne');

            $client=$manager->getRepository('App\Entity\Cliente')->find($numcli);

            $client->setNom($name);
            $client->setPrenom($prenom);
            $client->setAdresse($adresse);
            $client->setAge($age);
            $client->setSexe($sexe);
            $client->setCivil($civil);
            $client->setTelephone($phone);
            $client->setNational($national);
            $client->setCategorie($categorie);
          //  $client->setAccompagne($acc);
            $em->persist($client);
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
            $liste=$em->getRepository('App\Entity\Cliente')->find($id);
            $retour=array(
                'id'=>$liste->getId(),
                'nom' =>$liste->getNom(),
                'prenom' =>$liste->getPrenom(),
                'adresse'=>$liste->getAdresse(),
                'age'=>$liste->getAge(),
                'sexe' =>$liste->getSexe(),
                'civil' =>$liste->getCivil(),
                'phone' =>$liste->getTelephone(),
                'national' =>$liste->getNational(),
                'categorie' =>$liste->getCategorie(),
            );
            return new JsonResponse(['code'=>200,'client'=>$retour],200);
    }

     /**
     * @Route("/{id}/plusclient", name="clientheberge", methods={"GET","POST"})
     */
    public function plusheberge( Cliente $cliente,HebergeRepository $hebergeRepository,Request $request): Response
    {

        if($request->request->Count() > 0)
        {
            $heberge=new Heberge();
             $numcli= $request->request->get('numerocli');
             $numch=$request->request->get('numeroch');
             $date= date_create($request->request->get('dateentre'));
             $paye=$request->request->get('payer');
             $nbjrs=$request->request->get('nbjrs');
             if($nbjrs<0){
                $nbjrs*=(-1);
            }
             $secondEntre= strtotime($request->request->get('dateentre'));
             $secondnbjrs=(($nbjrs-1)*24*3600)+$secondEntre;
             $datesortie=date('Y-m-d H:i:s',$secondnbjrs);
             $compagne=$request->request->get('compagne');
             $manager =$this->getDoctrine()->getManager();
             $prix=$manager->getRepository('App\Entity\Chambre')->find($numch);
             $prixch=$prix->getPrixjournalier();
             $montant=$prixch*$nbjrs;
             $heberge->setNumcli($manager->getRepository('App\Entity\Cliente')->find($numcli));
             $heberge->setNumchambre($manager->getRepository('App\Entity\Chambre')->find($numch));
             $heberge->setDateentre($date);
             $heberge->setNbjours($nbjrs);
             $heberge->setCompagne($compagne);
             $heberge->setMontant($montant);
             $heberge->setDatesortie(date_create($datesortie));
             $heberge->setStatut('ko');
             $heberge->setPayement($paye);
 
             $em=$this->getDoctrine()->getManager();
             $em1=$this->getDoctrine()->getManager();
             $em2=$this->getDoctrine()->getManager();
             $em->persist($heberge);
             $em->flush();
             $numchambre=$em1->getRepository('App\Entity\Chambre')->find($numch);
             $numchambre->setStatut('occupe');
             $em1->persist($numchambre);
             $em1->flush();
             return $this->redirectToRoute('heberge_index');
        }

        $managerone =$this->getDoctrine()->getManager();
        $numcli= $cliente->getId();
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();
        return $this->render('heberge/new1.html.twig', [
            'chambres' =>$managerone->getRepository('App\Entity\Chambre')->findby(['statut'=>'disponible']),
            'heberges' => $hebergeRepository->findAll(),
            'numcli'=>$numcli,
        ]);    
        }


    /**
     * @Route("/{id}")
     */
    public function delete($id)
    {
        //if ($this->isCsrfTokenValid('delete'.$client->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $cli=$entityManager->getRepository('App\Entity\Cliente')->find($id);
            $em=$this->getDoctrine()->getManager();
            $em->remove($cli);
            $em->flush();
            return new JsonResponse(['code'=>200],200);
      //  }
       // return $this->redirectToRoute('client_index');
    }
}
