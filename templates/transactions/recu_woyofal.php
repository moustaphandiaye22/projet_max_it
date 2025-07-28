<?php
// Reçu d'achat Woyofal
// Variables attendues : $nom, $prenom, $numero_compteur, $code_recharge, $date_heure, $tranche, $prix_unitaire, $montant, $nbre_kw
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Reçu Achat Woyofal</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; }
        .recu-container { border: 1px solid #333; padding: 20px; max-width: 500px; margin: auto; }
        h2 { text-align: center; }
        .info { margin-bottom: 10px; }
        .label { font-weight: bold; }
        .code { font-size: 1.5em; color: #007b00; text-align: center; margin: 20px 0; }
    </style>
</head>
<body>
<div class="recu-container">
    <h2>Reçu Achat Woyofal</h2>
    <div class="info"><span class="label">Nom & Prénom :</span> <?= htmlspecialchars($nom) ?> <?= htmlspecialchars($prenom) ?></div>
    <div class="info"><span class="label">Numéro Compteur :</span> <?= htmlspecialchars($numero_compteur) ?></div>
    <div class="info"><span class="label">Date & Heure :</span> <?= htmlspecialchars($date_heure) ?></div>
    <div class="info"><span class="label">Montant :</span> <?= number_format($montant, 0, ',', ' ') ?> FCFA</div>
    <div class="info"><span class="label">Nombre de KW :</span> <?= htmlspecialchars($nbre_kw) ?></div>
    <div class="info"><span class="label">Tranche :</span> <?= htmlspecialchars($tranche) ?></div>
    <div class="info"><span class="label">Prix unitaire KWH :</span> <?= number_format($prix_unitaire, 2, ',', ' ') ?> FCFA</div>
    <div class="code">Code de recharge : <strong><?= htmlspecialchars($code_recharge) ?></strong></div>
</div>
</body>
</html>
