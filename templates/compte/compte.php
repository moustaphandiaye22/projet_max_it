<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compte - Max it</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    

    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-white shadow-lg">
            <!-- Logo -->
            <div class="p-6">
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-orange-500 rounded-lg flex items-center justify-center">
                        <span class="text-white font-bold text-sm">Max it</span>
                    </div>
                </div>
            </div>
            
            <!-- Navigation -->
            <nav class="mt-8">
                <div class="px-6 space-y-2">
                    <a href="/accueil" class="flex items-center space-x-3 px-4 py-3 text-gray-600 hover:bg-gray-100 rounded-lg">
                        <i class="fas fa-th-large w-5"></i>
                        <span>Accueil</span>
                    </a>
                    <a href="/compte" class="flex items-center space-x-3 px-4 py-3 text-orange-500 bg-orange-50 rounded-lg">
                        <i class="fas fa-calculator w-5"></i>
                        <span class="font-medium">Compte</span>
                    </a>
                    <a href="/list_transaction" class="flex items-center space-x-3 px-4 py-3 text-gray-600 hover:bg-gray-100 rounded-lg">
                        <i class="fas fa-exchange-alt w-5"></i>
                        <span>Transactions</span>
                    </a>
                    <a href="#" class="flex items-center space-x-3 px-4 py-3 text-gray-600 hover:bg-gray-100 rounded-lg">
                        <i class="fas fa-user w-5"></i>
                        <span>Profile</span>
                    </a>
                </div>
            </nav>
            
            <!-- Logout -->
            <div class="absolute bottom-6 left-6">
                <a href="/logout" class="flex items-center space-x-3 text-gray-600 hover:text-gray-800">
                    <i class="fas fa-sign-out-alt w-5"></i>
                    <span>Logout</span>
                </a>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="flex-1 overflow-auto">
            <!-- Header -->
            <div class="bg-white border-b border-gray-200 px-8 py-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-semibold text-gray-900">Compte</h1>
                        <p class="text-gray-600 mt-1">Principal</p>
                        <p class="text-gray-900 font-medium">77 141 12 51</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <input type="text" placeholder="Search" class="w-64 pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                        </div>
                        <button class="p-2 text-gray-400 hover:text-gray-600">
                            <i class="fas fa-bell"></i>
                        </button>
                        <div class="w-8 h-8 bg-gray-800 rounded-full"></div>
                    </div>
                </div>
            </div>
            
            <!-- Account Cards and Add Button -->
            <div class="px-8 py-6">
                <div class="flex items-center space-x-6">
                    <?php if (!empty($comptes)): ?>
                        <?php foreach ($comptes as $compte): ?>
                            <div class="bg-orange-500 text-white rounded-xl p-6 w-80 relative">
                                <!-- Bandeau type de compte -->
                                <div class="absolute -top-4 left-1/2 transform -translate-x-1/2 bg-white text-orange-500 px-4 py-1 rounded-full shadow text-xs font-bold uppercase border border-orange-500">
                                    <?php if ($compte->getType() === 'principal'): ?>
                                        Compte Principal
                                    <?php else: ?>
                                        Compte Secondaire
                                    <?php endif; ?>
                                </div>
                                <div class="flex justify-between items-start mt-4">
                                    <div>
                                        <p class="text-orange-100 text-xs mb-1">N° <?= htmlspecialchars($compte->getNumeroTelephone()) ?></p>
                                        <p class="text-2xl font-bold mt-2">
                                            <?= number_format($compte->getSolde(), 2, ',', ' ') ?> F CFA
                                        </p>
                                    </div>
                                    <i class="fas fa-edit text-orange-200 cursor-pointer"></i>
                                </div>
                                <?php 
                                    
                                ?>
                                <?php if (trim(strtolower($compte->getType())) === 'secondaire'): ?>
                                    <p class="text-xs text-orange-100 mt-2">Compte secondaire</p>
                                    <div class="mt-4">
                                        <form method="post" action="/compte/set_principal">
                                            <input type="hidden" name="compte_id" value="<?= $compte->getId() ?>">
                                            <button type="submit" class="bg-white text-orange-500 px-4 py-2 rounded-lg text-sm font-medium hover:bg-orange-50">
                                                Changer en Principal
                                            </button>
                                        </form>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <!-- Add Account Button -->
                    <a href="/add_compte_secondaire" class="block">
                        <div class="bg-gray-100 rounded-xl p-6 w-80 flex items-center justify-center cursor-pointer hover:bg-gray-200">
                            <div class="text-center">
                                <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center mx-auto mb-2">
                                    <i class="fas fa-plus text-gray-600"></i>
                                </div>
                                <p class="text-gray-600 text-sm font-medium">Ajouter Compte</p>
                                <p class="text-gray-500 text-xs">Secondaire</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            
            <!-- Transactions Section -->
            <div class="px-8 pb-8">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-semibold text-gray-900">Transactions</h2>
                    <button class="flex items-center space-x-2 bg-orange-500 text-white px-4 py-2 rounded-lg hover:bg-orange-600">
                        <span>voir plus</span>
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="divide-y divide-gray-200">
                        <?php if (!empty($transactions_principal)): ?>
                            <?php foreach ($transactions_principal as $transaction): ?>
                                <div class="flex items-center justify-between p-6 hover:bg-gray-50">
                                    <div class="flex items-center space-x-4">
                                        <div class="w-10 h-10 <?php echo ($transaction['type'] === 'retrait') ? 'bg-red-100' : 'bg-green-100'; ?> rounded-full flex items-center justify-center">
                                            <i class="fas <?php echo ($transaction['type'] === 'retrait') ? 'fa-minus text-red-500' : 'fa-plus text-green-500'; ?>"></i>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-900">Transaction #<?= htmlspecialchars($transaction['id']) ?></p>
                                            <p class="text-sm text-gray-500">Réf : <?= htmlspecialchars($transaction['reference'] ?? '') ?></p>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-6">
                                        <div class="text-right">
                                            <p class="text-sm text-gray-500"><?php echo isset($transaction['datetransaction']) ? date('d M Y - H:i', strtotime($transaction['datetransaction'])) : ''; ?></p>
                                        </div>
                                        <div class="text-right">
                                            <p class="font-medium <?php echo ($transaction['type'] === 'retrait') ? 'text-red-500' : 'text-green-500'; ?>">
                                                <?php echo ($transaction['type'] === 'retrait' ? '-' : '+') . number_format($transaction['montant'], 2, ',', ' '); ?>
                                            </p>
                                        </div>
                                        <div>
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium <?php echo ($transaction['type'] === 'retrait') ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800'; ?>">
                                                <?= ucfirst($transaction['type']) ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="p-6 text-center text-gray-500">Aucune transaction trouvée pour le compte principal.</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>