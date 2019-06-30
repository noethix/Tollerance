<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\UserType;
use App\Entity\Users;
use App\Entity\Region;
use App\Entity\Departement;
use App\Entity\Groupes;
use App\Entity\Activites;
use App\Entity\Events;
use App\Entity\Posts;
use App\Entity\Topics;

class UserController extends AbstractController
{
    /**
     * @Route("/welcome", name="welcome")
     */
    public function welcome(Request $request)
    {
        $user = $this->getUser();
        $posts = $this->getDoctrine()
            ->getRepository(Posts::class)
            ->findBy(array('postsUser' => $user), array('createdDatePost' => 'DESC'), 5, 0);



        return $this->render('user/welcome.html.twig', [
            'controller_name' => 'UserController',
            'user' => $user,
            'posts' => $posts,

        ]);

    }

    /**
     * @Route("/profile", name="profile")
     */
    public function profile( Request $request)
    {

        $user = $this->getUser();

        $avatar=$user->getAvatar();

        $form = $this->createForm(UserType::class,$user, array());
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $user->setUsersRegion($form['usersRegion']->getData());
            $user->setUsersDepartment($form['usersDepartment']->getData());
            $user->setTagline($form['tagline']->getData());
            $user->setCity($form['city']->getData());

            if ($form['avatar']->getData() != null) {
                $file = $form['avatar']->getData();
                    // Efface le fichier et le nom déjà existant
                if($user->getAvatar() != null) {
                    $oldFile = $this->getParameter('kernel.project_dir') . '/public/images/avatars/'.$user->getAvatar();
                    if (file_exists($oldFile)) {
                        unlink($oldFile);
                    }
                }
                $filename = $user->getIdUser().'.'.$file->guessExtension();
                    $user->setAvatar($filename);
                $file->move($this->getParameter('kernel.project_dir') . '/public/images/avatars/', $filename);
            } else {
                $user->setAvatar($avatar);
            }

            
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            
            $this->addFlash('notice', 'Votre profil a bien été mis à jour');

        }


        return $this->render('user/profile.html.twig', [
            'controller_name' => 'UserController',
            'form' => $form->createView(),
            'user' => $user
        ]);
    }

    /**
     * @Route("/profile/{id}", name="profile_view")
     */
    public function profileView($id, Request $request)
    {
        $user = $this->getDoctrine()
            ->getRepository(Users::class)
            ->findOneBy(array('idUser' => $id));

        $posts = $this->getDoctrine()
            ->getRepository(Posts::class)
            ->findBy(array('postsUser' => $id), array('createdDatePost' => 'DESC'), 5, 0);


        return $this->render('user/profile_view.html.twig', [
            'controller_name' => 'UserController',
            'user' => $user,
            'posts' => $posts,
        ]);

    }

    /**
     * @Route("/profil/all", name="viewallprofile")
     * 
     */

    public function DisplayActivites(Request $request)
    { 
        $displayUsers = $this->getDoctrine()->getRepository(Users::class)->findAll();

        return $this->render('user/viewalluser.html.twig', array(
            'displayUsers' => $displayUsers)        
            
        );
    }

}
