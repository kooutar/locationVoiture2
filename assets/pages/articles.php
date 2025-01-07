<?php
session_start();
require_once '../classe/db.php';
require_once '../classe/article.php';
require_once '../classe/tag.php';
try{

    $database = new Database();
    $db = $database->connect();
    $tag = new tag($db);
} catch(PDOException $e){
    $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Document</title>
</head>
<body class="min-h-screen bg-gray-100">
    <!-- Navbar -->
    <nav class="bg-black shadow-lg">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <h1 class="text-2xl font-bold text-blue-600">Drive & Loc</h1>
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="../index.php" class="text-white hover:text-blue-600">Accueil</a>
                    <a href="cars.php" class="text-white hover:text-blue-600">Véhicules</a>
                    <a href="registre.php" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Registre</a>
                </div>
            </div>
        </div> 
    </nav>

    <div class="max-w-6xl mx-auto px-4 mt-8">
        <button id="ajoutArticle" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition duration-300">
            Ajouter un article
        </button>
    </div>

 
    <div id="articlesContainer" class="max-w-6xl mx-auto px-4 mt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
  
    </div>
    <div id="articleModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Ajouter un nouvel article</h3>
                <form action="../traitement/ajoutArticle.php" method="POST" id="articleForm" class="space-y-4" enctype="multipart/form-data">
                    <input type="hidden" name='idtheme' value="<?= $_GET['idtheme']?>">
                    <input type="hidden" name="iduser" value="<?= $_SESSION['id_user']?>">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Titre</label>
                        <input type="text" id="titre" name="titre" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea id="description" name="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Media</label>
                        <input type="file" name="media" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                    <label  class="block text-sm font-medium text-gray-700" for="combobox">Choisissez ou entrez une valeur :</label>
                            <input list="options" id="combobox" name="tagName"  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Choisissez ou entrez">
                            <datalist id="options" >
                           <?php
                            $tags=$tag->getAlltag();
                            foreach($tags as $tag){
                                echo "<option data-id='{$tag['id']}'>{$tag['tag']}</option>";
                            }
                           ?>
                            </datalist>
                            <input type="hidden" id="tagId" name="tagId">
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" id="annulerBtn" class="bg-gray-200 px-4 py-2 rounded-md hover:bg-gray-300">
                            Annuler
                        </button>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                            Ajouter
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const modal = document.getElementById('articleModal');
        const ajoutBtn = document.getElementById('ajoutArticle');
        const annulerBtn = document.getElementById('annulerBtn');
        const articleForm = document.getElementById('articleForm');
        const articlesContainer = document.getElementById('articlesContainer');

        ajoutBtn.addEventListener('click', () => {
            modal.classList.remove('hidden');
        });

        // Fermer la modale
        annulerBtn.addEventListener('click', () => {
            modal.classList.add('hidden');
            articleForm.reset();
        });

        // 
        const combobox = document.getElementById("combobox");
    const hiddenTagId = document.getElementById("tagId");
    const options = document.getElementById("options").children;

    // Écouter les modifications de l'utilisateur dans le champ
    combobox.addEventListener("input", () => {
        let selectedTagId = null;

        // Parcourir les options pour trouver l'ID correspondant au texte
        for (let option of options) {
            if (option.value === combobox.value) {
                selectedTagId = option.getAttribute("data-id");
                break;
            }
        }

        // Mettre à jour le champ caché avec l'ID
        hiddenTagId.value = selectedTagId || "";
    });

        // Gérer la soumission du formulaire
        // articleForm.addEventListener('submit', (e) => {
        //     e.preventDefault();
            
        //     // Récupérer les valeurs du formulaire
        //     const titre = document.getElementById('titre').value;
        //     const description = document.getElementById('description').value;
        //     const media = document.getElementById('media').value;

        //     // Créer un nouvel article
        //     const articleElement = document.createElement('div');
        //     articleElement.className = 'bg-white rounded-lg shadow-md p-6';
        //     articleElement.innerHTML = `
        //         <h2 class="text-xl font-bold mb-2">${titre}</h2>
        //         <p class="text-gray-600 mb-4">${description}</p>
        //         <p class="text-blue-600 font-bold">${media} €</p>
        //     `;

        //     // Ajouter l'article au container
        //     articlesContainer.appendChild(articleElement);

        //     // Fermer la modale et réinitialiser le formulaire
        //     modal.classList.add('hidden');
        //     articleForm.reset();
        // });

        // Fermer la modale si on clique en dehors
        // modal.addEventListener('click', (e) => {
        //     if (e.target === modal) {
        //         modal.classList.add('hidden');
        //         articleForm.reset();
        //     }
        // });
    </script>
</body>
</html>