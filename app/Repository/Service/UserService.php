<?php

namespace App\Repository\Service;

use App\Jobs\UpdateBalanceJob;
use App\Models\User;
use App\Repository\Interface\UserInterface;
use Illuminate\Support\Facades\Log;

class UserService implements UserInterface
{
    public function updateBalance(int $user_id,float $balance)
    {
        $user = $this->findInfo($user_id);
        if(empty($user)){
            $msg = '用户ID为'.$user_id.'不存在';
            Log::error($msg);
            return;
        }
        if ($balance > $user->balance) {
            $msg = '用户ID为'.$user_id.'的余额不足';
            Log::error($msg);
            return;
        }
        UpdateBalanceJob::dispatch($user,$balance)->onQueue('balance');
    }

    public function findInfo(int $user_id)
    {
        return User::find($user_id);
    }
}
