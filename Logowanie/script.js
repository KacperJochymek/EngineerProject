//Funkcja, która służy do przewijania pomiędzy formularzem logowania, a formularzem rejestracji.
const container = document.querySelector(".container");
const pwShowHideIcons = document.querySelectorAll(".showHidePw");
const pwFields = document.querySelectorAll(".password");
const signUp = document.querySelector(".signup-link");
const login = document.querySelector(".login-link");

pwShowHideIcons.forEach(eyeIcon => {
    eyeIcon.addEventListener("click", () => {
        pwFields.forEach(pwField => {
            if (pwField.type === "password") {
                pwField.type = "text";
                eyeIcon.classList.replace("fa-solid", "fa-regular");
            } else {
                pwField.type = "password";
                eyeIcon.classList.replace("fa-regular", "fa-solid");
            }
        });
    });
});

signUp.addEventListener("click", () => {
    container.classList.add("active");
});

login.addEventListener("click", () => {
    container.classList.remove("active");
});

