// document.getElementById('filterButton').addEventListener('click', function() {
//     let role = document.getElementById('role').value;
//     let archive = document.getElementById('archive').value;

//     // Construire l'URL avec les paramètres de filtre
//     let url = `../../../Controlleur/EmployeController.php?role=${role}&archive=${archive}`;

//     // Faire une requête GET pour récupérer les administrateurs
//     fetch(url)
//         .then(response => response.json())
//         .then(data => {
//             // Vider le tableau
//             let tableBody = document.querySelector('#enseignantsTable tbody');
//             tableBody.innerHTML = '';

//             // Parcourir les résultats et les afficher
//             data.forEach(admin => {
//                 let row = `<tr>
//                             <td>${admin.nom}</td>
//                             <td>${admin.prenom}</td>
//                             <td>${admin.telephone}</td>
//                             <td>${admin.email}</td>
//                             <td>${admin.role}</td>
//                             <td>${admin.matricule}</td>
//                            </tr>`;
//                 tableBody.innerHTML += row;
//             });
//         })
//         .catch(error => {
//             console.error('Erreur lors de la récupération des données:', error);
//         });
// });
