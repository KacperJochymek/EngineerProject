document.addEventListener("DOMContentLoaded", function () {
    // Pobierz przycisk "DALEJ"
    var dalejButton = document.querySelector(".lekarz-btn[name='submit']");
    
    // Pobierz kontenery kalendarza, formularza, "guziczki" i "availableHours"
    var calendarContainer = document.getElementById("calendarContainer");
    var formContainer = document.getElementById("formContainer");
    var guziczkiContainer = document.getElementById("guziczki");
    var availableHoursContainer = document.getElementById("availableHours");
    
    // Pobierz przycisk "Powrót"
    var powrotButton = document.getElementById("powrotButton");
    
    // Pobierz element <p class="lekarz-wybierz">
    var lekarzWybierzText = document.getElementById("lekarz-wybierz-text");
    
    // Dodaj obsługę zdarzenia kliknięcia przycisku "DALEJ"
    dalejButton.addEventListener("click", function (event) {
        event.preventDefault();
        
        // Ukryj kalendarz
        calendarContainer.style.display = "none";
        
        // Ukryj "guziczki" i "availableHours"
        guziczkiContainer.style.display = "none";
        availableHoursContainer.style.display = "none";
        
        // Wyświetl formularz
        formContainer.style.display = "block";
        
        // Zaktualizuj tekst na "Podaj dane osobowe:"
        lekarzWybierzText.textContent = "Podaj dane osobowe:";
    });

    // Dodaj obsługę zdarzenia kliknięcia przycisku "Powrót"
    powrotButton.addEventListener("click", function (event) {
        event.preventDefault();
        
        // Wyświetl kalendarz
        calendarContainer.style.display = "block";
        
        // Wyświetl "guziczki" i "availableHours"
        guziczkiContainer.style.display = "block";
        availableHoursContainer.style.display = "block";
        
        // Ukryj formularz
        formContainer.style.display = "none";
        
        // Zaktualizuj tekst na "Wybierz date i godzine wizyty:"
        lekarzWybierzText.textContent = "Wybierz date i godzine wizyty:";
    });
});

