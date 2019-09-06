<?php
/**
 * The IllustrationManager file doc comment
 *
 * PHP version 7.2.10
 *
 * @category Class
 * @package  IllustrationManager
 * @author   Samir <allabsamir666@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     src/Services/IllustrationManager.php
 */
namespace App\Services;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Illustration;
use App\Entity\Trick;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Common\Persistence\ObjectManager;
use App\Repository\TrickRepository;

/**
 * Undocumented class
 *
 * @category Class
 * @package  IllustrationManager
 * @author   Samir <allabsamir666@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     src/Services/IllustrationManager.php
 */
class IllustrationManager extends AbstractController
{
    /**
     * @var [type]
     */
    private $manager;
    private $trickRepository;
    /**
     * Construct function class
     *
     * @param ObjectManager $manager
     */
    public function __construct(
        ObjectManager $manager,
        TrickRepository $trickRepository
    ) {
        $this->manager = $manager;
        $this->trickRepository = $trickRepository;
    }
    /**
     * This function uses for upload multiple illustration
     * giving them the uniq id and moving them in
     * the directory specified in service.yaml
     *
     * @param array $files
     * @param Trick $trick
     *
     * @return array
     */
    public function multipleIllustrationUpload(array $files, Trick $trick):array
    {
        foreach ($files as $file) {
            $url = $file['url'];
            $originalFilename = pathinfo(
                $url->getClientOriginalName(),
                PATHINFO_FILENAME
            );
            $illustration = new Illustration();
            $fileName = md5(uniqid()).'.'.$url->guessExtension();
            $url->move($this->getParameter('PATH_TO_IMAGE'), $fileName);
            $illustration->setName($originalFilename);
            $illustration->setUrl($fileName);
            $illustration->setTrick($trick);
            $illustrations[] = $illustration;
        }
        return $illustrations;
    }
    /**
     * Undocumented function
     *
     * @return void
     */
    public function singleIllustrationUpload(
        $form,
        Illustration $illustration,
        Trick $trick = null
    ) {
    
        $file = $form['url']->getData();
        if ($file) {
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $originalFilename = pathinfo(
                $file->getClientOriginalName(),
                PATHINFO_FILENAME
            );
            $file->move($this->getParameter('PATH_TO_IMAGE'), $fileName);
            $illustration->setUrl($fileName);
            $illustration->setName($originalFilename);
            if (!$trick) {
                $trick = $this->trickRepository
                    ->findOneBy(['id'=>$illustration->getTrick()->getId()]);
            } else {
                $illustration->setTrick($trick);
            }
            $trick->setUpdatedAt(new \DateTime);
            $this->manager->persist($illustration);
            $this->manager->flush();
        }
    }
}
