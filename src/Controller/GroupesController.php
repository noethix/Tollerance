<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Groupes;
use App\Entity\Users;
use App\Entity\Topics;
use App\Form\GroupeType;
use App\Form\JoinType;
use App\Form\TopicType;
use App\Form\DisplayEventType;
use Symfony\Component\HttpFoundation\Request;



class GroupesController extends AbstractController
{
    /**
     * @Route("/groupe/{id}/{page}", name="groupe")
     */
    public function index($id,$page=1, Request $request)
    {
        $user = $this->getUser();

        $groupe = $this->getDoctrine()
            ->getRepository(Groupes::class)
            ->findOneBy(array('idGroupe' => $id));
        $createdby = $groupe -> getCreatedBy();

        $topics = $this->getDoctrine()
            ->getRepository(Topics::class)
            ->findBy(array('idGroupe' => $id), array('lastPostDate' => 'DESC'));

        $pages = ceil((count($topics))/10);

        $topics = $this->getDoctrine()
            ->getRepository(Topics::class)
            ->findBy(array('idGroupe' => $id), array('lastPostDate' => 'DESC'), 10, ($page-1)*10);
							  
        $newTopic = new Topics();

        $form = $this->createForm(TopicType::class, $newTopic, array());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newTopic->setNameTopic($form['nameTopic']->getData());
            $newTopic->setContentTopic($form['contentTopic']->getData());
            $newTopic->setIdGroupe($groupe);

				
            $newTopic->setIdUser($user);
            $now = new \DateTime('now');
            $newTopic->setCreatedDateTopic($now);
            $newTopic->setLastPostDate($now);


            $em = $this->getDoctrine()->getManager();
            $em->persist($newTopic);
            $em->flush();
            

			return $this->redirectToRoute('topic', ['id' => $newTopic->getIdTopic()]);


        }


        $participateForm = $this->createForm(JoinType::class);
        $participateForm->handleRequest($request);

        if ($participateForm->isSubmitted() && $participateForm->isValid()) {
            
            if ($participateForm['join']->getData() == true) {
                $user->addGroupesFk($groupe);
                $groupe->addGroupesUser($user);
            }
            else {
                $user->removeGroupesFk($groupe);
                $groupe->removeGroupesUser($user);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->persist($groupe);
            $em->flush();

        }
        
        $participate = false;

        foreach ($groupe->getGroupesUser() as $groupeUser) {
            if ($groupeUser->getIdUser() == $user->getIdUser()) {
                $participate = true;
            }
        }


        return $this->render('groupes/view_groupe.html.twig', [
            'controller_name' => 'GroupesController',
            'groupe' => $groupe,
            'topics' => $topics,
            'form' => $form->createView(),
			'pages' => $pages,
            'page' => $page,							  
            'participateForm' => $participateForm->createView(),
            'participate' => $participate,
            'user' => $user,
            'createdby' => $createdby,

        ]);
    }

