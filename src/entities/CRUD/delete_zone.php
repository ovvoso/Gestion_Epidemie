<?php
require_once realpath(dirname(__DIR__, levels: 3) . '/bootstrap.php');

use App\Zone;

// Récupérer l'ID de la zone à supprimer
$zoneId = $_GET['id'] ?? null;

if ($zoneId) {
    try {
        // Trouver la zone
        $zone = $entityManager->find(Zone::class, $zoneId);

        if ($zone) {
            // Supprimer la zone
            $entityManager->remove($zone);
            $entityManager->flush();

            // Rediriger avec un message de succès
            header('Location: list_zone.php?success=1');
            exit;
        } else {
            // Zone non trouvée
            header('Location: list_zone.php?error=notfound');
            exit;
        }
    } catch (\Exception $e) {
        // Erreur lors de la suppression
        header('Location: list_zone.php?error=delete');
        exit;
    }
} else {
    // ID non fourni
    header('Location: list_zone.php?error=noid');
    exit;
}
?>
