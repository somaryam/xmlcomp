<?php
session_start();

// Vérifier si l'utilisateur est connecté
if(!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    header("Location: login.php"); // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    exit;
}

// Déconnexion de l'utilisateur
if(isset($_GET['logout'])) {
    session_destroy(); // Détruire toutes les données de session
    header("Location: login.php"); // Rediriger vers la page de connexion après déconnexion
    exit;
}

// Code PHP pour le chargement et l'affichage des films à partir du fichier XML
$cinemaXmlFile = 'XML/cinema.xml';
$cinemaXml = simplexml_load_file($cinemaXmlFile);

// Vérification du chargement du fichier XML des films
if ($cinemaXml === false) {
    die('Erreur lors du chargement du fichier XML des films.');
}

// Code PHP pour le chargement et l'affichage des restaurants à partir du fichier XML
$restaurantXmlFile = 'XML/restaurant.xml';
$restaurantXml = simplexml_load_file($restaurantXmlFile);

// Vérification du chargement du fichier XML des restaurants
if ($restaurantXml === false) {
    die('Erreur lors du chargement du fichier XML des restaurants.');
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Administration des Films et Restaurants</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Administration des Films et Restaurants</h1>

        <!-- Bouton de déconnexion -->
        <div style="text-align: right; margin-bottom: 10px;">
            <a href="?logout=true">Déconnexion</a>
        </div>

        <!-- Section Films -->
        <div class="section">
            <h2>Administration des Films</h2>
            <!-- Image -->
            <div class="image-container">
                <img src="imagescinoch/cinoch.jpg" alt="Cinéma">
            </div>
            <!-- Liens vers les différentes fonctionnalités des films -->
            <ul>
                <li><a href="addfilm.php">Ajouter un Film</a></li>
                <li><a href="editfilm.php">Modifier un Film</a></li>
                <li><a href="deletefilm.php">Supprimer un Film</a></li>
            </ul>
            <!-- Affichage des films -->
            <h3>Liste des Films</h3>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Titre</th>
                    <th>Année</th>
                    <th>Actions</th>
                </tr>
                <?php
                // Affichage des films à partir du XML chargé
                foreach ($cinemaXml->film as $film) {
                    echo '<tr>';
                    echo '<td>' . $film['id'] . '</td>';
                    echo '<td>' . $film->titre . '</td>';
                    echo '<td>' . $film->annee . '</td>';
                    echo '<td><a href="editfilm.php?id=' . $film['id'] . '">Modifier</a> | <a href="deletefilm.php?id=' . $film['id'] . '">Supprimer</a></td>';
                    echo '</tr>';
                }
                ?>
            </table>
        </div>

        <!-- Section Restaurants -->
        <div class="section">
            <h2>Administration des Restaurants</h2>
            <!-- Image -->
            <div class="image-container">
                <img src="imagesresto/avatarf.jpg" alt="Restaurant">
            </div>
            <!-- Liens vers les différentes fonctionnalités des restaurants -->
            <ul>
                <li><a href="addrestaurant.php">Ajouter un Restaurant</a></li>
                <li><a href="editrestaurant.php">Modifier un Restaurant</a></li>
                <li><a href="deleterestaurant.php">Supprimer un Restaurant</a></li>
            </ul>
            <!-- Affichage des restaurants -->
            <h3>Liste des Restaurants</h3>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Adresse</th>
                    <th>Actions</th>
                </tr>
                <?php
                // Affichage des restaurants à partir du XML chargé
                foreach ($restaurantXml->restaurant as $restaurant) {
                    echo '<tr>';
                    echo '<td>' . $restaurant['id'] . '</td>';
                    echo '<td>' . $restaurant->nom . '</td>';
                    echo '<td>' . $restaurant->adresse . '</td>';
                    echo '<td><a href="editrestaurant.php?id=' . $restaurant['id'] . '">Modifier</a> | <a href="deleterestaurant.php?id=' . $restaurant['id'] . '">Supprimer</a></td>';
                    echo '</tr>';
                }
                ?>
            </table>
        </div>
    </div>
</body>
</html>
