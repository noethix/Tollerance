<?php

namespace App\Controller;

use App\Entity\Posts;
use App\Entity\Users;
use App\Entity\Events;
use App\Entity\Departement;
use App\Form\PostType;
use App\Form\EventType;
use App\Form\GoType;
use App\Form\DisplayEventType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;




class EventController extends AbstractController
{
    /**
     * @Route("/events/{id}/{page}", name="event")
     */
    public function index($id, $page=1, Request $request)
    {
        $user = $this->getUser();

        $event = $this->getDoctrine()
            ->getRepository(Events::class)
            ->findOneBy(array('idEvent' => $id));

        $createdby = $event -> getCreatedByUser();

        $posts = $this->getDoctrine()
            ->getRepository(Posts::class)
            ->findBy(array('idEvent' => $id), array('createdDatePost' => 'DESC'));

        $pages = ceil((count($posts))/10);

        $posts = $this->getDoctrine()
            ->getRepository(Posts::class)
            ->findBy(array('idEvent' => $id), array('createdDatePost' => 'DESC'), 10, ($page-1)*10);

        $newPost = new Posts();

        $form = $this->createForm(PostType::class, $newPost, array());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newPost->setContentPost($form['contentPost']->getData());
            $newPost->setIdEvent($event);


            $newPost->setPostsUser($user);
            $now = new \DateTime('now');
            $newPost->setCreatedDatePost($now);


            $em = $this->getDoctrine()->getManager();
            $em->persist($newPost);
            $em->flush();
            
            $newPost = new Posts();

            $form = $this->createForm(PostType::class, $newPost, array());

			return $this->redirect($this->generateUrl('event', ['id' => $id]) . '#comments');
																				
        }

        $participateForm = $this->createForm(GoType::class);
        $participateForm->handleRequest($request);

        if ($participateForm->isSubmitted() && $participateForm->isValid()) {
            
            if ($participateForm['go']->getData() == true) {
                $user->addEventFk($event);
                $event->addEventsUser($user);
            }
            else {
                $user->removeEventFk($event);
                $event->removeEventsUser($user);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->persist($event);
            $em->flush();

        }

        $participate = false;

        foreach ($event->getEventsUser() as $eventUser) {
            if ($eventUser->getIdUser() == $user->getIdUser()) {
                $participate = true;
            }
        }

        return $this->render('event/view_event.html.twig', [
            'controller_name' => 'EventController',
            'event' => $event,
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
     * @Route("/event/new", name="eventNew")
     */
    public function newEvent(Request $request)
    {
        $event = new Events();
        $now = new \DateTime('now');
        $event->setDateCreatedEvent($now);
        $result = $now->format('Y-m-d');

        $user = $this->getUser();

        $photo=$event->getPhoto();

        $form = $this->createForm(eventType::class, $event,array());

        $form->handleRequest($request);

        if ($form->isSubmitted()&& $form->isValid()) {
            $event->setNameEvent($form['nameEvent']->getData());
            $event->setDescriptionEvent($form['descriptionEvent']->getData());
            $event->setPlaceEvent($form['placeEvent']->getData());
            $event->setDateEvent($form['dateEvent']->getData());
            $event->setPrice($form['price']->getData());
            
            if ($form['photo']->getData() != null) {
                $file = $form['photo']->getData();
                    // Efface le fichier et le nom déjà existant
                if($event->getPhoto() != null) {
                    $oldFile = $this->getParameter('kernel.project_dir') . '/public/images/events/'.$event->getPhoto();
                    if (file_exists($oldFile)) {
                        unlink($oldFile);
                    } 
                }
                
                
                $filename = str_replace(' ','-',$form['nameEvent']->getData()).$result .'.'.$file->guessExtension();
                    $event->setPhoto($filename);
                $file->move($this->getParameter('kernel.project_dir') . '/public/images/events/', $filename);
            }
            
          
            $user = $this->getUser();
            
            $user->addEventFk($event);
            $event->addEventsUser($user);

            $event->setCreatedByUser($user);
            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();
                
            $this->addFlash(
                'notice',
                'Evènement crée!'
            );

            return $this->redirectToRoute('event', ['id' => $event->getIdEvent()]);
        }

        return $this->render('event/form_event.html.twig', array(
            'events' => $event,
            'form' => $form->createView(),
            'action' => 'créer',
            )        
            
        );
        
    }

    /**
     * @Route("/event/update/{id}", name="updateEvent")
     */
    public function updateEvent($id, Request $request)
    {
        $event = $this->getDoctrine()
        ->getRepository(Events::class)
        ->findOneBy(array('idEvent' => $id));
        $photo=$event->getPhoto();
        $form = $this->createForm(EventType::class, $event,array());
        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            
            $event->setNameEvent($form['nameEvent']->getData());
            $event->setDescriptionEvent($form['descriptionEvent']->getData());
            $event->setPlaceEvent($form['placeEvent']->getData());
            $event->setDateEvent($form['dateEvent']->getData());
            $event->setPrice($form['price']->getData());

            if ($form['photo']->getData() != null) {
                $file = $form['photo']->getData();
                    // Efface le fichier et le nom déjà existant
                if($event->getPhoto() != null) {
                    $oldFile = $this->getParameter('kernel.project_dir') . '/public/images/events/'.$event->getPhoto();
                    if (file_exists($oldFile)) {
                        unlink($oldFile);
                    } 
                }

                
                $filename = $event->getIdEvent().'.'.$file->guessExtension();
                    $event->setPhoto($filename);
                $file->move($this->getParameter('kernel.project_dir') . '/public/images/events/', $filename);
            } else {
                $event->setPhoto($photo);
            }
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();
      
            $this->addFlash(
                'notice',
                'évènement modifié!'
            );

            return $this->redirectToRoute('event', ['id' => $event->getIdEvent()]);
        }

        return $this->render('event/form_event.html.twig', array(
            'event' => $event,
            'form' => $form->createView(),
            'action' => 'modifier',
        ));
   
    }

    /**
     * @Route("/event/delete/{id}", name="deleteEvent")
     * 
     */

     public function deleteEvent($id)
     {
         $em = $this->getDoctrine()->getManager();
         $em->remove( $this->getDoctrine()
         ->getRepository(Events::class)
         ->findOneBy(array('idEvent' => $id)));

        $em->flush();

        $this->addFlash(
            'notice',
            'évènement éffacé!'
        );
        
        return $this->redirectToRoute('allEvents');
        }

    /**
     * @Route("/event/all", name="allEvents")
     * 
     */

    public function DisplayEvents(Request $request)
    {
        
        $form = $this->createForm(DisplayEventType::class,null,array());


        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
           
            
			if ($form['eventsDepartement']->getData()==null&&$form['eventsRegion']->getData()==null) {
				$displayEvent = $this->getDoctrine()->getRepository(Events::class)->findAll();
			} else {
				if ($form['eventsDepartement']->getData()!=null) {
					$displayEvent = $this->getDoctrine()->getRepository(Events::class)->findBy(array('eventsDepartement'=>$form['eventsDepartement']->getData()));
				} else {
					$displayEvent = $this->getDoctrine()->getRepository(Events::class)->findBy(array('eventsRegion'=>$form['eventsRegion']->getData()));
					
					
				}
			}

        } else {
            $displayEvent = $this->getDoctrine()->getRepository(Events::class)->findAll();
        }
        return $this->render('event/displayevent.html.twig', array(
            'displayEvent' => $displayEvent,
            
            'form'=>$form->createView())        
            
        );
    }

    }
