<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;

class UpdateBalanceJob implements ShouldQueue,ShouldBeUnique
{
    use Queueable;

    /**
     * @var \App\Models\User
     */
    public $user;
    public $balance;

    /**
     * 任务的唯一锁将在300秒后被释放。
     *
     * @var int
     */
    public $uniqueFor = 300;


    public function uniqueId(): string
    {
        return $this->user->id;
    }


    /**
     * Create a new job instance.
     */
    public function __construct(User $user,float $balance)
    {
        $this->user = $user;
        $this->balance = $balance;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        /**
         * 考虑到并发场景 这里需要使用乐观锁机制处理
         */
        $db_balance = $this->user->balance;//查询未更新之前的余额
        DB::table('user')->where(['id'=>$this->user->id,'balance'=>$db_balance])->update(['balance'=>$db_balance-$this->balance]);
    }
}
