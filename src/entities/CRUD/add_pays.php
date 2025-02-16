<?php
require_once realpath(dirname(__DIR__, 3) . '/bootstrap.php');

use App\Pays;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom = trim($_POST['nom']);

    if (empty($nom)) {
        echo "<div class='alert alert-danger'>Le nom du pays est requis.</div>";
    } else {
        // Vérifier si un pays avec ce nom existe déjà
        $existingPays = $entityManager->getRepository(Pays::class)
            ->findOneBy(['nom' => $nom]);

        if ($existingPays) {
            echo "<div class='alert alert-danger'>Ce pays existe déjà dans la base de données.</div>";
        } else {
            $pays = new Pays();
            $pays->setNom($nom);

            $entityManager->persist($pays);
            $entityManager->flush();

			// Rediriger vers la page de liste des pays
			header("Location: list_pays.php?success=ajouter");
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
		<?php require_once('../../component/head.php')?>
</head>

<body class="nav-md">
	<div class="container body">
		<div class="main_container">
			<div class="col-md-3 left_col">
				<div class="left_col scroll-view">
					<div class="navbar nav_title" style="border: 0;">
						<a href="index.html" class="site_title"><i class="fa fa-paw"></i> <span>Gestion épidemie</span></a>
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
							<h3>Formulaire du Pays</h3>
						</div>

						
					</div>
					<div class="clearfix"></div>
					<div class="container mt-5">
						<div class="row justify-content-center">
							<div class="col-md-8">
								<div class="card shadow-lg p-4">
								<h2 class="text-center text-primary">Ajouter un Pays</h2>
								<form method="POST" id="demo-form2" class="form-horizontal form-label-left">
										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="nom"><strong>Nom du Pays</strong><span class="required">*</span></label>
											<div class="col-md-6 col-sm-6">
												<input type="text" id="nom" name="nom" required="required" class="form-control">
											</div>
										</div>
										<div class="ln_solid"></div>
										<div class="item form-group">
											<div class="col-md-6 col-sm-6 offset-md-3 text-center">
												<button type="submit" class="btn btn-primary">Ajouter</button>
												<button type="reset" class="btn btn-danger">Effacer</button>
											</div>
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
