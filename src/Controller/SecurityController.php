<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\RegistrationType;
use App\Form\LoginType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class SecurityController extends AbstractController
{
    /**
     *  @Route("/inscription", name="inscription")

     */
    public function index()
    {
        return $this->json([
            'message' => 'CONNECTER',
            'path' => 'src/Controller/InscriptionController.php',
        ]);
    }

															  
		
//// FORMULAIRE D'INSCRIPTION D'UN UTILISATEUR.  
	/**
     * @Route("/user/inscription/new", name="security_integration")          
     */
    public function registration(Request $request, UserPasswordEncoderInterface $encoder){
	 

        $user = new Users();
        $now = new \DateTime('now');
        $user -> setCreatedDateUser($now);



        $form = $this->createForm(RegistrationType::class, $user,array());
        
        $form->handleRequest($request);

        if ($form->isSubmitted()&&$form->isValid()) {
               
                // CRYPTER LE MOT DE PASSE DANS LA BDD.
                
                $user->setNameUser($form['nameUser']->getData());
				$user->setEmail($form['email']->getData());
                $user->setAvatar('0.jpg');
				//$user->setPassword($form['password']->getData());
				$user->setPassword(password_hash($form['password']->getData(),PASSWORD_BCRYPT));
				$user->setUsersRegion($form['usersRegion']->getData());
				$user->setUsersDepartment($form['usersDepartment']->getData());
				$user->setBirthdateUser($form['birthdateUser']->getData());									   
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();
                
          return $this->redirectToRoute('app_login');
        }
        
        return $this->render('security/registration.html.twig', [
          'form'=> $form->createView() 
        ]);
    }

    

    /**
     * @Route ("/tramsmit/link_inscrition", name="link_inscription")
     */

    public function email_send($email) {
        $transport = (new Swift_SmtpTransport('smtp.ionos.fr', 25, 'tls'))
		  ->setUsername('contact@deerweb.fr')
		  ->setPassword('Re1-to3i')
        ;

        // Create the Mailer using your created Transport
		$mailer = new Swift_Mailer($transport);

        // Create a message
		$message = (new Swift_Message('Réinitialisation du mot de passe'))
        ->setFrom(['contact@TOLLErance.fr' => 'TOLLErance'])
        ->setTo([$email])
        ->setBody("<a href='http://deerweb.fr/demo/meteo/init_pass.php?token=".md5($email)."'>Cliquez ici pour réinitialiser le mot de passe</a>", "text/html")
        ;

        // Send the message
		$result = $mailer->send($message);

    }

    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $user = new Users();

        $form = $this->createForm(LoginType::class, $user,array());

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error,'form'=>$form->createView()]);

        //return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }
	
	/**
     * @Route("/logout", name="logout")
     */
    public function logout()
    {

    }
}
