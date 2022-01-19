<?php

namespace App\Controller;
use Dompdf\Dompdf;
use Numbers_Words;
use Dompdf\Options;
use App\Entity\Heberge;
use App\Repository\ClienteRepository;
use App\Repository\HebergeRepository;
use App\Repository\PuctureRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/heberge")
 */
class HebergeController extends AbstractController
{
    /**
     * @Route("/", name="heberge_index",  methods={"GET","POST"})
     */
    public function index(HebergeRepository $hebergeRepository, ClienteRepository $clienteRepository,Request $request): Response
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
       }
       
        $manager =$this->getDoctrine()->getManager();
        return $this->render('heberge/index.html.twig', [
            'clients' =>$clienteRepository->findAll(),
            'chambres' =>$manager->getRepository('App\Entity\Chambre')->findby(['statut'=>'disponible']),
            'heberges' => $hebergeRepository->findById(),
        ]);
    }

    /**
     * @Route("/{id}", name="heberge_show", methods={"GET"})
     */
    public function show(ClienteRepository $clienteRepository,Heberge $heberge): Response
    {
        $manager =$this->getDoctrine()->getManager();
        return $this->render('heberge/show.html.twig', [
            'clients' =>$clienteRepository->findAll(),
            'chambres' =>$manager->getRepository('App\Entity\Chambre')->findby(['statut'=>'disponible']),
            'heberge' => $heberge,
        ]);
    }

    /**
     * @Route("/hebergemodify", name="modify_heberge", methods={"GET","POST"})
     */
    public function modification(HebergeRepository $hebergeRepository, ClienteRepository $clienteRepository,Request $request): Response
    {
        if($request->request->Count() > 0)
        {
            $numheberge= $request->request->get('id');
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
            $heberge=$manager->getRepository('App\Entity\Heberge')->find($numheberge);
            $chambreUpdate=$heberge->getNumchambre();
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
                $em3=$this->getDoctrine()->getManager();
                $updatechambre=$em3->getRepository('App\Entity\Chambre')->find($chambreUpdate);
                $updatechambre->setStatut('disponible');
                $em3->persist($updatechambre);
              $em3->flush();
                $em1=$this->getDoctrine()->getManager();
                $em->persist($heberge);
                $em->flush();
                $numchambre=$em1->getRepository('App\Entity\Chambre')->find($numch);
                $numchambre->setStatut('occupe');
                $em1->persist($numchambre);
               $em1->flush();
              $this->addFlash('modifierheberge','Hébergement modifié avec succés ');
                return $this->redirectToRoute('heberge_index');
           }
           
        }

     /**
     * @Route("/newhebergeOne")
     */
    public function findClient(Request $request, ClienteRepository $clienteRepository): Response
    {
        if($request->isXmlHttpRequest() || $request->getMethod()=='POST')
        {
            $like=$request->request->get('like');
           // $retour=array(
           //     'okay'=>$like,
           // );
            $​entities​=$clienteRepository->findOneclient($like);
            //foreach ($​entities​ as $entity){
            //    $realEntities[$entity->getId()] = $entity->getNom();
            //}
            return new JsonResponse(['code'=>200,'client'=>$​entities​],200);

        }
    }

    /**
     * @Route("/facture", name="facture_edit",methods={"GET","POST"})
     */
    public function factureEdit(HebergeRepository $hebergeRepository ,Request $request)
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        //$pdfOptions->set('isHtml5ParserEnabled',true);
        $pdfOptions->set('defaultFont', 'Arial');
        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        $numheberge=$request->request->get('id');
        $manager =$this->getDoctrine()->getManager();
        $heberge=$manager->getRepository('App\Entity\Heberge')->find($numheberge);
        $montant=$heberge->getMontant();
        $numberToConvert = $montant;
        $localeEnglish = "fr"; // Or en_GB
        $wordsFromValue = Numbers_Words::toWords($numberToConvert, $localeEnglish);
        $html = $this->renderView('pucture/index.html.twig', [
            'title' => " FACTURE",
            'clients' => $hebergeRepository->editFacture($numheberge),
            'word'=> $wordsFromValue,
            'okay'=> $montant
        ]);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4','portrait');
        // Render the HTML as PDF
        $dompdf->render();
        // Output the generated PDF to Browser (inline view)
        $dompdf->stream("facture.pdf", ["Attachment"=> false]);
    }
    
    /**
     * @Route("/{id}", name="heberge_delete", methods={"POST"})
     */
    public function delete(Request $request, Heberge $heberge): Response
    {
        if ($this->isCsrfTokenValid('delete'.$heberge->getId(), $request->request->get('_token'))) {
            $numchambre=$heberge->getNumchambre();
            $em=$this->getDoctrine()->getManager();
            $numeroch_1=$em->getRepository('App\Entity\Chambre')->find($numchambre);
            $state=$numeroch_1->getStatut();
            if($state=="occupe"){
                $numeroch_1->setStatut("disponible");
                $em->persist($numeroch_1);
                $em->flush();
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($heberge);
                $entityManager->flush();
            }
            else{
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($heberge);
                $entityManager->flush();
            }
        }

        return $this->redirectToRoute('heberge_index');
    }
}
