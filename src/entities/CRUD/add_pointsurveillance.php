<?php
require_once realpath(dirname(__DIR__, 3) . '/bootstrap.php');

use App\Zone;
use App\PointSurveillance;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
	$nom = trim($_POST['nom']);
	$zoneId = $_POST['zone'] ?? null;

	if (empty($nom) || !$zoneId) {
		echo "<div class='alert alert-danger'>Tous les champs doivent être remplis.</div>";
	} else {
		$zone = $entityManager->find(Zone::class, $zoneId);
		if (!$zone) {
			echo "<div class='alert alert-danger'>Zone introuvable.</div>";
		} else {
			$pointSurveillance = new PointSurveillance();
			$pointSurveillance->setNom_pointsuper($nom);
			$pointSurveillance->setZone($zone);

			$entityManager->persist($pointSurveillance);
			$entityManager->flush();

			echo "<div class='alert alert-success'>Point de surveillance ajouté avec succès !</div>";
		}
	}
}
?>
<!DOCTYPE html>
<html lang="en">

	<?php require_once('../../component/head.php')?>

<body class="nav-md">
	<div class="container body">
		<div class="main_container">
			<div class="col-md-3 left_col">
				<div class="left_col scroll-view">
					<div class="navbar nav_title" style="border: 0;">
						<a href="index.html" class="site_title"><i class="fa fa-paw"></i> <span>Gentelella Alela!</span></a>
					</div>
					<div class="clearfix"></div>
					<!-- menu profile quick info -->
					<?php require_once('../../component/menu_profile.php')?>
					<!-- /menu profile quick info -->

					<br />

					<!-- sidebar menu -->
					<?php require_once('../../component/sidebar.php')?>
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
			<div class="top_nav">
				<div class="nav_menu">
					<div class="nav toggle">
						<a id="menu_toggle"><i class="fa fa-bars"></i></a>
					</div>
				</div>
			</div>
			<!-- /top navigation -->

			<!-- page content -->
			<div class="right_col" role="main">
				<div class="">
					<div class="page-title">
						<div class="title_left">
							<h3>Formulaire de Point de Surveillance</h3>
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="row">
						<div class="col-md-12 col-sm-12 ">
							<div class="x_panel">
								<div class="x_title">
									<h2>Ajouter un Point de Surveillance</h2>
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
									<form method="POST" id="zone-form" class="form-horizontal form-label-left">
										<!-- <div class="mb-3">
											<label for="id" class="form-label">ID de la Zone</label>
											<input type="text" id="id" name="id" class="form-control" disabled>
										</div> -->
										<div class="mb-3">
											<label for="nom" class="form-label">Nom de la Point Surveillance<span
													class="required">*</span></label>
											<input type="text" id="nom" name="nom" required="required"
												class="form-control">
										</div>
										<div class="mb-3">
										<label for="zone" class="form-label">Zone<span class="required">*</span></label>
										<select id="zone" name="zone" class="form-control" required>
											<option value="">Choisir une Zone</option>
											<?php
											// Ajout dynamique des pays depuis la base de données
											$zoneList = $entityManager->getRepository(App\Zone::class)->findAll();
											foreach ($zoneList as $zone) {
												echo "<option value='{$zone->getId()}'>{$zone->getNom()}</option>";
											}
											?>
										</select>
 
										</div>
										<!-- <div class="ln_solid"></div> -->
										<div class="text-center mb-3">
											<button type="submit" class="btn btn-primary">Ajouter</button>
											<button type="reset" class="btn btn-danger">Effacer</button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- /page content -->

			<!-- footer content -->
			<?php require_once('../../component/footer.php')?>
			<!-- /footer content -->
		</div>
	</div>

	<?php require_once('../../component/script.php')?>

</body>
</html>