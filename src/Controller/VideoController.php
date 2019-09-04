<?php
/**
 * The VideoController file doc comment
 *
 * PHP version 7.2.10
 *
 * @category Class
 * @package  VideoController
 * @author   Samir <allabsamir666@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     src/Controller/VideoController
 */
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Forms;
use App\Repository\TrickRepository;
use App\Repository\VideoRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Entity\Trick;
use App\Entity\Video;
use App\Form\VideoType;
use App\Form\TrickType;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * This class allows to controlle the video of snowtrick
 *
 * @category Class
 * @package  VideoController
 * @author   Samir <allabsamir777@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     src/Controller/VideoController
 */
class VideoController extends AbstractController
{
    private $trickRepository;
    private $videoRepository;
    private $manager;
    /**
     * The constructor of class with different initialisations
     *
     * @param TrickRepository        $trickRepository
     * @param VideoRepository        $videoRepository
     * @param ObjectManager          $manager
     */
    public function __construct(
        TrickRepository $trickRepository,
        VideoRepository $videoRepository,
        ObjectManager $manager
    ) {

        $this->trickRepository = $trickRepository;
        $this->videoRepository = $videoRepository;
        $this->manager = $manager;
    }
    /**
     * This methode allows to edit a video
     *
     * @param Video   $video
     * @param Request $request
     *
     * @return Response
     *
     * @Route("/member/snowtrick/edit-video/{id}", name="edit_video")
     */
    public function editVideo(Video $video, Request $request):Response
    {
        $form = $this->createForm(VideoType::class, $video);
        $form->HandleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $url = $form['url']->getData();
            $trick = $this->trickRepository->findOneBy(
                ['id'=>$video->getTrick()->getId()]
            );
            $video->setUrl($url);
            $trick->setUpdatedAt(new \DateTime);
            $this->manager->flush();
            return $this->redirectToRoute('edit_trick', ['id'=>$trick->getId()]);
        }
        return $this->render(
            'tricks/edit-video.html.twig',
            ['formVideo'=>$form->createView(), 'add'=>false]
        );
    }
    /**
     * This methode allows to add a new video
     *
     * @param Trick   $trick
     * @param Request $request
     *
     * @return Response
     *
     * @Route("/member/snowtrick/{id}/add-video", name="add_video")
     */
    public function addVideo(Trick $trick, Request $request):Response
    {
        $video = new Video();
        $form = $this->createForm(VideoType::class, $video);
        $form->HandleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $url = $form['url']->getData();
            $video->setUrl($url);
            $video->setTrick($trick);
            $trick->setUpdatedAt(new \DateTime);
            $this->manager->persist($video);
            $this->manager->flush();
            return $this->redirectToRoute('edit_trick', ['id'=>$trick->getId()]);
        }
        return $this->render(
            'tricks/edit-video.html.twig',
            ['formVideo'=>$form->createView(), 'add'=>true]
        );
    }
    /**
     * This method allows to delete a video
     *
     * @param Video $video
     *
     * @return void
     *
     * @Route("/member/snowtrick/delete-video/{id}", name="delete_video")
     */
    public function deleteVideo(Video $video)
    {
        $this->manager->remove($video);
        $this->manager->flush();
        return $this->redirectToRoute(
            'edit_trick',
            ['id'=>$video->getTrick()->getId()]
        );
    }
}
