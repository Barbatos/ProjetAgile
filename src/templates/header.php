 <!DOCTYPE html>
<html lang="fr">
	<head>
		<title>DBM Web Design - Bootstrap Responsive Design</title>
			<!-- On ouvre la fenêtre à la largeur de l'écran -->
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<!-- Intégration du CSS Bootstrap -->
			<link href="./css/bootstrap.css" rel="stylesheet" media="screen">
			<link href="./css/connexion.css" rel="stylesheet" media="screen">
	</head>
<body>

    <!-- Fixed navbar -->
    <div class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Covoiturage</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="index.php">Accueil</a></li>
            <li><a href="rechercheCovoiturage.php">Chercher covoiturage</a></li>
						<li><a href="#proposer">Proposer covoiturage</a></li>         
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="inscription.php">Inscription</a></li>
            <li><a href="connexion.php">Connexion</a></li>
          </ul>
        </div>
      </div>
    </div>

    <div class="container">
		
    <?php 
    if(isset($_SESSION['errors']) && !empty($_SESSION['errors'])){
      foreach($_SESSION['errors'] as $e){
        echo '<br /><br /><div class="alert alert-error">'.$e['error'].'</div>';
      }
      $_SESSION['errors'] = array();
    }

    if(isset($_SESSION['messages']) && !empty($_SESSION['messages'])){
      foreach($_SESSION['messages'] as $e){
        echo '<br /><br /><div class="alert alert-success">'.$e['message'].'</div>';
      }
      $_SESSION['messages'] = array();
    }
    ?>
