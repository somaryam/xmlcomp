<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
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
    $restaurantId = $_POST['restaurant_id'];

    // Recherche du restaurant à supprimer
    $restaurantToDelete = $xml->xpath("//restaurant[@id='$restaurantId']");

    // Vérifier si le restaurant existe
    if (!empty($restaurantToDelete)) {
        // Supprimer le restaurant
        $domToDelete = dom_import_simplexml($restaurantToDelete[0]);
        if ($domToDelete && $domToDelete->parentNode) {
            $domToDelete->parentNode->removeChild($domToDelete);

            // Sauvegarde du fichier XML
            $xml->asXML($xmlFile);

            // Redirection vers la page d'administration après suppression
            header('Location: admin.php');
            exit;
        } else {
            die('Erreur lors de la suppression du restaurant.');
        }
    } else {
        die('Restaurant non trouvé.');
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Supprimer un Restaurant</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Supprimer un Restaurant</h1>

        <!-- Formulaire de sélection du restaurant à supprimer -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <input type="hidden" name="action" value="delete">

            <label for="restaurant_id">Choisir un Restaurant:</label><br>
            <select name="restaurant_id" id="restaurant_id">
                <?php foreach ($xml->restaurant as $restaurant): ?>
                    <option value="<?php echo $restaurant['id']; ?>"><?php echo $restaurant->nom; ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Supprimer</button>
        </form>
    </div> <!-- Fin div .container -->
</body>
</html>
