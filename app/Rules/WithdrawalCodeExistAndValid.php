<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Contracts\Validation\ValidatorAwareRule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Validation\DataAwareRule;

class WithdrawalCodeExistAndValid implements Rule, DataAwareRule
{
    protected $data = [];

    public function __construct() {
    }

    public function setData($data)
    {
        $this->data = $data;
 
        return $this;
    }

    public function passes($attribute, $value): bool
    {
        // dd($this->data['transaction_uuid']);
        return  !is_null(auth()->user()
                        ->withdrawalConfirmations()
                        ->where('id', $this->data['transaction_uuid'])
                        ->where('code', $value)
                        ->where('valid_until','>',now())->first()
                    );
    }

    public function message(): string
    {
        return 'You have Enterd a Bad Code !.';
    }
}
