<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Contracts\Validation\ValidatorAwareRule;
use Illuminate\Database\Eloquent\Model;

class WithdrawalCodeExistAndValid implements Rule
{
    public function __construct() {
    }

    public function passes($attribute, $value): bool
    {
        return  !is_null(auth()->user()
                        ->withdrawalConfirmations()
                        ->where('code', $value)
                        ->where('valid_until','>',now())->first()
                    );
    }

    public function message(): string
    {
        return 'You have Enterd a Bad Code !.';
    }
}
