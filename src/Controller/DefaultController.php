<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Region;
use App\Entity\Departement;


class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="default")
     */
    public function index()
    {
        return $this->redirectToRoute('home');
    }

	/**
     *  @Route("/departments/{id}", name="departments_region_root")
	 *  @Route("/user/inscription/departments/{id}", name="departments_region")
	 *  @Route("/event/new/departments/{id}", name="departments_region_event")
	 *  @Route("/activites/new/departments/{id}", name="departments_region_activity")
     *  @Route("/event/all/departments/{id}", name="departments_region_event_all")
     *  @Route("/event/departments/{id}", name="events_display_region_dep")
     *  @Route("/activites/departments/{id}", name="activites_display_region_dep")
     * 
     */
    public function loadDepartments($id)
    {
        
        $region = $this->getDoctrine()->getRepository(Region::class)
        ->findOneBy(array('idRegion' => $id));
        
        $departments = $this->getDoctrine()->getRepository(Departement::class)
        ->findBy(array('departementRegion' => $region),array('nameDepartment'=>'ASC'));
    
        $encoders = [new JsonEncoder()];

        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);
        
        $jsonContent = $serializer->serialize($departments, 'json');

        return new JsonResponse($jsonContent);
    }

	
}
