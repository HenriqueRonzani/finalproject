<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class NoLinks implements Rule
{
    public function passes($attribute, $value): bool
    {
        // Check if the value contains a link
        return !preg_match('/\b(?:https?|ftp):\/\/\S+\b/', $value);
    }

    public function message(): string
    {
        return 'O :attribute não pode conter links.';
    }
}
