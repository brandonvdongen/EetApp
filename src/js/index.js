document.addEventListener("DOMContentLoaded", (ev) => {
    let meals = document.querySelectorAll(".meal");
    meals.forEach((meal, index, array) => {
        console.log(meal);
        meal.addEventListener("click", function () {
            console.log(meal.dataset.id);
            window.location.href = "index.php?page=mealinfo&mealid=" + meal.dataset.id;
        });
    })
});