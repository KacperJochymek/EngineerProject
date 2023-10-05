document.addEventListener("DOMContentLoaded", function () {
    const textarea = document.querySelector("textarea[name='tekst']");
    const maxCharacters = 2000;
    const messageElement = document.createElement("div");

    messageElement.style.color = "red";
    messageElement.style.fontSize = "14px";
    messageElement.style.marginTop = "5px";

    textarea.parentElement.appendChild(messageElement);

    textarea.addEventListener("input", function () {
        const currentCharacters = textarea.value.length;
        messageElement.innerText = `${currentCharacters} / ${maxCharacters} znaków`;

        if (currentCharacters >= maxCharacters) {
            messageElement.innerText = "Przekroczono limit 2000 znaków!";
            messageElement.style.color = "red";
            textarea.style.borderColor = "red";
            textarea.setAttribute("disabled", "true");
        } else {
            messageElement.style.color = "black";
            textarea.style.borderColor = "initial";
            textarea.removeAttribute("disabled");
        }
    });
});