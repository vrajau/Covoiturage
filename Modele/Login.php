<?php

class Login
{

    /**
     * @var Tableau contenant les messages d'erreurs
     */
    public $errors = array();
    /**
     * @var Tableau contenant différent type de message
     */
    public $messages = array();

  
    public function __construct()
    {
        session_start();

        if (isset($_GET["logout"])) {
            $this->deconnexion();
        }
        
        elseif (isset($_POST["login"])) {
            $this->connexion();
        }
    }

    private function connexion()
    {
        
        if (empty($_POST['id_user'])) {
            $this->errors[] = "Vous n'avez pas renseigné d'adresse e-mail";
        } elseif (empty($_POST['pwd_user'])) {
            $this->errors[] = "Vous n'avez pas renseigné de mot de passe";
        } elseif (!empty($_POST['id_user']) && !empty($_POST['pwd_user'])) {

            $database = UsineBDD::getUsine()->connection();

               
                $email_utilisateur = strip_tags($_POST['id_user'], ENT_QUOTES);
                $mot_de_passe = strip_tags($_POST['pwd_user'], ENT_QUOTES);
                $sql = "SELECT * FROM utilisateur WHERE email=:mail";
                $requete = $database->prepare($sql);
                $requete->execute(array(":mail"=>$email_utilisateur));
                $resultat_requete  = $requete->fetchAll();

                //Si l'utilisateur existe
                if (count($resultat_requete) == 1) {
                    if (password_verify($mot_de_passe, $resultat_requete[0]["mdp_hash"])) {

                        // write user data into PHP SESSION (a file on your server)
                        $_SESSION['utilisateur'] = $resultat_requete[0]["prenom"].substr($resultat_requete[0]["nom"],0,1);
                        $_SESSION['id_utilisateur'] = $resultat_requete[0]["id"];
                        $_SESSION['connecte'] = 1;

                    } else {
                        $this->errors[] = "Mauvais mot de passe!";
                    }
                } else {
                    $this->errors[] = "Cet utilisateur n'existe pas";
                }
           
        }
    }

    /**
     * perform the logout
     */
    public function deconnexion()
    {
        
        $_SESSION = array();
        session_destroy();
        

    }

    

 
    public function isConnecte()
    {
        if (isset($_SESSION['connecte']) AND $_SESSION['connecte'] == 1 ) {

            return true;
        }
        return false;
    }
}
