<?php
namespace App\Exception;

class AccountUnvalidatedException extends \Exception
{
    public function __construct($message)
    {
        parent::__construct($message);
    }
}