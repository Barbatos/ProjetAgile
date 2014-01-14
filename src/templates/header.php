 <!DOCTYPE html>
<html lang="fr">
	<head>
		<title>Covoituragile</title>
			<!-- On ouvre la fenêtre à la largeur de l'écran -->
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<!-- Intégration du CSS Bootstrap -->
			<link href="./css/bootstrap.css" rel="stylesheet" media="screen" />
			<link href="./css/connexion.css" rel="stylesheet" media="screen" />
			<link href="./css/inscription.css" rel="stylesheet" media="screen" />
      <link href="./css/design.css" rel="stylesheet" media="screen" />
      <link href="./css/heure_js.css" rel="stylesheet" media="screen" />

      <script type="text/javascript" src="./js/calendrier.js"></script>
      <script type="text/javascript" src="./js/pickHour.js"></script> 
	</head>
<body>

    <!-- Fixed navbar -->
    <div class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <a class="navbar-brand" href="index.php">Covoituragile</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li <?php if($pageActive == "Accueil") echo 'class="active"' ?>><a href="index.php">Accueil</a></li>
            <li <?php if($pageActive == "Chercher") echo 'class="active"' ?>><a href="rechercheCovoiturage.php">Chercher covoiturage</a></li>
	          <li <?php if($pageActive == "Proposer") echo 'class="active"' ?>><a href="proposerTrajet.php">Proposer covoiturage</a></li>  
            <li <?php if($pageActive == "PrevenirRetard") echo 'class="active="' ?>><a href="prevenirretard.php">Prévenir d'un retard</a></li>       
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <?php if(est_connecte()){ ?>
            <li <?php if($pageActive == "Compte") echo 'class="active"' ?>><a href="compte.php">Mon compte</a></li>
            <li><a href="deconnexion.php">Déconnexion</a></li>
            <li><a>Bonjour <?php echo $_SESSION['prenom'] ?> !</a></li>
            <?php } else { ?>
            <li <?php if($pageActive == "Inscription") echo 'class="active"' ?>><a href="inscription.php">Inscription</a></li>
            <li <?php if($pageActive == "Connexion") echo 'class="active"' ?>><a href="connexion.php">Connexion</a></li>
            <?php } ?>
          </ul>
        </div>
      </div>
    </div>

    <div class="container">
		
    <?php 
    if(isset($_SESSION['errors']) && !empty($_SESSION['errors'])){
      foreach($_SESSION['errors'] as $e){
        echo '<br /><br /><br /><div class="alert alert-error">'.$e['error'].'</div>';
      }
      $_SESSION['errors'] = array();
    }

    if(isset($_SESSION['messages']) && !empty($_SESSION['messages'])){
      foreach($_SESSION['messages'] as $e){
        echo '<br /><br /><br /><div class="alert alert-success">'.$e['message'].'</div>';
      }
      $_SESSION['messages'] = array();
    }
    ?>
