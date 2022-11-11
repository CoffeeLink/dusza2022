const loginButton = document.getElementById('#frmLogin');
const loginForm = document.getElementById('#loginForm');

loginButton.addEventListener('submit', async e => {
    e.preventDefault();

    const email = loginForm['username'].value;
    const password = loginForm['password'].value;

    const response = await fetch('/handlers/authorize.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
        },
        body: JSON.stringify({
            username: email,
            password: password,
        }),
    });
});
