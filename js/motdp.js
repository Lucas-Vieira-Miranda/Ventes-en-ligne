function checkPassword(){
	var retour=false;
	// On récupère les MDP
	var pass = document.getElementById("id_pass");
	var reg = /(?=.*[A-Z])(?=.*[#\$\&\%\@])/;
	resultat = reg.test(pass.value);
	//le mot de passe doit être saisi 2 fois, sinon on affiche une pop-up d'alerte 
	if(resultat==true){
        alert("toutes les conditions sont repectées");
        retour=true
    }
    else {
    
        alert("le mdp doit être complexe");
       // msgErreur.innerHTML="respecter les consignes de dureté";		
    }
	return retour;
}