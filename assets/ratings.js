window.onload = () => {
    // Récupération de l'élément du DOM pour récupérer la note
const stars = document.querySelectorAll('.fa-star');
const formRating = document.querySelector('#review_rating');
const ratings = document.querySelectorAll('.ratings');

stars.forEach(star => {
    star.addEventListener("mouseover", function() {
        regularStars();
        this.style.color = "red";

        // Élément sibling précédent dans le DOM
        let previousStar = this.previousElementSibling;

       while(previousStar) {
            previousStar.style.color= "red";  
            previousStar = previousStar.previousElementSibling;
       }

    });

    star.addEventListener('click', function() { 
        formRating.value = this.dataset.value;
        console.log(formRating.value)
    });
});

const regularStars = () => {
    stars.forEach(star => {
         star.style.color = "yellow";
    })
}

ratings.forEach(rating => {    
    ratings.classList.add('fa-star');
    ratings.classList.add('fa-regular');
    ratings.style.color = 'red';
});
    
}

