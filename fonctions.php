<?php

/**
 * Fonctions pour mon application "Magazine"
 */

// Inclure la connexion à la base de données
require_once 'bdd.php';


/**
 * Vérifie si les champs d'un formulaire sont remplis
 *
 * @param $post array
 * @param $champs array
 * @return bool
 */
function isNotEmpty($post, $champs)
{
	foreach ($champs as $champ) {
		if (!isset($post[$champ]) || empty($post[$champ])) {
			return false;
		}
	}

	return true;
}

function checkPriceInRange($prix, $min, $max)
{
	if ( ($prix >= $min) && ($prix <= $max) ) {
		return true;
	}  
	else {
		return false;
	}
}


/**
 * Vérifie les caractéristiques d'une image
 *
 * @param $file
 * @return bool|string|string[]
 */
function verifPicture($file)
{
	$taille_max = 2 * 1024 * 1024; // 2Mo
	$type_image = [
		'jpg' => 'image/jpeg',
		'jpeg' => 'image/jpeg',
		'png' => 'image/png',
		'gif' => 'image/gif'
	];

	// $file['name'] => $_FILES['image']['name']
	$extension = pathinfo($file['name'], PATHINFO_EXTENSION);
	if (array_key_exists(strtolower($extension), $type_image)) {

		// Vérifie le type MIME du fichier
		if (in_array($file['type'], $type_image)) {

			// Vérifie le poids de l'image
			if ($file['size'] <= $taille_max) {
				return $extension;
			}
			else {
				return false;
			}
		}
		else {
			return false;
		}
	}
	else {
		return false;
	}
}

/**
 * Upload d'image
 *
 * @param $file
 * @param $nom
 * @param $id
 * @param $extension
 * @return string
 */
function uploadImage($file, $nom, $id, $extension)
{
	// Formatte le nom du magazine de façon a retirer les espaces et les caractères spéciaux
	$slug = preg_replace('/[^A-Za-z0-9-]/', '-', $nom);

	// Formatte le nouveau nom
	// mon-titre-magazine_12.png
	$nouveau_nom = $slug .'_'. $id .'.'. $extension;

	// Upload l'image avec le nouveau nom
	move_uploaded_file($file['tmp_name'], 'images/'. $nouveau_nom);

	return $nouveau_nom;
}

/**
 * Retourne tous les magazines
 *
 * @return array
 */
function getAllMagazines()
{
	// Je récupère ma connexion à la base de données
	global $db;

	// J'effectue ma requête SQL permettant de récupérer les informations nécessaires
	$requete = $db->query("SELECT magazine.id, magazine.nom, editeur.nom AS nom_editeur FROM magazine INNER JOIN editeur ON editeur.id = magazine.editeur_id");

	// Je retourne toutes les valeurs récupérées par ma requête du dessus
	return $requete->fetchAll();
}

/**
 * Récupère les informations d'un magazine
 *
 * @param $id
 * @return mixed
 */
function getMagazineById($id)
{
	// Je récupère ma connexion à la base de données
	global $db;

	// Préparation de ma requête SQL
	$requete = $db->prepare("SELECT magazine.id, magazine.nom, magazine.description, magazine.prix, magazine.image, magazine.editeur_id, editeur.nom AS nom_editeur FROM magazine INNER JOIN editeur ON editeur.id = magazine.editeur_id WHERE magazine.id = :id");
	$requete->bindValue(':id', $id, PDO::PARAM_INT);
	$requete->execute();

	// Retourne les informations trouvées
	return $requete->fetch();
}

/**
 * Récupère tous les éditeurs
 */
function getAllEditor()
{
	global $db;

	$requete = $db->query("SELECT * FROM editeur");

	return $requete->fetchAll();
}

/**
 * Insère un nouveau magazine en BDD
 *
 * @param $post
 * @return string
 */
function insertMagazine($post)
{
	global $db;

	// Préparation de la requête
	$requete = $db->prepare("INSERT INTO magazine (nom, description, prix, image, editeur_id) VALUES (:nom, :description, :prix, :image, :editeur_id)");

	// Passage des valeurs à la requête
	$requete->bindValue(':nom', $post['nom'], PDO::PARAM_STR);
	$requete->bindValue(':description', $post['description'], PDO::PARAM_STR);
	$requete->bindValue(':prix', $post['prix'], PDO::PARAM_STR);
	$requete->bindValue(':image', 'image.png', PDO::PARAM_STR);
	$requete->bindValue(':editeur_id', $post['editeur_id'], PDO::PARAM_INT);

	// Execute
	$requete->execute();

	// Retourne l'ID du magazine inséré en BDD
	return $db->lastInsertId();
}

/**
 * Mise à jour d'un magazine en BDD
 *
 * @param $id
 * @param $post
 * @param $image
 * @return bool
 */
function updateMagazineById($id, $post, $image)
{
	global $db;

	// Prépare la requête pour une mise à jour des données
	$requete = $db->prepare("UPDATE magazine SET nom = :nom, description = :description, prix = :prix, image = :image, editeur_id = :editeur_id WHERE id = :id");

	// Passage des paramètres à la requête
	$requete->bindValue(':nom', $post['nom'], PDO::PARAM_STR);
	$requete->bindValue(':description', $post['description'], PDO::PARAM_STR);
	$requete->bindValue(':prix', $post['prix'], PDO::PARAM_STR);
	$requete->bindValue(':image', $image, PDO::PARAM_STR);
	$requete->bindValue(':editeur_id', $post['editeur_id'], PDO::PARAM_INT);
	$requete->bindValue(':id', $id, PDO::PARAM_INT);

	$requete->execute();

	return true;
}

/**
 * Suppression d'un magazine
 */
function deleteMagazineById($id)
{
	global $db;

	// Récupère les informations du magazine à supprimer
	$magazine = getMagazineById($id);

	// Supprime le magazine en BDD
	$requete = $db->prepare("DELETE FROM magazine WHERE id = :id");
	$requete->bindValue(':id', $id, PDO::PARAM_INT);
	$requete->execute();

	// Supprime l'image de ce même magazine sur le serveur
	unlink('images/'. $magazine['image']);

	return true;
}
