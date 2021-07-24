<?php

include_once './scriptImage.php';

$dbHost = "localhost:3306";// à compléter
$dbUser = "p1920022";// à compléter
$dbPwd = "0beb2b";// à compléter
$dbName = "p1920022";
$connection=getConnection($dbHost,$dbUser,$dbPwd,$dbName);


//Verification formulaire soumis

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    if(isset($_FILES["upFichier"]) && $_FILES["upFichier"]["error"]==0)
    {
        $filename = $_FILES["upFichier"]["name"];
        $filetype = $_FILES["upFichier"]["type"];
        $filesize = $_FILES["upFichier"]["size"];

        //Verification taille du fichier
        if($filesize > 102400)
        {
            die("Error: La taille du fichier est supérieure à la limite autorisée.");
        }

        //Verifie si fichier existe deja avant de telecharger
        if(file_exists("assets/images" . $filename))
        {
            echo $filename . " existe déjà.";
        }
        else
        {
            move_uploaded_file($_FILES["upFichier"]["tmp_name"], "assets/images/" . $filename);
            echo "Fichier téléchargé avec succès.";
        }
    }
    else
    {
        echo "Error: Il y a eu un problème de téléchargement de votre fichier. Veuillez réessayer."; 
    }
}
else 
{
    echo "Error: " . $_FILES["upFichier"]["error"];
}


$image = $filename;

$description = str_ireplace("'", "''", $_POST['upDescription']);
$categorie = $_POST['upCategorie'];
$auteur = $_SESSION['user'];
ajoutImage($connection, $image, $description, $categorie, $auteur);

sleep(2);
header('Location: https://bdw1.univ-lyon1.fr/p1908800/projet/index.php');
exit;