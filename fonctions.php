<?php
	//****************Fonctions utilisées*****************************************************************
	function authentification($mail,$pass){
		$retour = false ;
		$madb = new PDO('sqlite:bdd/comptes.sqlite'); 
		$mail= $madb->quote($mail);
		$pass = $madb->quote($pass);
		$requete = "SELECT EMAIL, PASS FROM utilisateurs WHERE EMAIL = ".$mail." AND PASS = ".$pass ;
		//var_dump($requete);echo "<br/>";  	
		$resultat = $madb->query($requete);
		$tableau_assoc = $resultat->fetchAll(PDO::FETCH_ASSOC);
		if (sizeof($tableau_assoc)!=0) $retour = true;	
		return $retour;
	}
	
	//***************************************************************************************************
	
	function isAdmin($mail){
		$retour = false ;
		//se connecter à la bdd
		$madb = new PDO('sqlite:bdd/comptes.sqlite'); 
		$mail= $madb->quote($mail);
		$requete = "SELECT STATUT FROM utilisateurs WHERE EMAIL = $mail;" ;
		// var_dump($requete) ;
		$resultat = $madb->query($requete) ;
		$statut = $resultat->fetch(PDO::FETCH_ASSOC) ;		// fetch -> quand on a un seul résultat attendu
		if ($statut["STATUT"] == "admin")	  // décision !
			$retour = true ;

		return $retour;	
		
	}
	//***************************************************************************************************
	function listerProduits()	{
		$retour = false ;	
		$madb = new PDO('sqlite:bdd/produits.sqlite'); 
		$requete = "SELECT images, designation, prixTTC, forfaitlivraison FROM produit ;" ;
		$resultat = $madb->query($requete) ;
		$retour = $resultat->fetchAll(PDO::FETCH_ASSOC) ;

		return $retour;
	}		
	
	//***************************************************************************************************
	function listerProduitsParCategorie($categorie){
		$retour = false ;
		$madb = new PDO('sqlite:bdd/produits.sqlite');
		$categoriep = $madb->quote($categorie);
		//var_dump($categorie) ;
		$requete = "SELECT images, designation, prixTTC, forfaitlivraison FROM produit as p INNER JOIN categorieproduit as c ON p.idCat = c.idCat WHERE c.idCat = $categoriep;" ;
		$resultat = $madb->query($requete);
		$retour = $resultat->fetchAll(PDO::FETCH_ASSOC);
		return $retour;
	}
	//*****************************************************************************************************
	function ajouterProduit($categorie,$designation,$forfait,$image,$prix){
		$retour=0;
		try {
			$madb = new PDO('sqlite:bdd/produits.sqlite'); 
			$categorie=$madb->quote($categorie);
			$designation=$madb->quote($designation);
			$forfait=$madb->quote($forfait);
			$prix=$madb->quote($prix);
			$image=$madb->quote($image);
			$requete = "INSERT INTO produit (idCat, designation, forfaitlivraison, images, prixTTC) VALUES ($categorie,$designation,$forfait,$image, $prix);" ;
			$retour = $madb->exec($requete) ;

		}
		catch (Exception $e) {		
			echo "Erreur " . $e->getMessage();
		}
		return $retour;

	}
	//*****************************************************************************************************
	function supprimerProduit($produit){
		$retour=0;
		try {
			$madb = new PDO('sqlite:bdd/produits.sqlite');
			$requete = "SELECT images FROM produit WHERE idPdt = $produit ;";
			$resultat = $madb->query($requete);
			$image = $resultat->fetch(PDO::FETCH_ASSOC);
			
			if ($image) {
				//var_dump($image['images']);
				$requete2 = "DELETE FROM produit WHERE idPdt = $produit ;";
				$retour = $madb->exec($requete2);
				
				// Supprimer l'image associée (code trouver grâce à mes recherches personnelles)
				$imagePath = 'images/' . $image['images'];
				//var_dump($imagePath);
				$extension = pathinfo($imagePath, PATHINFO_EXTENSION);
				switch ($extension) {
					case 'jpg':
					case 'jpeg':
					case 'png':
					case 'gif':
					case 'svg':
						if (file_exists($imagePath)) {
							unlink($imagePath);
						}
						break;
				}
			} else {
				echo "Image non trouvée pour le produit avec ID : $produit";
			}
		} catch (Exception $e) {
			echo "Erreur " . $e->getMessage();
		}
		return $retour;
	}
	//******************************************************************************************************
	function modifierProduit($produit,$prix,$forfait){
        $retour=0;
        try{
            $madb = new PDO('sqlite:bdd/produits.sqlite'); 
            $madb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION) ;
            $produit=$madb->quote($produit);
            $prix=$madb->quote($prix);
            $forfait=$madb->quote($forfait);
            
            $requete = "UPDATE produit SET prixTTC = $prix WHERE  designation = $produit ; " ;
            
            $requete2 = "UPDATE produit SET forfaitlivraison = $forfait  WHERE  designation = $produit ; " ;
            
            //var_dump($requete) ;
            $retour = $madb->exec($requete) ;
            $retour2 = $madb->exec($requete2) ;
        }
        catch (Exception $e) {      
            echo "Erreur " . $e->getMessage();      
        }
        return $retour+$retour2;
    }
	//*********************************************************************************************************
	//Nom : redirect()
	//Role : Permet une redirection en javascript
	//Parametre : URL de redirection et Délais avant la redirection
	//Retour : Aucun
	//*******************
	function redirect($url,$tps)
	{
		$temps = $tps * 1000;
		
		echo "<script type=\"text/javascript\">\n"
		. "<!--\n"
		. "\n"
		. "function redirect() {\n"
		. "window.location='" . $url . "'\n"
		. "}\n"
		. "setTimeout('redirect()','" . $temps ."');\n"
		. "\n"
		. "// -->\n"
		. "</script>\n";
		
	}
	//********************************************************************************************************
	function afficheTableau($tab) {
		echo '<table>';
		echo '<tr>'; // Les entêtes des colonnes qu'on lit dans le premier tableau par exemple
		foreach ($tab[0] as $colonne => $valeur) {
			echo "<th>$colonne</th>";
		}
		echo "</tr>\n";
		// Le corps de la table
		foreach ($tab as $ligne) {
			echo '<tr>';
			foreach ($ligne as $colonne => $case) {
				if ($colonne == 'images') {
					echo '<td><img src="./images/'.$case.'" alt="'.$case.'" style="max-width: 150px; max-height: 150px;"></td>';
				} else {
					echo "<td>$case</td>";
				}
			}
			echo "</tr>\n";
		}
		echo '</table>';
	}
	
?>
