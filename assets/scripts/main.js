const messages = document.querySelectorAll(".messages");

messages.forEach(message => {
    setTimeout(() => {
        message.parentElement.removeChild(message);
    }, 1500);
});
