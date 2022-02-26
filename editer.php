<?php

// Récupérer les fonctions
require_once 'fonctions.php';

// Récupère tous les éditeurs
$editeurs = getAllEditor();

// Récupérer les informations d'un magazine
$magazine = getMagazineById($_GET['id']);

// Vérifie si des données existent
if (!$magazine) {
    header('Location: index.php');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Edition d'un magazine</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
<div class="container p-5">
	<h1>Edition de magazine</h1>

	<?php

	// Si le bouton "Valider" est cliqué, on commence l'insertion en BDD
	if (isset($_POST['submit'])) {

		// Contient les différents "name" des inputs du formulaire à vérifier (hormis l'image)
		$champs = ['nom', 'description', 'prix', 'editeur_id'];

		// Vérifie que tous les champs sont bien remplis
		if (isNotEmpty($_POST, $champs)) {

			// Vérifie si le prix est bien numérique
			if (is_numeric($_POST['prix'])) {

			    $nom_image = $_POST['old_image'];

				// Si une image est envoyée, effectuer les vérifications nécessaires
				if (!empty($_FILES['image']['name'])) {

					$extension = verifPicture($_FILES['image']);

					// Si par d'erreur dans la vérification de l'image, on upload
					if ($extension) {
						// Upload de l'image
						$nom_image = uploadImage($_FILES['image'], $_POST['nom'], $_GET['id'], $extension);

						// Suppression de l'ancienne image
						unlink('images/'. $_POST['old_image']);
					}
					else {
						echo '<div class="alert alert-danger" role="alert">Image invalide !</div>';
					}
				}

                // Mise à jour en base de données
				updateMagazineById($_GET['id'], $_POST, $nom_image);

				// Récupère les nouvelles valeurs du magazine
				$magazine = getMagazineById($_GET['id']);

				echo '<div class="alert alert-success" role="alert">Magazine correctement mis à jour !</div>';
			}
			else {
				echo '<div class="alert alert-danger" role="alert">Le prix est invalide !</div>';
			}
		}
		else {
			echo '<div class="alert alert-danger" role="alert">Tous les champs sont obligatoires !</div>';
		}
	}

	?>

	<form method="post" class="mt-5" enctype="multipart/form-data" novalidate>
		<div class="form-group">
			<label>Nom du magazine</label>
			<input type="text" class="form-control" name="nom" value="<?php echo $magazine['nom'] ?>">
		</div>
		<div class="form-group">
			<label>Description</label>
			<textarea name="description" rows="10" class="form-control"><?php echo $magazine['description'] ?></textarea>
		</div>
		<div class="form-group">
			<label>Prix</label>
			<div class="input-group">
				<input type="text" class="form-control" name="prix" value="<?php echo $magazine['prix'] ?>">
				<div class="input-group-append">
					<div class="input-group-text">€</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label>Image</label>
			<div class="custom-file">
				<input type="file" class="custom-file-input" name="image">
				<label class="custom-file-label">Choisir une image</label>
			</div>
            <img src="images/<?php echo $magazine['image'] ?>" alt="<?php echo $magazine['nom'] ?>" class="img-fluid w-25">
            <input type="hidden" name="old_image" value="<?php echo $magazine['image'] ?>">
		</div>
		<div class="form-group">
			<label>Editeur</label>
			<select name="editeur_id" class="custom-select">
				<?php foreach ($editeurs as $editeur): ?>
					<option value="<?php echo $editeur['id'] ?>" <?php if($editeur['id'] === $magazine['editeur_id']) { echo 'selected'; } ?>><?php echo $editeur['nom'] ?></option>
				<?php endforeach; ?>
			</select>
		</div>
		<a href="index.php" class="btn btn-outline-secondary">Annuler</a>
		<input type="submit" class="btn btn-primary" name="submit" value="Modifier">
	</form>
</div>
</body>
</html>
