<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Activites;
use App\Entity\Posts;
use App\Entity\Users;
use App\Form\ActiviteType;
use App\Form\PostType;
use App\Form\ParticipateType;
use App\Form\DisplayActivitesType;
use Symfony\Component\HttpFoundation\Request;

class ActivitesController extends AbstractController
{
    /**
     * @Route("/activite/{id}/{page}", name="activite")
     */
    public function index($id, $page=1, Request $request)
    {
        $user = $this->getUser();

        $activite = $this->getDoctrine()
            ->getRepository(Activites::class)
            ->findOneBy(array('idActivites' => $id));

        $createdby = $activite -> getUser();

        $posts = $this->getDoctrine()
            ->getRepository(Posts::class)
			->findBy(array('idActivite' => $id), array('createdDatePost' => 'DESC'));

        $pages = ceil((count($posts))/10);

        $posts = $this->getDoctrine()
            ->getRepository(Posts::class)
            ->findBy(array('idActivite' => $id), array('createdDatePost' => 'DESC'), 10, ($page-1)*10);
        $newPost = new Posts();

        $form = $this->createForm(PostType::class, $newPost, array());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newPost->setContentPost($form['contentPost']->getData());
            $newPost->setIdActivite($activite);

            $newPost->setPostsUser($user);
            $now = new \DateTime('now');
            $newPost->setCreatedDatePost($now);


            $em = $this->getDoctrine()->getManager();
            $em->persist($newPost);
            $em->flush();
            
            $newPost = new Posts();

            $form = $this->createForm(PostType::class, $newPost, array());

			return $this->redirect($this->generateUrl('activite', ['id' => $id]) . '#comments');
																					
        }

        $participateForm = $this->createForm(ParticipateType::class);
        $participateForm->handleRequest($request);

