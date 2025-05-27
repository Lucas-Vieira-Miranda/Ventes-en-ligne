<?php
	session_start();
	include 'fonctions.php';
	include 'formulaires.php';
	
	if (!(!empty($_SESSION) && isset($_SESSION["statut"]) &&  $_SESSION["statut"]==true)){
		redirect("index.php",0);
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
		<title>Page de modification</title>
	</head>
	<body class = "page-modification">
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
        <?php 
		if(empty($_POST))  FormulaireChoixProduit("Modifier")  ;
		// Traitement du 1er formulaire FormulaireChoixEtudiant
		if(!empty($_POST) && isset($_POST['produit'] )) {
			FormulaireModificationProduit($_POST['produit']) ;
			// Traitement du 2nd formulaire FormulaireModificationEtudiant
			if (isset($_POST['captcha']) && ($_POST['captcha'] == $_SESSION['code'])) {
				if( !empty($_POST) && isset($_POST['produit']) && isset($_POST['prix']) && isset($_POST['forfait'])) {		
						$res=modifierProduit($_POST['produit'], $_POST['prix'], $_POST['forfait']);
						// var_dump($_POST['mail']) ;
						if ($res == 0)
							echo "<h1>Echec lors de la modification du produit ".$_POST['produit']." </h1>" ;
						else echo "<h1>Modification réussie pour le produit ".$_POST['produit']." </h1>" ;
						echo '<br/>' ;
						redirect("index.php",0) ;
					}
				else echo "<script>alert('Veuillez choisir un produit');</script>" ;
			}
			elseif (!empty($_POST['captcha']) && ($_POST['captcha'] != $_SESSION['code'])) {
					echo "<script>alert('Il y a une erreur dans le capcha !!');</script>" ;
					redirect("modification.php",0) ;
			}
		}
		?>
		

		</article>
		<footer>
			<a href="javascript:history.back()">Retour à la page précédente</a>
		</footer>
	</body>
</html>	

