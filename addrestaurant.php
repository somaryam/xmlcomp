<?php
session_start();

// Vérifier si l'utilisateur est connecté
if(!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    header("Location: login.php");
    exit;
}

// Charger le fichier XML
$xmlFile = 'XML/restaurant.xml';
if (!file_exists($xmlFile)) {
    die("Erreur : Le fichier XML n'existe pas.");
}
$xml = simplexml_load_file($xmlFile);
if ($xml === false) {
    die("Erreur lors du chargement du fichier XML.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $id = $_POST['id'];
    $nom = $_POST['nom'];
    $coordonnees = $_POST['coordonnees'];
    $adresse = $_POST['adresse'];
    $restaurateur = $_POST['restaurateur'];
    $description = $_POST['description'];
    $carte = $_POST['carte'];
    $menus = $_POST['menus'];

    // Vérifier que toutes les données obligatoires sont présentes
    if (empty($id) || empty($nom) || empty($adresse) || empty($restaurateur)) {
        die("Erreur : Tous les champs obligatoires ne sont pas remplis.");
    }

    // Ajouter un nouvel élément restaurant
    $newRestaurant = $xml->addChild('restaurant');
    $newRestaurant->addAttribute('id', $id);
    $newRestaurant->addChild('nom', $nom);
    $newRestaurant->addChild('coordonnees', $coordonnees);
    $newRestaurant->addChild('adresse', $adresse);
    $newRestaurant->addChild('restaurateur', $restaurateur);

    $descriptionNode = $newRestaurant->addChild('description');
    $descriptionNode[0] = $description;

    $carteNode = $newRestaurant->addChild('carte');
    $carteNode[0] = $carte;

    $menusNode = $newRestaurant->addChild('menus');
    $menusNode[0] = $menus;

    // Enregistrer les modifications dans le fichier XML
    $result = $xml->asXML($xmlFile);
    if ($result === false) {
        die("Erreur lors de l'enregistrement des modifications dans le fichier XML.");
    }

    // Rediriger vers la page d'administration
    header("Location: admin.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un Restaurant</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Ajouter un Restaurant</h1>
        <form action="addrestaurant.php" method="post">
            <label for="id">ID :</label>
            <input type="text" id="id" name="id" required><br>

            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" required><br>

            <label for="coordonnees">Coordonnées :</label>
            <input type="text" id="coordonnees" name="coordonnees"><br>

            <label for="adresse">Adresse :</label>
            <input type="text" id="adresse" name="adresse" required><br>

            <label for="restaurateur">Restaurateur :</label>
            <input type="text" id="restaurateur" name="restaurateur" required><br>

            <label for="description">Description :</label>
            <textarea id="description" name="description"></textarea><br>

            <label for="carte">Carte :</label>
            <textarea id="carte" name="carte"></textarea><br>

            <label for="menus">Menus :</label>
            <textarea id="menus" name="menus"></textarea><br>

            <input type="submit" value="Ajouter">
        </form>
    </div>
</body>
</html>
