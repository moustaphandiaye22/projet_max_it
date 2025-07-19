<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dépôt</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col items-center justify-center">
    <div class="w-full max-w-lg bg-white rounded-lg shadow-lg p-8 mt-8">
        <a href="/compte" class="inline-block mb-6 text-orange-500 hover:underline"><i class="fas fa-arrow-left mr-2"></i>Retour</a>
        <h2 class="text-2xl font-bold mb-6 text-center">Dépôt</h2>
        <?php if (isset($_GET['success'])): ?>
            <div class="mb-4 p-3 rounded bg-green-100 text-green-700 text-center">Dépôt effectué avec succès !</div>
        <?php elseif (isset($_GET['error'])): ?>
            <div class="mb-4 p-3 rounded bg-red-100 text-red-700 text-center">Erreur : <?= htmlspecialchars($_GET['error']) ?></div>
        <?php endif; ?>
        <form method="post" action="/transactions/depot" class="space-y-4">
            <div>
                <label for="compte_id" class="block text-gray-700">Compte à créditer :</label>
                <select name="compte_id" id="compte_id" required class="w-full border rounded px-3 py-2 mt-1">
                    <option value="">-- Sélectionner un compte --</option>
                    <?php if (!empty($comptes)) : foreach ($comptes as $c) : ?>
                        <option value="<?= htmlspecialchars($c->getId()) ?>">
                            <?= htmlspecialchars($c->getNumeroTelephone()) ?> (<?= htmlspecialchars($c->getType()) ?>)
                        </option>
                    <?php endforeach; endif; ?>
                </select>
            </div>
            <div>
                <label for="montant" class="block text-gray-700">Montant :</label>
                <input type="number" name="montant" id="montant" step="0.01" min="1"  class="w-full border rounded px-3 py-2 mt-1">
            </div>
            <button type="submit" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-semibold py-2 rounded">Déposer</button>
        </form>
    </div>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</body>
</html>
