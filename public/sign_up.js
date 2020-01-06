// Verify user's data
var form = document.querySelector("form");
form.addEventListener("submit", function (e) {
  if (lang == 'fr_FR') {
    var error ="ERREUR : Les deux mots de passe ne sont pas identiques !";
    var password = "Le mot de passe est trop court (minimum 8 caractères) !";
    var email = "Votre adresse mail est invalide";
  } else if (lang == 'en_US') {
      var error = "Error : Both passwords are differents !";
      var password = "Password is too short (minimum 8 characters) !";
      var email = "Your email adress is not correct";
  }

  var mdp1 = document.querySelector("form").elements.password.value;
  var mdp2 = document.querySelector("form").elements.repeatpassword.value;
  var erreur = document.getElementById("validiteCourriel");
  var user = document.getElementById("username");
  var mail = document.getElementById("email").value;
  var regexCourriel = /.+@.+\..+/;
  var match = regexCourriel.test(mail);
  if ( mdp1 !== mdp2)
  {
    erreur.textContent = error;
    e.preventDefault();
  }
  else if ( mdp1.length < 8 ) {
    erreur.textContent = password;
    e.preventDefault();
  }
  else if (match === false)
  {
    document.getElementById("validiteCourriel").textContent = email;
    e.preventDefault();
  }
  user.value = user.value.toLowerCase();
});
