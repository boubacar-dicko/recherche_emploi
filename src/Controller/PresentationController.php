<?php

namespace App\Controller;

use App\Entity\Cv;
use App\Entity\Offre;
use App\Entity\User;
use App\Repository\CvRepository;
use App\Repository\OffreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class PresentationController extends AbstractController
{
    #[Route("/")]
    public function accueil(): Response
    {
        return $this->render('accueil.html.twig');
    }

   

    #[Route("/presentation/register", "methods={POST, GET}")]
    public function register(Request $request, EntityManagerInterface $em): Response
    { 
        if($request->isMethod('POST'))
        {
            $data=$request->request->all();
            
           if ($this->isCsrfTokenValid('create_user',$data['csrf_token']))
            { 
                $user = new User;
                
                $user->setNom($data['nom']);
                $user->setPrenom($data['prenom']);
                $user->setEmail($data['email']);
                $user->setPassword($data['password']);
                $user->setProfil($data['profil']);

                $em->persist($user);
                $em->flush();
           }
            
            return $this->redirectToRoute('app_login');

      }
        
        return $this->render('/presentation/register.html.twig');
    }

    #[Route("/presentation/formulaireCV")]
    public function editCV(Request $request, EntityManagerInterface $em): Response
    {     
        
        if($request->isMethod('POST'))
        {

            $data=$request->request->all();
            
            if ($this->isCsrfTokenValid('create_user',$data['csrf_token']))
            {
           
                $cv = new Cv();
                
                $cv->setNom($data['nom']);
                $cv->setPrenom($data['prenom']);
                $cv->setEmail($data['email']);
                $cv->setAge($data['age']);
                $cv->setAdresse($data['adresse']);
                $cv->setTelephone($data['telephone']);
                $cv->setAdresse($data['adresse']);
                $cv->setSpecialite($data['specialite']);
                $cv->setNiveauEtude($data['etude']);
                $cv->setExperienceProfessionnelle($data['experience']);

                $em->persist($cv);
                $em->flush();
            }

                return $this->redirectToRoute('app_presentation_listoffre');
     }
    return $this->render('/presentation/formulaireCV.html.twig');
 }

 
    #[Route("/presentation/formulaireOffre")]
    public function editOffre(Request $request, EntityManagerInterface $em): Response
    {     
        
        if($request->isMethod('POST'))
        {

            $data=$request->request->all();
            
            if ($this->isCsrfTokenValid('create_user',$data['csrf_token']))
            {
           
                $offre = new Offre();
                
                $offre->setNomOffre($data['nomOffre']);
                $offre->setNomEntreprise($data['nomEntreprise']);
                $offre->setDescription($data['description']);
                

                $em->persist($offre);
                $em->flush();
            }

                return $this->redirectToRoute('app_presentation_listcv');
     }
    return $this->render('/presentation/formulaireOffre.html.twig');
 }



   
    #[Route("/presentation/listeCv")]
    public function listCv(CvRepository $cvRep):Response
    {     
        $cvs = $cvRep->findAll();
        //dd($cvs);

        return $this->render('/presentation/listeCv.html.twig', compact('cvs'));
    }

    #[Route("/presentation/listeOffre")]
    public function listOffre(OffreRepository $OffreRep):Response
    {     
        $offres = $OffreRep->findAll();
        

        return $this->render('/presentation/listeOffre.html.twig', compact('offres'));
    }

     #[Route("/presentation/index")]
     public function index(): Response
     {
         return $this->render('presentation/index.html.twig');
     }

}
