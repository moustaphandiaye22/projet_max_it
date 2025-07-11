<?php
namespace App\Core;
class Validator
{
    private static array $errors = [];

    public static function isEmail(string $key, string $email, string $message = "Email is invalid"): bool
    {
        if (!self::isEmpty($key, $email, "Email is required")) {
            return false;
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            self::addError($key, $message);
            return false;
        }
        return true;
    }

    public static function isEmpty(string $key, $value, string $message = "Ce champ est requis"): bool
    {
        if (empty($value)) {
            self::addError($key, $message);
            return false;
        }
        return true;
    }

    public static function addError(string $key, string $message): void
    {
        if (!isset(self::$errors[$key])) {
            self::$errors[$key] = [];
        }
        self::$errors[$key][] = $message;
    }

    public static function getError(string $key): array
    {
        $errors = self::$errors[$key] ?? [];
        return is_array($errors) ? $errors : [$errors];
    }

    public static function isValid(): bool
    {
        return empty(self::$errors);
    }

    public static function getAllErrors(): array
    {
        return self::$errors;
    }

    public static function reset(): void
    {
        self::$errors = [];
    }

    public static function isSenegalesePhone(string $key, string $numero, string $message = "Numéro de téléphone invalide"): bool
    {
        if (!self::isEmpty($key, $numero, "Le numéro de téléphone est obligatoire")) {
            return false;
        }
        if (!preg_match('/^(77|78|70|76|75)[0-9]{7}$/', $numero)) {
            self::addError($key, $message);
            return false;
        }
        return true;
    }

    public static function isSenegaleseCni(string $key, string $cni, string $message = "Numéro CNI invalide"): bool
    {
        if (!self::isEmpty($key, $cni, "Le numéro de carte identité est obligatoire")) {
            return false;
        }
        
        if (!preg_match('/^[0-9]{13}$/', $cni)) {
            self::addError($key, $message);
            return false;
        }
        return true;
    }
}