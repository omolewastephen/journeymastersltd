<?php

declare(strict_types=1);

namespace App\Core;

/**
 * Minimal rule-based validator. Rules: required, email, min:n, max:n, phone.
 */
final class Validator
{
    private array $errors = [];

    public function __construct(private array $data)
    {
    }

    public function validate(array $rules, array $labels = []): bool
    {
        foreach ($rules as $field => $ruleset) {
            $value = trim((string) ($this->data[$field] ?? ''));
            $label = $labels[$field] ?? ucfirst(str_replace('_', ' ', $field));

            foreach (explode('|', $ruleset) as $rule) {
                [$name, $param] = array_pad(explode(':', $rule, 2), 2, null);

                $failed = match ($name) {
                    'required' => $value === '',
                    'email'    => $value !== '' && !filter_var($value, FILTER_VALIDATE_EMAIL),
                    'min'      => mb_strlen($value) < (int) $param,
                    'max'      => mb_strlen($value) > (int) $param,
                    'phone'    => $value !== '' && !preg_match('/^[0-9+()\-\s]{7,20}$/', $value),
                    default    => false,
                };

                if ($failed) {
                    $this->errors[$field] = match ($name) {
                        'required' => "{$label} is required.",
                        'email'    => "Please enter a valid email address.",
                        'min'      => "{$label} must be at least {$param} characters.",
                        'max'      => "{$label} must not exceed {$param} characters.",
                        'phone'    => "Please enter a valid phone number.",
                        default    => "{$label} is invalid.",
                    };
                    break; // one error per field
                }
            }
        }

        return $this->passes();
    }

    public function passes(): bool
    {
        return $this->errors === [];
    }

    public function errors(): array
    {
        return $this->errors;
    }
}
