<?php
// Chargement à nouveau du fichier XML pour afficher les restaurants
$xml = simplexml_load_file('XML/restaurant.xml');

// Vérification du chargement du fichier
if ($xml === false) {
    die('Erreur lors du chargement du fichier XML.');
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Restaurants</title>
    <link rel="stylesheet" href="design.css">
    <style>
       
    </style>
</head>
<body>
    <div class="container">
        <h1>Liste des Restaurants</h1>
        <!-- Liste des restaurants existants -->
        <div class="restaurant-list">
            <?php foreach ($xml->restaurant as $restaurant): ?>
                <div class="restaurant">
                    <h2><?php echo $restaurant->nom; ?></h2>
                    <img src="<?php echo $restaurant->image['url']; ?>" alt="<?php echo $restaurant->nom; ?>">
                    <p><strong>Adresse:</strong> <?php echo $restaurant->adresse; ?></p>
                    <p><strong>Nom du Restaurateur:</strong> <?php echo $restaurant->nom_restaurateur; ?></p>
                    <?php if (isset($restaurant->coordonnees)): ?>
                        <div>
                            <strong>Coordonnées:</strong>
                            <ul>
                                <?php foreach ($restaurant->coordonnees->coordonee as $coordonee): ?>
                                    <li><strong><?php echo $coordonee->type; ?>:</strong> <?php echo $coordonee->valeur; ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    <div>
                        <strong>Description:</strong>
                        <p><?php echo $restaurant->description; ?></p>
                    </div>
                    <!-- Affichage de la carte des plats -->
                    <h3>Carte des Plats</h3>
                    <ul>
                        <?php foreach ($restaurant->carte->plat as $plat): ?>
                            <li>
                                <strong><?php echo $plat->nom; ?></strong><br>
                                <strong>Partie:</strong> <?php echo $plat->partie; ?><br>
                                <strong>Prix:</strong> <?php echo $plat->prix; ?><br>
                                <?php if (isset($plat->description)): ?>
                                    <p><?php echo $plat->description; ?></p>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <!-- Affichage des menus -->
                    <h3>Menus</h3>
                    <ul>
                        <?php if (isset($restaurant->menus)): ?>
                            <?php foreach ($restaurant->menus->menu as $menu): ?>
                                <li>
                                    <strong><?php echo $menu->titre; ?></strong><br>
                                    <?php if (isset($menu->description)): ?>
                                        <p><?php echo $menu->description; ?></p>
                                    <?php endif; ?>
                                    <strong>Prix:</strong> <?php echo $menu->prix; ?><br>
                                    <ul>
                                        <?php foreach ($menu->elements->element as $element): ?>
                                            <li><?php echo $element; ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </div>
            <?php endforeach; ?>
        </div>
    </div> <!-- Fin div .container -->
</body>
</html>
