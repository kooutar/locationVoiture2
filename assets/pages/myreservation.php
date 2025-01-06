<?php 
require_once '../classe/db.php';
require_once '../classe/reservation.php';
require_once '../classe/vehicule.php';
 session_start();
 $sessionActive= isset($_SESSION['id_user']) ;
 if($sessionActive){


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Reservations</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .navbar {
            background-color: black;
            color: white;
            padding: 10px;
            text-align: center;
        }
        .navbar ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
            display: flex;
            justify-content: center;
        }
        .navbar li {
            margin: 0 15px;
        }
        .navbar a {
            color: white;
            text-decoration: none;
        }
        .container {
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #4e4ffa;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
        th {
            background-color:rgb(151, 151, 214);
            color: white;
        }
        .btn {
            padding: 5px 10px;
            border: none;
            color: white;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .edit {
            background-color: green;
        }
        .remove{
            background-color: red;
        }
        .btn:hover {
            background-color: #3c3ccf;
        }
    </style>
</head>
<body class="min-h-screen bg-gray-100">

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

<div class="container">
    <h1>My Reservations</h1>
    <table>
        <tr>
            <th>Vehicule</th>
            <th>Image Vehicule</th>
            <th>Date de Rendre</th>
            <th>Date de Reservation</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php 
        try{
        $database = new Database();
        $db =$database->connect();   
        }catch(PDOException $e){
            $e->getMessage();
        }
         $reservation= new reservation($db);
         $reservations=$reservation->showALLreservationCleint($_SESSION['id_user']);
         
          foreach($reservations as $reservation){
           
            ?>
             <tr>
             <td><?= $reservation['nom']?></td>
             <td><img src='<?=$reservation['path_image']?>' alt="Clio" style="width:100px;"></td>
             <td><?=$reservation['date_fin'] ?></td>
             <td><?=$reservation['date_debut'] ?></td>
             <td><?=$reservation['status']?></td>
             <td>
                 <button class="btn edit"
                        data-id="<?= $reservation['idVehicule']?>"
                        data-nom="<?=$reservation['nom']?>" 
                        data-finDate="<?=$reservation['date_fin'] ?>" 
                        data-debutDate="<?=$reservation['date_debut']?>" >Edit</button>
                <form action="../traitement/removeReservation.php" method="POST">
                <input type="hidden"  id='idvehicule' name="idvehicule">
                <input type="hidden" id ='modal-id' name='iduser' value='<?=$_SESSION['id_user']?>'>
                 <button class="btn remove ">Remove</button>
                 </form>
             </td>
         </tr>
         <?php
          }
        ?>
       
    </table>
</div>
<?php 
 }
?>
     <div id="modalEdit" class="fixed inset-0 bg-black bg-opacity-50 hidden">
    <div class="bg-white rounded-lg w-96 mx-auto mt-20 p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold">Edit reservation</h2>
            <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <form action="../traitement/updateReseravtion.php" method="POST">
            <div class="space-y-4">
                <input type="hidden"  id='idvehicule' name="idvehicule">
                 <input type="hidden" id ='modal-id' name='iduser' value='<?=$_SESSION['id_user']?>'>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">date reservation</label>
                    <input type="date" id="modal-datedebut" name="dateRservation" value=" " class="w-full border rounded-lg px-3 py-2" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">date rendre</label>
                    <input type="date" id="modal-datefin" name="dateRendre" value="" class="w-full border rounded-lg px-3 py-2" required>
                </div>
                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">
                    Update reservation
                </button>
            </div>
        </form>
    </div>
</div>
<script>
    function closeModal() {
    document.getElementById('modalEdit').classList.add('hidden');
}
    bteEdit= document.querySelectorAll('.edit');
    selectVehicule=document.getElementById('selectVehicule');
    datedebut =document.getElementById('modal-datedebut');
    datefin=document.getElementById('modal-datefin');
    modaleEdit=document.querySelector('#modalEdit');
    idvehicule=document.getElementById('idvehicule');
    bteEdit.forEach(bte =>{
        bte.addEventListener('click',()=>{
            console.log(bte.dataset)
            datedebut.value=bte.dataset.debutdate
            datefin.value=bte.dataset.findate
            idvehicule.value=bte.dataset.id;
            modaleEdit.classList.remove('hidden')
        })
    })
      
</script>
</body>
</html>
