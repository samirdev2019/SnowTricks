<?php
/**
 * The IllustrationController file doc comment
 *
 * PHP version 7.2.10
 *
 * @category Class
 * @package  IllustrationController
 * @author   Samir <allabsamir666@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     src/Controller/IllustrationController
 */
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Forms;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Repository\IllustrationRepository;
use App\Services\IllustrationManager;
use App\Entity\Illustration;
use App\Form\IllustrationType;
use App\Entity\Trick;
use App\Repository\TrickRepository;

/**
 * This class allows to edit a snowtrick
 *
 * @category Class
 * @package  IllustrationController
 * @author   Samir <allabsamir777@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     src/Controller/IllustrationController
 */
class IllustrationController extends AbstractController
{
    private $trickRepository;
    private $illustrationRepository;
    private $manager;
    /**
     * The constructor of class with different initialisations
     *
     * @param TrickRepository        $trickRepository
     * @param IllustrationRepository $illustrationRepository
     * @param ObjectManager          $manager
     */
    public function __construct(
        TrickRepository $trickRepository,
        IllustrationRepository $illustrationRepository,
        ObjectManager $manager
    ) {

        $this->trickRepository = $trickRepository;
        $this->illustrationRepository = $illustrationRepository;
        $this->manager = $manager;
    }
    /**
     * This method allow to edit a illustration
     *
     * @param Illustration $illustration
     * @param Request      $request
     *
     * @return Response
     *
     * @Route("/member/snowtrick/edit-illustration/{id}", name="edit_illustration")
     */
    public function editIllustration(
        Illustration $illustration,
        Request $request,
        IllustrationManager $illustrationManager
    ):Response {
        if (!$illustration) {
            //exception page 404
        }
        $form = $this->createForm(IllustrationType::class, $illustration);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $illustrationManager->
            singleIllustrationUpload($form, $illustration);
            return $this->redirectToRoute(
                'edit_trick',
                ['id'=>$illustration->getTrick()->getId()]
            );
        }
        return $this->render(
            'tricks/edit-illustration.html.twig',
            ['form' => $form->createView(), 'edit'=> true ]
        );
    }
    /**
     * This method allow to edit a illustration
     *
     * @param Trick   $trick
     * @param Request $request
     *
     * @return Response
     *
     * @Route("/member/trick/{id}/add-illustration/", name="add_illustration")
     */
    public function addIllustration(Trick $trick, IllustrationManager $illustrationManager, Request $request):Response
    {
        $illustration = new Illustration();
        $form = $this->createForm(IllustrationType::class, $illustration);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //$data = $form->getData(); essayer d'utiliser uniquement url au lieu de form
            $illustrationManager->
            singleIllustrationUpload($form, $illustration, $trick);
            return $this->redirectToRoute('edit_trick', ['id'=>$trick->getId()]);
        }
        return $this->render(
            'tricks/edit-illustration.html.twig',
            ['form' => $form->createView(), 'edit'=>false]
        );
    }
    /**
     * This method allows to delete an illustration
     *
     * @param Illustration $illustration
     *
     * @return void
     *
     * @Route("/member/snowtrick/delete-illustration/{id}", name="delete_illustration")
     */
    public function deleteIllustration(Illustration $illustration)
    {
        $this->manager->remove($illustration);
        $this->manager->flush();
        return $this->redirectToRoute(
            'edit_trick',
            ['id'=>$illustration->getTrick()->getId()]
        );
    }
}
