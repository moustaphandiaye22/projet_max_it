<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Recherche de compte</title>
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
                <span>log out</span>
            </a>
        </div>
    </div>
    <!-- Main Content -->
    <div class="flex-1 p-8">
        <h1 class="text-2xl font-bold mb-4">Recherche de compte</h1>
        <form method="get" action="/servicecommercial/compte" class="mb-4 flex space-x-4">
            <input type="text" name="numero" placeholder="Numéro de compte ou téléphone" class="w-64 pl-4 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500" required>
            <button type="submit" class="bg-orange-500 text-white px-4 py-2 rounded-lg hover:bg-orange-600">Rechercher</button>
        </form>
        <?php if (isset($compte_recherche) && $compte_recherche): ?>
        <div class="bg-white rounded-xl shadow p-6 mb-6">
            <h2 class="text-lg font-semibold mb-2">Compte trouvé</h2>
            <p><strong>Numéro :</strong> <?= htmlspecialchars($compte_recherche->getNumeroTelephone()) ?></p>
            <p><strong>Solde :</strong> <?= number_format($compte_recherche->getSolde(), 2, ',', ' ') ?> F CFA</p>
            <p><strong>Date création :</strong> <?= htmlspecialchars($compte_recherche->getDateCreation()->format('Y-m-d')) ?></p>
            <p><strong>Type :</strong> <?= htmlspecialchars($compte_recherche->getType()) ?></p>
        </div>
        <div class="bg-white rounded-xl shadow p-6">
            <h3 class="text-md font-semibold mb-2">10 dernières transactions</h3>
            <?php if (!empty($transactions_recherche)): ?>
                <ul>
                    <?php foreach ($transactions_recherche as $t): ?>
                        <li class="border-b py-2 flex justify-between">
                            <span><?= htmlspecialchars($t['type']) ?> - <?= htmlspecialchars($t['datetransaction'] ?? ($t['date_transaction'] ?? '')) ?></span>
                            <span><?= number_format($t['montant'], 2, ',', ' ') ?> F CFA</span>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <a href="/servicecommercial/transactions?compte_id=<?= $compte_recherche->getId() ?>" class="text-orange-500 hover:underline mt-2 inline-block">Voir plus</a>
            <?php else: ?>
                <p>Aucune transaction trouvée.</p>
            <?php endif; ?>
        </div>
        <?php elseif (isset($_GET['numero'])): ?>
            <div class="bg-white rounded-xl shadow p-6 mb-6">Aucun compte trouvé.</div>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
