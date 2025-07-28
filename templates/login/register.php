<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un Compte</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-color: #e5e7eb;
        }
        .upload-box {
            border: 2px dashed #d1d5db;
            background-color: #f9fafb;
        }
        .upload-box:hover {
            border-color: #9ca3af;
        }
    </style>
</head>

<body class="bg-gray-200 flex items-center justify-center">
<?php 
if (!isset($errors)) $errors = [];
if (!isset($old)) $old = [];
?>
<?php if (!empty($success)): ?>
    <div class="w-full max-w-2xl mx-auto mt-4 mb-2 p-3 bg-green-100 text-green-800 rounded text-center border border-green-300">
        <?= htmlspecialchars($success) ?>
    </div>
<?php endif; ?>
    <!-- Main Container -->
    <div class="flex items-center justify-center  p-4">
        <div class="bg-white rounded-lg shadow-lg p-8 w-full max-w-2xl h-auto flex flex-col justify-center">
            <!-- Bouton Retour -->
            <button onclick="window.location.href='/login'" class="mb-4 w-fit flex items-center text-orange-500 hover:text-orange-600 font-medium focus:outline-none">
                <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Retour
            </button>
            <!-- Logo -->
            <div class="flex-1 flex items-center justify-center">
                <div class="flex items-center">
                    <img src="/images/uploads/unnamed__1_-removebg-preview.png" alt="Logo" class="h-12 w-12">
                </div>
            </div>

            <!-- Title -->
            <h1 class="text-2xl font-semibold text-center mb-8 text-gray-800">Créer un Compte</h1>

            <!-- Form -->
            <form method="POST" action="/register" enctype="multipart/form-data" class="space-y-6 flex-1 flex flex-col justify-center">
                <!-- Row 1: Nom and Prenom -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nom</label>
                        <input type="text" name="nom" id="nom" placeholder="Enter nom" value="<?= htmlspecialchars(
                        isset($old['nom']) ? $old['nom'] : '') ?>" 
                        autocomplete="family-name"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent" >
                        <?php if (!empty($errors['nom'])): ?>
                            <span class="text-red-500 text-xs"><?php echo implode('<br>', $errors['nom']); ?></span>
                        <?php endif; ?>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Prenom</label>
                        <input type="text" name="prenom" id="prenom" placeholder="Enter prenom" value="<?= htmlspecialchars(
                        isset($old['prenom']) ? $old['prenom'] : '') ?>"
                         autocomplete="given-name"
                         class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent" >
                        <?php if (!empty($errors['prenom'])): ?>
                            <span class="text-red-500 text-xs"><?php echo implode('<br>', $errors['prenom']); ?></span>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Row 2: Telephone and Numero CNI -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">telephone</label>
                        <input type="tel" name="numero_telephone" id="telephone" placeholder="Enter telephone" value="<?= htmlspecialchars(isset($old['numero_telephone']) ? $old['numero_telephone'] : '') ?>" autocomplete="tel" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent" >
                        <?php if (!empty($errors['numero_telephone'])): ?>
                            <span class="text-red-500 text-xs"><?php echo implode('<br>', $errors['numero_telephone']); ?></span>
                        <?php endif; ?>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Numero CNI</label>
                        <input type="text" name="numero_carte_identite" id="numeroCni" placeholder="Enter CNI" value="<?= htmlspecialchars(isset($old['numero_carte_identite']) ? $old['numero_carte_identite'] : '') ?>" autocomplete="off" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent" >
                        <?php if (!empty($errors['numero_carte_identite'])): ?>
                            <span class="text-red-500 text-xs"><?php echo implode('<br>', $errors['numero_carte_identite']); ?></span>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Row 3: Adresse -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Adresse</label>
                    <input type="text" name="adresse" id="address" placeholder="Enter votre adresse" value="<?= htmlspecialchars(isset($old['adresse']) ? $old['adresse'] : '') ?>" autocomplete="street-address" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent" >
                    <?php if (!empty($errors['adresse'])): ?>
                        <span class="text-red-500 text-xs"><?php echo implode('<br>', $errors['adresse']); ?></span>
                    <?php endif; ?>
                </div>

                <!-- Row 4: Login and Password -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Login</label>
                        <input type="text" name="login" placeholder="Enter login" value="<?= htmlspecialchars(isset($old['login']) ? $old['login'] : '') ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent" >
                        <?php if (!empty($errors['login'])): ?>
                            <span class="text-red-500 text-xs"><?php echo implode('<br>', $errors['login']); ?></span>
                        <?php endif; ?>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                        <input type="password" name="password" placeholder="Enter mot de passe" value="<?= htmlspecialchars(isset($old['password']) ? $old['password'] : '') ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                        <?php if (!empty($errors['password'])): ?>
                            <span class="text-red-500 text-xs"><?php echo implode('<br>', $errors['password']); ?></span>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Row 5: Photo Upload -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Photo CNI Recto</label>
                        <div class="upload-box rounded-md h-24 flex items-center justify-center cursor-pointer">
                            <div class="text-center">
                                <svg class="mx-auto h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                            </div>
                            <input type="file" name="photo_recto_carte_identite" class="hidden" accept="image/*">
                        </div>
                        <?php if (!empty($errors['photo_recto_carte_identite'])): ?>
                            <span class="text-red-500 text-xs"><?php echo implode('<br>', $errors['photo_recto_carte_identite']); ?></span>
                        <?php endif; ?>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Photo CNI Verso</label>
                        <div class="upload-box rounded-md h-24 flex items-center justify-center cursor-pointer">
                            <div class="text-center">
                                <svg class="mx-auto h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                            </div>
                            <input type="file" name="photo_verso_carte_identite" class="hidden" accept="image/*">
                        </div>
                        <?php if (!empty($errors['photo_verso_carte_identite'])): ?>
                            <span class="text-red-500 text-xs"><?php echo implode('<br>', $errors['photo_verso_carte_identite']); ?></span>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Checkbox -->
                <div class="flex items-center">
                    <input type="checkbox" name="terms" class="h-4 w-4 text-orange-500 focus:ring-orange-400 border-gray-300 rounded" >
                    <label class="ml-2 text-sm text-gray-700">Accepter les termes d'utilisation</label>
                </div>
                <?php if (!empty($errors['terms'])): ?>
                    <span class="text-red-500 text-xs"><?php echo implode('<br>', $errors['terms']); ?></span>
                <?php endif; ?>

                <!-- Submit Button -->
                <button type="submit" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-semibold py-3 px-4 rounded-md transition duration-200">
                    Register
                </button>

                <!-- Login Link -->
                <div class="text-center mt-4">
                    <span class="text-gray-600">J'ai déjà un Compte? </span>
                    <a href="/login" class="text-orange-500 hover:text-orange-600 font-medium">se connecter.</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Gestion des zones de upload
        document.querySelectorAll('.upload-box').forEach(box => {
            const input = box.querySelector('input[type="file"]');
            
            box.addEventListener('click', () => {
                input.click();
            });
            
            box.addEventListener('dragover', (e) => {
                e.preventDefault();
                box.classList.add('border-orange-500');
            });
            
            box.addEventListener('dragleave', () => {
                box.classList.remove('border-orange-500');
            });
            
            box.addEventListener('drop', (e) => {
                e.preventDefault();
                box.classList.remove('border-orange-500');
                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    input.files = files;
                    // Ici vous pouvez ajouter la logique pour prévisualiser l'image
                }
            });
        });

        // Gestion de l'auto-completion CNI
        document.addEventListener('DOMContentLoaded', function() {
            const cniInput = document.getElementById('numeroCni');
            if (!cniInput) return;
            
            cniInput.addEventListener('input', async function() {
                const cniValue = cniInput.value.trim();
                console.log('CNI saisi:', cniValue); 
                
                if (/^\d{13}$/.test(cniValue)) {
                    try {
                        console.log('Envoi requête fetch...');
                        const response = await fetch(`https://appdaf-9aze.onrender.com/citoyen?nci=${cniValue}`);
                        console.log('Réponse fetch:', response);
                        
                        if (response.ok) {
                            const citoyen = await response.json();
                            console.log('Citoyen reçu:', citoyen);
                            
                            if (citoyen && citoyen.data) {
                                document.getElementById('prenom').value = citoyen.data.prenom || '';
                                document.getElementById('nom').value = citoyen.data.nom || '';
                                document.getElementById('telephone').value = citoyen.data.telephone || '';
                                document.getElementById('address').value = citoyen.data.lieuNaissance || '';
                            }
                            
                            // Ajouter un indicateur visuel de succès
                            cniInput.classList.add('border-green-500');
                            cniInput.classList.remove('border-red-500');
                            
                        } else {
                            // CNI non trouvé - vider les champs
                            document.getElementById('prenom').value = '';
                            document.getElementById('nom').value = '';
                            document.getElementById('telephone').value = '';
                            document.getElementById('address').value = '';
                            
                            cniInput.classList.add('border-red-500');
                            cniInput.classList.remove('border-green-500');
                        }
                    } catch (e) {
                        console.error('Erreur lors de la récupération du citoyen:', e);
                        cniInput.classList.add('border-red-500');
                        cniInput.classList.remove('border-green-500');
                    }
                } else {
                    // Réinitialiser les couleurs si le CNI n'est pas valide
                    cniInput.classList.remove('border-green-500', 'border-red-500');
                }
            });
        });
    </script>
</body>
</html>