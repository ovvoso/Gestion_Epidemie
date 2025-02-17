<?php
require_once realpath(dirname(__DIR__, 3) . '/bootstrap.php');

use App\PointSurveillance;
use App\Zone;

// Récupérer l'ID de la zone à modifier
$pointSurveillanceId = $_GET['id'] ?? null;
$pointSurveillance = null;
if ($pointSurveillanceId) {
	$pointSurveillance = $entityManager->find(PointSurveillance::class, $pointSurveillanceId);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
	$nom_pointsuper = trim($_POST['nom_pointsuper']);
	$zoneId = $_POST['zone'] ?? null;

	if (empty($nom_pointsuper) || !$zoneId || !$pointSurveillance) {
		echo "<div class='alert alert-danger'>Tous les champs obligatoires doivent être remplis.</div>";
	} else {
		$zone = $entityManager->find(Zone::class, $zoneId);
		if (!$zone) {
			echo "<div class='alert alert-danger'>Zone introuvable.</div>";
		} else {
			$pointSurveillance->setNom_pointsuper($nom_pointsuper);
			$pointSurveillance->setZone($zone);

			$entityManager->flush();
			echo "<div class='alert alert-success'>Point de surveillance modifié avec succès !</div>";
		}
	}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<?php require_once('../../component/head.php') ?>
</head>

<body class="nav-md">
	<div class="container body">
		<div class="main_container">
			<div class="col-md-3 left_col">
				<div class="left_col scroll-view">
					<div class="navbar nav_title" style="border: 0;">
						<a href="index.html" class="site_title"><i class="fa fa-globe"></i> <span>Gentelella Alela!</span></a>
					</div>
					<div class="clearfix"></div>
					<!-- menu profile quick info -->
					<?php require_once('../../component/menu_profile.php') ?>
					<!-- /menu profile quick info -->

					<br />

					<!-- sidebar menu -->
					<?php require_once('../../component/sidebar.php') ?>
					<!-- /sidebar menu -->

					<!-- /menu footer buttons -->
					<div class="sidebar-footer hidden-small">
						<a data-toggle="tooltip" data-placement="top" title="Settings">
							<span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
						</a>
						<a data-toggle="tooltip" data-placement="top" title="FullScreen">
							<span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
						</a>
						<a data-toggle="tooltip" data-placement="top" title="Lock">
							<span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
						</a>
						<a data-toggle="tooltip" data-placement="top" title="Logout" href="login.html">
							<span class="glyphicon glyphicon-off" aria-hidden="true"></span>
						</a>
					</div>
					<!-- /menu footer buttons -->
				</div>
			</div>

			<!-- top navigation -->
			<?php require_once('../component/top_navig.php') ?>
			<!-- /top navigation -->

			<!-- page content -->
			<div class="right_col" role="main">
				<div class="">
					<div class="page-title">
						<div class="title_left">
							<h3>Formulaire de modification de Point de Surveillance</h3>
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="row">
						<div class="col-md-12 col-sm-12 ">
							<div class="x_panel">
								<div class="x_title">
									<h2>Modifier un Point de Surveillance</h2>
									<ul class="nav navbar-right panel_toolbox">
										<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
										</li>
										<li><a class="close-link"><i class="fa fa-close"></i></a>
										</li>
									</ul>
									<div class="clearfix"></div>
								</div>
								<div class="x_content">
									<br />
									<?php if ($pointSurveillance): ?>
										<form method="POST" id="pays-form" class="form-horizontal form-label-left">
											<div class="mb-3">
												<label for="nom" class="form-label">Nom du Point de Surveillance<span class="required">*</span></label>
												<input type="text" id="nom" name="nom_pointsuper" required="required" class="form-control"
													value="<?php echo htmlspecialchars($pointSurveillance->getNom_pointsuper()); ?>">
											</div>
											<div class="mb-3">
												<label for="zone" class="form-label">Zone<span class="required">*</span></label>
												<select id="zone" name="zone" class="form-control" required>
													<option value="">Choisir une zone</option>
													<?php
													$pointSurveillancesList = $entityManager->getRepository(Zone::class)->findAll();
													foreach ($pointSurveillancesList as $zone) {
														$selected = $pointSurveillance->getZone()->getId() === $zone->getId() ? 'selected' : '';
														echo "<option value='{$zone->getId()}' {$selected}>{$zone->getNom()}</option>";
													}
													?>
												</select>
											</div>
											<div class="ln_solid"></div>
											<div class="text-center">
												<button type="submit" class="btn btn-primary">Modifier</button>
												<button type="reset" class="btn btn-danger">Réinitialiser</button>
											</div>
										</form>
									<?php else: ?>
										<div class='alert alert-danger'>Point de surveillance non trouvé.</div>
									<?php endif; ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- /page content -->

			<!-- footer content -->
			<?php require_once('../../component/footer.php') ?>
			<!-- /footer content -->
		</div>
	</div>

	<?php require_once('../../component/script.php') ?>

</body>

</html>