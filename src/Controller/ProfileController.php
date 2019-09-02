<?php
/**
 * The ProfileController file doc comment
 * 
 * PHP version 7.2.10 
 * 
 * @category Class
 * @package  ProfileControler
 * @author   Samir <allabsamir666@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     http://127.0.0.1/member/{username}/add-avatar
 */
namespace App\Controller;

use App\Entity\User;
use App\Form\AvatarUserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * This class allows to add or update a new avatar of user
 * 
 * @category Class
 * @package  ProfileControler
 * @author   Samir <allabsamir777@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     http://127.0.0.1/member/name/add-avatar
 */
class ProfileController extends AbstractController
{
    /**
     * Undocumented function
     *
     * @param User          $user    the user Entity
     * @param Request       $request Request Object  
     * @param ObjectManager $manager Manager Object
     * 
     * @return Response
     * 
     * @Route("/member/{username}/add-avatar", name="add_avatar")
     */
    public function addAvatar(User $user, Request $request,
        ObjectManager $manager
    ):Response {
    
        $form = $this->createForm(AvatarUserType::class, $user);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form['avatar']->getData();
            if ($file) {
                $fileName = md5(uniqid()).'.'.$file->guessExtension();
            
                $file->move($this->getParameter('upload-directory'), $fileName);
                $user->setAvatar($fileName);      
                $manager->persist($user);
                $manager->flush();
                return $this->redirect($this->generateUrl('home'));
            } 
        }
        return $this->render(
            'security/add-avatar.html.twig', [
            'form' => $form->createView(),
            ]
        );
    }
}
