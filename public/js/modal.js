var modal = document.getElementById("reservationModal");
var btn = document.getElementById("openModalBtn");
var span = document.getElementsByClassName("close")[0];

// Ouvrir le modal lorsqu'on clique sur le bouton
btn.onclick = function() {
    modal.style.display = "block";
}

// Fermer le modal lorsqu'on clique sur la croix
span.onclick = function() {
    modal.style.display = "none";
}

// Fermer le modal si l'utilisateur clique en dehors du modal
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
    document.getElementById('mealType').addEventListener('change', function () {
        const mealType = this.value;
        const menuItemSelect = document.getElementById('menuItem');
        menuItemSelect.innerHTML = '';

        const menuOptions = {
            ptitDej: [
                { name: 'Le Pack Essentiel', price: '10€/pers' },
                { name: 'Formule Confort', price: '20€/pers' },
                { name: 'Formule Prestige', price: '30€/pers' },
                { name: 'Le brunch Frenchy', price: '40€/pers' },
            ],
            dej: [
                { name: 'Pâtes crémeuses aux champignons', price: '34€' },
                { name: 'Pizza aux saveurs de la mer', price: '53€' },
                { name: 'Truffe', price: '45€' },
                 { name: 'Salade Cesar', price: '30€' },
            ],
            diner: [
                { name: 'Sauté de veau aux morilles', price: '45€' },
                { name: 'Poulet grillé aux girolles et crème', price: '39€' },
                { name: 'Pâtes au citron et au poulet', price: '41€' },
                { name: 'Délicieux Steak au poivre et frites', price: '50€' },
            ],
        };

        const options = menuOptions[mealType] || [];
        options.forEach(item => {
            const option = document.createElement('option');
            option.value = item.name;
            option.textContent = `${item.name} - ${item.price}`;
            menuItemSelect.appendChild(option);
        });
    });

    document.getElementById('mealType').dispatchEvent(new Event('change'));