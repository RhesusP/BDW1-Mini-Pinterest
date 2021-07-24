<?php
$dbHost = "localhost:3306";// à compléter
$dbUser = "p1920022";// à compléter
$dbPwd = "0beb2b";// à compléter
$dbName = "p1920022";

include './scriptImage.php';
$formco="";
$formEdit="";
$photo=$_GET["img"];
$connection=getConnection($dbHost,$dbUser,$dbPwd,$dbName);
$menu=<<<HTML
    <!doctype html>
    <html>
        <head>
            <meta http-equiv="Content-Type" content="text/html" charset="UTF-8" /> 
            <link type="text/css" rel="stylesheet" href="css/style.css">
            <title>Description</title>
        </head>
        <body>
            <header>
                <ul id="liste_nav">
                    <li><a href="./index.php">Acceuil</a></li>
HTML;
$chaine=<<<HTML
            <h1>Les détails sur cette photo :<br></h1>
            <div id="description">
HTML;


$desc=getDescription($connection, $photo);
$cat=getNomCat($connection, $photo);
$numCat = getNumCat($connection, $photo);
$chaine.= '</header><div id="description">';
$chaine.= '<div id="imageDesc"><img src="assets/images/' . $photo . '"></div>';
$chaine.=<<<HTML
            <table>
                <tr>
                    <td>Description</td>
                    <td>
HTML;
$chaine.= $desc;
$chaine.=<<<HTML
                    </td>
                </tr>
                <tr>
                    <td>Nom du fichier</td>
                    <td>
HTML;
$chaine.= $photo;
$chaine.=<<<HTML
                    </td>
                </tr>
                <tr>
                    <td>Catégorie</td>
                    <td>
HTML;
$chaine.= '<a href="./index.php?categorie=' . $numCat . '">'. $cat . '</a>';
$chaine.=<<<HTML
                        </a></td>
                </tr>
            </table>
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
            $formEdit.=<<<HTML
             <h2>Modifier des éléments de l'image</h2>
             <div class="formulaireCentre">
HTML;
            $formEdit.="<form method=\"POST\""." action=\"description.php"."?img=".$photo."\">";
            $formEdit.="<form method=\"POST\""." action=\"description.php"."?img=".$photo."\">";
            $formEdit.=<<<HTML
                <label>Changer la description :
                    <textarea name="newDescription" maxlength="250"></textarea>
                </label>
                <button type="submit">Valider</button>
            </form>
HTML;
            $formEdit.="<form method=\"POST\""." action=\"description.php"."?img=".$photo."\">";
            $formEdit.=<<<HTML
                <label>Changer la catégorie :
                    <select name="newCategorie">
HTML;
            $formEdit.=getCategories($connection);
            $formEdit.=<<<HTML
                    </select>
                </label>
                <button type="submit">Valider</button>
                </form>
HTML;
$formEdit.="<form method=\"POST\""." action=\"description.php"."?img=".$photo."\">";
$formEdit.=<<<HTML
                    <label> 
                        <input name="effacer" type="checkbox" value="effacer">
                        Effacer la photo
                    </label>
                <button type="submit">Valider</button>
            </form>
HTML;
        }
        elseif (strtolower($_POST['identifiant'])==strtolower(getAuthor($connection,$photo))) 
        {
            $formEdit.=<<<HTML
            <h2>Modifier des éléments de l'image</h2> 
            <div class="formulaireCentre">
HTML;
            $formEdit.="<form method=\"POST\""." action=\"description.php"."?img=".$photo."\">";
            $formEdit.="<form method=\"POST\""." action=\"description.php"."?img=".$photo."\">";
            $formEdit.=<<<HTML
                <label>Changer la description :
                    <textarea name="newDescription" maxlength="250"></textarea>
                </label>
                <button type="submit">Valider</button>
            </form>
HTML;
            $formEdit.="<form method=\"POST\""." action=\"description.php"."?img=".$photo."\">";
            $formEdit.=<<<HTML
                <label>Changer la catégorie :
                    <select name="newCategorie">
HTML;
            $formEdit.=getCategories($connection);
            $formEdit.=<<<HTML
                    </select>
                </label>
                <button type="submit">Valider</button>
                </form>
HTML;
            $formEdit.="<form method=\"POST\""." action=\"description.php"."?img=".$photo."\">";
            $formEdit.=<<<HTML
                    <label> 
                        <input name="effacer" type="checkbox" value="effacer">
                        Effacer la photo
                    </label>
                <button type="submit">Valider</button>
            </form>
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
            $formEdit.=<<<HTML
            <h2>Modifier des éléments de l'image</h2>
            <div class="formulaireCentre">
HTML;
            $formEdit.="<form method=\"POST\""." action=\"description.php"."?img=".$photo."\">";
            $formEdit.="<form method=\"POST\""." action=\"description.php"."?img=".$photo."\">";
            $formEdit.=<<<HTML
                <label>Changer la description :
                    <textarea name="newDescription" maxlength="250"></textarea>
                </label>
                <button type="submit">Valider</button>
            </form>
HTML;
            $formEdit.="<form method=\"POST\""." action=\"description.php"."?img=".$photo."\">";
            $formEdit.=<<<HTML
                <label>Changer la catégorie :
                    <select name="newCategorie">
HTML;
            $formEdit.=getCategories($connection);
            $formEdit.=<<<HTML
                    </select>
                </label>
                <button type="submit">Valider</button>
                </form>
HTML;
            $formEdit.="<form method=\"POST\""." action=\"description.php"."?img=".$photo."\">";
            $formEdit.=<<<HTML
                    <label> 
                        <input name="effacer" type="checkbox" value="effacer">
                        Effacer la photo
                    </label>
                <button type="submit">Valider</button>
            </form>
HTML;
        }
        elseif (strtolower($_SESSION['user'])==strtolower(getAuthor($connection,$photo))) 
        {
            $formEdit.=<<<HTML
            <h2>Modifier des éléments de l'image</h2>
            <div class="formulaireCentre">
HTML;
            $formEdit.="<form method=\"POST\""." action=\"description.php"."?img=".$photo."\">";
            $formEdit.=<<<HTML
                    <label>Changer la description :
                        <textarea name="newDescription" maxlength="250"></textarea>
                    </label>
                    <button type="submit">Valider</button>
                </form>
HTML;
            $formEdit.="<form method=\"POST\""." action=\"description.php"."?img=".$photo."\">";
            $formEdit.=<<<HTML
                <form method="POST" action="description.php">
                    <label>Changer la catégorie :
                        <select name="newCategorie">
HTML;
            $formEdit.=getCategories($connection);
            $formEdit.=<<<HTML
                        </select>
                    </label>
                    <button type="submit">Valider</button>
                </form>
HTML;
            $formEdit.="<form method=\"POST\""." action=\"description.php"."?img=".$photo."\">";
            $formEdit.=<<<HTML
                <form method="POST" action="description.php">
                    <button name="effacer" value="0">Effacer la photo</button>    <!-- Ajout bouton-->
                    <button type="submit">Valider</button>
                </form>
            </div>
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

if(isset($_POST['newDescription']))
{
    setDescription($connection, $photo, $_POST['newDescription']);
}

elseif(isset($_POST['newCategorie']))
{
    setCategorie($connection, $photo, $_POST['newCategorie']);
}

elseif(isset($_POST['effacer']))
{
    effacerPhoto($connection, $photo);
}


$formco=getTimeLogged().$formco;
$chaine= $menu.$formco.$chaine.$formEdit;
echo $chaine;

?>