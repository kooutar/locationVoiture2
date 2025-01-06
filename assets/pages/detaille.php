<?php
session_start();
$sessionActive = isset($_SESSION['id_user']);

require_once '../classe/db.php';
require_once '../classe/vehicule.php';
require_once '../classe/reservation.php';
require_once '../classe/avis.php';
try {
    $database = new Database();
    $db = $database->connect();
} catch (PDOException $e) {
    $e->getMessage();
}
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Details</title>
    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <!-- Main Content -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <!-- Image Gallery -->
            <?php
            if ($_SERVER['REQUEST_METHOD'] == "POST"):
                $idvehicule = $_POST['idvehicule'];
                $vehicule = new vehicule($db);

                $array = $vehicule->getVehiculeWithId($idvehicule);

            ?>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4">
                    <img src="<?= $array['path_image'] ?>" alt="Car Main View" class="w-full h-96 object-cover rounded-lg">
                    <div class="mt-8 border-t pt-8">
                        <h2 class="text-xl font-semibold mb-4">Make a Reservation</h2>
                        <form class="grid grid-cols-1 md:grid-cols-2 gap-6" action="../traitement/reservation.php" method="POST">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Pickup Date</label>
                                <input type="date" name="dateResrvation" class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Return Date</label>
                                <input type="date" name="dateRendre" class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                            </div>

                            <input type="hidden" name="idvehicule" value="<?= $array['idVehicule'] ?>">
                            <?php if ($sessionActive): ?>
                                <input type="hidden" name="iduser" value="<?= $_SESSION['id_user'] ?>">
                                <?php if ($array['disponsible'] == true): ?>
                                    <p class="text-2xl font-bold text-blue-600">Indisponible</p>
                                <?php else: ?>
                                    <button type="submit" class="md:col-span-2 bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition-colors">
                                        Reserve Now
                                    </button>
                                <?php endif; ?>
                            <?php else: ?>
                                <p class="text-2xl font-bold text-blue-600">Connectez-vous pour réserver</p>
                            <?php endif; ?>

                        </form>
                        <?php
                        if(isset($_SESSION['id_user'])):
                        $resrvation = new reservation($db);
                        $resrvations = $resrvation->showAllreservation($_SESSION['id_user'], $idvehicule);
                        if ($resrvations):
                        ?>
                            <div class="max-w-md mx-auto bg-white p-6 rounded-lg">
                                <form action='../traitement/avis.php' method='POST'>
                                    <h1 class="text-2xl font-bold text-gray-800 mb-6">Donner votre avis</h1>
                                    <input type="hidden" name="idvehicule" value="<?= $idvehicule ?>">
                                    <input type="hidden" name="iduser" value="<?= $_SESSION['id_user'] ?>">
                                    <div class="flex flex-wrap gap-4">
                                        <!-- Option One -->
                                        <label class="flex items-center cursor-pointer">
                                            <input type="radio" name="radio" class="hidden peer" value='1'>
                                            <span class="w-6 h-6 rounded-full border-2 border-gray-300 flex items-center justify-center peer-checked:border-blue-500 peer-checked:bg-blue-500">
                                                <span class="w-3 h-3 bg-white rounded-full hidden peer-checked:block"></span>
                                            </span>
                                            <span class="ml-3 text-lg text-gray-700 peer-checked:font-semibold">Option One</span>
                                        </label>

                                        <!-- Option Two -->
                                        <label class="flex items-center cursor-pointer">
                                            <input type="radio" name="radio" class="hidden peer" value='2'>
                                            <span class="w-6 h-6 rounded-full border-2 border-gray-300 flex items-center justify-center peer-checked:border-blue-500 peer-checked:bg-blue-500">
                                                <span class="w-3 h-3 bg-white rounded-full hidden peer-checked:block"></span>
                                            </span>
                                            <span class="ml-3 text-lg text-gray-700 peer-checked:font-semibold">Option Two</span>
                                        </label>

                                        <!-- Option Three -->
                                        <label class="flex items-center cursor-pointer">
                                            <input type="radio" name="radio" class="hidden peer" value='3'>
                                            <span class="w-6 h-6 rounded-full border-2 border-gray-300 flex items-center justify-center peer-checked:border-blue-500 peer-checked:bg-blue-500">
                                                <span class="w-3 h-3 bg-white rounded-full hidden peer-checked:block"></span>
                                            </span>
                                            <span class="ml-3 text-lg text-gray-700 peer-checked:font-semibold">Option Three</span>
                                        </label>

                                        <!-- Option Four -->
                                        <label class="flex items-center cursor-pointer">
                                            <input type="radio" name="radio" class="hidden peer" value='4'>
                                            <span class="w-6 h-6 rounded-full border-2 border-gray-300 flex items-center justify-center peer-checked:border-blue-500 peer-checked:bg-blue-500">
                                                <span class="w-3 h-3 bg-white rounded-full hidden peer-checked:block"></span>
                                            </span>
                                            <span class="ml-3 text-lg text-gray-700 peer-checked:font-semibold">Option Four</span>
                                        </label>
                                    </div>


                                    <div class="mt-6">
                                        <label for="feedback" class="block text-gray-700 font-semibold mb-2">Avis</label>
                                        <textarea
                                            id="feedback"
                                            name="commentaire"
                                            class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
                                            rows="4"
                                            placeholder="Écrivez votre avis ici..."></textarea>
                                    </div>

                                    <button
                                        type="submit"
                                        class="mt-6 w-full bg-blue-500 text-white py-2 px-4 rounded-lg font-semibold hover:bg-blue-600 transition">
                                        Envoyer
                                    </button>
                                </form>
                            </div>
                        <?php endif;
                         endif; ?>

                    </div>
                </div>
                <!-- Car Info -->
                <div class="p-6">
                    <div class="flex justify-between items-center">
                        <h1 class="text-3xl font-bold text-gray-800"><?= $array['nom'] ?></h1>
                        <p class="text-2xl font-bold text-blue-600"><?= $array['prix'] ?>/jour</p>
                    </div>

                    <!-- Tags -->
                    <div class="flex gap-2 mt-4">
                        <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm">
                            <?php if ($array['disponsible'] == false): ?>
                                disponible
                            <?php else : ?>
                                indisponible
                            <?php endif; ?>
                        </span>
                        <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm"><?= $array['categorie'] ?></span>
                    </div>

                    <!-- Specifications -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-8">
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <p class="text-gray-500">Mileage</p>
                            <p class="text-lg font-semibold">3100 mi</p>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <p class="text-gray-500">Power</p>
                            <p class="text-lg font-semibold">240 HP</p>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <p class="text-gray-500">Transmission</p>
                            <p class="text-lg font-semibold">Automatic</p>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <p class="text-gray-500">Year</p>
                            <p class="text-lg font-semibold">2016</p>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mt-8">
                        <h2 class="text-xl font-semibold mb-4">Description</h2>
                        <p class="text-gray-600 leading-relaxed">
                            Luxury vehicle with excellent performance and comfort. Features include leather seats,
                            premium sound system, and advanced safety features.
                        </p>
                    </div>

                    <div class="ml-8 p-4 bg-gray-100 rounded-lg shadow-md">
    <?php
    $avis = new avis($db);
    $arrayAvis = $avis->afficheAvis($idvehicule);
    if($arrayAvis){
    ?>
    <div class="mb-4 border-b border-gray-300 pb-2">
        <h1 class="text-xl font-bold text-gray-800"><?= $arrayAvis['nom'] ?></h1>
        <p class="text-gray-600"><?= $arrayAvis['commentaire'] ?></p>
    </div>
    <?php } ?>
</div>

                </div>
            <?php

            endif
            ?>




        </div>
    </div>
</body>

</html>