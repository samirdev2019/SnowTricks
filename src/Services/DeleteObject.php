<?php
/**
 * The DeleteObject file doc comment
 *
 * PHP version 7.2.10
 *
 * @category Class
 * @package  DeleteObject
 * @author   Samir <allabsamir666@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     src/Services/DeleteObject.php
 */
namespace App\Services;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * DeleteObject class allows to delete object
 *
 * @category Class
 * @package  DeleteObject
 * @author   Samir <allabsamir666@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     src/Services/DeleteObject.php
 */
class DeleteObject extends AbstractController
{
    /**
     * This function allows to delete an object
     *
     * @param object        $object  an instance of any class
     * @param ObjectManager $manager an instance of objectManager class
     *
     * @return void
     */
    public function delete($object, ObjectManager $manager)
    {
        $manager->remove($object);
        //$manager->flush();
    }
}
