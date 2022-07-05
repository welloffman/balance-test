<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Validator;

class Operation extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class)->first();
    }

    public function getError($balance)
    {
        $fields = [
            'amount' => $this->amount,
            'description' => $this->description,
            'type' => $this->type,
        ];

        $validator = Validator::make($fields, [
            'amount' => 'bail|required|numeric|min:0',
            'description' => 'bail|required|string|max:255',
            'type' => 'in:debit,credit',
        ]);

        if($validator->fails()) {    
            return $validator->errors()->first();
        }

        return false;
    }

    public function isDebit()
    {
        return $this->type == 'debit';
    }

    public function isCredit()
    {
        return $this->type == 'credit';
    }

    public function getAmountWithSign()
    {
        $amount = $this->amount;
        if($this->isDebit()) {
            $amount *= -1;
        }

        return $amount;
    }

    public function getSerialized()
    {
        return [
            'amount' => $this->amount,
            'type' => $this->type,
            'description' => $this->description,
            'created_at' => date('Y-m-d H:i:s', strtotime($this->created_at)),
        ];
    }
}