        if ($participateForm->isSubmitted() && $participateForm->isValid()) {
            
            if ($participateForm['participate']->getData() == true) {
                $user->addActivitesFk($activite);
                $activite->addIdActivitesUser($user);
            }
            else {
                $user->removeActivitesFk($activite);
                $activite->removeIdActivitesUser($user);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->persist($activite);
            $em->flush();

        }

        $participate = false;

        foreach ($activite->getIdActivitesUser() as $activiteUser) {
            if ($activiteUser->getIdUser() == $user->getIdUser()) {
                $participate = true;
            }
        }


        return $this->render('activites/view_activite.html.twig', [
            'controller_name' => 'ActivitesController',
            'activite' => $activite,
            'posts' => $posts,
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
     * @Route("/activites/new", name="activitesNew")
     */
    public function newActivites(Request $request)
    {
        $activites = new Activites();
        $now = new \DateTime('now');
        $activites->setDateCreatedActivites($now);
        $result = $now->format('Y-m-d');

        $user = $this->getUser();

        $photo=$activites->getPhotoActivites();

        $form = $this->createForm(activiteType::class, $activites,array());

        $form->handleRequest($request);

        if ($form->isSubmitted()&& $form->isValid()) {
            $activites->setNameActvites($form['nameActvites']->getData());
            $activites->setDescriptionActivites($form['descriptionActivites']->getData());
            $activites->setLocationActivites($form['locationActivites']->getData());
            $activites->setDateActivites($form['dateActivites']->getData());
            $activites->setPriceActivite($form['priceActivite']->getData());
                
            if ($form['photoActivites']->getData() != null) {
                $file = $form['photoActivites']->getData();
                    // Efface le fichier et le nom déjà existant
                if($activites->getPhotoActivites() != null) {
                    $oldFile = $this->getParameter('kernel.project_dir') . '/public/images/activites/'.$activites->getPhotoActivites();
                    if (file_exists($oldFile)) {
                        unlink($oldFile);
                    } 
                }
                
                
                $filename = $form['nameActvites']->getData().$result .'.'.$file->guessExtension();
                    $activites->setPhotoActivites($filename);
                $file->move($this->getParameter('kernel.project_dir') . '/public/images/activites/', $filename);
            }
            
            $user = $this->getUser();

            $user->addActivitesFk($activites);
            $activites->addIdActivitesUser($user);

            $activites->setUser($user);
                $em = $this->getDoctrine()->getManager();
                $em->persist($activites);
                $em->flush();

            $this->addFlash(
                'notice',
                'Activité crée!'
            );


            return $this->redirectToRoute('activite', ['id' => $activites->getIdActivites()]);
        }
    
        return $this->render('activites/formactivite.html.twig', [        
            'activite' => $activites,
            'form' => $form->createView(),
            'action' => 'créer',
        ]);

    }


    /**
     * @Route("/activites/update/{id}", name="updateActivites")
     */

    public function updateActivites($id, Request $request)
    {
        $activites = $this->getDoctrine()
        ->getRepository(Activites::class)
        ->findOneBy(array('idActivites' => $id));
        $photo=$activites->getPhotoActivites();
        
        $form = $this->createForm(ActiviteType::class, $activites,array());
        
        $form->handleRequest($request);

        if ($form->isSubmitted()&& $form->isValid()) {
            
            $activites->setNameActvites($form['nameActvites']->getData());
            $activites->setDescriptionActivites($form['descriptionActivites']->getData());
            $activites->setLocationActivites($form['locationActivites']->getData());
            $activites->setDateActivites($form['dateActivites']->getData());
            $activites->setPriceActivite($form['priceActivite']->getData());
                
            if ($form['photoActivites']->getData() != null) {
                $file = $form['photoActivites']->getData();
                    // Efface le fichier et le nom déjà existant
                if($activites->getPhotoActivites() != null) {
                    $oldFile = $this->getParameter('kernel.project_dir') . '/public/images/activites/'.$activites->getPhotoActivites();
                    if (file_exists($oldFile)) {
                        unlink($oldFile);
                    } 
                }
                
                
                $filename = $form['nameActivites']->getData().$result .'.'.$file->guessExtension();
                    $activites->setPhotoActivites($filename);
                $file->move($this->getParameter('kernel.project_dir') . '/public/images/activites/', $filename);
            } else {
                $activites->setPhotoActivites($photo);
            }
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($activites);
            $em->flush();
      
            $this->addFlash(
                'notice',
                'activité modifié!'
            );

            return $this->redirectToRoute('activite', ['id' => $activites->getIdActivites()]);
        }

        return $this->render('activites/formactivite.html.twig', array(
            'activites' => $activites,
            'form' => $form->createView(),
            'action' => 'modifier',
        ));
   
    }

    /**
     * @Route("/activites/delete/{id}", name="deleteActivites")
     * 
     */

     public function deleteActivites($id)
     {
         $em = $this->getDoctrine()->getManager();
         $em->remove( $this->getDoctrine()
         ->getRepository(Activites::class)
         ->findOneBy(array('idActivites' => $id)));

        $em->flush();

        $this->addFlash(
            'notice',
            'activité éffacé!'
        );
        
        return $this->redirectToRoute('allActivites');
        }

    /**
     * @Route("/activites/all", name="allActivites")
     * 
     */

    public function DisplayActivites(Request $request)

    {
        
        $form = $this->createForm(DisplayActivitesType::class,null,array());


        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
           
            if ($form['departement']->getData()==null&&$form['region']->getData()==null) {

                $displayActivites = $this->getDoctrine()->getRepository(Activites::class)->findAll();
            } else {
            if ($form['departement']->getData()!=null) {
                $displayActivites = $this->getDoctrine()->getRepository(Activites::class)->findBy(array('departement'=>$form['departement']->getData()));
            } else {
                $displayActivites = $this->getDoctrine()->getRepository(Activites::class)->findBy(array('region'=>$form['region']->getData()));
                
                
            }
        }

        } else {
            $displayActivites = $this->getDoctrine()->getRepository(Activites::class)->findAll();
        }
        return $this->render('activites/displayactivites.html.twig', array(
            'displayactivites' => $displayActivites,
            
            'form'=>$form->createView())        
            
        );
    }

}
