    <?php
    // Démarrer la session pour accéder aux messages
    session_start();
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // Assurez-vous que le modèle est chargé et que vous avez la liste des surveillants
    require_once '../../../database.php';
    require_once __DIR__ . '/../../../Model/Surveillant.php';
    require_once __DIR__ . '/../../../Controlleur/SurveillantController.php';

    // Créer une instance du contrôleur
    $controller = new SurveillantController($pdo);
    $surveillants = $controller->getAll(); // Récupérez les surveillants


    $controller = new SurveillantController($pdo); // Créer une instance de SurveillantController
    $surveillants = $controller->getAll(); // Récupérez les surveillants

    require_once 'layout.php'; // ou '../views/layout.php' selon votre structure de dossier
    ?>
    <!DOCTYPE html>
    <html lang="en" >
    <head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
    <link rel="stylesheet" href="../../Dashboard/dashboard.css">

    </head>
    <body>
    <!-- partial:index.partial.html -->
    <div class="dashboard">
        <aside class="search-wrap">
        </aside>
        
        <header class="menu-wrap">
            <figure class="user">
                <div class="user-avatar">
                    <img src="../../../assets/SABADIFA.png" alt="">
                </div>
            </figure>
        
            <nav>
                <section class="dicover">
                    <ul>
                        <li>
                            <a href="../../../View/Dashboard/dashboard_directeur.php">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 576 512"><path d="M575.8 255.5c0 18-15 32.1-32 32.1l-32 0 .7 160.2c0 2.7-.2 5.4-.5 8.1l0 16.2c0 22.1-17.9 40-40 40l-16 0c-1.1 0-2.2 0-3.3-.1c-1.4 .1-2.8 .1-4.2 .1L416 512l-24 0c-22.1 0-40-17.9-40-40l0-24 0-64c0-17.7-14.3-32-32-32l-64 0c-17.7 0-32 14.3-32 32l0 64 0 24c0 22.1-17.9 40-40 40l-24 0-31.9 0c-1.5 0-3-.1-4.5-.2c-1.2 .1-2.4 .2-3.6 .2l-16 0c-22.1 0-40-17.9-40-40l0-112c0-.9 0-1.9 .1-2.8l0-69.7-32 0c-18 0-32-14-32-32.1c0-9 3-17 10-24L266.4 8c7-7 15-8 22-8s15 2 21 7L564.8 231.5c8 7 12 15 11 24z"/></svg>
                                DASHBOARD
                            </a>
                        </li>
                        
                        <li>
                            <a href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 640 512"><path d="M320 32c-8.1 0-16.1 1.4-23.7 4.1L15.8 137.4C6.3 140.9 0 149.9 0 160s6.3 19.1 15.8 22.6l57.9 20.9C57.3 229.3 48 259.8 48 291.9l0 28.1c0 28.4-10.8 57.7-22.3 80.8c-6.5 13-13.9 25.8-22.5 37.6C0 442.7-.9 448.3 .9 453.4s6 8.9 11.2 10.2l64 16c4.2 1.1 8.7 .3 12.4-2s6.3-6.1 7.1-10.4c8.6-42.8 4.3-81.2-2.1-108.7C90.3 344.3 86 329.8 80 316.5l0-24.6c0-30.2 10.2-58.7 27.9-81.5c12.9-15.5 29.6-28 49.2-35.7l157-61.7c8.2-3.2 17.5 .8 20.7 9s-.8 17.5-9 20.7l-157 61.7c-12.4 4.9-23.3 12.4-32.2 21.6l159.6 57.6c7.6 2.7 15.6 4.1 23.7 4.1s16.1-1.4 23.7-4.1L624.2 182.6c9.5-3.4 15.8-12.5 15.8-22.6s-6.3-19.1-15.8-22.6L343.7 36.1C336.1 33.4 328.1 32 320 32zM128 408c0 35.3 86 72 192 72s192-36.7 192-72L496.7 262.6 354.5 314c-11.1 4-22.8 6-34.5 6s-23.5-2-34.5-6L143.3 262.6 128 408z"/></svg>
                                List des ELEVES
                            </a>
                        </li>
                        
                        <li>
                            <a href="#">
                            <svg xmlns="http://www.w3.org/2000/svg"  width="24" height="24" viewBox="0 0 576 512"><path d="M312 24l0 10.5c6.4 1.2 12.6 2.7 18.2 4.2c12.8 3.4 20.4 16.6 17 29.4s-16.6 20.4-29.4 17c-10.9-2.9-21.1-4.9-30.2-5c-7.3-.1-14.7 1.7-19.4 4.4c-2.1 1.3-3.1 2.4-3.5 3c-.3 .5-.7 1.2-.7 2.8c0 .3 0 .5 0 .6c.2 .2 .9 1.2 3.3 2.6c5.8 3.5 14.4 6.2 27.4 10.1l.9 .3s0 0 0 0c11.1 3.3 25.9 7.8 37.9 15.3c13.7 8.6 26.1 22.9 26.4 44.9c.3 22.5-11.4 38.9-26.7 48.5c-6.7 4.1-13.9 7-21.3 8.8l0 10.6c0 13.3-10.7 24-24 24s-24-10.7-24-24l0-11.4c-9.5-2.3-18.2-5.3-25.6-7.8c-2.1-.7-4.1-1.4-6-2c-12.6-4.2-19.4-17.8-15.2-30.4s17.8-19.4 30.4-15.2c2.6 .9 5 1.7 7.3 2.5c13.6 4.6 23.4 7.9 33.9 8.3c8 .3 15.1-1.6 19.2-4.1c1.9-1.2 2.8-2.2 3.2-2.9c.4-.6 .9-1.8 .8-4.1l0-.2c0-1 0-2.1-4-4.6c-5.7-3.6-14.3-6.4-27.1-10.3l-1.9-.6c-10.8-3.2-25-7.5-36.4-14.4c-13.5-8.1-26.5-22-26.6-44.1c-.1-22.9 12.9-38.6 27.7-47.4c6.4-3.8 13.3-6.4 20.2-8.2L264 24c0-13.3 10.7-24 24-24s24 10.7 24 24zM568.2 336.3c13.1 17.8 9.3 42.8-8.5 55.9L433.1 485.5c-23.4 17.2-51.6 26.5-80.7 26.5L192 512 32 512c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l36.8 0 44.9-36c22.7-18.2 50.9-28 80-28l78.3 0 16 0 64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0-16 0c-8.8 0-16 7.2-16 16s7.2 16 16 16l120.6 0 119.7-88.2c17.8-13.1 42.8-9.3 55.9 8.5zM193.6 384c0 0 0 0 0 0l-.9 0c.3 0 .6 0 .9 0z"/></svg>
                                GESTION SCOLARITE
                            </a>
                        </li>
                        
                        <li>
                            <a href="../Employe/employe-list/enseignant-list/enseignant-list.php">
                            <svg xmlns="http://www.w3.org/2000/svg"  width="24" height="24" viewBox="0 0 640 512"><path d="M144 0a80 80 0 1 1 0 160A80 80 0 1 1 144 0zM512 0a80 80 0 1 1 0 160A80 80 0 1 1 512 0zM0 298.7C0 239.8 47.8 192 106.7 192l42.7 0c15.9 0 31 3.5 44.6 9.7c-1.3 7.2-1.9 14.7-1.9 22.3c0 38.2 16.8 72.5 43.3 96c-.2 0-.4 0-.7 0L21.3 320C9.6 320 0 310.4 0 298.7zM405.3 320c-.2 0-.4 0-.7 0c26.6-23.5 43.3-57.8 43.3-96c0-7.6-.7-15-1.9-22.3c13.6-6.3 28.7-9.7 44.6-9.7l42.7 0C592.2 192 640 239.8 640 298.7c0 11.8-9.6 21.3-21.3 21.3l-213.3 0zM224 224a96 96 0 1 1 192 0 96 96 0 1 1 -192 0zM128 485.3C128 411.7 187.7 352 261.3 352l117.3 0C452.3 352 512 411.7 512 485.3c0 14.7-11.9 26.7-26.7 26.7l-330.7 0c-14.7 0-26.7-11.9-26.7-26.7z"/></svg>
                                List des PROFESSEURS
                            </a>
                        </li>
                        <li>
                            <a href="../Employe/employe-new/employe-new.html">
                            <svg xmlns="http://www.w3.org/2000/svg"  width="24" height="24" viewBox="0 0 640 512"><path d="M144 0a80 80 0 1 1 0 160A80 80 0 1 1 144 0zM512 0a80 80 0 1 1 0 160A80 80 0 1 1 512 0zM0 298.7C0 239.8 47.8 192 106.7 192l42.7 0c15.9 0 31 3.5 44.6 9.7c-1.3 7.2-1.9 14.7-1.9 22.3c0 38.2 16.8 72.5 43.3 96c-.2 0-.4 0-.7 0L21.3 320C9.6 320 0 310.4 0 298.7zM405.3 320c-.2 0-.4 0-.7 0c26.6-23.5 43.3-57.8 43.3-96c0-7.6-.7-15-1.9-22.3c13.6-6.3 28.7-9.7 44.6-9.7l42.7 0C592.2 192 640 239.8 640 298.7c0 11.8-9.6 21.3-21.3 21.3l-213.3 0zM224 224a96 96 0 1 1 192 0 96 96 0 1 1 -192 0zM128 485.3C128 411.7 187.7 352 261.3 352l117.3 0C452.3 352 512 411.7 512 485.3c0 14.7-11.9 26.7-26.7 26.7l-330.7 0c-14.7 0-26.7-11.9-26.7-26.7z"/></svg>
                                Inscrire Professeur
                            </a>
                        </li>

                        <li>
                            <a href="../Employe/employe-list/comptable-list/comptable-list.php">
                            <svg xmlns="http://www.w3.org/2000/svg"  width="24" height="24" viewBox="0 0 640 512"><path d="M96 96l0 224c0 35.3 28.7 64 64 64l416 0c35.3 0 64-28.7 64-64l0-224c0-35.3-28.7-64-64-64L160 32c-35.3 0-64 28.7-64 64zm64 160c35.3 0 64 28.7 64 64l-64 0 0-64zM224 96c0 35.3-28.7 64-64 64l0-64 64 0zM576 256l0 64-64 0c0-35.3 28.7-64 64-64zM512 96l64 0 0 64c-35.3 0-64-28.7-64-64zM288 208a80 80 0 1 1 160 0 80 80 0 1 1 -160 0zM48 120c0-13.3-10.7-24-24-24S0 106.7 0 120L0 360c0 66.3 53.7 120 120 120l400 0c13.3 0 24-10.7 24-24s-10.7-24-24-24l-400 0c-39.8 0-72-32.2-72-72l0-240z"/></svg>
                                COMPTABILITE
                            </a>
                        </li>


                        <li>
                            <a href="#">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M13 7L11 7 11 11 7 11 7 13 11 13 11 17 13 17 13 13 17 13 17 11 13 11z"/><path d="M12,2C6.486,2,2,6.486,2,12s4.486,10,10,10c5.514,0,10-4.486,10-10S17.514,2,12,2z M12,20c-4.411,0-8-3.589-8-8 s3.589-8,8-8s8,3.589,8,8S16.411,20,12,20z"/></svg>
                                RAPPORT
                            </a>
                        </li>

                        <li>
                            <a href="#">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 640 512"><path d="M144 160A80 80 0 1 0 144 0a80 80 0 1 0 0 160zm368 0A80 80 0 1 0 512 0a80 80 0 1 0 0 160zM0 298.7C0 310.4 9.6 320 21.3 320l213.3 0c.2 0 .4 0 .7 0c-26.6-23.5-43.3-57.8-43.3-96c0-7.6 .7-15 1.9-22.3c-13.6-6.3-28.7-9.7-44.6-9.7l-42.7 0C47.8 192 0 239.8 0 298.7zM320 320c24 0 45.9-8.8 62.7-23.3c2.5-3.7 5.2-7.3 8-10.7c2.7-3.3 5.7-6.1 9-8.3C410 262.3 416 243.9 416 224c0-53-43-96-96-96s-96 43-96 96s43 96 96 96zm65.4 60.2c-10.3-5.9-18.1-16.2-20.8-28.2l-103.2 0C187.7 352 128 411.7 128 485.3c0 14.7 11.9 26.7 26.7 26.7l300.6 0c-2.1-5.2-3.2-10.9-3.2-16.4l0-3c-1.3-.7-2.7-1.5-4-2.3l-2.6 1.5c-16.8 9.7-40.5 8-54.7-9.7c-4.5-5.6-8.6-11.5-12.4-17.6l-.1-.2-.1-.2-2.4-4.1-.1-.2-.1-.2c-3.4-6.2-6.4-12.6-9-19.3c-8.2-21.2 2.2-42.6 19-52.3l2.7-1.5c0-.8 0-1.5 0-2.3s0-1.5 0-2.3l-2.7-1.5zM533.3 192l-42.7 0c-15.9 0-31 3.5-44.6 9.7c1.3 7.2 1.9 14.7 1.9 22.3c0 17.4-3.5 33.9-9.7 49c2.5 .9 4.9 2 7.1 3.3l2.6 1.5c1.3-.8 2.6-1.6 4-2.3l0-3c0-19.4 13.3-39.1 35.8-42.6c7.9-1.2 16-1.9 24.2-1.9s16.3 .6 24.2 1.9c22.5 3.5 35.8 23.2 35.8 42.6l0 3c1.3 .7 2.7 1.5 4 2.3l2.6-1.5c16.8-9.7 40.5-8 54.7 9.7c2.3 2.8 4.5 5.8 6.6 8.7c-2.1-57.1-49-102.7-106.6-102.7zm91.3 163.9c6.3-3.6 9.5-11.1 6.8-18c-2.1-5.5-4.6-10.8-7.4-15.9l-2.3-4c-3.1-5.1-6.5-9.9-10.2-14.5c-4.6-5.7-12.7-6.7-19-3l-2.9 1.7c-9.2 5.3-20.4 4-29.6-1.3s-16.1-14.5-16.1-25.1l0-3.4c0-7.3-4.9-13.8-12.1-14.9c-6.5-1-13.1-1.5-19.9-1.5s-13.4 .5-19.9 1.5c-7.2 1.1-12.1 7.6-12.1 14.9l0 3.4c0 10.6-6.9 19.8-16.1 25.1s-20.4 6.6-29.6 1.3l-2.9-1.7c-6.3-3.6-14.4-2.6-19 3c-3.7 4.6-7.1 9.5-10.2 14.6l-2.3 3.9c-2.8 5.1-5.3 10.4-7.4 15.9c-2.6 6.8 .5 14.3 6.8 17.9l2.9 1.7c9.2 5.3 13.7 15.8 13.7 26.4s-4.5 21.1-13.7 26.4l-3 1.7c-6.3 3.6-9.5 11.1-6.8 17.9c2.1 5.5 4.6 10.7 7.4 15.8l2.4 4.1c3 5.1 6.4 9.9 10.1 14.5c4.6 5.7 12.7 6.7 19 3l2.9-1.7c9.2-5.3 20.4-4 29.6 1.3s16.1 14.5 16.1 25.1l0 3.4c0 7.3 4.9 13.8 12.1 14.9c6.5 1 13.1 1.5 19.9 1.5s13.4-.5 19.9-1.5c7.2-1.1 12.1-7.6 12.1-14.9l0-3.4c0-10.6 6.9-19.8 16.1-25.1s20.4-6.6 29.6-1.3l2.9 1.7c6.3 3.6 14.4 2.6 19-3c3.7-4.6 7.1-9.4 10.1-14.5l2.4-4.2c2.8-5.1 5.3-10.3 7.4-15.8c2.6-6.8-.5-14.3-6.8-17.9l-3-1.7c-9.2-5.3-13.7-15.8-13.7-26.4s4.5-21.1 13.7-26.4l3-1.7zM472 384a40 40 0 1 1 80 0 40 40 0 1 1 -80 0z"/></svg>
                                PERSONNELS
                            </a>
                        </li>
                    </ul>
                </section>
            </nav>
        </header>

        <main>
    <div class="container-fluid h-100 bg-light">
        <h1 class="text-dark">Liste des Surveillants</h1>

        <!-- Modals pour les messages -->
        <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title" id="successModalLabel">Succès</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p id="successMessage"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" data-bs-dismiss="modal">Fermer</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-warning text-dark">
                        <h5 class="modal-title" id="errorModalLabel">Erreur</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p id="errorMessage"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" data-bs-dismiss="modal">Fermer</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Formulaire de recherche et lien vers surveillants archivés -->
        <div class="row mb-3">
            <div class="col-md-4">
                <div class="input-group">
                    <input type="text" class="form-control" id="searchInput" placeholder="Rechercher par matricule ou nom...">
                    <button id="searchButton" class="btn btn-danger">RECHERCHE</button>
                </div>
            </div>
            <div class="col-md-4 d-flex justify-content-end">
                <a href="indexSurveillantArchiver.php" class="btn btn-info">Voir les Surveillants Archivés</a>
            </div>
            <div class="col-md-4"></div>
        </div>

        <!-- Tableau des surveillants -->
        <div class="table-responsive">
            <table class="table table-striped mt-3 text-dark">
                <thead class="bg-primary">
                    <tr>
                        <th>Matricule</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Email</th>
                        <th>Archivage</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="surveillantTableBody">
                    <?php if ($surveillants): ?>
                        <?php foreach ($surveillants as $surveillant): ?>
                            <tr>
                                <td><?= htmlspecialchars($surveillant['matricule']) ?></td>
                                <td><?= htmlspecialchars($surveillant['nom']) ?></td>
                                <td><?= htmlspecialchars($surveillant['prenom']) ?></td>
                                <td><?= htmlspecialchars($surveillant['email']) ?></td>
                                <td>
                                    <?php if ($surveillant['archive']): ?>
                                        <span class="text-danger">Archivé</span>
                                    <?php else: ?>
                                        <span class="text-success">Actif</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="edit.php?id=<?= $surveillant['id'] ?>" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="../../../Controlleur/SurveillantController.php?action=archive&id=<?= $surveillant['id'] ?>" class="btn btn-secondary btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir archiver cet enregistrement ?')">
                                        <i class="fas fa-archive"></i>
                                    </a>
                                    <a href="../../../Controlleur/SurveillantController.php?action=delete&id=<?= $surveillant['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet enregistrement ?')">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6">Aucun surveillant trouvé.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div id="paginationControls" class="d-flex justify-content-center">
            <button id="prevPage" class="btn btn-secondary" onclick="changePage(-1)">Précédent</button>
            <span id="pageInfo"></span>
            <button id="nextPage" class="btn btn-secondary" onclick="changePage(1)">Suivant</button>
        </div>
    </div>
