<?php
session_start();

/**
 * @brief Permet d'effectuer une connexion à la base de données.
 * @param $dbHost (string) Hote de connexion à la basé de données.
 * @param $dbUser (string) Identifiant de connexion à la base de données.
 * @param $dbPwd (string) Mot de passe de connexion à la base de données.
 * @param $dbName (string) Nom de la base de données à laquelle se connecter.
 * @return Objet mysqli (mysqli).
 */
function getConnection($dbHost, $dbUser, $dbPwd, $dbName)
{
	$mysqli = new mysqli($dbHost,$dbUser,$dbPwd,$dbName);
	if($mysqli->connect_error)
	{
		exit("Erreur lors de la connexion");
	}
	mysqli_set_charset($mysqli,"utf8");
	return $mysqli;
}

/**
 * @brief Permet d'executer une requête sur la base de données.
 * @param $link (mysqli) Connexion à la base de données.
 * @param $query (string) Requête.
 * @return Résultat de la requête ou erreur.
 */
function executeQuery($link, $query)
{
	$res=$link->query($query);
	if($res===FALSE)
	{
		exit("Erreur : la requête n'a pas été exécutée");
	}
	return $res;
}

/**
 * @brief Récupère toutes les photos présentes dans la base de données.
 * Retourne une chaine de caractères HTML permettant d'afficher toutes les images en lien cliquable vers description.php
 * @param $link (mysqli) Connexion à la base de données.
 * @return Toutes les images sous la forme de liens cliquables (string).
 */
function getAllPictures($link)
{
	$string="<a href='description.php?img=";
	$string2="'><img src=\"assets/images/";
	$query="SELECT nomFich FROM Photo";
	$imgs=executeQuery($link,$query);
	$img="";
	$retour="";
	for($i=0;$i<$imgs->num_rows;++$i)
	{
		$img=$imgs->fetch_array(MYSQLI_NUM)[0];
		$retour.= $string . urlencode($img) . $string2 . $img . "\"></a>";
	}
	return $retour;
}

/**
 * @brief Récupère toutes les photos d'une catégorie présentes dans la base de données.
 * Retourne une chaine de caractères HTML permettant d'afficher toutes les images d'une catégorie donnée en lien cliquable vers description.php
 * @param $link (mysqli) Connexion à la base de données.
 * @param $categorie (int) Id de catégorie.
 * @return Toutes les images sous la forme de liens cliquables (string).
 */
function getPicturesCategorie($link, $categorie)
{
	$string="<a href='description.php?img=";
	$string2="'><img src=\"assets/images/";
	$query="SELECT nomFich FROM Photo WHERE catId =" . $categorie;
	$imgs=executeQuery($link,$query);
	$img="";
	$retour="";
	for($i=0;$i<$imgs->num_rows;++$i)
	{
		$img=$imgs->fetch_array(MYSQLI_NUM)[0];
		$retour.= $string . urlencode($img) . $string2 . $img ."\"></a>";
	}
	return $retour;
}

/**
 * @brief Récupère le nom d'une catégorie en fonction de son identifiant
 * @param $link (mysqli) Connexion à la base de données.
 * @param $catId (int) Id de catégorie.
 * @return Nom de la catégorie (string).
 */
function catIdToNomCat($link, $catId)
{
	$query="SELECT nomCat FROM Categorie WHERE catId =" . $catId;
	$nomCat=mysqli_fetch_array(executeQuery($link,$query))[0];
	return $nomCat;
}

/**
 * @brief Récupère la description associée à une photo.
 * Envoie une requête SQL à la base de données permettant de recupérer la description d'une photo.
 * @param $link (mysqli) Connexion à la base de données.
 * @param $photo (string) Nom de la photo dans la base de données.
 * @return Description (string).
 */
function getDescription($link,$photo)
{
	$query="SELECT Description FROM Photo WHERE nomFich ='" . $photo . "';"; 
	$desc=mysqli_fetch_array(executeQuery($link,$query))[0];
	return $desc;
}

/**
 * @brief Récupère la catégorie associée à une photo.
 * Envoie une requête SQL à la base de données permettant de recupérer la catégorie d'une photo.
 * @param $link (mysqli) Connexion à la base de données.
 * @param $photo (string) Nom de la photo dans la base de données.
 * @return Nom de la catégorie (string).
 */
function getNomCat($link, $photo)
{
	$query ="SELECT c.nomCat FROM Categorie c JOIN Photo p ON c.catId = p.catId WHERE nomFich ='".$photo."';";
	$cat = mysqli_fetch_array(executeQuery($link,$query))[0];
	return $cat;
}

