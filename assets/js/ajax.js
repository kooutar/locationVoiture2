const selectCategorie = document.querySelector('#selectCategorie');
const vehicle_grid = document.querySelector('#vehicle-grid');


// filtre
selectCategorie.addEventListener('change', () => {
    const idcategorie = selectCategorie.value; 
    console.log(idcategorie);
    loadDoc(idcategorie); 
});

function loadDoc(idcategorie) {
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function () {
        const vehicules = JSON.parse(this.responseText); 
        vehicle_grid.innerHTML = ''; 
        vehicules.forEach(vehicule => {
            vehicle_grid.innerHTML += `
                <div class="vehicle-card">
                    <img src="${vehicule.path_image}" alt="" class="vehicle-image">
                    <div class="vehicle-details">
                        <div class="vehicle-header">
                            <h2 class="vehicle-title">${vehicule.nom}</h2>
                            <span class="vehicle-price">${vehicule.prix}</span>
                        </div>
                        <div class="tags">
                            <span class="tag tag-active">${vehicule.categorie}</span>
                            <span class="tag tag-family">${vehicule.lieu}</span>
                        </div>
                        <form action="detaille.php" method="POST">
                            <input type="hidden" name="idvehicule" value="${vehicule.idVehicule}">
                            <button class="reserve-button">Voir plus</button>
                        </form>
                    </div>
                </div>
            `;
        });
    };
    xhttp.open("GET", `../classe/getVehicules.php?idcategorie=${idcategorie}`, true);
    xhttp.send();
}



