<?php
require_once realpath(dirname(__DIR__, 3) . '/bootstrap.php');

use App\Pays;
use App\Zone;

// Récupérer l'ID de la zone à modifier
$zoneId = $_GET['id'] ?? null;
$zone = null;
if ($zoneId) {
	$zone = $entityManager->find(Zone::class, $zoneId);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
	$nom = trim($_POST['nom']);
	$statut = $_POST['statut'] ?? '';
	$nbHabitants = $_POST['nb_habitants'] ?? 0;
	$nbSymptomatiques = $_POST['nb_symptomatiques'] ?? 0;
	$nbPositifs = $_POST['nb_positifs'] ?? 0;
	$paysId = $_POST['pays'] ?? null;

	if (empty($nom) || empty($statut) || !$paysId || !$zone) {
		echo "<div class='alert alert-danger'>Tous les champs obligatoires doivent être remplis.</div>";
	} else {
		$pays = $entityManager->find(Pays::class, $paysId);
		if (!$pays) {
			echo "<div class='alert alert-danger'>Pays introuvable.</div>";
		} else {
			$zone->setNom($nom);
			$zone->setStatut($statut);
			$zone->setNb_habitants($nbHabitants);
			$zone->setNb_symptomatiques($nbSymptomatiques);
			$zone->setNb_positifs($nbPositifs);
			$zone->setPays($pays);

			$entityManager->flush();
			echo "<div class='alert alert-success'>Zone modifiée avec succès !</div>";
		}
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<?php require_once('../../component/head.php') ?>

<body class="nav-md">
	<div class="container body">
		<div class="main_container">
			<div class="col-md-3 left_col">
				<div class="left_col scroll-view">
					<div class="navbar nav_title" style="border: 0;">
						<a href="index.html" class="site_title"><i class="fa fa-globe"></i> <span>Gestion épidemie</span></a>
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
							<h3>Formulaire de modification de Zone</h3>
						</div>

					</div>
					<div class="clearfix"></div>
					<div class="row">
						<div class="col-md-12 col-sm-12 ">
							<div class="x_panel">
								<div class="x_title">
									<h2>Modifier une zone</h2>
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
									<?php if ($zone): ?>
										<form method="POST" id="zone-form" class="form-horizontal form-label-left">
											<div class="mb-3">
												<label for="nom" class="form-label">Nom de la Zone<span class="required">*</span></label>
												<input type="text" id="nom" name="nom" required="required" class="form-control"
													value="<?php echo htmlspecialchars($zone->getNom()); ?>">
											</div>
											<div class="mb-3">
												<label for="statut" class="form-label">Statut<span class="required">*</span></label>
												<select id="statut" name="statut" class="form-control" required>
													<option value="">Choisir un statut</option>
													<option value="verte" <?php echo $zone->getStatut() === 'verte' ? 'selected' : ''; ?>>Verte</option>
													<option value="orange" <?php echo $zone->getStatut() === 'orange' ? 'selected' : ''; ?>>Orange</option>
													<option value="rouge" <?php echo $zone->getStatut() === 'rouge' ? 'selected' : ''; ?>>Rouge</option>
												</select>
											</div>
											<div class="mb-3">
												<label for="nb_habitants" class="form-label">Nombre d'Habitants</label>
												<input type="number" id="nb_habitants" name="nb_habitants" class="form-control"
													value="<?php echo $zone->getNb_habitants(); ?>">
											</div>
											<div class="mb-3">
												<label for="nb_symptomatiques" class="form-label">Nombre de Symptomatiques</label>
												<input type="number" id="nb_symptomatiques" name="nb_symptomatiques" class="form-control"
													value="<?php echo $zone->getNb_symptomatiques(); ?>">
											</div>
											<div class="mb-3">
												<label for="nb_positifs" class="form-label">Nombre de Cas Positifs</label>
												<input type="number" id="nb_positifs" name="nb_positifs" class="form-control"
													value="<?php echo $zone->getNb_positifs(); ?>">
											</div>
											<div class="mb-3">
												<label for="pays" class="form-label">Pays<span class="required">*</span></label>
												<select id="pays" name="pays" class="form-control" required>
													<option value="">Choisir un pays</option>
													<?php
													$paysList = $entityManager->getRepository(Pays::class)->findAll();
													foreach ($paysList as $pays) {
														$selected = $zone->getPays()->getId() === $pays->getId() ? 'selected' : '';
														echo "<option value='{$pays->getId()}' {$selected}>{$pays->getNom()}</option>";
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
										<div class="alert alert-danger">Zone non trouvée.</div>
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