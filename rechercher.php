<?php

// Récupérer les fonctions
require_once 'fonctions.php';

// Récupère tous les éditeurs
$editeurs = getAllEditor();

$min = getMinPrice();
$max = getMaxPrice();

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Recherche parmi les magazines</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
<div class="container p-5">
	<h1>Recherche parmi les magazine</h1>

	<form method="get" action="rechercher.php" class="mt-5" enctype="multipart/form-data" novalidate>
		<div class="form-group">
			<label>Nom du magazine</label>
			<input type="text" class="form-control" name="nom"/>
		</div>
		<div class="form-group">
			<label>Description</label>
			<input type="text" name="description" rows="10" class="form-control"/       >
		</div>
		<div class="form-group">
			<label>Prix</label>
			<div class="input-group">
				<input type="number" step = "0.01" class="form-control" name="prix-min" value="<?php echo $min ?>">
				<div class="input-group-append">
					<div class="input-group-text">€</div>
				</div>
                <input type="number" step = "0.01" class="form-control" name="prix-max" value="<?php echo $max ?>">
				<div class="input-group-append">
					<div class="input-group-text">€</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label>Editeur</label>
				<?php foreach ($editeurs as $editeur): ?>
                    <div>
                       <label> <?php echo($editeur['nom']) ?></label>
                        <input type="radio" name="editeur_id" value="<?php echo $editeur['nom']     ?>">
                    </div>
                <?php endforeach; ?>
		</div>
		<input type="submit" class="btn btn-primary" name="submit" value="Rechercher">
	</form>

<?php
    if (isset($_GET['submit'])  ) {

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

                <?php 
                    $magazines = rechercheMagazines($_GET);
                    foreach ($magazines as $magazine): ?>
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
 <?php           
    }
?>
</div>
</body>
</html>
