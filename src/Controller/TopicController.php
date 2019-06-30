<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Groupes;
use App\Entity\Users;
use App\Entity\Posts;
use App\Entity\Topics;
use App\Form\TopicType;
use App\Form\PostType;
use Symfony\Component\HttpFoundation\Request;


class TopicController extends AbstractController
{
    /**
     * @Route("/topic/{id}/{page}", name="topic")
     */
    public function index($id, $page=1, Request $request)
    {
    	$user = $this->getUser();

    	$topic = $this->getDoctrine()
            ->getRepository(Topics::class)
            ->findOneBy(array('idTopic' => $id));

        $posts = $this->getDoctrine()
            ->getRepository(Posts::class)
            ->findBy(array('idTopic' => $id), array('createdDatePost' => 'DESC'));

        $pages = ceil((count($posts))/10);

        $posts = $this->getDoctrine()
            ->getRepository(Posts::class)
            ->findBy(array('idTopic' => $id), array('createdDatePost' => 'DESC'), 10, ($page-1)*10);
							  
        $newPost = new Posts();

        $form = $this->createForm(PostType::class, $newPost, array());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newPost->setContentPost($form['contentPost']->getData());
            $newPost->setIdTopic($topic);

				
            $newPost->setPostsUser($user);
            $now = new \DateTime('now');
            $newPost->setCreatedDatePost($now);
            $topic->setLastPostDate($now);


            $em = $this->getDoctrine()->getManager();
            $em->persist($newPost);
            $em->persist($topic);
            $em->flush();
            
            $newPost = new Posts();

            $form = $this->createForm(PostType::class, $newPost, array());

			return $this->redirectToRoute('topic', ['id' => $id]);

        }

        $participate = false;

        foreach ($topic->getIdGroupe()->getGroupesUser() as $groupeUser) {
            if ($groupeUser->getIdUser() == $user->getIdUser()) {
                $participate = true;
            }
        }


        return $this->render('topic/topic_view.html.twig', [
            'controller_name' => 'TopicController',
            'form' => $form->createView(),
            'topic' => $topic,
            'posts' => $posts,
            'pages' => $pages,
            'page' => $page,
            'participate' => $participate,
        ]);
    }



}
