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
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
namespace App\Services;
use App\Entity\Illustration;
use App\Entity\Trick;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
     * This function uses for upload multiple illustration 
     * giving them the uniq id and moving them in
     * the directory specified in service.yaml 
     *
     * @param array $files 
     * @param Trick $trick 
     * 
     * @return void
     */
    public function multipleIllustrationSave(array $files, Trick $trick)
    {
        foreach ($files as $file) {
            $url = $file['url'];
            $originalFilename = pathinfo(
                $url->getClientOriginalName(), PATHINFO_FILENAME
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
}