/**
 * @brief Récupère l'identifiant de la catégorie associée à une photo.
 * Envoie une requête SQL à la base de données permettant de recupérer l'identifiant de la catégorie d'une photo.
 * @param $link (mysqli) Connexion à la base de données.
 * @param $photo (string) Nom de la photo dans la base de données.
 * @return Identifiant de la catégorie (string).
 */
function getNumCat($link, $photo)
{
	$query = "SELECT catId FROM Photo WHERE nomFich ='".$photo."';";
	$num = mysqli_fetch_array(executeQuery($link,$query))[0];
	return $num;
}

/**
 * @brief Permet à l'utilisateur de se connecter sur le site. 
 * @param $link (mysqli) Connexion à la base de données.
 * @param $user (string) Nom d'utilisateur.
 * @param $password (string) Mot de passe.
 * @return int.
 */
function getUser($link,$user,$password)
{
	$query ="SELECT admin FROM Utilisateur WHERE login ='".$user."' AND mdp='".$password."';";
	$admin=executeQuery($link,$query);
	if($admin->num_rows>0)
	{
		$_SESSION['logged']=true;
		$_SESSION['user']=$user;
		$_SESSION['tempsConn']=time();
		if(mysqli_fetch_array($admin)[0]==0)
		{
			$_SESSION['admin']=false;
			return 1;
		}
		$_SESSION['admin']=true;
		return 2;
	}
	return 0;
}

/**
 * @brief Récupère toutes les photos de l'utilisateur connecté dans la base de données.
 * Retourne une chaine de caractères HTML permettant d'afficher sous la forme de liens cliquables vers description.php toutes les images de l'utilisateur connecté.
 * Cette fonction est utilisée dans mesPhotos.php.
 * @param $link (mysqli) Connexion à la base de données.
 * @return Images de l'utilisateur sous la forme de liens cliquables (string).
 */
function getUserPictures($link)
{
	$string="<a href='description.php?img=";
	$string2="'><img src=\"assets/images/";
	$query="SELECT nomFich FROM Photo WHERE auteur ='" . $_SESSION['user']."'";
	$imgs=executeQuery($link,$query);
	$img="";
	$retour="";
	for($i=0;$i<$imgs->num_rows;++$i)
	{
		$img=$imgs->fetch_array(MYSQLI_NUM)[0];
		$retour.= $string . urlencode($img) . $string2 . $img ."\"></a>";
	}
	return $retour;
}

/**
 * @brief Permet d'ajouter une image dans la base de données. 
 * Ajoute une photo dans la base de données et renseigne son nom, sa description, sa catégorie et son auteur. 
 * Cette fonction est utilisée dans upload.php.
 * @param $link (mysqli) Connexion à la base de données.
 * @param $photo (string) Nom de la photo.
 * @param $description (string) Description de la photo.
 * @param $categorie (int) Identifiant de la catégorie de la photo.
 * @param $auteur (string) Auteur de la photo.
 * 
 */
function ajoutImage($link, $photo, $description, $categorie, $auteur)
{
	$query="INSERT INTO Photo (nomFich, Description, catId, auteur) VALUES ('" . $photo . "','" . $description . "','" . $categorie . "','" . $auteur . "');";
	executeQuery($link,$query);
}

/**
 * @brief Recupère le nombre d'utilisateurs présents dans la base de données.
 * Cette fonction est utilisée dans statistiques.php.
 * @param $link (mysqli) Connexion à la base de données.
 * @return Nombre d'utilisateurs (int)
 */
function getNbUtilisateurs($link)
{
	$query = "SELECT COUNT(login) FROM Utilisateur;";
	$rep = mysqli_fetch_array(executeQuery($link,$query))[0];
	return $rep;
}

/**
 * @brief Recupère le nom des utilisateurs présents dans la base de données.
 * Cette fonction est utilisée dans statistiques.php.
 * @param $link (mysqli) Connexion à la base de données.
 * @return Nom des utilisateurs (array).
 */
function getUserName($link)
{
	$query = "SELECT login FROM Utilisateur;";
	$rep = executeQuery($link, $query);
	$tab = array();
	for($i=0;$i<$rep->num_rows;++$i)
	{
		$string=$rep->fetch_array(MYSQLI_NUM)[0];
		array_push($tab, $string);
	}
	return $tab;
}

