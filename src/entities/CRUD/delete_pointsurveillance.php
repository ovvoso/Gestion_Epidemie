<?php

require_once realpath(dirname(__DIR__, levels: 3) . '/bootstrap.php');

use App\PointSurveillance;

// Récupérer l'ID de la zone à supprimer
$pointSuveillanceId = $_GET['id'] ?? null;

if ($pointSuveillanceId) {
    try {
        // Trouver la zone
        $pointSurveillance = $entityManager->find(PointSurveillance::class, $pointSuveillanceId);

        if ($pointSurveillance) {
            // Supprimer la zone
            $entityManager->remove($pointSurveillance);
            $entityManager->flush();

            // Rediriger avec un message de succès
            header('Location: list_pointsurveillance.php?success=1');
            exit;
        } else {
            // Zone non trouvée
            header('Location: list_pointsurveillance.php?error=notfound');
            exit;
        }
    } catch (\Exception $e) {
        // Erreur lors de la suppression
        header('Location: list_pointsurveillance.php?error=delete');
        exit;
    }
} else {
    // ID non fourni
    header('Location: list_pointsurveillance.php?error=noid');
    exit;
}
