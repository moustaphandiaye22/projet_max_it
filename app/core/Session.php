<?php
namespace app\core;

class Session {
    private static $instance = null;

    private function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function set(string $key, $data) {
        $_SESSION[$key] = $data;
    }

    public function get(string $key) {
        return $_SESSION[$key] ?? null;
    }

    public function unset(string $key) {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }

    public function isset(string $key) {
        return isset($_SESSION[$key]);
    }

    public function destroy() {
        session_unset();
        session_destroy();
        self::$instance = null;
    }

    // Gestion des erreurs en session
    public function addError(string $message) {
        if (!isset($_SESSION['errors'])) {
            $_SESSION['errors'] = [];
        }
        $_SESSION['errors'][] = $message;
    }

    public function getErrors() {
        $errors = $_SESSION['errors'] ?? [];
        unset($_SESSION['errors']);
        return $errors;
    }
}
