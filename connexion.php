<?php	
	session_start(); // cette page utilisera les sessions. A mettre au début !!!!!!!!!!!!!!!!!!!!!
	include 'formulaires.php';
	include 'fonctions.php';
	?>

<!DOCTYPE html>
<html lang="fr" >
	<head>
		<meta charset="utf-8">
		<link href="css/style.css" rel="stylesheet" type="text/css"/>
		<script src="js/motdp.js" type="text/javascript"></script>
		<title>Page connexion</title>
	</head>
	<body class = "page-connexion">
		<div class="container">
			<header>
				<h1>Veuillez vous connecter</h1>
			</header>
			<nav>
				<?php
					// affichage du formulaire de connexion ou le menu avec le nom de la personne
					if( empty($_SESSION)  ){				
						FormulaireAuthentification();				
					}
					else {
						Menu();
					}				
					// test de la connexion
					if(!empty($_POST) && isset($_POST['login']) && isset($_POST['pass'])  ){		
						if (authentification($_POST['login'],$_POST['pass'])){
							$_SESSION["login"]= $_POST['login'] ;
							$_SESSION["statut"]=isAdmin($_POST['login']);
							redirect('index.php',0);// on recharge la page
						}
						else{
							echo 'Echec Authentification de '.$_POST['login'];
						}	
					}
					
					// Destruction de la session
					if (!empty($_GET) && isset($_GET['action']) && $_GET['action']=="logout" ){				
						$_SESSION=array();
						session_destroy();		
						redirect('index.php',0);// on recharge la page
					}
				?>
			</nav>
			<?php	

			// 1 : on ouvre le fichier
			$monfichier = fopen('acces.log', 'a+');

			// 2 : Ecriture dans le fichier...
			if (isset($login) && isset($_SERVER['REMOTE_ADDR']) && isset($statut)) {
				fputs($monfichier, $_POST['login']." de ".$_SERVER['REMOTE_ADDR']." à ".date('l jS \of F Y h:i:s A').$_SESSION["statut"]);

				fputs($monfichier, "\n");
			}

			// 3 : quand on a fini de l'utiliser, on ferme le fichier
			fclose($monfichier);
			?>
		</div>
	</body>
</html>


