<?php
$dbHost = "localhost:3306";// à compléter
$dbUser = "p1920022";// à compléter
$dbPwd = "0beb2b";// à compléter
$dbName = "p1920022";

include_once './scriptImage.php';
$formco="";
$connection=getConnection($dbHost,$dbUser,$dbPwd,$dbName);
$stats=<<<HTML
        <h1>Statistiques</h1>
    </header>
HTML;
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
$chaine =<<<HTML
        </body>
    </html>
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
            $stats.=<<<HTML
                    <div id = "stats">
            <table>
                <tr>
                    <td>Utilisateur</td>
                    <td>Nombre de photos</td>
                    <td>Statut</td>
                </tr>
HTML;

$userName = getUserName($connection);
for($i=0 ; $i < getNbUtilisateurs($connection) ; $i++)    
{
    $stats.= "<tr><td>" . $userName[$i] . "</td><td>" . getNbUserPictures($connection, $userName[$i]) . "</td><td>" . getUserStatus($connection, $userName[$i]) . "</td></tr>";
}

$stats.= <<<HTML

HTML;
$stats.=<<<HTML
            </table>

            <table>
                <tr>
                    <td>Catégorie</td>
                    <td>Nombre de photos</td>
                </tr>
HTML;

$valeur = "test";

$catName = getCatName($connection);
for($i=0 ; $i < getNbCategorie($connection) ; $i++)
{
    $stats.= "<tr><td>" . $catName[$i] . "</td><td>" . getNbPhotoCat($connection, $catName[$i]) . "</td></tr>";
}

$stats.=<<<HTML
            </table>
        </div>
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
            $stats.=<<<HTML
                    <div id = "stats">
            <table>
                <tr>
                    <td>Utilisateur</td>
                    <td>Nombre de photos</td>
                    <td>Statut</td>
                </tr>
HTML;

$userName = getUserName($connection);       //tableau
for($i=0 ; $i < getNbUtilisateurs($connection) ; $i++)    
{
    $stats.= "<tr><td>" . $userName[$i] . "</td><td>" . getNbUserPictures($connection, $userName[$i]) . "</td><td>" . getUserStatus($connection, $userName[$i]) . "</td></tr>";
}

$stats.= <<<HTML

HTML;
$stats.=<<<HTML
            </table>

            <table>
                <tr>
                    <td>Catégorie</td>
                    <td>Nombre de photos</td>
                </tr>
HTML;

$valeur = "test";

$catName = getCatName($connection);
for($i=0 ; $i < getNbCategorie($connection) ; $i++)
{
    $stats.= "<tr><td>" . $catName[$i] . "</td><td>" . getNbPhotoCat($connection, $catName[$i]) . "</td></tr>";
}

$stats.=<<<HTML
            </table>
        </div>
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
$chaine= $menu.$formco.$chaine.$stats;
$chaine.= <<<HTML
    </html>
HTML;
echo $chaine;
?>