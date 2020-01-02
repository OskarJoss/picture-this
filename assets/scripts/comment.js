const commentForms = document.querySelectorAll(".comment-form");

if (commentForms !== null) {
    commentForms.forEach(commentForm => {
        commentForm.addEventListener("submit", event => {
            event.preventDefault();
            const formData = new FormData(commentForm);
            fetch("http://localhost:8000/app/posts/createcomment.php", {
                method: "POST",
                body: formData
            })
                .then(response => {
                    return response.json();
                })
                .then(json => {
                    console.log(json);
                })
                .catch(error => {
                    console.error("Error:", error);
                });
        });
    });
}
