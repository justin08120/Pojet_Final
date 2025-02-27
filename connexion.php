<?php
/*
Page: connexion.php
*/
//à mettre tout en haut du fichier .php, cette fonction propre à PHP servira à maintenir la $_SESSION
session_start();
//si le bouton "Connexion" est cliqué
if(isset($_POST['connexion'])){
  // on vérifie que le champ "Pseudo" n'est pas vide
  // empty vérifie à la fois si le champ est vide et si le champ existe belle et bien (is set)
  if(empty($_POST['pseudo'])){
    echo "Le champ Pseudo est vide.";
  } else {
    // on vérifie maintenant si le champ "Mot de passe" n'est pas vide"
    if(empty($_POST['mdp'])){
      echo "Le champ Mot de passe est vide.";
    } else {
      // les champs pseudo & mdp sont bien postés et pas vides, on sécurise les données entrées par l'utilisateur
      //le htmlentities() passera les guillemets en entités HTML, ce qui empêchera en partie, les injections SQL
      $Pseudo = htmlentities($_POST['pseudo'], ENT_QUOTES, "UTF-8"); 
      $MotDePasse = htmlentities($_POST['mdp'], ENT_QUOTES, "UTF-8");
      //on se connecte à la base de données:
      $mysqli = mysqli_connect("domaine.tld", "nom d'utilisateur", "mot de passe", "base de données");
      //on vérifie que la connexion s'effectue correctement:
      if(!$mysqli){
        echo "Erreur de connexion à la base de données.";
      } else {
        //on fait maintenant la requête dans la base de données pour rechercher si ces données existent et correspondent:
        //si vous avez enregistré le mot de passe en md5() il vous faudra faire la vérification en mettant mdp = '".md5($MotDePasse)."' au lieu de mdp = '".$MotDePasse."'
        $Requete = mysqli_query($mysqli,"SELECT * FROM membres WHERE pseudo = '".$Pseudo."' AND mdp = '".$MotDePasse."'");
        //si il y a un résultat, mysqli_num_rows() nous donnera alors 1
        //si mysqli_num_rows() retourne 0 c'est qu'il a trouvé aucun résultat
        if(mysqli_num_rows($Requete) == 0) {
          echo "Le pseudo ou le mot de passe est incorrect, le compte n'a pas été trouvé.";
        } else {
          //on ouvre la session avec $_SESSION:
          //la session peut être appelée différemment et son contenu aussi peut être autre chose que le pseudo
          $_SESSION['pseudo'] = $Pseudo;
          header("index.html"); // Redirection du navigateur
          exit;//on affiche pas le reste de la page pour faire une redirection parfaite et sans erreurs;
        }
      }
    }
  }
}
?>

<!-- 
Les balises <form> servent à dire que c'est un formulaire
on lui demande de faire fonctionner la page connexion.php une fois le bouton "Connexion" cliqué
on lui dit également que c'est un formulaire de type "POST" (récupéré via $_POST en PHP)
Les balises <input> sont les champs de formulaire
type="text" sera du texte
type="password" sera des petits points noir (texte caché)
type="submit" sera un bouton pour valider le formulaire
name="nom de l'input" sert à le reconnaitre une fois le bouton submit cliqué, pour le code PHP (récupéré via $_POST["nom de l'input"] en PHP)
 -->
