<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use App\Models\Operation;
use App\Models\User;

class ProcessOperation implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     */
    public function handle()
    {
        $email = $this->data['email'];
        $type = $this->data['type'];
        $amount = $this->data['amount'];
        $description = $this->data['description'];

        $user = User::where('email', $email)->first();
        if(!$user) {
            return false;
        }

        $balance = $user->getBalance();

        $operation = new Operation();
        $operation->user_id = $user->id;
        $operation->type = $type;
        $operation->amount = $amount;
        $operation->description = $description;

        $error = $operation->getError($balance);
        if($error) {
            return false;
        }

        DB::beginTransaction();
        $amount = $balance->applyOperation($operation);
        if($amount < 0) {
            DB::rollback();
        } else {
            $operation->save();
            DB::commit();
        }
    }
}
