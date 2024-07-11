<?php
session_start();

// Vérifier si l'utilisateur est connecté
if(!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    header("Location: login.php");
    exit;
}

$xmlFile = 'XML/restaurant.xml';

// Chargement du fichier XML
$xml = simplexml_load_file($xmlFile);

// Vérification du chargement du fichier
if ($xml === false) {
    die('Erreur lors du chargement du fichier XML.');
}

// Suppression d'un restaurant
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] === 'delete') {
    $idToDelete = $_POST['id'];

    // Recherche du restaurant par son ID
    $restaurantToDelete = null;
    foreach ($xml->restaurant as $restaurant) {
        if ($restaurant['id'] == $idToDelete) {
            $restaurantToDelete = $restaurant;
            break;
        }
    }

    // Si le restaurant est trouvé, le supprimer
    if ($restaurantToDelete) {
        $domRestaurant = dom_import_simplexml($restaurantToDelete);
        if ($domRestaurant && $domRestaurant->parentNode) {
            $domRestaurant->parentNode->removeChild($domRestaurant);
        }

        // Sauvegarde du fichier XML
        $xml->asXML($xmlFile);

        // Redirection vers la page d'administration après suppression
        header('Location: admin.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Administration des Restaurants</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Administration des Restaurants</h1>

        <!-- Tableau des restaurants -->
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Adresse</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($xml->restaurant as $restaurant): ?>
                <tr>
                    <td><?php echo $restaurant->nom; ?></td>
                    <td><?php echo $restaurant->adresse; ?></td>
                    <td>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="id" value="<?php echo $restaurant['id']; ?>">
                            <button type="submit">Supprimer</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div> <!-- Fin div .container -->
</body>
</html>
