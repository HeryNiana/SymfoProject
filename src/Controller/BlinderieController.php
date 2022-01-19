<?php

namespace App\Controller;

use App\Entity\Blinderie;
use App\Repository\HebergeRepository;
use App\Repository\BlinderieRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Dompdf\Dompdf;
use Numbers_Words;
use Dompdf\Options;

/**
 * @Route("/blinderie")
 */
class BlinderieController extends AbstractController
{
    /**
     * @Route("/", name="blinderie_index", methods={"GET"})
     */
    public function index(BlinderieRepository $blinderieRepository): Response
    {
        return $this->render('blinderie/index.html.twig', [
            'blinderies' => $blinderieRepository->findAll(),
        ]);
    }

    /**
     * @Route("/blinderie_new")
     */
    public function new(Request $request): Response
    {
        $blinderie = new Blinderie();
        if($request->isXmlHttpRequest() || $request->getMethod()=='POST')
        {
            $name= $request->request->get('nom');
            $prenom=$request->request->get('prenom');
            $adresse= $request->request->get('adresse');
            $sexe=$request->request->get('sexe');
            $phone=$request->request->get('phone');
          //  $acc=$request->request->get('accompagne');

            $blinderie->setNom($name);
            $blinderie->setPrenom($prenom);
            $blinderie->setAdresse($adresse);
            $blinderie->setTelephone($phone);
            $blinderie->setSexe($sexe);

           // $client->setAccompagne($acc);
            $em=$this->getDoctrine()->getManager();
            $em->persist($blinderie);
            $em->flush();
            $numero=['num'=>$blinderie->getId()];
            //$response=new Response();
            //$response->headers->set('content-Type',application/json);
            //
            return new JsonResponse(['code'=>$numero, 'mesage'=>'okay'], 200);
        }
    }
    /**
     * @Route("/liste", name="heberge_edit", methods={"GET","POST"})
     */
    public function list(HebergeRepository $hebergeRepository,Request $request ): Response
    {
        if($request->request->Count() > 0)
        {
            $date1=$request->request->get('date1');
            $date2=$request->request->get('date2');
            $date11=strtotime($date1);
            $date22=strtotime($date2);
            if($date11>$date22){
                $date1a=$date2;
                $date2a=$date1;
            }else{
                $date1a=$date1;
                $date2a=$date2;
            }
            if($date11==$date22){
                $this->addFlash('date','Vous avez entré 2 dates identiques, veuillez resaisir deux dates différentes.');
                return $this->render('client/list.html.twig', [
                    'heberges' => $hebergeRepository->findByRecette(),
                    'montants'=>  $hebergeRepository->findByRecette_1(),
                ]);
            }
            else{
                $this->addFlash('dateinfo','Vous avez entré 2 dates identiques, veuillez resaisir deux dates différentes.');
                return $this->render('client/list.html.twig', [
                'heberges' => $hebergeRepository->findByRecetteok($date1a,$date2a),
                'montants'=>  $hebergeRepository->findByRecetteok_1($date1a,$date2a),
                'date1'=>$date1a,
                'date2'=>$date2a,
                ]);
            }
        }else{
                return $this->render('client/list.html.twig', [
                'heberges' => $hebergeRepository->findByRecette(),
                'montants'=>  $hebergeRepository->findByRecette_1(),
            ]);
        }
    }

