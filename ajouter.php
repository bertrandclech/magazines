<?php

// Récupérer les fonctions
require_once 'fonctions.php';

// Récupère tous les éditeurs
$editeurs = getAllEditor();

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Nouveau magazine</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	</head>
	<body>
		<div class="container p-5">
			<h1>Nouveau magazine</h1>

            <?php

            // Si le bouton "Valider" est cliqué, on commence l'insertion en BDD
            if (isset($_POST['submit'])) {

                // Contient les différents "name" des inputs du formulaire à vérifier (hormis l'image)
				$champs = ['nom', 'description', 'prix', 'editeur_id'];

				// Vérifie que tous les champs sont bien remplis
				if (isNotEmpty($_POST, $champs) && !empty($_FILES['image']) && $_FILES['image']['error'] == 0) {

				    // Vérifie si le prix est bien numérique
					str_replace(',','.',strval($_POST['prix']));
	
                   	if ( is_numeric($_POST['prix']) && checkPriceInRange(floatval($_POST['prix']), 0, 1000) ) {
					//	if ( is_numeric($_POST['prix']) ) {
                        // Vérifie les caractéristiques de l'image
                        $extension = verifPicture($_FILES['image']);
                        if ($extension) {

                            // Insertion en BDD avec récupération de l'ID
                            $lastId = insertMagazine($_POST);

                            // Upload de l'image
                            $nom_image = uploadImage($_FILES['image'], $_POST['nom'], $lastId, $extension);

                            // Met à jour le nom de l'image en BDD
                            updateMagazineById($lastId, $_POST, $nom_image);

							echo '<div class="alert alert-success" role="alert">Magazine bien enregistré !</div>';
                        }
                        else {
							echo '<div class="alert alert-danger" role="alert">Image invalide !</div>';
                        }
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
					<input type="text" class="form-control" name="nom">
				</div>
				<div class="form-group">
					<label>Description</label>
					<textarea name="description" rows="10" class="form-control"></textarea>
				</div>
				<div class="form-group">
					<label>Prix</label>
					<div class="input-group">
						<input type="number" step="0.01"	 class="form-control" name="prix">
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
				</div>
				<div class="form-group">
					<label>Editeur</label>
                    <select name="editeur_id" class="custom-select">
                        <?php foreach ($editeurs as $editeur): ?>
                            <option value="<?php echo $editeur['id'] ?>"><?php echo $editeur['nom'] ?></option>
                        <?php endforeach; ?>
                    </select>
				</div>
				<a href="index.php" class="btn btn-outline-secondary">Annuler</a>
				<input type="submit" class="btn btn-primary" name="submit" value="Valider">
			</form>
		</div>
	</body>
</html>
