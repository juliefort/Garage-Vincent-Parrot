document.addEventListener('DOMContentLoaded', () => {
// Récupération des éléments du DOM 
const stars = document.querySelectorAll('.fa-star');
const formRating = document.querySelector('#review_rating');

stars.forEach(star => {
    star.addEventListener("mouseover", function() {
        // Appel de la fonction permettant de réinitialiser la couleur originelle
        regularStars();
        this.style.color = "red";
        this.classList.add('fa-solid');

        // Élément frère/soeur précédent dans le DOM
        let previousStar = this.previousElementSibling;

        // Appel de l'étoile précédente à chaque fois que l'on passe à une autre
       while(previousStar) {
            previousStar.style.color= "red";  
            previousStar.classList.add('fa-solid');
            previousStar = previousStar.previousElementSibling;
       }

    });

    // Au clique sur l'étoile on récupère sa valeur dans le data-set
    star.addEventListener('click', function() { 
        formRating.value = this.dataset.value;
    });
});

// On redonne la couleur initial de l'étoile
const regularStars = () => {
    stars.forEach(star => {
         star.style.color = "yellow";
         star.classList.remove('fa-solid');
    })
}

// Ajout d'une étoile à côté de la note laissé dans la section Review
const ratings = document.querySelectorAll('.ratings');
ratings.forEach(rating => {    
    rating.classList.add('fa-star');
    rating.classList.add('fa-regular');
    rating.style.color = 'red';
});
    
})

