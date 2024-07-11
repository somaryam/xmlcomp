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

// Traitement de la modification d'un restaurant
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] === 'edit') {
    $restaurantId = $_POST['restaurant_id'];

    // Recherche du restaurant à modifier
    $restaurantToEdit = $xml->xpath("//restaurant[@id='$restaurantId']");

    // Vérifier si le restaurant existe
    if (!empty($restaurantToEdit)) {
        $restaurantToEdit = $restaurantToEdit[0];

        // Mettre à jour les données du restaurant
        $restaurantToEdit->nom = $_POST['nom'];
        $restaurantToEdit->coordonnees = $_POST['coordonnees'];
        $restaurantToEdit->adresse = $_POST['adresse'];
        $restaurantToEdit->restaurateur = $_POST['restaurateur'];
        $restaurantToEdit->description = $_POST['description'];

        // Mise à jour de la carte des plats
        $restaurantToEdit->carte = null; // Supprime les plats existants
        $carte = $restaurantToEdit->addChild('carte');

        for ($i = 1; $i <= $_POST['nombre_plats']; $i++) {
            if (!empty($_POST['plat_nom' . $i]) && !empty($_POST['plat_type' . $i]) && !empty($_POST['plat_prix' . $i])) {
                $plat = $carte->addChild('plat');
                $plat->addChild('nom', $_POST['plat_nom' . $i]);
                $plat->addChild('type', $_POST['plat_type' . $i]);
                $plat->addChild('prix', $_POST['plat_prix' . $i]);
                if (!empty($_POST['plat_description' . $i])) {
                    $plat->addChild('description', $_POST['plat_description' . $i]);
                }
            }
        }

        // Sauvegarde du fichier XML
        $xml->asXML($xmlFile);

        // Redirection vers la page d'administration après modification
        header('Location: admin.php');
        exit;
    } else {
        die('Restaurant non trouvé.');
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un Restaurant</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Modifier un Restaurant</h1>

        <!-- Formulaire de modification de restaurant -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <input type="hidden" name="action" value="edit">

            <label for="restaurant_id">Choisir un Restaurant:</label><br>
            <select name="restaurant_id" id="restaurant_id">
                <?php foreach ($xml->restaurant as $restaurant): ?>
                    <option value="<?php echo $restaurant['id']; ?>"><?php echo $restaurant->nom; ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Charger</button><br><br>

            <!-- Champs de modification du restaurant -->
            <label for="nom">Nom:</label><br>
            <input type="text" id="nom" name="nom" required><br><br>

            <label for="coordonnees">Coordonnées:</label><br>
            <input type="text" id="coordonnees" name="coordonnees"><br><br>

            <label for="adresse">Adresse:</label><br>
            <input type="text" id="adresse" name="adresse"><br><br>

            <label for="restaurateur">Restaurateur:</label><br>
            <input type="text" id="restaurateur" name="restaurateur"><br><br>

            <label for="description">Description:</label><br>
            <textarea id="description" name="description"></textarea><br><br>

            <label for="nombre_plats">Nombre de plats:</label>
            <input type="number" id="nombre_plats" name="nombre_plats" min="1" value="1"><br><br>

            <!-- Champs de plats variables -->
            <div id="plats">
                <script>
                    // Script pour ajouter dynamiquement des champs de plats
                    var nombrePlats = 1;

                    function addPlat() {
                        nombrePlats++;
                        var divPlats = document.getElementById('plats');

                        var newDiv = document.createElement('div');
                        newDiv.innerHTML = `
                            <label for="plat_nom${nombrePlats}">Nom du Plat ${nombrePlats}:</label>
                            <input type="text" id="plat_nom${nombrePlats}" name="plat_nom${nombrePlats}" required>
                            <label for="plat_type${nombrePlats}">Type du Plat ${nombrePlats}:</label>
                            <input type="text" id="plat_type${nombrePlats}" name="plat_type${nombrePlats}" required>
                            <label for="plat_prix${nombrePlats}">Prix du Plat ${nombrePlats}:</label>
                            <input type="text" id="plat_prix${nombrePlats}" name="plat_prix${nombrePlats}" required>
                            <label for="plat_description${nombrePlats}">Description du Plat ${nombrePlats}:</label>
                            <input type="text" id="plat_description${nombrePlats}" name="plat_description${nombrePlats}">
                            <br><br>
                        `;

                        divPlats.appendChild(newDiv);
                    }
                </script>
                <button type="button" onclick="addPlat()">Ajouter un Plat</button><br><br>
            </div>

            <button type="submit">Enregistrer les Modifications</button>
        </form>
    </div> <!-- Fin div .container -->
</body>
</html>
