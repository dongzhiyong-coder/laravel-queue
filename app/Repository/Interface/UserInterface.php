<?php

namespace App\Repository\Interface;


interface  UserInterface {
    public function findInfo(int $user_id);
    public function updateBalance(int $user_id,float $balance);
}