      /**
     * @Route("/groupes/new", name="groupesNew")
     */
    public function newGroupe(Request $request)
    {
        $user = $this->getUser();

        $groupe = new Groupes();
        $now = new \DateTime('now');
        $groupe->setDateCreatedGroupe($now);
        $result = $now->format('Y-m-d');

        $groupe->setCreatedBy($user);

        $photo=$groupe->getPhotoGroup();

        $form = $this->createForm(groupeType::class, $groupe,array());

        $form->handleRequest($request);

        if ($form->isSubmitted()&& $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $groupe->setNameGroup($form['nameGroup']->getData());
            $groupe->setDescriptionGroupe($form['descriptionGroupe']->getData());

        
            if ($form['photoGroup']->getData() != null) {
                $file = $form['photoGroup']->getData();
                    // Efface le fichier et le nom déjà existant
                if($groupe->getPhotoGroup() != null) {
                    $oldFile = $this->getParameter('kernel.project_dir') . '/public/images/groupes/'.$groupe->getPhotoGroup();
                    if (file_exists($oldFile)) {
                        unlink($oldFile);
                    } 
                }
                
                
                $filename = $form['nameGroup']->getData().$result .'.'.$file->guessExtension();
                    $groupe->setPhotoGroup($filename);
                $file->move($this->getParameter('kernel.project_dir') . '/public/images/groupes/', $filename);
            }

            $user->addGroupesFk($groupe);
            $groupe->addGroupesUser($user);

            $em = $this->getDoctrine()->getManager();
            $em->persist($groupe);
            $em->flush();
			
			$this->addFlash(
				'notice',
				'groupe crée!'
			);

            return $this->redirectToRoute('groupe', ['id' => $groupe->getIdGroupe()]);

        }

        
        return $this->render('groupes/formgroup.html.twig', [        
            'form' => $form->createView(),
            'action' => 'créer',

        ]);
    }

    
    /**
     * @Route("/groupes/update/{id}", name="updateGroupe")
     */
    public function updateGroupe($id, Request $request)
    {
        $groupe = $this->getDoctrine()
        ->getRepository(Groupes::class)
        ->findOneBy(array('idGroupe' => $id));

        $photo=$groupe->getPhotoGroup();
        
        $form = $this->createForm(GroupeType::class, $groupe,array());
        
        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $groupe->setNameGroup($form['nameGroup']->getData());
            $groupe->setDescriptionGroupe($form['descriptionGroupe']->getData());
            
            if ($form['photoGroup']->getData() != null) {
                $file = $form['photoGroup']->getData();
                    // Efface le fichier et le nom déjà existant
                if($groupe->getPhotoGroup() != null) {
                    $oldFile = $this->getParameter('kernel.project_dir') . '/public/images/groupes/'.$groupe->getPhotoGroup();
                    if (file_exists($oldFile)) {
                        unlink($oldFile);
                    } 
                }

                
                $filename = $groupe->getIdGroupe().'.'.$file->guessExtension();
                    $groupe->setPhotoGroup($filename);
                $file->move($this->getParameter('kernel.project_dir') . '/public/images/groupes/', $filename);
            } else {
                $groupe->setPhotoGroup($photo);
            }

            $em->flush();
      
            $this->addFlash(
                'notice',
                'groupe modifié!'
            );

            return $this->redirectToRoute('groupe', ['id' => $groupe->getIdGroupe()]);
        }

        return $this->render('groupes/formgroup.html.twig', array(
            'groupe' => $groupe,
            'form' => $form->createView(),
            'action' => 'modifier',
        ));
   
    }

    /**
     * @Route("/groupes/delete/{id}", name="deleteGroupe")
     * 
     */

     public function deleteGroupe($id)
     {
        $groupe = $this->getDoctrine()
        ->getRepository(Groupes::class)
        ->findOneBy(array('idGroupe' => $id));
 

         $em = $this->getDoctrine()->getManager();
         $em->remove( $this->getDoctrine()
         ->getRepository(Groupes::class)
         ->findOneBy(array('idGroupe' => $id)));

        $em->flush();

        $this->addFlash(
            'notice',
            'groupe éffacé!'
        );
        return $this->redirectToRoute('allGroupes');
        }

    /**
     * @Route("/groupes/all", name="allGroupes")
     * 
     */

    public function DisplayGroupes(Request $request)
    {
        
		$form = $this->createForm(DisplayEventType::class,null,array());

        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {

			if ($form['eventsDepartement']->getData()==null&&$form['eventsRegion']->getData()==null) {
				$displayGroupes = $this->getDoctrine()->getRepository(Groupes::class)->findAll();
			} else {
				if ($form['eventsDepartement']->getData()!=null) {
					$displayGroupes = $this->getDoctrine()->getRepository(Groupes::class)->findBy(array('groupesDepartement'=>$form['eventsDepartement']->getData()));
				} else {
					$displayGroupes = $this->getDoctrine()->getRepository(Groupes::class)->findBy(array('groupesRegion'=>$form['eventsRegion']->getData()));
	 
				}
			}
        } else {
            $displayGroupes = $this->getDoctrine()->getRepository(Groupes::class)->findAll();
        }
		
        return $this->render('groupes/displaygroupe.html.twig', array(
            'displayGroupes' => $displayGroupes,
			'form'=>$form->createView())        
            
        );
    }
}
