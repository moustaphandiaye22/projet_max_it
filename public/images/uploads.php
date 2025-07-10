<?php
// Script d'upload d'image pour Personne

function uploadImage($file, $targetDir = __DIR__ . '/uploads/') {
    if (!isset($file['tmp_name']) || $file['error'] !== UPLOAD_ERR_OK) {
        return [false, 'Erreur lors de l\'upload du fichier.'];
    }
    $filename = uniqid() . '_' . basename($file['name']);
    $targetPath = $targetDir . $filename;
    if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
        return [false, 'Impossible de sauvegarder le fichier uploadé.'];
    }
    return [true, $filename];
}


