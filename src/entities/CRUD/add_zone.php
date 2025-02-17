<?php
require_once realpath(dirname(__DIR__, 3) . '/bootstrap.php');

use App\Pays;
use App\Zone;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom = trim($_POST['nom']);
    $statut = $_POST['statut'] ?? '';
    $nbHabitants = $_POST['nb_habitants'] ?? 0;
    $nbSymptomatiques = $_POST['nb_symptomatiques'] ?? 0;
    $nbPositifs = $_POST['nb_positifs'] ?? 0;
    $paysId = $_POST['pays'] ?? null;

    if (empty($nom) || empty($statut) || !$paysId) {
        echo "<div class='alert alert-danger'>Tous les champs obligatoires doivent être remplis.</div>";
    } else {
        $pays = $entityManager->find(Pays::class, $paysId);
        if (!$pays) {
            echo "<div class='alert alert-danger'>Pays introuvable.</div>";
        } else {
            // Vérifier si une zone avec ce nom et ce pays existe déjà
            $existingZone = $entityManager->getRepository(Zone::class)
                ->findOneBy(['nom' => $nom, 'pays' => $pays]);

            if ($existingZone) {
                echo "<div class='alert alert-danger'>Cette zone existe déjà dans la base de données avec le même pays.</div>";
            } else {
                $zone = new Zone();
                $zone->setNom($nom);
                $zone->setStatut($statut);
                $zone->setNb_habitants($nbHabitants);
                $zone->setNb_symptomatiques($nbSymptomatiques);
                $zone->setNb_positifs($nbPositifs);
                $zone->setPays($pays);

                $entityManager->persist($zone);
                $entityManager->flush();

                // Rediriger vers la page de liste des zones
                header("Location: list_zone.php?success=ajouter");
                exit();
            }
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
					<!-- Recherche require_once et require -->
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
			<?php require_once('../../component/top_navig.php') ?>
			<!-- /top navigation -->

			<!-- page content -->
			<div class="right_col" role="main">
				<div class="">
					<div class="page-title">
						<div class="title_left">
							<h3>Formulaire du Zone</h3>
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="row">
						<div class="col-md-12 col-sm-12 ">
							<div class="x_panel">
								<div class="x_title">
									<h2>Ajouter une Zone</h2>
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
										<div class="mb-3">
											<label for="nom" class="form-label">Nom de la Zone<span class="required">*</span></label>
											<input type="text" id="nom" name="nom" required="required" class="form-control">
										</div>
										<div class="mb-3">
											<label for="statut" class="form-label">Statut<span class="required">*</span></label>
											<select id="statut" name="statut" class="form-control" required>
												<option value="">Choisir un statut</option>
												<option value="verte">Verte</option>
												<option value="orange">Orange</option>
												<option value="rouge">Rouge</option>
											</select>
										</div>
										<div class="mb-3">
											<label for="nb_habitants" class="form-label">Nombre d'Habitants</label>
											<input type="number" id="nb_habitants" name="nb_habitants" class="form-control">
										</div>
										<div class="mb-3">
											<label for="nb_symptomatiques" class="form-label">Nombre de Symptomatiques</label>
											<input type="number" id="nb_symptomatiques" name="nb_symptomatiques" class="form-control">
										</div>
										<div class="mb-3">
											<label for="nb_positifs" class="form-label">Nombre de Cas Positifs</label>
											<input type="number" id="nb_positifs" name="nb_positifs" class="form-control">
										</div>
										<div class="mb-3">
											<label for="pays" class="form-label">Pays<span class="required">*</span></label>
											<select id="pays" name="pays" class="form-control" required>
												<option value="">Choisir un pays</option>
												<?php
												// Ajout dynamique des pays depuis la base de données
												$paysList = $entityManager->getRepository(App\Pays::class)->findAll();
												foreach ($paysList as $pays) {
													echo "<option value='{$pays->getId()}'>{$pays->getNom()}</option>";
												}
												?>
											</select>
										</div>
										<div class="ln_solid"></div>
										<div class="text-center">
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
			<?php require_once('../../component/footer.php') ?>
			<!-- /footer content -->
		</div>
	</div>

	<?php require_once('../../component/script.php') ?>

</body>

</html>