      /**
     * @Route("/listepdf", name="heberge_edit_pdf", methods={"GET","POST"})
     */
    public function listpdf(HebergeRepository $hebergeRepository,Request $request )
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        //$pdfOptions->set('isHtml5ParserEnabled',true);
        $pdfOptions->set('defaultFont', 'Arial');
        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        if($request->request->Count() > 1)
        {
            $date1=$request->request->get('dateone');
            $date2=$request->request->get('datetwo');
            $date11=strtotime($date1);
            $date22=strtotime($date2);
            if($date11>$date22){
                $date1a=$date2;
                $date2a=$date1;
            }else{
                $date1a=$date1;
                $date2a=$date2;
            }
            if($date11==$date22){
                $montant=$request->request->get('montant_no_date');
                $hebergenumber=$request->request->get('numberheberge');
                $numberToConvert = $montant;
                $localeEnglish = "fr"; // Or en_GB
                $wordsFromValue = Numbers_Words::toWords($numberToConvert, $localeEnglish);
                // Retrieve the HTML generated in our twig file
                $html = $this->renderView('client/list_pdf.html.twig', [
                    'heberges' => $hebergeRepository->findByRecette(),
                    'word'=> $wordsFromValue,
                    'okay'=> $montant,
                    'hebergenumber'=>$hebergenumber,
                ]);
                // Load HTML to Dompdf
                $dompdf->loadHtml($html);
                // (Optional) Setup the paper size and orientation '
                $dompdf->setPaper('A3','portrait');
                // Render the HTML as PDF
                $dompdf->render();
                // Output the generated PDF to Browser (inline view)
                $dompdf->stream("mypdfList1.pdf", ["Attachment"=> false]);
            }
            else {
                $montant=$request->request->get('montant');
                $hebergenumber=$request->request->get('numberheberge');
                $numberToConvert = $montant;
                $localeEnglish = "fr"; // Or en_GB
                $wordsFromValue = Numbers_Words::toWords($numberToConvert, $localeEnglish);
                // Retrieve the HTML generated in our twig file
                $html = $this->renderView('client/list_pdf1.html.twig', [
                    'heberges' => $hebergeRepository->findByRecetteok($date1a,$date2a),
                    'word'=> $wordsFromValue,
                    'okay'=> $montant,
                    'date1'=>$date1a,
                    'date2'=>$date2a,
                    'hebergenumber'=>$hebergenumber,

                ]);
                // Load HTML to Dompdf
                $dompdf->loadHtml($html);
                // (Optional) Setup the paper size and orientation '
                $dompdf->setPaper('A3','portrait');
                // Render the HTML as PDF
                $dompdf->render();
                // Output the generated PDF to Browser (inline view)
                $dompdf->stream("mypdfList1.pdf", ["Attachment"=> false]);
    
            }
           
        }else{
            $montant=$request->request->get('montant_no_date');
            $hebergenumber=$request->request->get('numberheberge');
            $numberToConvert = $montant;
            $localeEnglish = "fr"; // Or en_GB
            $wordsFromValue = Numbers_Words::toWords($numberToConvert, $localeEnglish);
            // Retrieve the HTML generated in our twig file
            $html = $this->renderView('client/list_pdf.html.twig', [
                'heberges' => $hebergeRepository->findByRecette(),
                'word'=> $wordsFromValue,
                'okay'=> $montant,
                'hebergenumber'=>$hebergenumber,

            ]);
            // Load HTML to Dompdf
            $dompdf->loadHtml($html);
            // (Optional) Setup the paper size and orientation '
            $dompdf->setPaper('A3','portrait');
            // Render the HTML as PDF
            $dompdf->render();
            // Output the generated PDF to Browser (inline view)
            $dompdf->stream("mypdfList.pdf", ["Attachment"=> false]);
        }
    }


    /**
     * @Route("/listheberge", name="heberge_list", methods={"GET","POST"})
     */
    public function listheberge(HebergeRepository $hebergeRepository,Request $request ): Response
    {
        if($request->request->Count() > 0)
        {
            $date1=$request->request->get('date1');
            $date2=$request->request->get('date2');
            $date11=strtotime($date1);
            $date22=strtotime($date2);
            if($date11>$date22){
                $date1a=$date2;
                $date2a=$date1;
            }else{
                $date1a=$date1;
                $date2a=$date2;
                $date1b=date_create($date1a);
                $date2b=date_create($date2a);
            }
            if($date11==$date22){
                $this->addFlash('date','Vous avez entré 2 dates identiques, veuillez resaisir deux dates différentes.');
                return $this->render('client/listeheberge.html.twig', [
                    'heberges' => $hebergeRepository->findByHeberge(),
                    'montants'=>  $hebergeRepository->findByRecette_1(),
                    'numbernationals'=>$hebergeRepository->findByHeberge_2(),

                ]);
            }
            $this->addFlash('dateinfo','Vous avez entré 2 dates identiques, veuillez resaisir deux dates différentes.');
            return $this->render('client/listeheberge.html.twig', [
            'heberges' => $hebergeRepository->listeheberge($date1a,$date2a),
            'montants' => $hebergeRepository->listeheberge_1($date1a,$date2a),
            'numbernationals'=>$hebergeRepository->findByHeberge_3($date1a,$date2a),

            'date1'=>$date1a,
            'date2'=>$date2a,
            ]);

        }else{
                return $this->render('client/listeheberge.html.twig', [
                'heberges' => $hebergeRepository->findByHeberge(),
                'montants'=>  $hebergeRepository->findByRecette_1(),
                'numbernationals'=>$hebergeRepository->findByHeberge_2(),
            ]);
        }
    }

     /**
     * @Route("/listehebergepdf", name="hebergelist_edit_pdf", methods={"GET","POST"})
     */
    public function listhebergepdf(HebergeRepository $hebergeRepository,Request $request )
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        //$pdfOptions->set('isHtml5ParserEnabled',true);
        $pdfOptions->set('defaultFont', 'Arial');
        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        if($request->request->Count() > 1)
        {
            $date1=$request->request->get('dateone');
            $date2=$request->request->get('datetwo');
            $date11=strtotime($date1);
            $date22=strtotime($date2);
            if($date11>$date22){
                $date1a=$date2;
                $date2a=$date1;
            }else{
                $date1a=$date1;
                $date2a=$date2;
            }
            if($date11==$date22){
                $montant=$request->request->get('montant_no_date');
                $hebergenumber=$request->request->get('numberheberge');
                $numberToConvert = $montant;
                $localeEnglish = "fr"; // Or en_GB
                $wordsFromValue = Numbers_Words::toWords($numberToConvert, $localeEnglish);
                // Retrieve the HTML generated in our twig file
                $html = $this->renderView('client/listehebergepdf.html.twig', [
                    'heberges' => $hebergeRepository->findByHeberge(),
                    'numbernationals'=>$hebergeRepository->findByHeberge_2(),
                    'word'=> $wordsFromValue,
                    'okay'=> $montant,
                    'hebergenumber'=>$hebergenumber,
                ]);
                // Load HTML to Dompdf
                $dompdf->loadHtml($html);
                // (Optional) Setup the paper size and orientation '
                $dompdf->setPaper('A3','portrait');
                // Render the HTML as PDF
                $dompdf->render();
                // Output the generated PDF to Browser (inline view)
                $dompdf->stream("listehebergepdf.pdf", ["Attachment"=> false]);
            }
            else {
                $montant=$request->request->get('montant');
                $hebergenumber=$request->request->get('numberheberge');
                $numberToConvert = $montant;
                $localeEnglish = "fr"; // Or en_GB
                $wordsFromValue = Numbers_Words::toWords($numberToConvert, $localeEnglish);
                $html = $this->renderView('client/listehebergepdf1.html.twig', [
                    'heberges' => $hebergeRepository->listeheberge($date1a,$date2a),
                    'numbernationals'=>$hebergeRepository->findByHeberge_3($date1a,$date2a),
                    'word'=> $wordsFromValue,
                    'okay'=> $montant,
                    'date1'=>$date1a,
                    'date2'=>$date2a,
                    'hebergenumber'=>$hebergenumber,

                ]);
                $dompdf->loadHtml($html);
                $dompdf->setPaper('A3','portrait');
                $dompdf->render();
                $dompdf->stream("listehebergepdf.pdf", ["Attachment"=> false]);
    
            }
           
        }else{
            $montant=$request->request->get('montant_no_date');
            $hebergenumber=$request->request->get('numberheberge');
            $numberToConvert = $montant;
            $localeEnglish = "fr"; // Or en_GB
            $wordsFromValue = Numbers_Words::toWords($numberToConvert, $localeEnglish);
            $html = $this->renderView('client/listehebergepdf.html.twig', [
                'heberges' => $hebergeRepository->findByHeberge(),
                'numbernationals'=>$hebergeRepository->findByHeberge_2(),
                'word'=> $wordsFromValue,
                'okay'=> $montant,
                'hebergenumber'=>$hebergenumber,

            ]);
            // Load HTML to Dompdf
            $dompdf->loadHtml($html);
            // (Optional) Setup the paper size and orientation '
            $dompdf->setPaper('A3','portrait');
            // Render the HTML as PDF
            $dompdf->render();
            // Output the generated PDF to Browser (inline view)
            $dompdf->stream("listehebergepdf.pdf", ["Attachment"=> false]);
        }
    }


    /**
     * @Route("/alert}", name="alert", methods={"GET"})
     */
    public function listealert(HebergeRepository $hebergeRepository): Response
    {
        $statut='ko';
        $date=date('Y-m-d');
        return $this->render('chambre/alert.html.twig', [
            'chambres'=>$hebergeRepository->findByStatutlist($date,$statut),
        ]);
    }

    /**
     * @Route("/{id}/edit")
     */
    public function show($id)
    {
        $em=$this->getDoctrine()->getManager();
        // if($request->isXmlHttpRequest() || $request->getMethod()=='GET')
        // {
             //$numcli= $request->request->get("id");
             $liste=$em->getRepository('App\Entity\Blinderie')->find($id);
             $retour=array(
                 'id'=>$liste->getId(),
                 'nom' =>$liste->getNom(),
                 'prenom' =>$liste->getPrenom(),
                 'adresse'=>$liste->getAdresse(),
                 'phone' =>$liste->getTelephone(),
                 'sexe' =>$liste->getSexe(),
                // 'acc' =>$liste->getAccompagne(),
             );
             return new JsonResponse(['code'=>200,'client'=>$retour],200);
    }

    /**
     * @Route("/miseajourblinderie")
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
            $sexe=$request->request->get('sexe');
            $phone=$request->request->get('phone');
           // $acc=$request->request->get('accompagne');

            $blinderie=$manager->getRepository('App\Entity\Blinderie')->find($numcli);

            $blinderie->setNom($name);
            $blinderie->setPrenom($prenom);
            $blinderie->setAdresse($adresse);
            $blinderie->setTelephone($phone);
            $blinderie->setSexe($sexe);
          //  $client->setAccompagne($acc);
            $em->persist($blinderie);
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
            $cli=$entityManager->getRepository('App\Entity\Blinderie')->find($id);
            $em=$this->getDoctrine()->getManager();
            $em->remove($cli);
            $em->flush();
            return new JsonResponse(['code'=>200],200);
      //  }
       // return $this->redirectToRoute('client_index');
    }
}
