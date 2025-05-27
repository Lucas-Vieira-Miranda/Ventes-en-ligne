<?php
    include "fonctions.php" ;

    if (!empty($_POST) && isset($_POST["categorieproduit"])){		
        $tab = listerProduitsParCategorie($_POST["categorieproduit"]) ;
        afficheTableau($tab) ;
    }
?>