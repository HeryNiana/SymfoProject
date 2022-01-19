<?php

namespace App\Controller;

use App\Entity\Chambre;
use App\Entity\Heberge;
use App\Form\ChambreType;
use App\Form\Chambre1Type;
use App\Repository\ChambreRepository;
use App\Repository\ClienteRepository;
use App\Repository\HebergeRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/chambre")
 */
class ChambreController extends AbstractController
{
    /**
     * @Route("/", name="chambre_index",methods={"GET","POST"})
     */
    public function index(ChambreRepository $chambreRepository,Request $request,HebergeRepository $hebergeRepository): Response
    {
        $em=$this->getDoctrine()->getManager();
        $chambre = new Chambre();
        $form = $this->createForm(Chambre1Type::class, $chambre);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $codechambre=$request->request->get('codech');
                $images = $form->get('photo')->getData();
                // On boucle sur les images
                foreach($images as $image){
                // On génère un nouveau nom de fichier
                $fichier = md5(uniqid()).'.'.$image->guessExtension();
                // On copie le fichier dans le dossier uploads
                $image->move(
                $this->getParameter('images_directory'),
                $fichier
                );
                // On crée l'image dans la base de données
                $chambre->setStatut('disponible');
                $chambre->setHeureMenage('to define');
                $chambre->setPhoto($fichier);
                $chambre->setStateMenage('false');
                }
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($chambre);
                $entityManager->flush();
                return $this->redirectToRoute('chambre_index');
        }
        //pour la gestion de menage
        $date=date('Y-m-d');
        $liste=$em->getRepository('App\Entity\Dateday')->find(1);
        $olddate=$liste->getDaytoday();
        if($date==$olddate)
        {
            $statut='ko';
            $date=date('Y-m-d');
            return $this->render('chambre/index.html.twig', [
                'chambres' => $chambreRepository->findAll(),
                'form' => $form->createView(),
                'alert'=>$hebergeRepository->findByStatut($date,$statut),
            ]);
        }
        else{
            $liste->setDaytoday($date);
            $em->persist($liste);
            $em->flush();
            $true='true';
            $chambrelist=$em->getRepository('App\Entity\Chambre')->findBy(['stateMenage'=>$true]);
            foreach ($chambrelist as $statemenage){
            $statemenage->setStateMenage('false');
            $em->persist($statemenage);
            $em->flush();
            }
            $statut='ko';
            $date=date('Y-m-d');
            return $this->render('chambre/index.html.twig', [
                'chambres' => $chambreRepository->findAll(),
                'form' => $form->createView(),
                'alert'=>$hebergeRepository->findByStatut($date,$statut),
            ]);
        }
    }

    /**
     * @Route("/{id}", name="chambre_show", methods={"GET"})
     */

    public function show(Chambre $chambre): Response
    {
        return $this->render('chambre/show.html.twig', [
            'chambre' => $chambre,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="chambre_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Chambre $chambre): Response
    {
        $form = $this->createForm(Chambre1Type::class, $chambre);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $images = $form->get('photo')->getData();
            // On boucle sur les images
            foreach($images as $image){
            // On génère un nouveau nom de fichier
            $fichier = md5(uniqid()).'.'.$image->guessExtension();
            // On copie le fichier dans le dossier uploads
            $image->move(
            $this->getParameter('images_directory'),
            $fichier
            );
            $photo=$chambre->getPhoto();
            unlink($this->getParameter('images_directory').'/'.$photo);

            // On crée l'image dans la base de données
            $chambre->setPhoto($fichier);
        }
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('modifier','la modification est terminée avec succéss');
            return $this->redirectToRoute('chambre_index');
        }

        return $this->render('chambre/edit.html.twig', [
            'chambre' => $chambre,
            'form' => $form->createView(),
        ]);
    }
    
     /**
     * @Route("/{id}/editer")
     */
    public function showing( $id)
    {
        $em=$this->getDoctrine()->getManager();
            $liste=$em->getRepository('App\Entity\Chambre')->find($id);
            $retour=array(
                'id'=>$liste->getId(),
            );
            return new JsonResponse(['code'=>200,'client'=>$retour],200);
    }

     /**
     * @Route("/{id}/edite", name="chambre_edit1", methods={"GET","POST"})
     */
    public function editer(Request $request, Chambre $chambre): Response
    {
        $form = $this->createForm(ChambreType::class, $chambre);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $images = $form->get('photo')->getData();
            // On boucle sur les images
            foreach($images as $image){
            // On génère un nouveau nom de fichier
            $fichier = md5(uniqid()).'.'.$image->guessExtension();
            // On copie le fichier dans le dossier uploads
            $image->move(
            $this->getParameter('images_directory'),
            $fichier
            );
            $photo=$chambre->getPhoto();
            unlink($this->getParameter('images_directory').'/'.$photo);

            // On crée l'image dans la base de données
            $chambre->setPhoto($fichier);
        }
            $chambre->setStateMenage('false');
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('modifier','la modification est terminée avec succéss');
            return $this->redirectToRoute('chambre_index');
        }

        return $this->render('chambre/edit1.html.twig', [
            'chambre' => $chambre,
            'form' => $form->createView(),
        ]);
    }

     /**
     * @Route("/{id}/update", name="chambremise", methods={"GET","POST"})
     */
    public function miseajour( Chambre $chambre): Response
    {
        $chambre->setStatut("disponible");
        $id=$chambre->getId();
        $manager =$this->getDoctrine()->getManager();
        $heberge=$manager->getRepository('App\Entity\Heberge')->findby(['numchambre'=>$id]);
        foreach ($heberge as $okay)
        {
            $okay->setStatut('ok');
            $manager->persist($chambre);
            $manager->flush();
        }
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();
        return $this->redirectToRoute('chambre_index');
    }

     /**
     * @Route("/{id}/update_", name="chambremiseheberge", methods={"GET","POST"})
     */
    public function miseajourfromheberge( Chambre $chambre): Response
    {
        $chambre->setStatut("disponible");
        $id=$chambre->getId();
        $manager =$this->getDoctrine()->getManager();
        $heberge=$manager->getRepository('App\Entity\Heberge')->findby(['numchambre'=>$id]);
        foreach ($heberge as $okay)
        {
            $okay->setStatut('ok');
            $manager->persist($chambre);
            $manager->flush();
        }
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();
        return $this->redirectToRoute('heberge_index');
    }

     /**
     * @Route("/{id}/plus", name="chambreheberge", methods={"GET","POST"})
     */
    public function plusheberge( Chambre $chambre, ClienteRepository $clienteRepository,HebergeRepository $hebergeRepository,Request $request): Response
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
            // $em2=$this->getDoctrine()->getManager();
             $em->persist($heberge);
             $em->flush();
             $numchambre=$em1->getRepository('App\Entity\Chambre')->find($numch);
             $numchambre->setStatut('occupe');
             $em1->persist($numchambre);
             $em1->flush();
             return $this->redirectToRoute('heberge_index');
        }

        $numchu= $chambre->getId();
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();
        return $this->render('heberge/new.html.twig', [
            'clients' =>$clienteRepository->findAll(),
            'heberges' => $hebergeRepository->findAll(),
            'numch'=>$numchu
        ]);    
        }


         /**
     * @Route("/{id}/editprice")
     */
    public function showPrice($id)
    {
        $manager =$this->getDoctrine()->getManager();
        $prix=$manager->getRepository('App\Entity\Chambre')->find($id);
        $prixch=$prix->getPrixjournalier();
            $retour=array(
                'prix'=>$prixch,
            );
            return new JsonResponse(['code'=>200,'client'=>$retour],200);
    }

    /**
     * @Route("/{id}", name="chambre_delete", methods={"POST"})
     */
    public function delete(Request $request, Chambre $chambre): Response
    {
        if ($this->isCsrfTokenValid('delete'.$chambre->getId(), $request->request->get('_token'))) {
            $photo=$chambre->getPhoto();
            unlink($this->getParameter('images_directory').'/'.$photo);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($chambre);
            $entityManager->flush();
            return $this->redirectToRoute('chambre_index');
        }

    }
}
