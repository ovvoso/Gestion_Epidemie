<?php
require_once realpath(dirname(__DIR__, 3) . '/bootstrap.php');
require_once dirname(__DIR__) . '/../entities/Pays.php';
require_once dirname(__DIR__) . '/../entities/Zone.php';

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
            $zone = new Zone();
            $zone->setNom($nom);
            $zone->setStatut($statut);
            $zone->setNb_habitants($nbHabitants);
            $zone->setNb_symptomatiques($nbSymptomatiques);
            $zone->setNb_positifs($nbPositifs);
            $zone->setPays($pays);
            
            $entityManager->persist($zone);
            $entityManager->flush();

            echo "<div class='alert alert-success'>Zone ajoutée avec succès !</div>";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
  <head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<!-- Meta, title, CSS, favicons, etc. -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Gentelella Alela! | </title>

	<!-- Bootstrap -->
	<link href="../../../Admin1/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<!-- Font Awesome -->
	<link href="../../../Admin1/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
	<!-- NProgress -->
	<link href="../../../Admin1/vendors/nprogress/nprogress.css" rel="stylesheet">
	<!-- iCheck -->
	<link href="../../../Admin1/vendors/iCheck/skins/flat/green.css" rel="stylesheet">
	<!-- bootstrap-wysiwyg -->
	<link href="../../../Admin1/vendors/google-code-prettify/bin/prettify.min.css" rel="stylesheet">
	<!-- Select2 -->
	<link href="../../../Admin1/vendors/select2/dist/css/select2.min.css" rel="stylesheet">
	<!-- Switchery -->
	<link href="../../../Admin1/vendors/switchery/dist/switchery.min.css" rel="stylesheet">
	<!-- starrr -->
	<link href="../../../Admin1/vendors/starrr/dist/starrr.css" rel="stylesheet">
	<!-- bootstrap-daterangepicker -->
	<link href="../../../Admin1/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
	
	<!-- Custom Theme Style -->
	<link href="../../../Admin1/build/css/custom.min.css" rel="stylesheet">
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
					<div class="profile clearfix">
						<div class="profile_pic">
							<img src="../../../Admin1/production/images/img.jpg" alt="..." class="img-circle profile_img">
						</div>
						<div class="profile_info">
							<span>Bienvenue</span>
							<h2>Mouaze Sow</h2>
						</div>
					</div>
					<!-- /menu profile quick info -->

					<br />

					<!-- sidebar menu -->
					<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
						<div class="menu_section">
							<h3>General</h3>
							<ul class="nav side-menu">
							    <li><a href="../index.php"><i class="fa fa-home"></i>Accueil <span class="fa fa-chevron-down"></span></a>
								</li>
							</ul>
							<ul class="nav side-menu">
								<li><a><i class="fa fa-home"></i>Pays <span class="fa fa-chevron-down"></span></a>
								<ul class="nav child_menu">
									<li><a href="add_pays.php">Ajouter</a></li>
									<li><a href="list_pays.php">Lister</a></li>
								</ul>
								</li>
							</ul>
							<ul class="nav side-menu">
								<li><a><i class="fa fa-home"></i>Zone <span class="fa fa-chevron-down"></span></a>
								<ul class="nav child_menu">
									<li><a href="add_zone.php">Ajouter</a></li>
									<li><a href="list_zone.php">Lister</a></li>
								</ul>
								</li>
							</ul>
							<ul class="nav side-menu">
								<li><a><i class="fa fa-home"></i>Point de surveillance <span class="fa fa-chevron-down"></span></a>
								<ul class="nav child_menu">
									<li><a href="add_pointsurveillance.php">Ajouter</a></li>
									<li><a href="list_pointsurveillance.php">Lister</a></li>
								</ul>
								</li>
							</ul>
						</div>
					</div>
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
					<nav class="nav navbar-nav">
						<ul class=" navbar-right">
							<li class="nav-item dropdown open" style="padding-left: 15px;">
								<a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
									<img src="../../../Admin1/production/images/img.jpg" alt="">John Doe
								</a>
								<div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
									<a class="dropdown-item" href="javascript:;"> Profile</a>
									<a class="dropdown-item" href="javascript:;">
										<span class="badge bg-red pull-right">50%</span>
										<span>Settings</span>
									</a>
									<a class="dropdown-item" href="javascript:;">Help</a>
									<a class="dropdown-item" href="login.html"><i class="fa fa-sign-out pull-right"></i> Log Out</a>
								</div>
							</li>

							<li role="presentation" class="nav-item dropdown open">
								<a href="javascript:;" class="dropdown-toggle info-number" id="navbarDropdown1" data-toggle="dropdown" aria-expanded="false">
									<i class="fa fa-envelope-o"></i>
									<span class="badge bg-green">6</span>
								</a>
								<ul class="dropdown-menu list-unstyled msg_list" role="menu" aria-labelledby="navbarDropdown1">
									<li class="nav-item">
										<a class="dropdown-item">
											<span class="image"><img src="../../Admin1/production/images/img.jpg" alt="Profile Image" /></span>
											<span>
												<span>John Smith</span>
												<span class="time">3 mins ago</span>
											</span>
											<span class="message">
												Film festivals used to be do-or-die moments for movie makers. They were where...
											</span>
										</a>
									</li>
									<li class="nav-item">
										<a class="dropdown-item">
											<span class="image"><img src="../../Admin1/production/images/img.jpg" alt="Profile Image" /></span>
											<span>
												<span>John Smith</span>
												<span class="time">3 mins ago</span>
											</span>
											<span class="message">
												Film festivals used to be do-or-die moments for movie makers. They were where...
											</span>
										</a>
									</li>
									<li class="nav-item">
										<a class="dropdown-item">
											<span class="image"><img src="../../Admin1/production/images/img.jpg" alt="Profile Image" /></span>
											<span>
												<span>John Smith</span>
												<span class="time">3 mins ago</span>
											</span>
											<span class="message">
												Film festivals used to be do-or-die moments for movie makers. They were where...
											</span>
										</a>
									</li>
									<li class="nav-item">
										<a class="dropdown-item">
											<span class="image"><img src="../../Admin1/production/images/img.jpg" alt="Profile Image" /></span>
											<span>
												<span>John Smith</span>
												<span class="time">3 mins ago</span>
											</span>
											<span class="message">
												Film festivals used to be do-or-die moments for movie makers. They were where...
											</span>
										</a>
									</li>
									<li class="nav-item">
										<div class="text-center">
											<a class="dropdown-item">
												<strong>See All Alerts</strong>
												<i class="fa fa-angle-right"></i>
											</a>
										</div>
									</li>
								</ul>
							</li>
						</ul>
					</nav>
				</div>
			</div>
			<!-- /top navigation -->

			<!-- page content -->
			<div class="right_col" role="main">
				<div class="">
					<div class="page-title">
						<div class="title_left">
							<h3>Formulaire du Zone</h3>
						</div>

						<div class="title_right">
							<div class="col-md-5 col-sm-5  form-group pull-right top_search">
								<div class="input-group">
									<input type="text" class="form-control" placeholder="Search for...">
									<span class="input-group-btn">
										<button class="btn btn-default" type="button">Go!</button>
									</span>
								</div>
							</div>
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="row">
						<div class="col-md-12 col-sm-12 ">
							<div class="x_panel">
								<div class="x_title">
									<h2>Ajouter une zone</h2>
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
			<footer>
				<div class="pull-right">
					Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>
				</div>
				<div class="clearfix"></div>
			</footer>
			<!-- /footer content -->
		</div>
	</div>

	<!-- jQuery -->
	<script src="../../../Admin1/vendors/jquery/dist/jquery.min.js"></script>
	<!-- Bootstrap -->
	<script src="../../../Admin1/vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
	<!-- FastClick -->
	<script src="../../../Admin1/vendors/fastclick/lib/fastclick.js"></script>
	<!-- NProgress -->
	<script src="../../../Admin1/vendors/nprogress/nprogress.js"></script>
	<!-- bootstrap-progressbar -->
	<script src="../../../Admin1/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
	<!-- iCheck -->
	<script src="../../../Admin1/vendors/iCheck/icheck.min.js"></script>
	<!-- bootstrap-daterangepicker -->
	<script src="../../../Admin1/vendors/moment/min/moment.min.js"></script>
	<script src="../../../Admin1/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
	<!-- bootstrap-wysiwyg -->
	<script src="../../../Admin1/vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js"></script>
	<script src="../../../Admin1/vendors/jquery.hotkeys/jquery.hotkeys.js"></script>
	<script src="../../../Admin1/vendors/google-code-prettify/src/prettify.js"></script>
	<!-- jQuery Tags Input -->
	<script src="../../../Admin1/vendors/jquery.tagsinput/src/jquery.tagsinput.js"></script>
	<!-- Switchery -->
	<script src="../../../Admin1/vendors/switchery/dist/switchery.min.js"></script>
	<!-- Select2 -->
	<script src="../../../Admin1/vendors/select2/dist/js/select2.full.min.js"></script>
	<!-- Parsley -->
	<script src="../../../Admin1/vendors/parsleyjs/dist/parsley.min.js"></script>
	<!-- Autosize -->
	<script src="../../../Admin1/vendors/autosize/dist/autosize.min.js"></script>
	<!-- jQuery autocomplete -->
	<script src="../../../Admin1/vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js"></script>
	<!-- starrr -->
	<script src="../../../Admin1/vendors/starrr/dist/starrr.js"></script>
	<!-- Custom Theme Scripts -->
	<script src="../../../Admin1/build/js/custom.min.js"></script>

</body></html>