/**
 * @brief Recupère le nombre de photos uploadées par utilisateur.
 * Cette fonction est utilisée dans statistiques.php.
 * @param $link (mysqli) Connexion à la base de données.
 * @param $user (string) Nom de l'utilisateur.
 * @return Nombre de photos de l'utilisateur (int).
 */
function getNbUserPictures($link, $user)
{
	$query = "SELECT COUNT(photoId) FROM Photo WHERE auteur='" . $user . "';";
	$rep = mysqli_fetch_array(executeQuery($link,$query))[0];
	return $rep;
}

/**
 * @brief Recupère le statut de l'utilisateur.
 * Cette fonction est utilisée dans statistiques.php.
 * @param $link (mysqli) Connexion à la base de données.
 * @param $user (string) Nom de l'utilisateur.
 * @return Statut de l'utilisateur (string).
 */
function getUserStatus($link, $user)
{
	$query = "SELECT admin FROM Utilisateur WHERE login ='" . $user . "';";
	$status = executeQuery($link, $query);
	$status=$status->fetch_array(MYSQLI_NUM)[0];
	if($status == 1)
	{
		$rep = "Admin";
	}
	else
	{
		$rep = "Membre";
	}
	return $rep;
}

/**
 * @brief Recupère le nombre de catégorie présentes dans la base de données.
 * Cette fonction est utilisée dans statistiques.php.
 * @param $link (mysqli) Connexion à la base de données.
 * @return Nombre de catégorie (int).
 */
function getNbCategorie($link)
{
	$query="SELECT COUNT(catId) FROM Categorie;";
	$rep = mysqli_fetch_array(executeQuery($link,$query))[0];
	return $rep;
}

/**
 * @brief Recupère le nom des catégorie présentes dans la base de données.
 * Cette fonction est utilisée dans statistiques.php.
 * @param $link (mysqli) Connexion à la base de données.
 * @return Nom des catégories (array).
 */
function getCatName($link)
{
	$query="SELECT nomCat FROM Categorie;";
	$rep = executeQuery($link, $query);
	$tab = array();
	for($i=0;$i<$rep->num_rows;++$i)
	{
		$string=$rep->fetch_array(MYSQLI_NUM)[0];
		array_push($tab, $string);
	}
	return $tab;
}

/**
 * @brief Recupère le nombre de photo dans une catégorie.
 * Cette fonction est utilisée dans statistiques.php. 
 * @param $link (mysqli) Connexion à la base de données.
 * @param $categorie (string) Nom de la catégorie.
 * @return Nombre de photo dans la catégorie (int).
 */
function getNbPhotoCat($link, $categorie)
{
	$query="SELECT COUNT(photoId) FROM Photo p JOIN Categorie c ON p.catId = c.catId WHERE nomCat='" . $categorie . "';";
	$rep = mysqli_fetch_array(executeQuery($link,$query))[0];
	return $rep;
}

/**
 * @brief Retourne le temps de session de l'utilisateur connecté.
 * Cette fonction est utilisée sur chaque page du site.
 * @return Temps de connexion (string).
 */
function getTimeLogged()
{
	if(isset($_SESSION['logged'])&&$_SESSION['logged']==true)
	{
		$chaineConnection="<p> Vous êtes connecté via l'identifiant : ".$_SESSION['user']." depuis ";
		$temps=time()-$_SESSION['tempsConn'];
		$chaineTemps=($temps%60)." seconde(s)";
		$temps=(int)($temps/60);
		if($temps>0)
		{
			$chaineTemps=($temps%60)." minute(s), ".$chaineTemps;
			$temps=(int)($temps/60);
			if($temps>0)
			{
				$chaineTemps=($temps%24)." heure(s), ".$chaineTemps;
				$temps=(int)($temps/24);
				if($temps>0)
				{
					$chaineTemps=$temps." jour(s), ".$chaineTemps;
				}
			}
		}
		$chaineConnection.=$chaineTemps."</p>";
		return $chaineConnection;
	}
	return "";
}

/**
 * @brief Mutateur au nom d'utilisateur.
 * Permet de modifier le nom de l'utilisateur connecté grâce à une requete SQL.
 * Cette fonction est utilisée dans compte.php.
 * @param $link (mysqli) Connexion à la base de données.
 * @param $login (string) Ancien nom d'utilisateur.
 * @param $newLogin (string) Nouveau nom d'utilisateur.
 * @return Message de confirmation (string).
 */
