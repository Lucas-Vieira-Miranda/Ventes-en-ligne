/*****************************************************************/
function listeFiltreProduits(produit)	{
var req_AJAX = null;// Objet qui sera crée
if (window.XMLHttpRequest) 	{	// Mozilla, Safari
	req_AJAX= new XMLHttpRequest();
	} 
if (req_AJAX) 	{
	
	
	//méthode
	req_AJAX.onreadystatechange = function() {
		TraiteListeFiltreProduits(req_AJAX);
	}; 
	//action
	req_AJAX.open("POST", "listeProduits.php", true) ;
	req_AJAX.setRequestHeader("Content-Type", "application/x-www-form-urlencoded") ;
	req_AJAX.send("categorieproduit="+produit.value);


	} 
else 	{ 	
	alert("EnvoiRequete: pas de XMLHTTP !");	
	}
} // fin fonction listeUtilisateurs()

function TraiteListeFiltreProduits(requete)	{
	var ready = requete.readyState ;
	var tab = document.getElementById("vide") ;
	// test si la requête est terminée (état 4) et correcte (code HTTP 200)
	if (ready==4){ 
		var status = requete.status;
		if (status == 200) { // code = 200 réponse HTTP OK
			var data=requete.responseText;
			tab.innerHTML = data ;
			} 
		else {
			tab.innerHTML = "erreur serveur, code " + status;
		}
	}
}