<?php

// Récupérer les fonctions
require_once 'fonctions.php';

// Récupération des information d'un magazine
$magazine = getMagazineById($_GET['id']);

// Si le magazine n'existe pas, redirection vers la liste des magazines
if (!$magazine) {
    header('Location: index.php');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Détails d'un magazine</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
<div class="container p-5">
	<h1>Détails de "<?php echo $magazine['nom'] ?>"</h1>

    <a href="index.php" class="btn btn-secondary mt-2">Retour à la liste</a>

	<div class="row mt-5">
        <div class="col-2">
            <img src="images/<?php echo $magazine['image'] ?>" alt="<?php echo $magazine['nom'] ?>" class="img-fluid">
        </div>
        <div class="col-10">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Description</th>
                        <th>Prix</th>
                        <th>Nom éditeur</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo $magazine['id'] ?></td>
                        <td><?php echo $magazine['nom'] ?></td>
                        <td><?php echo $magazine['description'] ?></td>
                        <td><?php echo $magazine['prix'] ?>€</td>
                        <td><?php echo $magazine['nom_editeur'] ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
