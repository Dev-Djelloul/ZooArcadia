<?php
session_start();
if (!isset($_SESSION['userType']) || $_SESSION['userType'] !== 'employe') {
    header("Location: /public/connexion.html");
    exit();
}
require '../../config.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace personnel - Employé</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-XDw1Ua9p9LxD4XK9Lc9/7ifdSvMwzz55IviNdZ+rzxgC+SZIZCcU4p3KLJZGKQ0+7MO9Dp8CemixjLRGYKs+0w==" crossorigin="anonymous" referrerpolicy="no-referrer">
</head>
<body>
<header>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-1">
                <a href="index.html">
                    <img src="/assets/images/logo-arcadia.jpeg" alt="Logo Arcadia Zoo" class="logo">
                </a>
            </div>
            <div class="col-md-10">
                <nav>
                    <ul class="nav justify-content-center">
                        <li class="nav-item">
                            <a href="/index.html" class="nav-link" style="font-size: 20px">Accueil</a>
                        </li>
                        <li class="nav-item">
                            <a href="/public/services.php" class="nav-link" style="font-size: 20px">Nos Services</a>
                        </li>
                        <li class="nav-item">
                            <a href="/public/habitats.html" class="nav-link" style="font-size: 20px">Nos Habitats</a>
                        </li>
                        <li class="nav-item">
                            <a href="/public/contact.html" class="nav-link" style="font-size: 20px">Contact</a>
                        </li>
                        <li class="nav-item" id="loginNavItem">
                            <a id="loginLink" href="/public/connexion.html" class="nav-link" style="font-size: 20px">Connexion</a>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="col-md-1">
                <a href="/index.html">
                    <img src="/assets/images/logo-arcadia.jpeg" alt="Logo Arcadia Zoo" class="logo">
                </a>
            </div>
        </div>
    </div>
</header>

<h1 style="margin: 50px">Bienvenue dans votre espace employé</h1>

<div class="container mt-5">
    <!-- Section de gestion des avis -->
    <section id="gererAvis" class="container mt-5">
        <h2 class="text-center">Gestion des avis des visiteurs</h2>
        <div id="avisEnAttente" class="row justify-content-center">
            <!-- Les avis en attente seront affichés ici -->
        </div>
    </section>
</div>
     
<!-- Section de gestion des services du zoo -->
<main class="container mt-4">
    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-<?php echo $_SESSION['msg_type']; ?>">
            <?php echo $_SESSION['message']; ?>
            <?php unset($_SESSION['message']); ?>
            <?php unset($_SESSION['msg_type']); ?>
        </div>
    <?php endif; ?>

    <h2>Gérer les services</h2>
    <form action="/back-end-php/users/employe/create_service_employe.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="service_name">Nom du service :</label>
            <input type="text" class="form-control" id="service_name" name="service_name" required>
        </div>
        <div class="form-group">
            <label for="service_description">Description du service :</label>
            <textarea class="form-control" id="service_description" name="service_description" rows="3" required></textarea>
        </div>
        <div class="form-group">
            <label for="service_image">Image du service :</label>
            <input type="file" class="form-control-file" id="service_image" name="service_image" accept="image/*">
        </div>
        <button type="submit" class="btn btn-primary">Ajouter le service</button>
    </form>

    <!-- Table des services existants -->
    <h2>Liste des services</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Nom du service</th>
                <th>Description du service</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql_services = "SELECT * FROM Services";
            $stmt_services = $conn->query($sql_services);
            while ($row = $stmt_services->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>{$row['NomService']}</td>";
                echo "<td>{$row['DescriptionService']}</td>";
                echo "<td>";
                echo "<a href='edit_service_employe.php?id={$row['IdService']}' class='btn btn-warning'>Modifier</a> ";
                echo "<a href='delete_service_employe.php?id={$row['IdService']}' class='btn btn-danger'>Supprimer</a>";
                echo "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</main>

<footer class="bg-dark text-white py-4 mt-4">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h6 class="text-center">Comment venir au parc zoologique d'Arcadia ?</h6>
                <p class="text-center text-white">
                    Arcadia Zoo<br>
                    123 Rue des Animaux<br>
                    Ville des Animaux, 12345<br>
                </p>
                <h6 class="text-center">Nous contacter</h6>
                <p class="text-center text-white">
                    Téléphone: 123-456-7890<br>
                    Email: info.arcadiazoo@gmail.com
                </p>
            </div>
            <div class="col-md-8">
                <h6 class="text-center">Suivez-nous :</h6>
                <div class="text-center">
                    <a href="https://www.facebook.com/" class="social-icon"><i class="fab fa-facebook"></i> Facebook</a>
                    <a href="https://twitter.com/?lang=fr" class="social-icon"><i class="fab fa-twitter"></i> Twitter</a>
                    <a href="https://www.instagram.com/" class="social-icon"><i class="fab fa-instagram-square"></i> Instagram</a>
                    <a href="https://www.linkedin.com/feed/" class="social-icon"><i class="fab fa-linkedin"></i> Linkedin</a>
                </div>
            </div>
        </div>
    </div>
</footer>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Charger les avis en attente de validation
        $.ajax({
            type: "GET",
            url: "/back-end-php/employe_espace/gererAvis.php",
            dataType: "json",
            success: function(avis) {
                avis.forEach(function(avi) {
                    var avisHtml = `
                        <div class="col-md-4">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <p class="card-text">${avi.avis}</p>
                                    <p class="card-text"><small class="text-muted">- ${avi.pseudo}</small></p>
                                    <button class="btn btn-success approuverAvis" data-id="${avi.id}">Approuver</button>
                                    <button class="btn btn-danger rejeterAvis" data-id="${avi.id}">Rejeter</button>
                                </div>
                            </div>
                        </div>
                    `;
                    $("#avisEnAttente").append(avisHtml);
                });
            },
            error: function(xhr, status, error) {
                alert("Erreur lors du chargement des avis.");
            }
        });

        // Approuver ou rejeter un avis
        $(document).on("click", ".approuverAvis, .rejeterAvis", function() {
            var id = $(this).data("id");
            var approuve = $(this).hasClass("approuverAvis") ? 1 : 0;

            $.ajax({
                type: "POST",
                url: "/back-end-php/employe_espace/gererAvis.php",
                data: { id: id, approuve: approuve },
                dataType: "json",
                success: function(response) {
                    alert(response.message);
                    if (response.success) {
                        location.reload();
                    }
                },
                error: function(xhr, status, error) {
                    alert("Erreur lors de la mise à jour de l'avis.");
                }
            });
        });
    });
</script>
</body>
</html>