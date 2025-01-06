<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Drive & Loc - Inscription</title>
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

    <!-- Registration Form Section -->
    <div class="min-h-screen flex items-center justify-center bg-cover bg-center" style="background-image: url('../images/welcome-hero/welcome-banner.jpg'); background-color: rgba(0,0,0,0.5); background-blend-mode: overlay;">
        <div class="bg-white p-8 rounded-lg shadow-xl w-full max-w-md m-4">
            <h2 class="text-2xl font-bold text-center mb-8 text-gray-800">Connection</h2>
            
            <form class="space-y-6" action="../traitement/login.php" method="POST">
                <div class="space-y-4">
                    

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Email">
                    </div>

                   
                   
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Mot de passe</label>
                        <input type="password" name="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="mot de passe">
                    </div>

                    
                </div>

                <div>
                    <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Se connecter
                    </button>
                </div>
            </form>

            <!-- <p class="mt-4 text-center text-sm text-gray-600">
                Déjà un compte? 
                <a href="#" class="font-medium text-blue-600 hover:text-blue-500">
                    Connectez-vous
                </a>
            </p> -->
        </div>
    </div>
</body>
</html>