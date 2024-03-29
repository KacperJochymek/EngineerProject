//Funkcja, która przewija stronę do samej góry, nie odświeżając strony.

function ScrollingTop() {
    const czas = 1000; 
    const start = window.scrollY;
    const koniec = 0;
    const timeStart = performance.now();

    function scroll() {
        const currentTime = performance.now();
        const elapsed = currentTime - timeStart;
        const progress = Math.min(elapsed / czas, 1);

        window.scrollTo(0, start + (koniec - start) * progress);

        if (progress < 1) {
            requestAnimationFrame(scroll);
        }
    }
    requestAnimationFrame(scroll);
}

const stronaGlownaLink = document.querySelector('a[href="index.php"]');

stronaGlownaLink.addEventListener('click', function (event) {
    event.preventDefault(); 
    ScrollingTop(); 
});

//Funkcja, która sprawdza, czy użytkownik jest zalogowany. Jeśli nie - przekierowuje go do strony głównej.

document.addEventListener("DOMContentLoaded", function() {
    const myLinks = document.querySelectorAll("#myLink");

    myLinks.forEach(function(link) {
        link.addEventListener("click", function(event) {
            event.preventDefault(); 

            alert("Aby korzystać z serwisu, najpierw musisz się zalogować.");
        });
    });
});


