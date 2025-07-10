<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-color: #e5e7eb;
        }
        .login-container {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.3));
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .input-with-icon {
            position: relative;
        }
        .input-icon {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
        }
        .forgot-password {
            color: #f97316;
            text-decoration: none;
        }
        .forgot-password:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body class="bg-gray-200 min-h-screen">
   

    <!-- Main Container -->
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="flex w-full max-w-6xl">
            <!-- Left side - Logo -->
            <div class="flex-1 flex items-center justify-center">
                <div class="flex items-center">
                    <img src="/images/uploads/unnamed__1_-removebg-preview.png" alt="Logo" class="h-50 w-50">
                </div>
            </div>

            <!-- Right side - Login Form -->
            <div class="flex-1 flex items-center justify-center">
                <div class="login-container bg-white/20 rounded-2xl shadow-xl p-8 w-full max-w-md">
                    <!-- Title -->
                    <h1 class="text-3xl font-semibold text-center mb-8 text-orange-500">Login</h1>

                    <!-- Form -->
                    <?php if (!empty($errors['login'])): ?>
                        <span class="text-red-500 text-xs"><?php echo implode('<br>', $errors['login']); ?></span>
                    <?php endif; ?>
                    <form class="space-y-6" action="/login" method="POST">
                        <!-- Login Field -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Login</label>
                            <div class="input-with-icon">
                                <input type="text" name="login" placeholder="Enter votre login" value="<?= htmlspecialchars(isset($old['login']) ? $old['login'] : '') ?>" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent pr-12">
                                <svg class="input-icon h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                                </svg>
                            </div>
                        </div>

                        <!-- Password Field -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Mot de passe</label>
                            <div class="input-with-icon">
                                <input type="password" name="password" placeholder="Entrez votre mot de passe" id="password-input" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent pr-12">
                                <button type="button" id="toggle-password" tabindex="-1" class="input-icon focus:outline-none" aria-label="Afficher ou masquer le mot de passe">
                                    <svg id="eye-icon" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zm-6 0a9 9 0 0118 0a9 9 0 01-18 0z" />
                                    </svg>
                                </button>
                                <a href="#" class="forgot-password text-sm font-medium absolute right-12 top-1/2 transform -translate-y-1/2">Mot de passe oublié ?</a>
                            </div>
                            <?php if (!empty($errors['password'])): ?>
                                <span class="text-red-500 text-xs"><?php echo implode('<br>', $errors['password']); ?></span>
                            <?php endif; ?>
                        </div>

                        <!-- Login Button -->
                        <button type="submit" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-semibold py-3 px-4 rounded-lg transition duration-200 mt-8">
                            Login
                        </button>

                        <!-- Register Link -->
                        <div class="text-center mt-6">
                            <span class="text-gray-600">Don't Have an Account? </span>
                            <a href="/register" class="text-orange-500 hover:text-orange-600 font-medium">Register</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Gestion du toggle password visibility
        document.addEventListener('DOMContentLoaded', function() {
            const passwordInput = document.getElementById('password-input');
            const togglePassword = document.getElementById('toggle-password');
            const eyeIcon = document.getElementById('eye-icon');
            if (togglePassword && passwordInput) {
                togglePassword.addEventListener('click', function() {
                    const type = passwordInput.type === 'password' ? 'text' : 'password';
                    passwordInput.type = type;
                    // Optionnel: changer l'icône
                    eyeIcon.innerHTML = type === 'password'
                        ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zm-6 0a9 9 0 0118 0a9 9 0 01-18 0z" />'
                        : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-5 0-9-4-9-7s4-7 9-7c1.657 0 3.22.41 4.575 1.125M15 12a3 3 0 11-6 0 3 3 0 016 0z" />';
                });
            }
            // Effet de focus sur les inputs
            const inputs = document.querySelectorAll('input');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.classList.add('ring-2', 'ring-orange-500');
                });
                input.addEventListener('blur', function() {
                    this.parentElement.classList.remove('ring-2', 'ring-orange-500');
                });
            });
        });
    </script>
</body>
</html>