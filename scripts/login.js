import {useFetch, toBase64} from "./modules/fetchTools.js";

function loginFormHandling() {
    let loginForm = document.querySelector('.loginForm');
    loginForm.addEventListener('submit', (e) => {
        e.preventDefault();

        const formData = new FormData(e.target);
        const form = Object.fromEntries(formData);

        useFetch('/S2_PHP/api/user/login', 'POST', {
            pseudo: form.pseudo,
            password: form.password
        }).then(results => {
            if (results) {
                sessionStorage.setItem('fashion_token', results);
                location.assign('/S2_PHP/home.html');
            } else {
                alert("Vos identifiants sont erronés")
            }
        })
    })
}

function registerFormHandling() {
    let registerForm = document.querySelector('.registerForm');
    registerForm.addEventListener('submit', async (e) => {
        e.preventDefault();

        const formData = new FormData(e.target);
        const form = Object.fromEntries(formData);

        // vérifier que profile pic est une image

        const base64picture = await toBase64(form.profile_picture).catch(e => Error(e));
        if (!base64picture instanceof Error) {
            alert("The BASE64 translations didn't work");
            return;
        }

        useFetch('/S2_PHP/api/user/', 'POST', {
            pseudo: form.pseudo,
            mail_address: form.mail_address,
            password: form.password,
            name: form.name,
            firstname: form.firstname,
            date_of_birth: form.date_of_birth,
            profile_picture: base64picture
        }).then(results => {
            if (results) {
                alert("Vous avez créé votre compte ! Vous pouvez à présent vous connecter");
            } else {
                alert("L'enregistrement de votre compte n'a pas fonctionné. Vérifiez vos entrées, elles doivent toute être complètes")
            }
        })
    })
}

window.addEventListener('DOMContentLoaded', () => {
    if (sessionStorage.getItem('fashion_token')) {
        location.assign('/S2_PHP/home.html');
    }

    loginFormHandling();
    registerFormHandling();
})