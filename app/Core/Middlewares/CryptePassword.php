<?php
namespace App\Core\Middlewares;


class CryptePassword
{
    public function handle($request, \Closure $next)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['password'])) {
            $password = $_POST['password'];
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $_POST['password'] = $hashedPassword;
        }
        return $next($request);
    }
}