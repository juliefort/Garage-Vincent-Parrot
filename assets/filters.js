// Récupération de mes éléments du DOM 
const toggleReset = document.querySelector('#toggleReset');
const filterValue1 = document.querySelector('#filterValue1');
const filterValue2 = document.querySelector('#filterValue2');
const filterValue3 = document.querySelector('#filterValue3');
const slider1 = document.querySelector('.slider1');
const slider2 = document.querySelector('.slider2');
const slider3 = document.querySelector('.slider3');
const carPrice= document.querySelector('#carPrice');
const carYear = document.querySelector('#carYear');
const carKilometers = document.querySelector('#carKilometers');
const carManufacturer = document.querySelector('#manufacturer');
const carFuel = document.querySelector('#carFuel');

// Réinitialisation des filtres
toggleReset.addEventListener('click', () => {
    slider1.value = 0;
    slider2.value = 0;
    slider3.value = 0;
})



