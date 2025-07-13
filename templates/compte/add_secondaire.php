<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter Compte Secondaire</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-300 min-h-screen flex items-center justify-center p-4">
    <!-- Overlay Background -->
    <div class="fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center">
        <!-- Modal Container -->
        <div class="bg-white rounded-2xl shadow-2xl p-8 w-full max-w-md mx-4 border-2 border-blue-400">
            <!-- Header -->
            <div class="text-center mb-8">
                <h2 class="text-2xl font-semibold text-orange-500">Ajouter Compte Secondaire</h2>
            </div>
            
            <!-- Form -->
            <form class="space-y-6" method="post" action="/compte/store">
                <!-- Telephone Field -->
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Telephone</label>
                    <input 
                        type="tel" 
                        name="numero_telephone"
                        required
                        placeholder="Entrer le numéro de téléphone" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent placeholder-gray-400"
                    >
                </div>
                
                <!-- Solde Field -->
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Solde (optionnel)</label>
                    <input 
                        type="number" 
                        name="solde"
                        step="0.01"
                        placeholder="" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                    >
                </div>
                
                <!-- Error Messages -->
                <?php if (isset($_GET['error']) && $_GET['error'] === 'solde'): ?>
                    <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-lg text-center font-semibold">
                        Solde insuffisant sur le compte principal pour effectuer ce transfert.
                    </div>
                <?php elseif (isset($_GET['error']) && $_GET['error'] === 'insertion'): ?>
                    <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-lg text-center font-semibold">
                        Erreur lors de la création du compte secondaire. Veuillez réessayer.
                    </div>
                <?php endif; ?>
                
                <!-- Buttons -->
                <div class="flex space-x-4 pt-4">
                    <a href="/compte" class="flex-1 px-6 py-3 bg-gray-400 text-white rounded-lg font-medium hover:bg-gray-500 transition-colors text-center">Annuler</a>
                    <button 
                        type="submit" 
                        class="flex-1 px-6 py-3 bg-orange-500 text-white rounded-lg font-medium hover:bg-orange-600 transition-colors"
                    >
                        Ajouter
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Background hint text -->
    <div class="absolute top-8 left-8 text-gray-500 text-sm">
        add account overlay
    </div>
</body>
</html>