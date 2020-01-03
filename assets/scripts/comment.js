const commentForms = document.querySelectorAll(".comment-form");

const createCommentTemplate = (avatar, username, comment) => {
    return `<div class="avatar-container">
                <img class="avatar" src="/uploads/avatars/${avatar}" alt="avatar">
            </div>
            <p><span>${username}</span>${comment}</p>`;
};

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
                    //append the comment to the comment-list
                    const commentList = event.target.parentElement.querySelector(
                        ".comment-list"
                    );
                    const comment = document.createElement("li");
                    comment.classList.add("comment");
                    comment.innerHTML = createCommentTemplate(
                        json.user.avatar,
                        json.user.username,
                        json.comment.comment
                    );
                    commentList.appendChild(comment);
                    //empty the input field after comment is appended
                    const commentInput = commentForm.querySelector("textarea");
                    commentInput.value = "";
                }
            })
            .catch(error => {
                console.error("Error:", error);
            });
    });
});
