<?php
	session_start();
	include 'fonctions.php';
	include 'formulaires.php';
	
	if (!(!empty($_SESSION) && isset($_SESSION["statut"]) &&  $_SESSION["statut"]==true)){
		redirect("index.php",0);
		exit();
	}
	?>
<!DOCTYPE html>
<html lang="fr" >
	<head>
		<meta charset="utf-8">
		<link href="css/style.css" rel="stylesheet" type="text/css" />
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
		<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
		<title>Page Suppression</title>
	</head>
	<body class = "page-suppression">
		<header>
			<h1>Amazon - Lannion</h1>
		</header>
		<nav>
			<?php
				if (!empty($_SESSION)) {
					Menu();
				}

			?>
		</nav>
		<article>
			<h1>Supprimer un produit</h1>
			<?php
                FormulaireSuppressionBDD();
                    // Traitement du formulaire
					if (isset($_POST['captcha']) && ($_POST['captcha'] == $_SESSION['code'])) {
						if(!empty($_POST) && isset($_POST['produit_supp']) && ($_POST['produit_supp']) != 0) {
							$res=supprimerProduit($_POST['produit_supp']);
							if ($res) {
								echo "<h1>Code Correct, votre produit a été supprimé</h1>" ;
								$produits = listerProduits() ;
								afficheTableau($produits) ;
								echo '<br/>' ;
							}
							else echo "<script>alert('Erreur dans la suppression du produit');</script>";
						}
						else echo "<script>alert('Veuillez choisir un produit');</script>" ;
					}
					elseif (!empty($_POST['captcha']) && ($_POST['captcha'] != $_SESSION['code'])) {
						echo "<script>alert('Il y a une erreur dans le capcha !!');</script>" ;
					}
			?>	
		</article>
		<footer>
			<a href="javascript:history.back()">Retour à la page précédente</a>
		</footer>
	</body>
</html>	

