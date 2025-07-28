<?php
// Formulaire d'achat de code Woyofal
// Variables attendues : $comptes (liste des comptes principaux du client)
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Achat Code Woyofal</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; }
        .achat-container { border: 1px solid #333; padding: 20px; max-width: 400px; margin: auto; }
        h2 { text-align: center; }
        .form-group { margin-bottom: 15px; }
        label { display: block; font-weight: bold; margin-bottom: 5px; }
        input, select { width: 100%; padding: 8px; box-sizing: border-box; }
        .submit-btn { background: #007b00; color: #fff; border: none; padding: 10px 0; width: 100%; font-size: 1em; cursor: pointer; }
        .submit-btn:hover { background: #005a00; }
        .error { color: red; margin-bottom: 10px; }
    </style>
</head>
<body>
<div class="achat-container">
    <a href="/accueil" style="display:inline-block;margin-bottom:15px;text-decoration:none;color:#007b00;font-weight:bold;">&larr; Retour</a>
    <h2>Achat Code Woyofal</h2>
    <?php if (!empty($error)) : ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form id="formAchat">
        <div class="form-group">
            <label for="compte_id">Compte principal</label>
            <select name="compte_id" id="compte_id" required>
                <option value="">Sélectionner un compte</option>
                <?php foreach ($comptes as $compte) : ?>
                    <option value="<?= htmlspecialchars($compte->getId()) ?>">
                        <?= htmlspecialchars($compte->getNumeroTelephone()) ?> (Solde: <?= number_format($compte->getSolde(), 0, ',', ' ') ?> FCFA)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="numeroCompteur">Numéro compteur</label>
            <input type="text" name="numero_compteur" id="numeroCompteur" required maxlength="20">
        </div>
        <div class="form-group">
            <label for="montant">Montant (FCFA)</label>
            <input type="number" name="montant" id="montant" min="100" step="100" required>
        </div>
        <button type="button" id="btnAcheter" class="submit-btn">Acheter le code</button>
        <div id="loader" style="display:none; text-align:center; margin-top:10px;">
            <p>Traitement en cours...</p>
        </div>
    </form>
    <div id="recu" style="margin-top:20px; padding:15px; border:1px solid #ccc; display:none;"></div>
</div>
</body>
</html>
<script>
    async function acheterCreditWoyofal(numeroCompteur, montant) {
    try {
        const response = await fetch('https://appwoyofal-zfte.onrender.com/achat', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                numerocompteur: numeroCompteur,
                montant: parseFloat(montant)
            })
        });

        const result = await response.json();
        
        if (result.statut === 'success') {
            // Achat réussi - Afficher le reçu
            return {
                success: true,
                data: result.data,
                message: result.message
            };
        } else {
            // Erreur - Afficher le message d'erreur
            return {
                success: false,
                error: result.message,
                code: result.code
            };
        }
    } catch (error) {
        // Erreur de connexion
        return {
            success: false,
            error: 'Erreur de connexion à AppWoyofal: ' + error.message
        };
    }
}

// Utilisation dans MaxITSA
document.getElementById('btnAcheter').addEventListener('click', async function() {
    const numeroCompteur = document.getElementById('numeroCompteur').value;
    const montant = document.getElementById('montant').value;
    
    if (!numeroCompteur || !montant) {
        alert('Veuillez saisir le numéro de compteur et le montant');
        return;
    }
    
    // Afficher loader
    document.getElementById('loader').style.display = 'block';
    
    const resultat = await acheterCreditWoyofal(numeroCompteur, montant);
    
    // Cacher loader
    document.getElementById('loader').style.display = 'none';
    
    if (resultat.success) {
        // Afficher le reçu
        afficherRecu(resultat.data);
    } else {
        // Afficher l'erreur
        alert('Erreur: ' + resultat.error);
    }
});

function afficherRecu(data) {
    const recuDiv = document.getElementById('recu');
    recuDiv.style.display = 'block';
    recuDiv.innerHTML = `
        <h3 style="color:green;">✅ Achat Woyofal Réussi</h3>
        <p><strong>Client:</strong> ${data.client}</p>
        <p><strong>Compteur:</strong> ${data.compteur}</p>
        <p><strong>Code de recharge:</strong> <span style="font-size:1.2em;color:blue;font-weight:bold;">${data.code}</span></p>
        <p><strong>kWh obtenus:</strong> ${data.nbreKwt} kWh</p>
        <p><strong>Tranche:</strong> ${data.tranche}</p>
        <p><strong>Prix unitaire:</strong> ${data.prix} FCFA/kWh</p>
        <p><strong>Référence:</strong> ${data.reference}</p>
        <p><strong>Date:</strong> ${data.date}</p>
    `;
}
</script>