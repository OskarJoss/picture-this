"use_strict";

const replyButtons = document.querySelectorAll(".reply-button");

replyButtons.forEach(replyButton => {
    replyButton.addEventListener("click", event => {
        const replyForm = event.target.parentElement.parentElement.querySelector(
            ".reply-form"
        );
        replyForm.classList.add("visible");
    });
});
