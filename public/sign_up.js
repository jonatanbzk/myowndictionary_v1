var form = document.querySelector("form");
form.addEventListener("submit", function (e) {

var mdp1 = document.querySelector("form").elements.password.value;
var mdp2 = document.querySelector("form").elements.repeatpassword.value;
var erreur = document.getElementById("validiteCourriel");
var user = document.getElementById("username");
var mail = document.getElementById("email").value;
var regexCourriel = /.+@.+\..+/;
var match = regexCourriel.test(mail);

   if ( mdp1 !== mdp2)
   {
     erreur.textContent = "ERREUR : Les deux mots de passe ne sont pas identiques !";
     e.preventDefault();
   }

  else if ( mdp1.length < 8 ) {
    erreur.textContent = "Le mot de passe est trop court (minimum 8 charactères) !";
    e.preventDefault();
  }

  else if (match === false) {

    document.getElementById("validiteCourriel").textContent = "Votre adresse mail est invalide"
    e.preventDefault();
    }
user.value = user.value.toLowerCase();
});
