<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transactions - Max it</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <?php
    // Pagination et filtres (doit être tout en haut du fichier pour éviter les warnings)
    $typeFilter = $_GET['type'] ?? '';
    $dateFilter = $_GET['date'] ?? '';
    $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
    $perPage = 7;

    // Filtrage par type
    $filteredTransactions = $transactions;
    if ($typeFilter && $typeFilter !== 'all') {
        $filteredTransactions = array_filter($filteredTransactions, function($t) use ($typeFilter) {
            return isset($t['type']) && $t['type'] === $typeFilter;
        });
    }
    // Filtrage par date (exemple simple, à adapter selon format)
    if ($dateFilter && $dateFilter !== 'all') {
        $filteredTransactions = array_filter($filteredTransactions, function($t) use ($dateFilter) {
            $date = isset($t['datetransaction']) ? $t['datetransaction'] : ($t['date_transaction'] ?? '');
            if (!$date) return false;
            if ($dateFilter === 'today') {
                return strpos($date, date('Y-m-d')) === 0;
            } elseif ($dateFilter === 'week') {
                $week = date('W');
                return date('W', strtotime($date)) == $week;
            } elseif ($dateFilter === 'month') {
                return strpos($date, date('Y-m')) === 0;
            }
            return true;
        });
    }
    $total = count($filteredTransactions);
    $pages = max(1, ceil($total / $perPage));
    $start = ($page - 1) * $perPage;
    $displayedTransactions = array_slice($filteredTransactions, $start, $perPage);
    ?>
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
        <div class="flex-1 overflow-auto">
            <!-- Header -->
            <div class="bg-white border-b border-gray-200 px-8 py-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-semibold text-gray-900">Transactions</h1>
                        <p class="text-gray-600 mt-1">Principal</p>
                        <p class="text-gray-900 font-medium"> 
                            <?php echo isset($numero_telephone) ? htmlspecialchars($numero_telephone) : (isset($user['numero_telephone']) ? htmlspecialchars($user['numero_telephone']) : ''); ?>
                        </p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <a href="/transactions/depot" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded flex items-center">
                            <i class="fas fa-plus mr-2"></i> Dépôt
                        </a>
                        <a href="/transactions/transfert" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded flex items-center">
                            <i class="fas fa-exchange-alt mr-2"></i> Transfert
                        </a>
                        <a href="/transactions/depot#annulation" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded flex items-center">
                            <i class="fas fa-times mr-2"></i> Annuler dépôt
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Filters -->
            <div class="px-8 py-6">
                <div class="flex items-center space-x-4">
                    <div class="relative flex-1">
                        <input type="text" placeholder="" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>
                    <select id="type-filter" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500" onchange="submitFilter()">
                        <option value="all">par type</option>
                        <option value="retrait" <?php if($typeFilter==='retrait') echo 'selected'; ?>>Retrait</option>
                        <option value="depot" <?php if($typeFilter==='depot') echo 'selected'; ?>>Dépôt</option>
                    </select>
                    <select id="date-filter" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500" onchange="submitFilter()">
                        <option value="all">par date</option>
                        <option value="today" <?php if($dateFilter==='today') echo 'selected'; ?>>Aujourd'hui</option>
                        <option value="week" <?php if($dateFilter==='week') echo 'selected'; ?>>Cette semaine</option>
                        <option value="month" <?php if($dateFilter==='month') echo 'selected'; ?>>Ce mois</option>
                    </select>
                </div>
            </div>
            
            <!-- Transactions List -->
            <div class="px-8 pb-8">
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="divide-y divide-gray-200">
                        <!-- Header for columns -->
                        <div class="flex items-center justify-between font-bold text-gray-700 border-b pb-2 bg-gray-50">
                            <div class="flex items-center space-x-4 w-1/2">
                                <span class="w-10">Type</span>
                                <span class="flex-1">Libellé</span>
                            </div>
                            <div class="flex items-center space-x-6 w-1/2 justify-end">
                                <span class="w-32 text-right">Date</span>
                                <span class="w-32 text-right">Montant</span>
                                <span class="w-24 text-center">Statut</span>
                            </div>
                        </div>
                        <?php if (!empty($displayedTransactions)) : ?>
                            <?php foreach ($displayedTransactions as $transaction) : ?>
                                <div class="flex items-center justify-between p-6 hover:bg-gray-50">
                                    <div class="flex items-center space-x-4">
                                        <div class="w-10 h-10 rounded-full flex items-center justify-center <?php echo ($transaction['type'] === 'retrait') ? 'bg-red-100' : 'bg-green-100'; ?>">
                                            <i class="fas <?php echo ($transaction['type'] === 'retrait') ? 'fa-minus text-red-500' : 'fa-plus text-green-500'; ?>"></i>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-900">Transaction</p>
                                            <p class="text-sm text-gray-500"><?php echo htmlspecialchars($transaction['type'] ?? ''); ?></p>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-6">
                                        <div class="text-right">
                                            <p class="text-sm text-gray-500">
                                                <?php echo isset($transaction['datetransaction']) ? htmlspecialchars($transaction['datetransaction']) : (isset($transaction['date_transaction']) ? htmlspecialchars($transaction['date_transaction']) : ''); ?>
                                            </p>
                                        </div>
                                        <div class="text-right">
                                            <p class="font-medium <?php echo ($transaction['type'] === 'retrait') ? 'text-red-500' : 'text-green-500'; ?>">
                                                <?php echo ($transaction['type'] === 'retrait' ? '-' : '+') . number_format($transaction['montant'], 2, ',', ' '); ?>
                                            </p>
                                        </div>
                                        <div>
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium <?php echo ($transaction['type'] === 'retrait') ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800'; ?>">
                                                <?php echo ($transaction['type'] === 'retrait') ? 'Débité' : 'Crédité'; ?>
                                            </span>
                                        </div>
                                        <?php if (($transaction['type'] ?? '') === 'depot') : ?>
                                            <form method="post" action="/transactions/annuler" class="ml-4" onsubmit="return confirm('Annuler ce dépôt ?');">
                                                <input type="hidden" name="transaction_id" value="<?php echo $transaction['id'] ?? ''; ?>">
                                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs">Annuler</button>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <div class="p-6 text-center text-gray-500">Aucune transaction trouvée.</div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Pagination -->
                <div class="px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-500">
                            Affichage de <?php echo $start+1; ?> à <?php echo min($start+$perPage, $total); ?> sur <?php echo $total; ?> transactions
                        </div>
                        <div class="space-x-2">
                            <?php for ($i = 1; $i <= $pages; $i++) : ?>
                                <a href="?page=<?php echo $i; ?><?php echo $typeFilter ? '&type=' . urlencode($typeFilter) : ''; ?><?php echo $dateFilter ? '&date=' . urlencode($dateFilter) : ''; ?>" class="inline-flex items-center px-3 py-1 text-sm font-medium rounded-lg <?php echo ($i == $page) ? 'bg-orange-500 text-white' : 'bg-orange-50 text-orange-500 hover:bg-orange-100'; ?>">
                                    <?php echo $i; ?>
                                </a>
                            <?php endfor; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
    // Soumission des filtres
    function submitFilter() {
        const type = document.getElementById('type-filter').value;
        const date = document.getElementById('date-filter').value;
        window.location.href = '?type=' + encodeURIComponent(type) + '&date=' + encodeURIComponent(date);
    }
    </script>
</body>
</html>