<?php

namespace App\Controller;

use App\Entity\Personne;
use App\Repository\PersonneRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;  
 /**
 * @Route("/api")

 */
class ApiController extends AbstractController
{
    /**
     * @Route("/personnes/", 
     name="api_personne_add", methods={"POST"})
     */
    public function add(Request $request,EntityManagerInterface $em): Response
    {
        // objet JSON personne
        $p = json_decode($request->getContent());
    	// $p->nom
    	// création d'un objet personne
    	$personne = new Personne();
    	// hydrater
    	$personne->setNom($p->nom);
    	$personne->setPrenom($p->prenom);
    	//$entityManager = $this->getDoctrine()->getManager();
        $em->persist($personne);
        $em->flush();

    	$tab["id"] = $personne->getId();
        return $this->json($tab);
    }
    /**
     * @Route("/personnes/{id}", 
     name="api_personne_remove", methods={"DELETE"})
     */
    public function remove(Personne $personne,EntityManagerInterface $em): Response
    {
        $em->remove($personne);
        $em->flush();
    	$tab["delete"] = "ok";
        return $this->json($tab);
    }
    /**
     * @Route("/personnes/{id}", 
     name="api_personne_update", methods={"PUT"})
     */
    public function update(Request $request,Personne $personne,EntityManagerInterface $em): Response
    {
        $p = json_decode($request->getContent());
        // modifier son nouveau nom  et prenom
        $personne->setNom($p->nom);
        $personne->setPrenom($p->prenom);
        $this->getDoctrine()->getManager()->flush();
    	$tab["id"] = $personne->getId();
        return $this->json($tab);
    }
    
      /**
     * @Route("/personnes/", 
     name="api_personne_all", methods={"GET"})
     */
    public function all(PersonneRepository $repo): Response
    {
        	
        return $this->json($repo->findAll());
    }
    /**
     * @Route("/personnes/{id}", 
     name="api_personne_one", methods={"GET"})
     */
    public function one(Personne $personne): Response
    {
        return $this->json($personne);
        
    }

}
