const searchForm = document.querySelector('.search');

searchForm.addEventListener('input', (e) => {
    e.preventDefault();
    const formData = new FormData(searchForm);

    const list = document.querySelector('.search-result');
    const noResult = document.querySelector('.error');

    list.innerHTML = '';
    noResult.textContent = '';

    const createSearchResult = (avatar, id, username) => {
        return `<img class="search-avatar" src="/uploads/avatars/${avatar}"> <a href="profile.php?id=${id}">${username}</a>`
    }

    fetch('/app/users/search.php', {
        method: 'POST',
        body: formData
    })
        .then(response => {
            return response.json();
        })
        .then (users => {
            console.log(users);
            if(e.target.value.length >= 2) {
                noResult.textContent = '';
            if (users.length === 0) {
                const noUsersFound = document.createElement('p');
                noUsersFound.textContent = 'No users found';
                noResult.appendChild(noUsersFound);
            }
        }
            users.forEach(user => {
                if(e.target.value.length < 2) {
                    list.innerHTML = '';
                }

                if (e.target.value.length >= 2) {
                    const item = document.createElement('li');
                    item.innerHTML = createSearchResult(user.avatar, user.id, user.username);
                    list.appendChild(item);
                }
            });
        })
})

