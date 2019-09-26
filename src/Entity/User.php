<?php

namespace App\Entity;

class User
{
    public $firstName;
    public $lastName;
    public $gender;
    public $born;
    public $email;
    public $phone;
    public $website;
    public $address;
    public $status;
    public $avatarUrl;

    public function setavatarUrl($avatarUrl)
    {
        $this->avatarUrl = $avatarUrl;
    }
    
}