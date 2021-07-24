<?php
$dbHost = "localhost:3306";// à compléter
$dbUser = "p1920022";// à compléter
$dbPwd = "0beb2b";// à compléter
$dbName = "p1920022";
include_once './scriptImage.php';
$connection=getConnection($dbHost,$dbUser,$dbPwd,$dbName);
$formco="";
$menu=<<<HTML
    <!doctype html>
    <meta charset="UTF-8">
    <html>
        <head>
            <meta http-equiv="Content-Type" content="text/html" charset="UTF-8" /> 
            <link type="text/css" rel="stylesheet" href="css/style.css">
            <title>Mini Pinterest</title>
        </head>
        <body>
            <header>
                <ul id="liste_nav">
                <li><a href="./index.php">Acceuil</a></li>
HTML;
$chaine=<<<HTML
                <h1>Application mini-Pinterest</h1>
        </header>
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
           $chaine.=<<<HTML
                    <form name="choixCat" method="POST" action="./index.php">
                        <label>
                            Quelles catégorie souhaitez-vous afficher ? 
                            <select name="categorie">
HTML;
        $chaine.=getCategories($connection);
        $chaine.=<<<HTML
                            </select>
                        </label>
                        <button type="submit">Valider</button>
                    </form>
HTML;
            $formco.=<<<HTML
                    </form>
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
        $chaine.=<<<HTML
                    <form name="choixCat" method="POST" action="./index.php">
                        <label>
                            Quelles catégorie souhaitez-vous afficher ? 
                            <select name="categorie">
HTML;
        $chaine.=getCategories($connection);
        $chaine.=<<<HTML
                            </select>
                        </label>
                        <button type="submit">Valider</button>
                    </form>
HTML;
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
            getUser($connection,$_POST['identifiant'],$_POST['password']);
        }
    }

}
if (isset($_POST['categorie']))
        {
        $cat = $_POST['categorie'];
        $nomCat = catIdToNomCat($connection, $cat);
        $contenu= <<<HTML
            <div class="titre">
                <h1>Toutes les photos de la catégorie
HTML;
        $contenu .= " " . $nomCat . " :";
        $contenu .= <<<HTML
                </h1>
            </div>
                <div id="photos">
HTML;
        $images = getPicturesCategorie($connection, $cat);
        $contenu.=$images;
        }
        elseif (isset($_GET['categorie']))
        {
            $cat = $_GET['categorie'];
            $nomCat = catIdToNomCat($connection, $cat);
            $contenu= <<<HTML
                    <div class="titre">
                        <h1>Toutes les photos de la catégorie
HTML;
            $contenu .= " " . $nomCat . " :";
            $contenu .= <<<HTML
                        </h1>
                    </div>
                    <div id="photos">
HTML;
            $images = getPicturesCategorie($connection, $cat);
            $contenu.=$images;
        }
        else
        {
            $contenu= <<<HTML
                    <div class="titre">
                        <h1>Toutes les photos :</h1>
                    </div>
                    <div id="photos">
HTML;
            $images = getallPictures($connection);
            $contenu.=$images;
        }
        $chaine.= $contenu;
        $chaine .=<<<HTML
            </div> 
        </body>
    </html>
HTML;
$menu.=<<<HTML
                </ul>
HTML;
$formco=getTimeLogged().$formco;
$chaine= $menu.$formco.$chaine;
echo $chaine;

?>