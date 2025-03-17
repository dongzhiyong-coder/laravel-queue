<?php

namespace App\Http\Controllers;
use App\Repository\Interface\UserInterface;
use Illuminate\Http\Request;

class UserController extends BaseController
{
    protected $user_repository;

    public function __construct(UserInterface $user_repository)
    {
        $this->user_repository = $user_repository;
    }

    /**
     * @param Request $request
     * @id 用户ID
     * @balance 用户需要扣减的金额
     * @return mixed
     */
    public function updateBalance(Request $request){
        $id = $request->post('id');
        $balance = $request->post('balance');
        $this->user_repository->updateBalance($id,$balance);
        return $this->success();
    }
}
