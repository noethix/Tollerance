<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Messages;
use App\Entity\Users;
use App\Form\MessageType;
use App\Form\MessageAdminType;
use Symfony\Component\HttpFoundation\Request;


class MessageController extends AbstractController
{
   
	//// MESSAGERIE ENTRE UTILISATEUR ET ADMINISTRATEUR.  
	/**
     * @Route("/admin/message/new", name="new_admin_message")          
     */
    public function newMessageAdmin(Request $request)
    {
        
		$message = new Messages();		
        $now = new \DateTime('now');
        $message -> setCreatedDateMessage($now);

		$form = $this->createForm(MessageAdminType::class, $message,array());

		$form->handleRequest($request);

		if ($form->isSubmitted()&&$form->isValid()) {
            $message->setSubjectMessage($form['subjectMessage']->getData());
			$message->setContentMessage($form['contentMessage']->getData());
            $message->setTypeMessage('admin');
            
            /* RECUPERER A PARTIR D'UN LOGIN, L'IDENTIFIANT DE L'UTILISATEUR CONNECTE, AFIN DE LE METTRE COMME AUTEUR DU MESSAGE. A FAIRE EVOLUER POUR FAIRE CE LIEN...
            $user=$this->getDoctrine() 
            ->getRepository(Users::class) 
            ->findOneBy(array('idUser'=>3) );
            $message->setIdUser($user);
            */

			$em = $this->getDoctrine()->getManager();
            $em->persist($message);
            $em->flush();
            
            /// SUPPRIMER APRES L'ENVOIE DANS LA BDD LE MESSAGE TRANSCRIS INITIALISE LA DATE D'ENVOIE.
            $message = new Messages();
            $message->setCreatedDateMessage($now);
            $form = $this->createForm(MessageAdminType::class, $message,array());

            $this->addFlash(
                'notice',
                'Message envoyé!'
            );

		}
		//// Retourne l'affichage des données $form.
        return $this->render('message/formadmin.html.twig', [        
            'form' => $form->createView(),
        ]);
    }
    //// MESSAGERIE ENTRE UTILISATEUR. 
	/**
     * @Route("/user/message/new/{id}", name="new_user_message")          //// Adresse url d'appel.
     */
    public function newMessageUser($id, Request $request)
    {
        
		$message=new Messages();		
        $now = new \DateTime('now');
        $message->setCreatedDateMessage($now);

        $form = $this->createForm(MessageType::class, $message,array());
        
        $user = $this->getUser();

        $recipient = $this->getDoctrine()
        ->getRepository(Users::class)
        ->findOneBy(array('idUser' => $id));

		$form->handleRequest($request);

		if ($form->isSubmitted()&&$form->isValid()) {
            $message->setContentMessage($form['contentMessage']->getData());
            $message->setIdUser($user);
            $message->setIdUserRecipient($recipient);
			
			$em = $this->getDoctrine()->getManager();
            $em->persist($message);
            $em->flush();
            
            /// SUPPRIMER APRES L'ENVOIE DANS LA BDD LE MESSAGE TRANSCRIS INITIALISE LA DATE D'ENVOIE.
            $message = new Messages();
            $message->setCreatedDateMessage($now);
            $form = $this->createForm(MessageType::class, $message,array());

			$this->addFlash(
                'notice',
                'Message transmis'
            );
		}
		//// Retourne l'affichage des données $form.
        return $this->render('message/formuser.html.twig', [        
            'form' => $form->createView(),
            'user' =>$user,
            'recipient' => $recipient,
        ]);
    }
    
    //// MESSAGERIE ENTRE UTILISATEUR ET MODERATEUR.  
	/**
     * @Route("/moderateur/message/new", name="new_moderateur_message")          
     */
    public function newMessageModerateur(Request $request)
    {
        
		$message = new Messages();		
        $now = new \DateTime('now');
        $message->setCreatedDateMessage($now);

		$form = $this->createForm(MessageAdminType::class, $message,array());

		$form->handleRequest($request);

		if ($form->isSubmitted()&&$form->isValid()) {
			$message->setContentMessage($form['contentMessage']->getData());
            $message->setTypeMessage('moderateur');
            
            /* RECUPERER A PARTIR D'UN LOGIN, L'IDENTIFIANT DE L'UTILISATEUR CONNECTE, AFIN DE LE METTRE COMME AUTEUR DU MESSAGE. A FAIRE EVOLUER POUR FAIRE CE LIEN...
            $user=$this->getDoctrine() 
            ->getRepository(Users::class) 
            ->findOneBy(array('idUser'=>3) );
            $message->setIdUser($user);
            */

			$em = $this->getDoctrine()->getManager();
            $em->persist($message);
            $em->flush();

            /// SUPPRIMER APRES L'ENVOIE DANS LA BDD LE MESSAGE TRANSCRIS INITIALISE LA DATE D'ENVOIE.
            $message = new Messages();
            $message->setCreatedDateMessage($now);
            $form = $this->createForm(MessageAdminType::class, $message,array());

			$this->addFlash(
                'notice',
                'Message transmis'
            );
		}
		//// Retourne l'affichage des données $form.
        return $this->render('message/formmoderateur.html.twig', [        
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/messages", name="messages")          
     */
    public function messages()
    {
        $user = $this->getUser();

        $receivedMessages = $this->getDoctrine()
            ->getRepository(Messages::class)
            ->findBy(array('idUserRecipient' => $user), array('createdDateMessage' => 'DESC'));

        $sentMessages = $this->getDoctrine()
            ->getRepository(Messages::class)
            ->findBy(array('idUser' => $user), array('createdDateMessage' => 'DESC'));

        return $this->render('message/messages.html.twig', [
            'user' => $user,
            'receivedMessages' => $receivedMessages,
            'sentMessages' => $sentMessages,
        ]);

    }

    /**
     * @Route("/message/reply/{userId}/{messageId}", name="reply_message")
     */
    public function replyMessage($userId, $messageId, Request $request)
    {
        $originalMessage = $this->getDoctrine()
            ->getRepository(Messages::class)
            ->findOneBy(array('idMessage' => $messageId));

        $message=new Messages();        
        $now = new \DateTime('now');
        $message->setCreatedDateMessage($now);
        $message->setSubjectMessage("Re: ".$originalMessage->getSubjectMessage());

        $form = $this->createForm(MessageType::class, $message,array());
        
        $user = $this->getUser();

        $recipient = $this->getDoctrine()
        ->getRepository(Users::class)
        ->findOneBy(array('idUser' => $userId));

        $form->handleRequest($request);

        if ($form->isSubmitted()&&$form->isValid()) {
            $message->setContentMessage($form['contentMessage']->getData());
            $message->setIdUser($user);
            $message->setIdUserRecipient($recipient);
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($message);
            $em->flush();
            
            return $this->redirectToRoute('messages');
        }
        //// Retourne l'affichage des données $form.
        return $this->render('message/formuser.html.twig', [        
            'form' => $form->createView(),
            'user' =>$user,
            'recipient' => $recipient,
        ]);
    }



    /**
     * @Route("/message/remove/{id}", name="remove_message")          
     */
    public function removeMessage($id, Request $request)
    {
        $message = $this->getDoctrine()
            ->getRepository(Messages::class)
            ->findOneBy(array('idMessage' => $id));

        $em = $this->getDoctrine()->getManager();
        $em->remove($message);
        $em->flush();

        return $this->redirectToRoute('messages');
    }
}
