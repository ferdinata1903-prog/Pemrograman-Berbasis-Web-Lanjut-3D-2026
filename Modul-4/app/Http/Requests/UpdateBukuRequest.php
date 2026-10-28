<?php

namespace App\Http\Requests;

class UpdateBukuRequest extends StoreBukuRequest
{
    public function rules(): array
    {
        return collect(parent::rules())->map(function ($rule) {
            array_unshift($rule, 'sometimes');
            return $rule;
        })->toArray();
    }
}