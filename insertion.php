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
		<script type="text/javascript" src="js/insert.js"></script>
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
		<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
		<title>Page insertion</title>
	</head>
	<body class = "page-insertion">
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
			<h1>Ajouter un produit</h1>
			<?php

				FormulaireAjoutProduit();

				// Code trouvé grace à mes recherches sur internet car c'est un sujet non traité en TD/TP
				$retour = true;
				if ($_SERVER['REQUEST_METHOD'] === 'POST') {
					// Vérifier si un fichier a été téléchargé sans erreur
					if (isset($_FILES['images']) && $_FILES['images']['error'] === UPLOAD_ERR_OK) {
						$fileTmpPath = $_FILES['images']['tmp_name'];
						$fileName = $_FILES['images']['name'];
						$fileSize = $_FILES['images']['size'];
						$fileType = $_FILES['images']['type'];
						$fileNameCmps = explode(".", $fileName);
						$fileExtension = strtolower(end($fileNameCmps));

						// Définir les extensions autorisées
						$allowedfileExtensions = array('jpg', 'gif', 'png', 'txt', 'pdf');

						if (in_array($fileExtension, $allowedfileExtensions)) {
							// Chemin où le fichier sera enregistré
							$uploadFileDir = './images/';
							$dest_path = $uploadFileDir . $fileName;

							if (file_exists($dest_path)) {
								$message = "<script>alert('Le fichier existe déjà')</script>";
								$retour = false ;
							} else {
								// Créer le dossier s'il n'existe pas
								if (!is_dir($uploadFileDir)) {
									mkdir($uploadFileDir, 0777, true);
								}
				
								// Déplacer le fichier depuis l'emplacement temporaire vers le dossier de destination
								if (move_uploaded_file($fileTmpPath, $dest_path)) {
									$message = '<h1>Produit ajouté avec succès.</h1>';
								} else {
									$message = "<script>alert('Il y a eu une erreur lors du téléchargement du fichier. Veuillez réessayer.</script>";
									$retour = false ;
								}
							}
						} else {
							$message = "<script>alert('Upload échoué. Seuls les fichiers ' . implode(',', $allowedfileExtensions) . ' sont autorisés.</script>";
							$retour = false ;
						}
					} else {
						$message = "<script>alert('Il y a eu une erreur lors du téléchargement du fichier.</script>";
						$retour = false ;
					}
					// Afficher le message
					echo  $message . '<br>';
					// Vérifier si les données du formulaire sont présentes et valides
					if(!empty($_POST) && isset($_POST['categorieproduit']) && isset($_POST['designation']) && isset($_POST['forfait']) && isset($_POST['prix']) && isset($fileName) && $retour==true) {	
						$result=ajouterProduit($_POST['categorieproduit'], $_POST['designation'], $_POST['forfait'], $fileName, $_POST['prix']);
						$produits = listerProduits() ;
						afficheTableau($produits) ;
						?> 
						</br> 
						<?php
					}
					else echo '<br/>';
				}
			?>	
		</article>
		<footer>
			<a href="javascript:history.back()">Retour à la page précédente</a>
		</footer>
	</body>
</html>	

