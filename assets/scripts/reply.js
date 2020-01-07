"use_strict";

const replyButtons = document.querySelectorAll(".reply-button");
const replyForms = document.querySelectorAll(".reply-form");

// show the reply-form
replyButtons.forEach(replyButton => {
    replyButton.addEventListener("click", event => {
        const replyForm = event.target.parentElement.parentElement.querySelector(
            ".reply-form"
        );
        replyForm.classList.add("visible");
    });
});

replyForms.forEach(replyForm => {
    replyForm.addEventListener("submit", event => {
        event.preventDefault();
        const formData = new FormData(replyForm);
        fetch("http://localhost:8000/app/posts/createreply.php", {
            method: "POST",
            body: formData
        })
            .then(reply => {
                return reply.json();
            })
            .then(json => {
                //display problems with invalid $_POST data
                if (json.valid === false) {
                    window.alert(json.errors);
                } else {
                    console.log(json);
                }
            })
            .catch(error => {
                console.error("Error:", error);
            });
    });
});
