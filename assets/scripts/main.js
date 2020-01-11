"use_strict";
//to use on showing replies
let showRepliesForms = document.querySelectorAll(".show-replies-form");
let replyForms = document.querySelectorAll(".reply-form");

const messages = document.querySelectorAll(".messages");

messages.forEach(message => {
    setTimeout(() => {
        message.parentElement.removeChild(message);
    }, 1500);
});