</main>


<script>

    document.getElementById('searchButton').addEventListener('click', function() {
            var searchInput = document.getElementById('searchInput').value;
            var tableRows = document.getElementById('surveillantTableBody').rows;

            for (var i = 0; i < tableRows.length; i++) {
                var row = tableRows[i];
                var matriculeCell = row.cells[0];
                var nomCell = row.cells[1];

                if (matriculeCell.textContent.toLowerCase().includes(searchInput.toLowerCase()) || nomCell.textContent.toLowerCase().includes(searchInput.toLowerCase())) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            }
        });
    let currentPage = 1;
    const elementsPerPage = 5; // Changez ce nombre selon vos besoins
    const tableBody = document.getElementById('surveillantTableBody');
    const rows = Array.from(tableBody.getElementsByTagName('tr'));
    const totalPages = Math.ceil(rows.length / elementsPerPage);

    function displayPage(page) {
        const start = (page - 1) * elementsPerPage;
        const end = start + elementsPerPage;

        // Masquer toutes les lignes
        rows.forEach(row => row.style.display = 'none');

        // Afficher les lignes de la page actuelle
        for (let i = start; i < end && i < rows.length; i++) {
            rows[i].style.display = '';
        }

        // Mettre à jour les informations de pagination
        document.getElementById('pageInfo').innerText = `Page ${page} sur ${totalPages}`;
        
        // Activer ou désactiver les boutons de pagination
        document.getElementById('prevPage').disabled = page === 1;
        document.getElementById('nextPage').disabled = page === totalPages;
    }

    function changePage(delta) {
        currentPage += delta;
        displayPage(currentPage);
    }

    document.getElementById('searchButton').addEventListener('click', function() {
        var searchInput = document.getElementById('searchInput').value.toLowerCase();
        var filteredRows = rows.filter(row => {
            var matriculeCell = row.cells[0].textContent.toLowerCase();
            var nomCell = row.cells[1].textContent.toLowerCase();
            return matriculeCell.includes(searchInput) || nomCell.includes(searchInput);
        });

        // Mettre à jour le tableau avec les lignes filtrées
        tableBody.innerHTML = '';
        filteredRows.forEach(row => tableBody.appendChild(row));

        // Réinitialiser la pagination
        currentPage = 1;
        const newTotalPages = Math.ceil(filteredRows.length / elementsPerPage);
        if (newTotalPages < currentPage) {
            currentPage = newTotalPages;
        }

        displayPage(currentPage);
    });

    // Initialiser l'affichage de la première page
    displayPage(currentPage);
</script>
