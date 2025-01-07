<?php 
require_once '../classe/db.php';
require_once '../classe/theme.php';
try {
   $database= new Database();
   $db=$database->connect();
} catch (PDOException $e) {
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
<body>
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

  

 
    <div id="articlesContainer" class="max-w-6xl mx-auto px-4 mt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php 
           $theme = new theme($db);
           $themes=$theme->getALLTheme();
           foreach($themes as $theme) {
        ?>
    <div class="max-w-sm bg-white rounded-lg shadow-lg overflow-hidden">
     <img class="w-full h-48 object-cover" src="../images/brand/br1.png" alt="Card image">
            <div class="p-5">
                <h2 class="text-xl font-bold mb-3 text-gray-800"><?= $theme['theme']?></h2>
                <button class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-300">
                    <a href="articles.php?idtheme=<?=$theme['idtheme']?>">voir plus</a>
                </button>
            </div>
        </div>
        <?php }?>
    </div>
   

   
</body>
</body>
</html>