<?php

namespace netvod\avis;

use netvod\user\User;

class Commentaire
{
    protected string $commentaire;
    protected string $date;
    protected User $user;

    public function __construct($pComm, $pDate, $pUser)
     {
         $this->commentaire = $pComm;
         $this->date = $pDate;
         $this->user = $pUser;
     }

}