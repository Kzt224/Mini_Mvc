<?php

namespace App\Http;

session_start();

class Request
{
    protected array $request = [];
    protected array $Errors = [];
    public function __construct()
    {
        $this->request = array_merge($_GET, $_POST, $this->getJsonPayload());
    }

    protected function getJsonPayload(): array
    {
        $data = [];
        $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
        if (stripos($contentType, 'application/json') !== false) {
            $json = file_get_contents('php://input');
            $data = json_decode($json, true) ?? [];
        }
        return $data;
    }

    public function all(): array
    {
        return $this->request;
    }
    public function get($colName)
    {
        $value[$colName] = $this->request[$colName] ?? '';
        return $value;
    }
    public function input(string $key, $default = null, bool $escape = true)
    {
        $value = $this->request[$key] ?? $default;

        if ($escape && is_string($value)) {
            $value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
        }

        return $value;
    }

    public function validateCsrf()
    {
        $token = $this->input('csrf_token', '', false);
        if (!hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
            throw new \Exception('Invalid CSRF token.');
        }
    }

    public static function generateCsrfToken(): string
    {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    public function validate(array $rules): array
    {
        $errors = [];
        $validated = [];
        foreach ($rules as $field => $ruleString) {
            $rulesArray = explode('|', $ruleString);
            $value = $this->input($field, null, false);

            foreach ($rulesArray as $rule) {
                if ($rule === 'required' && ($value === null || $value === '')) {
                    $errors[] = "{$field} is required.";
                }

                if ($rule === 'string' && $value !== null && $value !== '' && !is_string($value)) {
                    $errors[] = "{$field} must be a string.";
                }

                if ($rule === 'integer' && $value !== null && !is_int($value)) {
                    $errors[] = "{$field} must be an integer.";
                }

                if ($rule === 'email' && $value !== null && $value !== '' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $errors[] = "{$field} must be a valid email.";
                }

                if ($value !== '' && str_starts_with($rule, 'min:')) {
                    $min = (int) explode(':', $rule)[1];
                    if ($value !== null && strlen((string)$value) < $min) {
                        $errors[] = "{$field} must be at least $min characters.";
                    }
                }

                if (str_starts_with($rule, 'max:')) {
                    $max = (int) explode(':', $rule)[1];
                    if ($value !== null && strlen((string)$value) > $max) {
                        $errors[] = "{$field} must not exceed $max characters.";
                    }
                }
            }

            if (!isset($errors[$field])) {
                $validated[$field] = is_string($value) ? htmlspecialchars($value, ENT_QUOTES, 'UTF-8') : $value;
            }
        }

        if (!empty($errors)) {
            $this->Errors[] = $errors;
            return [];
        } else {
            return $validated;
        }
    }

    //  public function set($data)
    // {
    //     print_r($data);
    // }

    public function getError()
    {
        return $this->Errors;
    }
}
