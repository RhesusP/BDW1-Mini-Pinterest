<?php
$dbHost = "localhost:3306";// à compléter
$dbUser = "p1920022";// à compléter
$dbPwd = "0beb2b";// à compléter
$dbName = "p1920022";

include_once './scriptImage.php';

$connection=getConnection($dbHost,$dbUser,$dbPwd,$dbName);

//------------------------------------ Les links et la fin de la page sont des tentatives d'affichage d'une pop up via boostrap.
$formco="";
$chaine="";
$infoCompte=<<<HTML
        <h1>Mes informations</h1>
        </header>
HTML;
$connection=getConnection($dbHost,$dbUser,$dbPwd,$dbName);
$menu=<<<HTML
    <!doctype html>
    <meta charset="UTF-8">
    <html>
        <head>
            <meta http-equiv="Content-Type" content="text/html" charset="UTF-8" /> 
            <link type="text/css" rel="stylesheet" href="css/style.css">
            <title>Statistiques</title>
        </head>
        <body>
            <header>
                    <ul id="liste_nav">
                        <li><a href="./index.php">Acceuil</a></li>
HTML;

if(!(isset($_SESSION['logged']) && $_SESSION['logged']))
{
    if((!(isset($_POST['identifiant'])&&isset($_POST['password'])))||(getUser($connection,$_POST['identifiant'],$_POST['password'])==0))
    {
        $formco.=<<<HTML
                    <form name="login" method="POST" action="">
                        <input name="identifiant" type="text" placeholder="Identifiant">
                        <input name="password" type="password" placeholder="Mot de passe">
                        <button type="submit">Se connecter</button>
                    </form>
HTML;
    }
    else
    {
        $infoCompte.=<<<HTML
        <form name="changementLogin" method="POST" action="compte.php">
                <label> Votre nom d'utilisateur est 
HTML;
        $infoCompte.= $_POST['identifiant'] . "<br>";
        $infoCompte.=<<<HTML
                            <br>Changer son nom d'utilisateur :
                                <input name="newLogin" maxlength="25" placeholder="Nouvel identifiant" required>
                        </label>
                        <button type="submit">Valider</button>
                    </form>
                    <form name="changementPwd" method="POST" action="#">
                        <label>Modification de mot de passe :
                            <input name="oldPwd" type="password" maxlenght="40" placeholder="Ancien mot de passe">
                            <input name="newPwd" type="password" maxlenght="40" placeholder="Nouveau mot de passe">
                            <input name="newPwd1" type="password" maxlenght="40" placeholder="Répéter mot de passe">
                        </label>
                        <button type="submit">Valider</button>
                    </form>
HTML;

        //variable texte de la pop-up
        $bouton = "";
        if(isset($_POST['newLogin']))
        {
            $bouton.= setLogin($connection, $_SESSION['user'], $_POST['newLogin']);
        }

        if(isset($_POST['oldPwd']) && isset($_POST['newPwd']) && isset($_POST['newPwd1']))
        {
            $bouton.= setPwd($connection, $_SESSION['user'], $_POST['oldPwd'], $_POST['newPwd'], $_POST['newPwd1']);
        }

        $infoCompte.=$bouton;
        $menu.=<<<HTML
                        <li><a href="mesPhotos.php">Mes photos</a></li>
                        <li><a href="upload.php">Ajouter une photo</a></li>
                        <li><a href="compte.php">Mon compte</a></li>
HTML;
        if(getUser($connection,$_POST['identifiant'],$_POST['password'])==2)
        {
            $menu.=<<<HTML
                <li><a href="statistiques.php">Statistiques</a></li>
HTML;
        }
        if(!isset($_POST['boutonDeconnexion']))
        {
            $formco.=<<<HTML
                    <form name="deconnexion" method="POST" action="">
                        <button type="submit" value="0" name="boutonDeconnexion">Se déconnecter</button>
                    </form>
HTML;
        }
        
    }
}
else
{
    if(!isset($_POST['boutonDeconnexion']))
    {
        $infoCompte.=<<<HTML
        <form name="changementLogin" method="POST" action="compte.php">
                <label> Votre nom d'utilisateur est 
HTML;
        $infoCompte.= $_SESSION['user'] . "<br>";
        $infoCompte.=<<<HTML
                            <br>Changer son nom d'utilisateur :
                                <input name="newLogin" maxlength="25" placeholder="Nouvel identifiant" required>
                        </label>
                        <button type="submit">Valider</button>
                    </form>
                    <form name="changementPwd" method="POST" action="#">
                        <label>Modification de mot de passe :
                            <input name="oldPwd" type="password" maxlenght="40" placeholder="Ancien mot de passe">
                            <input name="newPwd" type="password" maxlenght="40" placeholder="Nouveau mot de passe">
                            <input name="newPwd1" type="password" maxlenght="40" placeholder="Répéter mot de passe">
                        </label>
                        <button type="submit">Valider</button>
                    </form>
HTML;

        //variable texte de la pop-up
        $bouton = "";
        if(isset($_POST['newLogin']))
        {
            $bouton.= setLogin($connection, $_SESSION['user'], $_POST['newLogin']);
        }

        if(isset($_POST['oldPwd']) && isset($_POST['newPwd']) && isset($_POST['newPwd1']))
        {
            $bouton.= setPwd($connection, $_SESSION['user'], $_POST['oldPwd'], $_POST['newPwd'], $_POST['newPwd1']);
        }

        $infoCompte.=$bouton;
        $menu.=<<<HTML
                <li><a href="mesPhotos.php">Mes photos</a></li>
                <li><a href="upload.php">Ajouter une photo</a></li>
                <li><a href="compte.php">Mon compte</a></li>
HTML;
        if(isset($_SESSION['admin'])&&$_SESSION['admin']==true)
        {
            $menu.=<<<HTML
                <li><a href="statistiques.php">Statistiques</a></li>
HTML;
        }
        $formco.=<<<HTML
                    <form name="deconnexion" method="POST" action="">
                        <button type="submit" value="0" name="boutonDeconnexion">Se déconnecter</button>
                    </form>
HTML;
    }
    else
    {
        session_unset();
        $formco.=<<<HTML
                    <form name="login" method="POST" action="">
                        <input name="identifiant" type="text" placeholder="Identifiant">
                        <input name="password" type="password" placeholder="Mot de passe">
                        <button type="submit">Se connecter</button>
                    </form>
HTML;
        if(isset($_POST['identifiant'])&&isset($_POST['password']))
        {
            //$utilisateur = $_POST['identifiant'];
            getUser($connection,$_POST['identifiant'],$_POST['password']);
        }
    }

}
$menu.=<<<HTML
                </ul>
HTML;
$formco=getTimeLogged().$formco;
$chaine= $menu.$formco.$chaine.$infoCompte;

$chaine.=<<<HTML
        </body>
    </html>
HTML;
echo $chaine;
?>