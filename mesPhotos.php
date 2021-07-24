<?php
$dbHost = "localhost:3306";// à compléter
$dbUser = "p1920022";// à compléter
$dbPwd = "0beb2b";// à compléter
$dbName = "p1920022";
include_once './scriptImage.php';
//include_once './index.php';
$photos=<<<HTML
        <h1>Mes photos :<br></h1>
    </header>
    <div id="photos">
HTML;
$formco="";
$connection=getConnection($dbHost,$dbUser,$dbPwd,$dbName);
$menu=<<<HTML
    <!doctype html>
    <meta charset="UTF-8">
    <html>
        <head>
            <meta http-equiv="Content-Type" content="text/html" charset="UTF-8" /> 
            <link type="text/css" rel="stylesheet" href="css/style.css">
            <title>Mes photos</title>
        </head>
        <body>
            <header>
                <ul id="liste_nav">
                <li><a href="./index.php">Acceuil</a></li>
HTML;

$chaine = "";
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
        $photos.= getUserPictures($connection);
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
        $photos.= getUserPictures($connection);
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
$chaine= $menu.$formco.$chaine.$photos;

$chaine.= <<<HTML
            </div>
        </h1>
    </html>
HTML;

echo $chaine;

?>