<?php 
session_start();
require_once '../classe/db.php';
require_once '../classe/article.php';
require_once '../classe/tag.php';
require_once '../classe/tag_article.php';
require_once '../classe/commentaire.php';
try {

    $database = new Database();
    $db = $database->connect();
   
} catch (PDOException $e) {
    $e->getMessage();
}


?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Détails Article</title>
</head>

<body class="bg-gray-50">
    <div class="max-w-4xl mx-auto p-4 mt-8">
    
        <!-- Image Banner -->
        <div class="w-full rounded-xl overflow-hidden shadow-lg mb-8 h-[400px]">
            <?php
            if($_SERVER['REQUEST_METHOD']=='POST'){
                $tag = new tag($db);
                $article = new article($db);
                $article_tag= new tag_article($db);
                $idArticle=$_POST['idArticle'];
                $articles=$article->getarticlebyId($idArticle);
                 $tags=$article_tag->afficheTag_article($idArticle);
            
               
            }
            foreach($articles as $article){ 
            ?>
            <img src="<?= $article['path_image'] ?>" 
                 alt="<?= $article['titre'] ?>" 
                 class="w-full h-full object-cover">
        </div>

        <!-- Content Section -->
        <div class="bg-white rounded-xl shadow p-8">
            <!-- Header -->
            <div class="flex justify-between items-start mb-6">
                <h1 class="text-3xl font-bold text-gray-900"><?= $article['titre'] ?></h1>
                <div class="flex items-center space-x-4">
                    <div class="text-right">
                        <p class="text-sm text-gray-500">Publié par</p>
                        <p class="font-medium text-gray-900"><?= $article['iduser'] ?></p>
                    </div>
                    <img src="../images/clients/c1.png" 
                         alt="Avatar" 
                         class="w-12 h-12 rounded-full">
                </div>
            </div>

            <!-- Tags -->
            <div class="flex flex-wrap gap-2 mb-6">
                <?php foreach($tags as $tag): ?>
                    <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">
                        <?= $tag['tag'] ?>
                    </span>
                <?php endforeach; ?>
            </div>

            <!-- Content -->
            <div class="prose max-w-none">
                <p class="text-gray-700 leading-relaxed">
                    <?= nl2br($article['contenu']) ?>
                </p>
            </div>
  

  <div class="max-w-4xl mx-auto p-4 mt-8 bg-white rounded-xl shadow">
    <!-- Formulaire nouveau commentaire -->
    <form class="mb-8" action="../traitement/add_comment.php" method="POST">
        <input type="hidden" name="article_id" value="<?= $article['id'] ?>">
        <div class="mb-4">
            <label class="text-sm font-medium text-gray-700">Votre commentaire</label>
            <textarea name="comment" rows="3" class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"></textarea>
        </div>
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            Publier
        </button>
    </form>

    <!-- Liste des commentaires -->
    <div class="space-y-6">
    <?php
                    $commentaire= new commentaire($db);
                    $commentaires=$commentaire->getALLcommentaire($article['id']);
                    foreach($commentaires as $comm){
                    ?>
        <div class="flex space-x-4 p-4 border rounded-lg">
            <img src="../images/clients/c2.png" class="w-10 h-10 rounded-full">
            <div class="flex-1">
                <div class="flex justify-between items-center mb-2">
                    <h4 class="font-medium text-gray-900"></h4>
                    <span class="text-sm text-gray-500"></span>
                </div>
                <p class="text-gray-700"></p>
                
                <!-- Actions commentaire -->
                <div class="flex items-center space-x-4 mt-2">
                   
                   
                    <p><?= $comm['commentaire']?></p>
                    
                </div>
            </div>
        </div>
        <?php    
                    }
                   ?>
        
    </div>
</div>
<?php }?>
            <!-- Actions -->
            <div class="flex justify-between items-center mt-8 pt-6 border-t">
                
                
                <a href="articles.php" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-300">
                    Retour aux articles
                </a>
            </div>


        </div>
    </div>
</body>
</html>