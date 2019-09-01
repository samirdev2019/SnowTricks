<?php
namespace App\Controller;

use App\Entity\User;
use App\Form\AvatarUserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\File;


class ProfileController extends AbstractController
{
    /**
     * @Route("/member/{username}/add-avatar", name="add_avatar")
     */
    public function addAvatar(User $user, Request $request, ObjectManager $manager)
    {
       
        $form = $this->createForm(AvatarUserType::class, $user);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
           
            $file = $form['avatar']->getData();
            if( $file ) {
                $fileName = md5(uniqid()).'.'.$file->guessExtension();
            
                $file->move($this->getParameter('upload-directory'), $fileName);
                $user->setAvatar($fileName);    
                   
                $manager->persist($user);
                $manager->flush();
                
                return $this->redirect($this->generateUrl('home'));
            } 
           
        }
        return $this->render('security/add-avatar.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
