<?php
require_once realpath(dirname(__DIR__, levels: 3) . '/bootstrap.php');

use App\Pays;

// Récupérer l'ID de la Pays à supprimer
$paysId = $_GET['id'] ?? null;

if ($paysId) {
    try {
        // Trouver la Pays
        $pays = $entityManager->find(Pays::class, $paysId);

        if ($pays) {
            // Supprimer la Pays
            $entityManager->remove($pays);
            $entityManager->flush();

            // Rediriger avec un message de succès
            header('Location: list_pays.php?success=supprimer');
            exit;
        } else {
            // Pays non trouvée
            header('Location: list_pays.php?error=notfound');
            exit;
        }
    } catch (\Exception $e) {
        // Erreur lors de la suppression
        header('Location: list_pays.php?error=delete');
        exit;
    }
} else {
    // ID non fourni
    header('Location: list_pays.php?error=noid');
    exit;
}
?>
