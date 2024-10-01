<?php

namespace App\Rules;

use App\Models\Products;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;

class ChangeTurkishCharToEnglish implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $trCharToEnChar = $this->trCharToEnChar(mb_strtolower($value));

        $query = Products::query()
            ->whereRaw("REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(LOWER(name),'ü','u'),'ö','o'),'ğ','g'),'ş','s'),'ı','i'),'ç','c') = ?", $trCharToEnChar);

        if ($query->first()) {
            $fail(__("The $attribute has already been taken."));
        }
    }

    protected function trCharToEnChar(string $value): string
    {
        $trChars = ['ş', 'ı', 'ç', 'ğ', 'ö', 'ü'];
        $enChars = ['s', 'i', 'c', 'g', 'o', 'u'];

        return str_replace($trChars, $enChars, \strtolower($value));
    }
}
