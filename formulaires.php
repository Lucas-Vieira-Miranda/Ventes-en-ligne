<?php
	//******************************************************************************
	function FormulaireAuthentification(){//fourni
	?>
	<form id="form1" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" onsubmit="return checkPassword()">
		<fieldset>
			<legend>Formulaire d'authentification</legend>	
			<label for="id_mail">Adresse Mail : </label><input type="email" name="login" id="id_mail" placeholder="@mail" required size="20" /><br />
			<label for="id_pass">Mot de passe : </label><input type="password" name="pass" id="id_pass" required size="10" /><br />
			<input type="submit" name="connect" value="Connexion" />
		</fieldset>
	</form>
	<?php
	}
	
	//******************************************************************************
	function Menu() {
		?>
		<nav class="navbar navbar-expand-lg navbar-light bg-light">
			<a class="navbar-brand" href="index.php"><img src="images/Amazon_logo.svg" alt="image_am" style="max-width: 100px; max-height: 100px;"></a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarNav">
				<ul class="navbar-nav ml-auto">
					<li class="nav-item">
						<a class="nav-link" href="index.php?action=accueil" title="accueil">Accueil</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="index.php?action=liste_produits" title="Lister les produits par catégorie">Lister les produits par catégorie</a>
					</li>
					<?php
					if ($_SESSION["statut"] == true) { // Si il est admin
					?>
						<li class="nav-item">
							<a class="nav-link" href="insertion.php?action=inserer_produit" title="Insérer un produit">Insérer un produit</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="suppression.php?action=supprimer_produit" title="Supprimer un produit">Supprimer un produit</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="modification.php?action=modifier_produit" title="Modifier un produit">Modifier un produit</a>
						</li>
					<?php
					}
					?>
					<li class="nav-item">
						<p><a href="index.php?action=logout" id="deco" title="Déconnexion" style ="color : red;">Se déconnecter</a></p>
					</li>
				</ul>
				
			</div>
		</nav>
		<?php
	}
	//******************************************************************************
	function FormulaireProduitParCategorie(){
		echo "<br/>";
		// CNX BDD + REQUETE pour obtenir les villes correspondantes à des etudiants
		$madb = new PDO('sqlite:bdd/produits.sqlite');
		$requete = "SELECT DISTINCT c.idCat, intitule FROM produit as p INNER JOIN categorieproduit as c ON p.idCat = c.idCat ;" ;
		// var_dump($requete) ;
		$resultat = $madb->query($requete) ;
		$categories = $resultat->fetchAll(PDO::FETCH_ASSOC) ;
	?>
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
		<fieldset> 
			<label for="id_Cat">Catégories :</label> 
			<select id="id_Cat" name="categorieproduit" size="1" onchange="listeFiltreProduits(this)">
			<option value="0">Rechercher une catégorie</option>
				<?php
					foreach($categories as $categorieproduit){
						echo '<option value="'.$categorieproduit['idCat'].'">'.$categorieproduit['intitule'].'</option>';
					}
				?>
			</select>
		</fieldset>
	</form>
	<?php
		echo "<br/>";
	}
	//******************************************************************************
	function FormulaireAjoutProduit(){
		// connexion BDD et récupération des villes
		$madb = new PDO('sqlite:bdd/produits.sqlite'); // CNX BDD			
		$requete1 = 'SELECT DISTINCT c.idCat, intitule FROM produit as p INNER JOIN categorieproduit as c ON p.idCat = c.idCat ;';
		$resultat1 = $madb->query($requete1);
		$categories = $resultat1->fetchAll(PDO::FETCH_ASSOC);

		$requete2 = 'SELECT DISTINCT forfaitlivraison.idForfait, forfaitlivraison.description FROM forfaitlivraison ;';
		$resultat2 = $madb->query($requete2);
		$forfaits = $resultat2->fetchAll(PDO::FETCH_ASSOC);

	?>
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" onsubmit = "return checkproduit()" enctype="multipart/form-data">
	<!--<form action="upload.php" method='post' enctype="multipart/form-data">-->
		<fieldset>
			</br>
			<!-- Pour idCat -->
			<label for="id_Cat">Catégorie : </label>
			<select id="id_Cat" name="categorieproduit" size="1">
			<option value="0">Rechercher une catégorie</option>
				<?php
					foreach($categories as $categorieproduit){
						echo '<option value="'.$categorieproduit['idCat'].'">'.$categorieproduit['intitule'].'</option>';
					}
				?>
			</select>
			<br></br>
			<!-- Pour designation -->
			<label for="designation">Nom complet du produit : </label>
			<input type="text" name="designation" id="designation" placeholder="Nom" required size="20" /><br />
			</br>
			<!-- Pour forfait livraison -->
			<label for="id_forfait">forfait de livraison :</label> 
			<select id="id_forfait" name="forfait" size="1">
			<option value="0">Forfait de livraison adéquat</option>
				<?php
					foreach($forfaits as $forfaitlivraison ){
						echo '<option value="'.$forfaitlivraison['idForfait'].'">'.$forfaitlivraison['description'].' '.$forfaitlivraison['montant'].'</option>';
					}
				?>
			</select>
			<br></br>
			<!-- Pour image -->
			<label for="image">Choisissez une image à télécharger : </label>
			<input type="file" name="images" id="image">
			</br>	
			</br>
			<!-- Pour prix -->
				<label for="prix">Prix TTC du produit : </label>
				<input type="text" name="prix" id="prix" placeholder="Prix TTC" required size="20"/><br />
				</br>
				<input type="submit" value="Ajouter le nouveau produit"/>
		</fieldset>
	</form>
	<?php
		echo "<br/>";
	}
	//***********************************************************************************************
	function FormulaireSuppressionBDD(){
		$madb = new PDO('sqlite:bdd/produits.sqlite'); // CNX BDD		
		$requete = "SELECT * FROM produit;" ;
		$resultat = $madb->query($requete);
		$BDD = $resultat->fetchAll(PDO::FETCH_ASSOC);
	?>
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
		<fieldset> 
			<select id="produit_supp" name="produit_supp" size="1">
			<option value="0">Choisissez le produit à supprimer</option>
				<?php
						foreach($BDD as $bases ){
							echo '<option value="'.$bases['idPdt'].'">'.$bases['designation'].'</option>';
						}
				?>
			</select>
			</br></br>
			<img src="image.php" onclick="this.src='image.php?' + Math.random();" alt="captcha" style="cursor:pointer;">
			<input type="text" name="captcha"/>
			</br></br>
			<input type="submit" value="Supprimer"/>
		</fieldset>
	</form>
	<?php
		echo "<br/>";
	}// fin affiche$_SESSION["admin"]==true
	//****************************************************************************************************************
	function FormulaireChoixProduit($choix){
        $madb = new PDO('sqlite:bdd/produits.sqlite'); // CNX BDD           
        $requete = 'SELECT * FROM produit ;';
        $resultat = $madb->query($requete);
        $produits = $resultat->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <fieldset> 
            <select id="id_produit" name="produit" size="1">
                <?php
                    foreach($produits as $produit ){// $ville est une variable locale = tableau associatif
                        echo '<option value="'.$produit['idPdt'].'">'.$produit['designation'].'</option>';
                        
                    }

                ?>
            </select>
            <input type="submit" value=" <?php echo $choix;?> "/>
        </fieldset>
    </form>
    <?php
        echo "<br/>";
    }
	//****************************************************************************************************************
	function FormulaireModificationProduit($objet){ 
        $madb = new PDO('sqlite:bdd/produits.sqlite'); // CNX BDD   
        $requete = 'SELECT designation FROM produit WHERE "'.$objet.'" = produit.idPdt;';
        $resultat = $madb->query($requete);
        $produit2 = $resultat->fetch(PDO::FETCH_ASSOC);     
        
        $requete2 = 'SELECT prixTTC FROM produit WHERE "'.$objet.'" = produit.idPdt;';
        $resultat2 = $madb->query($requete2);
        $prix = $resultat2->fetch(PDO::FETCH_ASSOC);
    

        $requete3 = 'SELECT * FROM forfaitlivraison';
        $resultat3 = $madb->query($requete3);
        $forfaits = $resultat3->fetchall(PDO::FETCH_ASSOC);
        

    ?>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
         
        <fieldset> 
            <label for="id_produit">Nom produit : </label><input type="text" name="produit" id="id_produit" value="<?php echo $produit2["designation"] ?>" readonly required size="20" /><br />

            <label for="id_prix">Prix : </label><input name="prix" id="id_prix" value="<?php echo $prix['prixTTC'] ?>"  required size="20" /><br />
            
            <label for="id_forfait">Forfait de Livraison :</label> 
            <select id="id_forfait" name="forfait" size="1">
                
                <?php // on se sert de value directement pour l'insertion
                    foreach($forfaits as $forfait ){// $ville est une variable locale = tableau associatif
                        echo '<option value="'.$forfait['idForfait'].'">'.$forfait['description'];
                    }
                ?>
            </select>   
            <br/><br/>
			<img src="image.php" onclick="this.src='image.php?' + Math.random();" alt="captcha" style="cursor:pointer;">
			<input type="text" name="captcha"/>
			</br></br>
            <input type="submit" value="Valider"/>
        </fieldset>
    </form>
    <?php
        echo "<br/>";
    }// fin 
?>