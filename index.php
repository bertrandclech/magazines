<?php

// Récupérer les fonctions
require_once 'fonctions.php';

$success_delete = false;

// Suppression d'un magazine
// Vérifie si un id est envoyé et si une variable $type est bien envoyée
if (!empty($_GET['id']) && !empty($_GET['type']) && $_GET['type'] === 'supprimer') {
	// Suppression du magazine en BDD
	deleteMagazineById($_GET['id']);
	$success_delete = true;
}

// Récupération de tous les magazines
$magazines = getAllMagazines();

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Liste des magazines</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	</head>
	<body>
		<div class="container p-5">
			<h1>Liste des magazines</h1>

            <a href="ajouter.php" class="btn btn-primary mt-2">Ajouter un magazine</a>

            <?php

			if ($success_delete) {
				echo '<div class="alert alert-success" role="alert">Magazine bien supprimé !</div>';
            }

            ?>

            <table class="table table-striped mt-5">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom du magazine</th>
                        <th>Nom de l'éditeur</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>

                <?php foreach ($magazines as $magazine): ?>
                    <tr>
                        <td><?php echo $magazine['id']; ?></td>
                        <td><?php echo $magazine['nom']; ?></td>
                        <td><?php echo $magazine['nom_editeur']; ?></td>
                        <td class="text-right">
                            <a href="details.php?id=<?php echo $magazine['id']; ?>" class="btn btn-warning">Voir le détail</a>
                            <a href="editer.php?id=<?php echo $magazine['id']; ?>" class="btn btn-primary">Mettre à jour</a>
                            <a href="index.php?id=<?php echo $magazine['id']; ?>&type=supprimer" class="btn btn-danger">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>

                </tbody>
            </table>
		</div>
	</body>
</html>
