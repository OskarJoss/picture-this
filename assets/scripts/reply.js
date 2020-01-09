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

const createReplyButtonText = numberOfReplies => {
    if (numberOfReplies === 0) {
        return "reply";
    } else if (numberOfReplies === 1) {
        return "show 1 reply";
    } else {
        return `show ${numberOfReplies} replies`;
    }
};

//show/hide all replies and the reply-form
showRepliesForms.forEach(showRepliesForm => {
    showRepliesForm.addEventListener("submit", event => {
        event.preventDefault();
        //show/hide reply-form
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
                    const replyButton = event.target.querySelector(
                        ".reply-button"
                    );
                    const replyList = event.target.parentElement.querySelector(
                        ".reply-list"
                    );
                    if (replyButton.classList.contains("active") === false) {
                        //append all replies to the reply-list
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
                        //add active class and change button text
                        replyButton.classList.add("active");
                        replyButton.textContent = "hide replies";
                    } else {
                        //hide replies, remove active class and change text of reply-button
                        replyList.innerHTML = "";
                        replyButton.classList.remove("active");
                        replyButton.textContent = createReplyButtonText(
                            json.replies.length
                        );
                    }
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
                    //append new reply to the reply-list
                    const replyList = event.target.parentElement.querySelector(
                        ".reply-list"
                    );
                    const response = json.reply;
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
                    replyForm.querySelector("textarea").value = "";
                }
            })
            .catch(error => {
                console.error("Error:", error);
            });
    });
});
