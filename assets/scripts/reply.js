"use_strict";

const showRepliesForms = document.querySelectorAll(".show-replies-form");
const replyForms = document.querySelectorAll(".reply-form");

const createReplyTemplate = (userId, avatar, username, reply) => {
    return `<a href="/profile.php?id=${userId}">
    <div class="avatar-container">
    <img class="avatar" src="/uploads/avatars/${avatar}" alt="avatar">
    </div>
    </a>
    <p><a href="/profile.php?id=${userId}"><span>${username}</span></a>${reply}</p>`;
};

//show/hide all replies and the reply-form
showRepliesForms.forEach(showRepliesForm => {
    showRepliesForm.addEventListener("submit", event => {
        event.preventDefault();
        //show reply-form
        const replyForm = event.target.parentElement.querySelector(
            ".reply-form"
        );
        replyForm.classList.toggle("visible");
        //fetch all replies to the comment
        const formData = new FormData(showRepliesForm);
        fetch("http://localhost:8000/app/posts/getallreplies.php", {
            method: "POST",
            body: formData
        })
            .then(response => {
                return response.json();
            })
            .then(json => {
                //display problems with invalid $_POST data
                if (json.valid === false) {
                    window.alert(json.errors);
                } else {
                    //append all replies to the reply-list
                    const replyList = event.target.parentElement.querySelector(
                        ".reply-list"
                    );
                    json.replies.forEach(response => {
                        const replyTemplate = createReplyTemplate(
                            response.user_id,
                            response.avatar,
                            response.username,
                            response.reply
                        );
                        const reply = document.createElement("li");
                        reply.classList.add("reply");
                        reply.innerHTML = replyTemplate;
                        replyList.appendChild(reply);
                    });
                }
            });
    });
});

//create reply and append it to the reply-list
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
