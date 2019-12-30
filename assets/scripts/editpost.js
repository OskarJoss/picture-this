const deletePostForm = document.querySelector(".delete-post-form");

deletePostForm.addEventListener("submit", event => {
    if (!window.confirm("Are you sure you want to delete post?")) {
        event.preventDefault();
    }
});
