<?php 
session_start() ;		//cette page utilisera des sessions donc obligatoire
include 'formulaires.php';
include 'fonctions.php';
?>
<!DOCTYPE html>
<html lang="fr" >
	<head>
		<meta charset="utf-8">
		<link href="css/style.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="js/Ajax_produits.js"></script>
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
		<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
		<title>Page d'accueil</title>
	</head>
	<body class = "page-index">
		<header>
			<h1>Amazon - Lannion</h1>
		</header>
		<nav>
			<?php
				if (empty($_SESSION)) {
					redirect('connexion.php', 1) ;
				}
				else {
					Menu() ;
				}
				// test de la connexion
				if (!empty ($_POST) && isset ($_POST["login"]) && isset ($_POST["pass"])) {
					// on pourrait vérifier que les cases ne sont pas vides
					if (authentification($_POST["login"], $_POST["pass"])) {
						$_SESSION["login"] = $_POST["login"];
						$_SESSION["statut"] = isAdmin($_POST["login"]) ; 

						redirect('index.php', 1) ;		// on recharge la page
					}
					else {
						echo "l'utilisateur '".$_POST['login']."' n'existe pas" ;
					}
				}				
				// Destruction de la session
				if (!empty($_GET) && isset($_GET["action"]) && $_GET["action"] == "logout") {
					$_SESSION = array() ;
					session_destroy() ;
					redirect('index.php', 1); 
				}
			?>
		</nav>
		<article>
			<?php
				// Affichage du message accueil en fonction de la connexion
				if (!empty($_SESSION)) {
					echo '<h1>Vous êtes connecté comme '.$_SESSION["login"].'</h1>' ; 
				}
				else echo '<h1>Vous êtes déconnectés</h1>' ; 

				

				// traitement de la zone centrale de la page en fonction des liens GET du menu s'il y a une session
				if (!empty($_SESSION) && !empty($_GET) && isset($_GET["action"]) ){
					switch($_GET["action"]) {
						case "accueil":	echo '<h1>Accueil</h1>';
						redirect('index.php', 0) ;
						break;

						case "liste_produits":	echo '<h1>Lister les produits par catégorie</h1>';
						FormulaireProduitParCategorie() ;
						break;

						case "inserer_produit":	echo '<h1>Bienvenue '.$_SESSION["login"].' sur la page d Insertion</h1>';
						FormulaireAjoutProduit() ;
						break;

						case "supprimer_produit":	echo '<h1>Bienvenue '.$_SESSION["login"].' sur la page de Suppression</h1>';
						FormulaireChoixSuppressionBDD() ;
						break;

						case "modifier_produit":	echo '<h1>Bienvenue '.$_SESSION["login"].' sur la page de Modification</h1>';
						FormulaireModificationEtudiant() ;
						break;
						}
					}
				 
				// affichage du tableau selon la catégorie
				if(!empty($_SESSION) && !empty($_POST) && isset($_POST['categorieproduit'])) {
					FormulaireProduitParCategorie();
					$produits=listerProduitsParCategorie($_POST['categorieproduit']);
					afficheTableau($produits);		
				}

				elseif (!empty($_SESSION) && empty($_GET)){
					$produits = listerProduits() ;
					afficheTableau($produits) ;
				}
				?>
				<div id="vide"></div>
				<?php
			?>
		</article>
		<footer>
			<a href="javascript:history.back()">Retour à la page précédente</a>
		</footer>
	</body>
</html>


