<script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

<style>
    body {
        background-color: #e5e7eb;
    }

    .main-content {
        background-color: #ffffff;
        min-height: 100vh;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .balance-card {
        background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
    }

    .action-card {
        background-color: #1f2937;
    }

    .promo-card {
        background: linear-gradient(135deg, #f97316 0%, #1f2937 100%);
    }

    .transaction-positive {
        color: #10b981;
    }

    .transaction-negative {
        color: #ef4444;
    }
</style>
<body class="bg-gray-200 min-h-screen">
    <script>
        function toggleSolde() {
            const solde = document.getElementById('solde-value');
            const eyeOpen = document.getElementById('eye-open');
            const eyeClosed = document.getElementById('eye-closed');
            if (solde.style.filter === 'blur(8px)') {
                solde.style.filter = 'none';
                eyeOpen.style.display = 'inline';
                eyeClosed.style.display = 'none';
            } else {
                solde.style.filter = 'blur(8px)';
                eyeOpen.style.display = 'none';
                eyeClosed.style.display = 'inline';
            }
        }
    </script>
    <div class="flex">
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
                    <a href="/compte" class="flex items-center space-x-3 px-4 py-3 text-gray-600 hover:bg-gray-100 rounded-lg">
                        <i class="fas fa-calculator w-5"></i>
                        <span>Compte</span>
                    </a>
                    <a href="/list_transaction" class="flex items-center space-x-3 px-4 py-3 text-orange-500 bg-orange-50 rounded-lg">
                        <i class="fas fa-exchange-alt w-5"></i>
                        <span class="font-medium">Transactions</span>
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
        <div class="flex-1 main-content p-6 bg-gradient-to-br from-orange-50 to-gray-100">
            <!-- Message de bienvenue -->
            <div class="mb-2">
                <h2 class="text-2xl font-bold text-gray-800">Bienvenue sur votre espace Max It</h2>
                <p class="text-gray-500 mt-1">Gérez vos comptes et transactions en toute simplicité.</p>
            </div>
            <!-- Numéro de téléphone -->
            <?php if(isset($numero_telephone)) : ?>
                <div class="mb-6">
                    <span class="inline-block bg-orange-100 text-orange-700 px-4 py-2 rounded-full font-semibold text-sm shadow">
                        <svg class="inline w-5 h-5 mr-1 text-orange-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H5a2 2 0 01-2-2V5zm0 12a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H5a2 2 0 01-2-2v-2zm12-12a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zm0 12a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                        <?php echo htmlspecialchars($numero_telephone); ?>
                    </span>
                </div>
            <?php endif; ?>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Column -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Balance Card -->
                    <div class="balance-card rounded-lg p-6 text-white relative">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-medium">Solde du compte Principal</h3>
                            <div class="flex items-center space-x-2">
                                <div class="bg-white text-orange-500 p-2 rounded">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
                                    </svg>
                                </div>
                                <select class="bg-transparent border border-white/30 rounded px-3 py-1 text-white">
                                    <option>Principal</option>
                                </select>
                            </div>
                        </div>
                        <div class="text-3xl font-bold mb-4 flex items-center space-x-2">
                            <span id="solde-value" style="transition: filter 0.2s;"> <?php echo number_format($solde, 2, ',', ' '); ?> F CFA</span>
                            <button onclick="toggleSolde()" class="ml-2 focus:outline-none">
                                <svg id="eye-open" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.522 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.478 0-8.268-2.943-9.542-7z"/></svg>
                                <svg id="eye-closed" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="display:none"><path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.956 9.956 0 012.293-3.95M6.634 6.634A9.956 9.956 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.956 9.956 0 01-4.284 5.302M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18"/></svg>
                            </button>
                        </div>
                        <div class="flex justify-end">
                            <button class="bg-orange-600 hover:bg-orange-700 text-white p-2 rounded">
                                
                            </button>
                            <button class="bg-green-600 hover:bg-green-700 text-white p-2 rounded ml-2" onclick="window.location.href='/add_compte_secondaire'">
                                Ajouter un secondaire
                            </button>
                        </div>
                    </div>

                    <!-- Action Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <a href="/transactions/achat_woyofal_form" class="action-card rounded-lg p-4 text-white text-center shadow hover:scale-105 transition">
                            <svg class="w-8 h-8 mx-auto mb-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4zM18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z"></path>
                            </svg>
                            <div class="text-sm font-medium">Paiement woyofal</div>
                        </a>
                        <a href="/transactions/transfert" class="action-card rounded-lg p-4 text-white text-center shadow hover:scale-105 transition">
                            <svg class="w-8 h-8 mx-auto mb-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M8 5a1 1 0 100 2h5.586l-1.293 1.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L13.586 5H8zM12 15a1 1 0 100-2H6.414l1.293-1.293a1 1 0 10-1.414-1.414l-3 3a1 1 0 000 1.414l3 3a1 1 0 001.414-1.414L6.414 15H12z"></path>
                            </svg>
                            <div class="text-sm font-medium">Transfert</div>
                        </a>
                        <div class="action-card rounded-lg p-4 text-white text-center shadow hover:scale-105 transition">
                            <svg class="w-8 h-8 mx-auto mb-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
                            </svg>
                            <div class="text-sm font-medium">Forfait sakanal</div>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                        <div class="action-card rounded-lg p-4 text-white text-center shadow hover:scale-105 transition">
                            <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div class="text-sm font-medium">Recharge</div>
                        </div>
                        <div class="action-card rounded-lg p-4 text-white text-center shadow hover:scale-105 transition">
                            <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2a2 2 0 012-2h2a2 2 0 012 2v2m-6 4h6a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <div class="text-sm font-medium">Paiement Facture</div>
                        </div>
                        <div class="action-card rounded-lg p-4 text-white text-center shadow hover:scale-105 transition">
                            <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div class="text-sm font-medium">Historique</div>
                        </div>
                    </div>

                    <!-- Promo Card -->
                    <div class="promo-card rounded-lg p-6 text-white relative overflow-hidden flex items-center justify-center" style="height:180px;">
                        <img src="/images/uploads/images.jpeg" alt="Logo" class="absolute inset-0 w-full h-full object-cover opacity-80">
                        
                    </div>
                </div>

                <!-- Right Column - Transactions -->
                <div class="space-y-6">
                    <div class="bg-white rounded-lg p-6 shadow-sm">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-medium">Transactions</h3>
                            <button onclick="window.location.href='/list_transaction'" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg text-sm">
                                voir plus →
                            </button>
                        </div>
                        <div class="space-y-3">
                            <!-- Header for columns -->
                            <div class="flex items-center justify-between font-bold text-gray-700 border-b pb-2">
                                <div class="flex items-center space-x-3">
                                    <span class="w-8"></span>
                                    <span class="w-32">Date</span>
                                    <span class="w-24">Type</span>
                                </div>
                                <span class="w-32 text-right">Montant</span>
                            </div>
                            <?php 
                            $maxTransactions = 10;
                            $displayedTransactions = array_slice($transactions, 0, $maxTransactions);
                            if (!empty($displayedTransactions)) : ?>
                                <?php foreach ($displayedTransactions as $transaction) : ?>
                                    <div class="flex items-center justify-between hover:bg-orange-50 rounded transition p-1">
                                        <div class="flex items-center space-x-3">
                                            <!-- Icone selon le type -->
                                            <?php if (isset($transaction['type']) && $transaction['type'] === 'retrait') : ?>
                                                <span class="w-8 h-8 flex items-center justify-center bg-red-100 rounded-full">
                                                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 13l-5 5m0 0l-5-5m5 5V6"/></svg>
                                                </span>
                                            <?php else : ?>
                                                <span class="w-8 h-8 flex items-center justify-center bg-green-100 rounded-full">
                                                    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 11l5-5m0 0l5 5m-5-5v12"/></svg>
                                                </span>
                                            <?php endif; ?>
                                            <div class="w-32 text-xs text-gray-500">
                                                <?php 
                                                // Affichage de la date, essaye plusieurs clés possibles
                                                echo isset($transaction['datetransaction']) ? htmlspecialchars($transaction['datetransaction']) : (isset($transaction['date_transaction']) ? htmlspecialchars($transaction['date_transaction']) : ''); 
                                                ?>
                                            </div>
                                            <div class="w-24 text-xs">
                                                <?php if (isset($transaction['type']) && $transaction['type'] === 'retrait') : ?>
                                                    <span class="bg-red-100 text-red-600 px-2 py-0.5 rounded-full text-xs font-semibold">Retrait</span>
                                                <?php else : ?>
                                                    <span class="bg-green-100 text-green-600 px-2 py-0.5 rounded-full text-xs font-semibold">Dépôt</span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="w-32 text-right font-semibold <?php echo ($transaction['type'] === 'retrait') ? 'text-red-500' : 'text-green-500'; ?>">
                                            <?php echo ($transaction['type'] === 'retrait' ? '-' : '+') . number_format($transaction['montant'], 2, ',', ' '); ?> F CFA
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <div>Aucune transaction trouvée.</div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
