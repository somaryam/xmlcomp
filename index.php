<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - Portail Cinéma et Restaurants</title>
    <link rel="stylesheet" href="styles.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Custom styles -->
    <style>
        .film-list .film,
        .restaurant-list .restaurant {
            margin-bottom: 20px; /* Espacement entre les films ou restaurants */
            padding: 10px;
            border: 1px solid #ccc;
            text-align: center; /* Centrer le contenu */
        }

        .film-list .film img,
        .restaurant-list .restaurant img {
            max-width: 100%;
            height: auto;
        }

        .synopsis {
            text-align: left;
            padding: 10px;
        }
    </style>
</head>
<body class="dark-mode">
    <div class="container">
        <header>
            <h1>Bienvenue sur notre portail</h1>
            <p>Découvrez notre sélection de films et de restaurants.</p>
        </header>
        <main>
            <section class="section-links">
                <a href="cinema.php" class="button">Voir les films à l'affiche</a>
                <a href="restaurant.php" class="button">Découvrir nos restaurants</a>
            </section>
            <section class="section-featured">
                <h2>Films à l'affiche</h2>
                <div class="film-list row justify-content-center"> <!-- Centrer les éléments -->
                    <div id="film-carousel" class="carousel slide col-12" data-ride="carousel">
                        <div class="carousel-inner">
                            <?php
                            // Chargement du fichier XML pour les films
                            $xml_films = simplexml_load_file('XML/cinema.xml');

                            // Vérification du chargement du fichier des films
                            if ($xml_films === false) {
                                echo "Erreur lors du chargement du fichier XML des films.";
                            } else {
                                // Affichage des films à l'affiche
                                $first = true;
                                foreach ($xml_films->film as $index => $film) {
                                    $activeClass = $first ? 'active' : '';
                                    echo '<div class="carousel-item ' . $activeClass . '">';
                                    echo '<div class="row align-items-center">';
                                    echo '<div class="col-md-6">';
                                    echo '<img src="' . $film->image['url'] . '" alt="' . $film->titre . '">';
                                    echo '</div>';
                                    echo '<div class="col-md-6 synopsis">';
                                    echo '<h3>' . $film->titre . '</h3>';
                                    echo '<p><strong>Genre:</strong> ' . $film->genre . '</p>';
                                    echo '<p><strong>Réalisateur:</strong> ' . $film->realisateur . '</p>';
                                    echo '<p><strong>Synopsis:</strong> ' . $film->synopsis . '</p>';
                                    echo '<a href="cinema.php" class="btn btn-primary">Voir les détails</a>';
                                    echo '</div>';
                                    echo '</div>';
                                    echo '</div>';
                                    $first = false;
                                }
                            }
                            ?>
                        </div>
                        <a class="carousel-control-prev" href="#film-carousel" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Précédent</span>
                        </a>
                        <a class="carousel-control-next" href="#film-carousel" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Suivant</span>
                        </a>
                    </div>
                </div>
            </section>
            <section class="section-featured">
                <h2>Restaurants à découvrir</h2>
                <div class="restaurant-list row justify-content-center"> <!-- Centrer les éléments -->
                    <div id="restaurant-carousel" class="carousel slide col-12" data-ride="carousel">
                        <div class="carousel-inner">
                            <?php
                            // Chargement du fichier XML pour les restaurants
                            $xml_restaurants = simplexml_load_file('XML/restaurant.xml');

                            // Vérification du chargement du fichier des restaurants
                            if ($xml_restaurants === false) {
                                echo "Erreur lors du chargement du fichier XML des restaurants.";
                            } else {
                                // Affichage des restaurants à découvrir
                                $first = true;
                                foreach ($xml_restaurants->restaurant as $index => $restaurant) {
                                    $activeClass = $first ? 'active' : '';
                                    echo '<div class="carousel-item ' . $activeClass . '">';
                                    echo '<div class="row align-items-center">';
                                    echo '<div class="col-md-6">';
                                    echo '<img src="' . $restaurant->image['url'] . '" alt="' . $restaurant->nom . '">';
                                    echo '</div>';
                                    echo '<div class="col-md-6 synopsis">';
                                    echo '<h3>' . $restaurant->nom . '</h3>';
                                    echo '<p><strong>Adresse:</strong> ' . $restaurant->adresse . '</p>';
                                    echo '<p><strong>Nom du Restaurateur:</strong> ' . $restaurant->nom_restaurateur . '</p>';
                                    echo '<p><strong>Synopsis:</strong> ' . $restaurant->description . '</p>';
                                    echo '<a href="restaurant.php" class="btn btn-primary">Détails du restaurant</a>';
                                    echo '</div>';
                                    echo '</div>';
                                    echo '</div>';
                                    $first = false;
                                }
                            }
                            ?>
                        </div>
                        <a class="carousel-control-prev" href="#restaurant-carousel" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Précédent</span>
                        </a>
                        <a class="carousel-control-next" href="#restaurant-carousel" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Suivant</span>
                        </a>
                    </div>
                </div>
            </section>
        </main>
        <footer>
            <p>&copy; <?php echo date("Y"); ?> Portail Cinéma et Restaurants</p>
        </footer>
    </div> <!-- Fin div .container -->

    <!-- Bootstrap JavaScript et dépendances -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
