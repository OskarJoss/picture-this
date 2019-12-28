"use_strict";

const showFormButtons = document.querySelectorAll(".show-form-button");

showFormButtons.forEach(btn => {
    btn.addEventListener("click", event => {
        console.log(event.target);
    });
});
