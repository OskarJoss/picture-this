"use strict";

const likeBtns = document.querySelectorAll(".like-button");
likeBtns.forEach(likeBtn => {
    likeBtn.addEventListener("click", event => {
        const formData = new FormData();
        const postId = event.target.dataset.id;
        formData.set("id", postId);
        fetch("http://localhost:8000/app/posts/likes.php", {
            method: "POST",
            body: formData
        })
            .then(response => {
                return response.json();
            })
            .then(message => {
                console.log(message);
            });
    });
});

//använd för att updatera texten
//gör en funktion som tar emot response.action och updaterar likesiffran och knappen efter det.
likeBtns.forEach(likeBtn => {
    likeBtn.addEventListener("click", event => {
        const likeBox = event.target.parentElement.querySelector("p");
        console.log(likeBox);
    });
});
