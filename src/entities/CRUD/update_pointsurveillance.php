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
              <h3>Liste des Pays</h3>
            </div>
          </div>
          <div class="clearfix"></div>
          <div class="row">
            <div class="col-md-12 col-sm-12 ">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Liste</h2>
                  <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                  </ul>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <?php
                  if (isset($_GET['success'])) {
                    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
                    echo 'La zone a été supprimée avec succès.';
                    echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                    echo '</div>';
                  }
                  if (isset($_GET['error'])) {
                    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                    switch ($_GET['error']) {
                      case 'notfound':
                        echo 'La zone demandée n\'existe pas.';
                        break;
                      case 'delete':
                        echo 'Une erreur est survenue lors de la suppression de la zone.';
                        break;
                      case 'noid':
                        echo 'Aucun identifiant de zone n\'a été fourni.';
                        break;
                    }
                    echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                    echo '</div>';
                  }
                  ?>
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="card-box table-responsive">
                        <table id="datatable-buttons" class="table table-striped table-bordered" style="width:100%">
                          <thead>
                            <tr>
                              <th><strong>Nom de la Zone</strong></th>
                              <th><strong>Statut</strong></th>
                              <th><strong>Nombre d'Habitants</strong></th>
                              <th><strong>Nombre de Symptomatiques</strong></th>
                              <th><strong>Nombre de Cas Positifs</strong></th>
                              <th><strong>Pays</strong></th>
                              <th><strong>Action</strong></th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php foreach ($zonesList as $zone): ?>
                              <tr>
                                <td><?= htmlspecialchars($zone->getNom()); ?></td>
                                <td><?= htmlspecialchars($zone->getStatut()); ?></td>
                                <td><?= htmlspecialchars($zone->getNb_habitants()); ?></td>
                                <td><?= htmlspecialchars($zone->getNb_symptomatiques()); ?></td>
                                <td><?= htmlspecialchars($zone->getNb_positifs()); ?></td>
                                <td><?= htmlspecialchars($zone->getPays()->getNom()); ?></td>
                                <td>
                                  <a href="update_zone.php?id=<?= $zone->getId(); ?>"
                                    class="btn btn-warning btn-sm">Modifier</a>
                                  <a href="delete_zone.php?id=<?= $zone->getId(); ?>" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette zone ?');">Supprimer</a>
                                </td>
                              </tr>
                            <?php endforeach; ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
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