<?php

namespace App\Rules;

use App\Enums\LogServices;
use Illuminate\Contracts\Validation\Rule;

class ServiceExists implements Rule
{
    private string $notFoundedService;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (!is_array($value)) $value = [$value];
        foreach ($value as $enum) {
            if (is_null(LogServices::tryFrom($enum))) {
                $this->notFoundedService = $enum;
                return false;
            }
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "The Service {$this->notFoundedService} not founded";
    }
}
