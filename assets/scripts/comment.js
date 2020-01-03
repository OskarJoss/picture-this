const commentForms = document.querySelectorAll(".comment-form");

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
                //display problems with the POST data
                if (json.status === false) {
                    window.alert(json.errors);
                } else {
                    console.log(json.postId);
                }
            })
            .catch(error => {
                console.error("Error:", error);
            });
    });
});
