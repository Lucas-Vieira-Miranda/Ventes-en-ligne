function checkproduit() {
    var nom = document.getElementById("designation") ;
    var prix = document.getElementById("prix") ;
    var reg = /(?=.*[0-9])/;
    var retour = false ;

    if (nom.value.length >= 30) {
        alert("Vous devez réduire le nom de votre article !")
    } 
    else {
        if (reg.test(prix.value)) {
            retour = true ;
        }
        else alert("Vous ne pouvez pas mettre de lettres dans le prix !") ;
    }
    return retour ;
}