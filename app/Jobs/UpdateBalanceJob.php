<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

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
        $this->user->balance = $this->user->balance-$this->balance;
        $this->user->save();
    }
}
