"use_strict";

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

//Activate the reply buttons on initially visible comments
showRepliesForms.forEach(showRepliesForm => {
    activateReplyButton(showRepliesForm);
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