function setLogin($link, $login, $newLogin)
{
	$query="UPDATE Utilisateur SET login ='" . $newLogin . "' WHERE login='" . $login . "';";
	executeQuery($link, $query);
	$query1="UPDATE Photo SET auteur ='" . $newLogin . "' WHERE auteur='" . $login . "';";
	executeQuery($link, $query1);
	$_SESSION['user']=$newLogin;
	return "<p>Identifiant modifié.</p>";
}

/**
 * @brief Mutateur au mot de passe de connexion de l'utilisateur.
 * Permet de modifier le mot de passe de l'utilisateur connecté grâce à une requete SQL.
 * Cette fonction est utilisée dans compte.php.
 * @param $link (mysqli) Connexion à la base de données.
 * @param $user (string) Nom d'utilisateur.
 * @param $pwd (string) ancien mot de passe.
 * @param $newPwd (string) Nouveau de passe. 
 * @param $newPwd1 (string) Confirmation nouveau mot de passe.
 * @return Message de confirmation (string).
 */
function setPwd($link, $user, $pwd, $newPwd, $newPwd1)
{
	$query="SELECT mdp FROM Utilisateur WHERE login='" . $user . "';";
	$verifPwd = mysqli_fetch_array(executeQuery($link,$query))[0];
	if($verifPwd == $pwd)
	{
		if($newPwd == $newPwd1)
		{
			$query1="UPDATE Utilisateur SET mdp ='" . $newPwd . "' WHERE login='" . $user . "';";
			executeQuery($link, $query1);
			$str = "<p>Mot de passe modifié.</p>";
		}
		else
		{
			$str = "<p>Les deux mots de passe ne correspondent pas.</p>";
		}
	}
	else
	{
		$str = "<p>Mot de passe incorrect.</p>";
	}
	return $str;
}

/**
 * @brief Accesseur au nom de l'auteur d'une photo.
 * @param $link (mysqli) Connexion à la base de données.
 * @param $name (string) Nom d'une photo. 
 * @return Nom de l'auteur (string).
 */
function getAuthor($link,$name)
{
	$query="SELECT auteur FROM Photo WHERE nomFich='" . $name . "';";
	$auteur=executeQuery($link,$query);
	return mysqli_fetch_array($auteur)[0];
}

/**
 * @brief Accesseur à l'identifiant et au nom de toutes les catégories présentes dans la base de données.
 * @param $link (mysqli) Connexion à la base de données.
 * @return Tableau d'identifiants et de noms des catégories (array).
 */
function getCategories($link)
{
	$query="SELECT catId, nomCat FROM Categorie;";
	$categories=executeQuery($link,$query);
	$strcat="";
	for($i=0;$i<$categories->num_rows;++$i)
	{
		$curRow=mysqli_fetch_array($categories);
		$strcat.="<option value=\"".$curRow[0]."\">".$curRow[1]."</option>";
	}
	return $strcat;
}

/**
 * @brief Mutateur à la description d'une photo.
 * Cette foncion est utilisée dans description.php.
 * @param $link (mysqli) Connexion à la base de données.
 * @param $photo (string) Nom de la photo.
 * @param $newDescription (string) Nouvelle description de la photo.
 */
function setDescription($link, $photo, $newDescription)
{
	$query="UPDATE Photo SET Description ='" . $newDescription . "' WHERE nomFich='" . $photo . "';";
	executeQuery($link, $query);
	header("Refresh:0");
}

/**
 * @brief Mutateur à la catégorie d'une photo.
 * Cette foncion est utilisée dans description.php.
 * @param $link (mysqli) Connexion à la base de données.
 * @param $photo (string) Nom de la photo.
 * @param $newCategorie (int) Nouvel identifiant de catégorie de la photo.
 */
function setCategorie($link, $photo, $newCategorie)
{
	$query="UPDATE Photo SET catId ='" . $newCategorie . "' WHERE nomFich='" . $photo . "';";
	executeQuery($link, $query);
	header("Refresh:0");
}

/**
 * @brief Permet d'effacer une photo de la base de données. 
 * Efface la photo puis redirige vers l'acceuil.
 * Cette foncion est utilisée dans description.php.
 * @param $link (mysqli) Connexion à la base de données.
 * @param $photo (string) Nom de la photo.
 */
function effacerPhoto($link, $photo)
{
	$query="DELETE FROM Photo WHERE nomFich='" . $photo . "';";
	executeQuery($link, $query);
	$lienServeur= './assets/images/' . $photo;
	unlink($photo, $lienServeur);
	header('Location: https://bdw1.univ-lyon1.fr/p1908800/projet/index.php');
}

?>