// Récupération de mes éléments du DOM 
const slider1 = document.querySelector('#slider1');
const slider2 = document.querySelector('#slider2');
const slider3 = document.querySelector('#slider3');

const filters = document.querySelectorAll('div.filtered');

const filteredCars = () => {

    const getPrice = parseInt(slider1.value, 10);
    const getKilometers = parseInt(slider2.value, 10);
    const getYear = parseInt(slider3.value, 10);

    let filter1 = document.querySelector('.getFilter1').innerHTML = `${getPrice} `;
    let filter2 = document.querySelector('.getFilter2').innerHTML = `${getKilometers} km`;
    let filter3 = document.querySelector('.getFilter3').innerHTML = getYear;  

    filters.forEach(filter => {
        const price = parseInt(filter.getAttribute('data-price'), 10);
        const kilometers = parseInt(filter.getAttribute('data-kilometers'), 10);
        const year = parseInt(filter.getAttribute('data-year'), 10);

        if(price <= getPrice && kilometers <= getKilometers && year <= getYear) 
        {
            filter.style.display = '';     
        } else {
            filter.style.display = 'none';
        }
});


}

slider1.addEventListener('input', filteredCars);
slider2.addEventListener('input', filteredCars);
slider3.addEventListener('input', filteredCars);
   
const toggleReset = document.querySelector('#toggleReset');

// Réinitialisation des filtres 
toggleReset.addEventListener('click', (e) => {
    e.preventDefault();

    slider1.value = '25000';
    slider2.value = '100000';
    slider3.value = '2024';

    filters.forEach(filter => {
        filter.style.display = '';
        filter.value = ''
    })
});

   


