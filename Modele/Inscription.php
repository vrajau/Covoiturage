<?php

class Inscription
{

    public $errors = array();
  
    public $messages = array();

    
    public function __construct()
    {
        if (isset($_POST["inscription"])) {
            $this->enregistrerNouvelUtilisateur();
        }
    }

   
    private function enregistrerNouvelUtilisateur()
    {
      

        if (empty($_POST['nom'])) {
            $this->errors[] = "Vous n'avez pas précisé votre nom";  
        } elseif (empty($_POST['prenom'])){
            $this->errors[] = "Vous n'avez pas précisé votre prénom";
        } elseif (empty($_POST['pwd']) || empty($_POST['confirmation_pwd'])) {
            $this->errors[] = "Mot de Passe vide";
        } elseif ($_POST['pwd'] !== $_POST['confirmation_pwd']) {
            $this->errors[] = "Le mot de passe et la confirmation ne sont pas les même";
        } elseif (strlen($_POST['pwd']) < 6) {
            $this->errors[] = "Le mot de passe doit contenir 6 caractères minimum";
        }  elseif (!preg_match('/^[a-z\d]{2,64}$/i', $_POST['nom']) || !preg_match('/^[a-z\d]{2,64}$/i', $_POST['prenom']) ) {
            $this->errors[] = "Votre nom et/ou prénom est invalide: seul les lettres sont accepté, de 2 a 64 caractères";
        } elseif (empty($_POST['email'])) {
            $this->errors[] = "Vous n'avez pas précisé votre e-mail";
        }elseif($_POST['annee'] > (intval(date("Y"))-18)){
            $this->errors[] = "Vous devez avoir au moins 18 ans pour vous incrire sur EasyCovoit";

        }elseif (strlen($_POST['email']) > 64) {
            $this->errors[] = "Votre email ne peut pas contenir plus de 64 caractères";
        } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = "Votre email n'a pas le bon format";
        } elseif (!empty($_POST['nom'])
            && strlen($_POST['nom']) <= 64
            && strlen($_POST['nom']) >= 2
            && preg_match('/^[a-z\d]{2,64}$/i', $_POST['nom'])
            && !empty($_POST['email'])
            && strlen($_POST['email']) <= 64
            && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)
            && !empty($_POST['pwd'])
            && !empty($_POST['confirmation_pwd'])
            && ($_POST['pwd'] === $_POST['confirmation_pwd'])
        ) {
            
          
                $database = UsineBDD::getUsine()->connection();
              
                $nom_utilisateur = strip_tags($_POST['nom'], ENT_QUOTES);
                $prenom_utilisateur = strip_tags($_POST['prenom'], ENT_QUOTES);
                $email_utilisateur = strip_tags($_POST['email'], ENT_QUOTES);
                $naissance = strip_tags($_POST['annee'], ENT_QUOTES);
                $pwd_utilisateur= $_POST['pwd'];

                
                $hash = password_hash($pwd_utilisateur, PASSWORD_DEFAULT);

                // check if user or email address already exists
                $sql = "SELECT * FROM utilisateur WHERE email=:mail";
                $requete = $database->prepare($sql);
                $requete->execute(array(":mail"=>$email_utilisateur));
               
               
                $nombre_ligne = count($requete->fetchAll());
                if ($nombre_ligne > 0) {
                    $this->errors[] = "Cette e-mail est deja utilisé";
                } else {
                    
                    $sql = "INSERT INTO utilisateur (nom, prenom, email,mdp_hash,timestamp_creation,type_compte,naissance,solde)
                            VALUES(:nom,:prenom,:mail,:mdp,:creation,:type,:naissance,100)";
                    $creation_compte = $database->prepare($sql);
                    $creation_compte->execute(array(":nom"=>$nom_utilisateur,":prenom"=>$prenom_utilisateur,":mail"=>$email_utilisateur,":mdp"=>$hash,":creation"=>time(),":type"=>2,":naissance"=>$naissance));

                   
                    if ($creation_compte) {
                        $this->messages[] = "Votre compte a été crée!";
                    } else {
                        $this->errors[] = "Erreur, veuillez recommencer!";
                    }
                }
            
    }
}
}
