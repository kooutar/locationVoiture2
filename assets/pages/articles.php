<?php
session_start();
require_once '../classe/db.php';
require_once '../classe/article.php';
require_once '../classe/tag.php';
require_once '../classe/tag_article.php';
require_once '../classe/favorie.php';
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css">
    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
    <title>Document</title>
    <style>
        .vehicle-grid {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 20px;
            padding: 20px;
        }

        .vehicle-card {
            width: 300px;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            background: white;
        }

        .vehicle-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .vehicle-details {
            padding: 15px;
        }

        .vehicle-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .vehicle-title {
            font-size: 18px;
            font-weight: bold;
        }

        .vehicle-price {
            color: #4e4ffa;
            font-weight: bold;
        }

        .tags {
            display: flex;
            gap: 10px;
            margin-bottom: 15px;
        }

        .tag {
            padding: 5px 12px;
            border-radius: 15px;
            font-size: 14px;
        }

        .tag-active {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .tag-family {
            background: #ffebee;
            color: #c62828;
        }

        .reserve-button {
            width: 100%;
            padding: 10px;
            background: #4e4ffa;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
        }

        .reserve-button:hover {
            background: #3a3bc7;
        }
        .pagination {
    display: flex;
    justify-content: center; /* Centre les éléments */
}

.pagination ul {
    display: flex;
    list-style-type: none;
    padding: 0;
}

.pagination li {
    margin: 0 10px; /* Ajoute un espace de 10px entre chaque lien */
}

.pagination a {
    text-decoration: none;
    color: black; /* Couleur par défaut des liens */
    padding: 5px 10px;
    border-radius: 5px;
    transition: background-color 0.3s;
}

.pagination a:hover {
    background-color: #f0f0f0; /* Couleur de fond au survol */
}

.pagination .active {
    font-weight: bold;
    color: blue; /* Couleur des liens actifs */
}


.tag-item {
    padding: 4px 12px;
    background-color: #e5e7eb;
    border-radius: 15px;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.2s;
}

.tag-item:hover {
    background-color: #4f46e5;
    color: white;
}

.tag-item.selected {
    background-color: #4f46e5;
    color: white;
}
.favorite-btn svg {
    transition: all 0.3s;
    color: #9ca3af;
}

.favorite-btn.active svg {
    fill: #ef4444;
    color: #ef4444;
}


    </style>
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
                <form action="../traitement/ajouterTag.php" method="POST" id="articleForm" class="space-y-4" enctype="multipart/form-data">
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
                    <label class="block text-sm font-medium text-gray-700" for="combobox">Tags :</label>
                    <input id="combobox" name="tagName" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Sélectionnez ou saisissez des tags">
                    <div id="existingTags" class="mt-2 flex flex-wrap gap-2"></div>
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
    <!-- ************************************************************************************************ -->
    <div class="vehicle-grid" id="vehicle-grid">
    <?php

    $article = new article($db);
    $article_tag= new tag_article($db);

    $totalArticles = $article->getTotalArticles();

    $nbrpages = ceil($totalArticles / 2);

   

    if (isset($_GET['idtheme'])) {
        $theme = intval($_GET['idtheme']); // Récupérer idtheme depuis l'URL
    } else {
        $theme = null; // Valeur par défaut si idtheme n'est pas défini
    }
   

   $page = isset($_GET['page']) ? intval($_GET['page']) : 1;

   $articles = $article->Pagination($page,$theme);
   $favorie= new favorie($db);
    foreach ($articles as $row):
        $isFavorite= $favorie->estFavori($row['id'],$_SESSION['id_user'])
    ?>
       <div class="vehicle-card ">
     <div class=" top-4 right-4 z-10">
    <button onclick="toggleFavorite(this, <?= $row['id'] ?>)" 
        class="favorite-btn <?= $isFavorite ? 'active' : '' ?>">
    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
              d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
    </svg>
</button>
    </div>
    <img src="<?= $row['path_image'] ?>" alt="" class="vehicle-image">
    <div class="vehicle-details">
        <div class="vehicle-header">
            <h2 class="vehicle-title"><?= $row['titre'] ?></h2>
            <div class="tags">
              
                
                    
                
            </div>
        </div>
        <form action="detailleARTICLE.php" method="POST" class="mt-4">
            <input type="hidden" name="idArticle" value="<?= $row['id'] ?>">
            <button class="reserve-button">Voir plus</button>
        </form>
    </div>
</div>
    <?php endforeach; ?>
</div>


<div class="w-full">
    <div class="pagination">
        <ul>
            <?php
    
    for ($i = 1; $i <= $nbrpages; $i++) {
        $activeClass = ($i == $page) ? 'class="active"' : '';
        echo '<li><a href="?page=' . $i . ($theme ? '&idtheme=' . $theme : '') . '" ' . $activeClass . '>' . $i . '</a></li>';
    }
    
            ?>
        </ul>
    </div>
</div>
    <script>
        function toggleFavorite(btn, articleId) {
            btn.classList.toggle('active');
            fetch('../traitement/add_favorite.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ article_id: articleId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            btn.classList.toggle('active', data.isFavorite);
        }
    });
        }
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

const combobox = document.getElementById('combobox');
const existingTags = document.getElementById('existingTags');
let selectedTags = new Set();

async function fetchTags() {
    try {
        const response = await fetch('../traitement/fetchTag.php');
        if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
         const responseText = await response.text();
         console.log(responseText);
        const tags = JSON.parse(responseText); //t$responseText TO objet
        existingTags.innerHTML = '';
        
        // Afficher chaque tag
        tags.forEach(tagFor => {
            const tagElement = document.createElement('div');
            tagElement.className = 'tag-item';
            tagElement.textContent = tagFor.tag;
            console.log(tagFor.tag);
            tagElement.dataset.id = tagFor.id;
            console.log("id",tagFor.id)
            
            tagElement.onclick = () => {
                // console.log(tagFor.tag);
                if (selectedTags.has(tagFor.tag)) {
                    selectedTags.delete(tagFor.tag);
                    tagElement.classList.remove('selected');
                } else {
                    selectedTags.add(tagFor.tag);
                    tagElement.classList.add('selected');
                }
                updateCombobox();
            };
            combobox.addEventListener('input', ()=>{
                    
            })
            
            existingTags.appendChild(tagElement);
        });
    } catch (error) {
        console.error('Erreur lors de la récupération des tags:', error);
    }
}

function updateCombobox() {
   
    combobox.value = Array.from(selectedTags ).join(', ');
    // console.log(combobox.value);
}

// Charger les tags au chargement de la page
document.addEventListener('DOMContentLoaded', fetchTags);

new Tagify(combobox, {
  delimiters: ", ", // Sépare les tags avec des virgules
  maxTags: 5,      // Nombre maximum de tags
  
});
    </script>
</body>
</html>