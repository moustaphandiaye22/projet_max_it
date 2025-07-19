<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transfert</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col items-center justify-center">
    <div class="w-full max-w-lg bg-white rounded-lg shadow-lg p-8 mt-8">
        <a href="/compte" class="inline-block mb-6 text-orange-500 hover:underline"><i class="fas fa-arrow-left mr-2"></i>Retour</a>
        <h2 class="text-2xl font-bold mb-6 text-center">Transfert entre comptes</h2>
        <form method="post" action="/transactions/transfert" class="space-y-4">
            <div>
                <label for="from_compte_id" class="block text-gray-700">Compte source :</label>
                <select name="from_compte_id" id="from_compte_id" required class="w-full border rounded px-3 py-2 mt-1">
                    <option value="">-- Sélectionner un compte --</option>
                    <?php if (!empty($comptes)) : foreach ($comptes as $c) : ?>
                        <option value="<?= htmlspecialchars($c->getId()) ?>">
                            <?= htmlspecialchars($c->getNumeroTelephone()) ?> (<?= htmlspecialchars($c->getType()) ?>)
                        </option>
                    <?php endforeach; endif; ?>
                </select>
            </div>
            <div>
                <label for="to_compte_id" class="block text-gray-700">Compte destinataire :</label>
                <select name="to_compte_id" id="to_compte_id" required class="w-full border rounded px-3 py-2 mt-1">
                    <option value="">-- Sélectionner un compte --</option>
                    <?php if (!empty($comptes)) : foreach ($comptes as $c) : ?>
                        <option value="<?= htmlspecialchars($c->getId()) ?>">
                            <?= htmlspecialchars($c->getNumeroTelephone()) ?> (<?= htmlspecialchars($c->getType()) ?>)
                        </option>
                    <?php endforeach; endif; ?>
                </select>
            </div>
            <div>
                <label for="montant_transfert" class="block text-gray-700">Montant :</label>
                <input type="number" name="montant" id="montant_transfert" step="0.01" min="1"  class="w-full border rounded px-3 py-2 mt-1">
            </div>
            <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 rounded">Transférer</button>
        </form>
    </div>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</body>
</html>
