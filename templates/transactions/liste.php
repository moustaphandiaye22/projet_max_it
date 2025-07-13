<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des transactions</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
<div class="flex min-h-screen">
    <!-- Sidebar -->
    <div class="w-64 bg-white shadow-lg flex flex-col justify-between">
        <div>
            <div class="p-6">
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-orange-500 rounded-lg flex items-center justify-center">
                        <span class="text-white font-bold text-sm">Max it</span>
                    </div>
                </div>
            </div>
            <nav class="mt-8 px-6">
                <a href="/servicecommercial/compte" class="flex items-center space-x-3 px-4 py-3 text-orange-500 bg-orange-50 rounded-lg font-medium">
                    <i class="fas fa-search w-5"></i>
                    <span>Recherche comptes</span>
                </a>
            </nav>
        </div>
        <div class="p-6">
            <a href="/logout" class="flex items-center space-x-3 text-gray-600 hover:text-gray-800">
                <i class="fas fa-sign-out-alt w-5"></i>
                <span>Déconnexion</span>
            </a>
        </div>
    </div>
    <!-- Main Content -->
    <div class="flex-1 p-8">
        <div class="flex items-center justify-between mb-4">
            <h1 class="text-2xl font-bold">Liste des transactions</h1>
            <a href="/servicecommercial/compte" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded flex items-center">
                <i class="fas fa-arrow-left mr-2"></i> Retour à la recherche
            </a>
        </div>
        <form method="get" class="mb-4 flex space-x-4">
            <input type="hidden" name="compte_id" value="<?= htmlspecialchars($_GET['compte_id'] ?? '') ?>">
            <input type="date" name="date" class="border rounded px-2 py-1" value="<?= htmlspecialchars($_GET['date'] ?? '') ?>">
            <select name="type" class="border rounded px-2 py-1">
                <option value="">Tous types</option>
                <option value="depot" <?= (($_GET['type'] ?? '') === 'depot') ? 'selected' : '' ?>>Dépôt</option>
                <option value="retrait" <?= (($_GET['type'] ?? '') === 'retrait') ? 'selected' : '' ?>>Retrait</option>
                <option value="virement" <?= (($_GET['type'] ?? '') === 'virement') ? 'selected' : '' ?>>Virement</option>
            </select>
            <button type="submit" class="bg-orange-500 text-white px-4 py-2 rounded">Filtrer</button>
        </form>
        <?php if (!empty($transactions)): ?>
            <table class="min-w-full bg-white rounded shadow">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b">Date</th>
                        <th class="py-2 px-4 border-b">Type</th>
                        <th class="py-2 px-4 border-b">Montant</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($transactions as $t): ?>
                        <tr>
                            <td class="py-2 px-4 border-b"><?= htmlspecialchars($t['datetransaction'] ?? ($t['date_transaction'] ?? '')) ?></td>
                            <td class="py-2 px-4 border-b"><?= htmlspecialchars($t['type']) ?></td>
                            <td class="py-2 px-4 border-b"><?= number_format($t['montant'], 2, ',', ' ') ?> F CFA</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Aucune transaction trouvée.</p>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
