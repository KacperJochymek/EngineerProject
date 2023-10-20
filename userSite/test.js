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

//Mapa największych miast i przypisanych do nich województw
var miastaWojewodztwa = {
    "Warszawa": "Mazowieckie",
    "Kraków": "Małopolskie",
    "Gdańsk": "Pomorskie",
    "Rzeszów": "Podkarpackie",
    "Lublin": "Lubelskie",
    "Gdańsk": "Pomorskie",
    "Poznań": "Wielkopolskie",
    "Katowice": "Śląskie",
};


//Walidacja formularza po kalendarzu  

function validateForm() {
    var imie = document.getElementById("imie").value;
    var nazwisko = document.getElementById("nazwisko").value;
    var wiek = document.getElementById("wiek").value;
    var pesel = document.getElementById("pesel").value;
    var miasto = document.getElementById("miasto").value;
    var wojewodztwo = document.getElementById("wojewodztwo").value;

    if (imie === "" || nazwisko === "") {
        alert("Imię i nazwisko są wymagane");
        return false;
    }

    if (isNaN(wiek)) {
        alert("Wiek musi być liczbą");
        return false;
    }

    if (pesel.length !== 11 || isNaN(pesel)) {
        alert("Pesel musi składać się z 11 cyfr");
        return false;
    }

    if (miasto === "" || wojewodztwo === "") {
        alert("Miasto i województwo są wymagane");
        return false;
    }

    if (miastaWojewodztwa[miasto] !== wojewodztwo) {
        alert("Podane miasto nie znajduje się w wybranym województwie.");
        return false;
    }

    return true; 
}

//Skrypt do myAccount.php -- skryt do naprawienia, div mojeWizyty sie źle wyświetla + trzeba zrobić css'a dla tego drugiego
document.addEventListener("DOMContentLoaded", function () {

    var settingi = document.querySelector(".settingi");
    var mojeWizyty = document.querySelector(".mojeWizyty");
    var settingsInpt = document.querySelector(".settings-inpt");

    // Początkowo ukryj settings-inpt
    settingsInpt.style.display = "none";

    // Utwórz zmienną do śledzenia widoczności mojeWizyty
    var mojeWizytyVisible = true;

    settingi.addEventListener("click", function (event) {
        event.preventDefault();

        if (mojeWizytyVisible) {
            // Ukryj mojeWizyty
            mojeWizyty.style.display = "none";
            // Wyświetl settings-inpt
            settingsInpt.style.display = "block";
            mojeWizytyVisible = false;
        } else {
            // Jeśli mojeWizyty jest już ukryte, przywróć je
            mojeWizyty.style.display = "block";
            settingsInpt.style.display = "none";
            mojeWizytyVisible = true;
        }
    });

    // Pobierz przycisk "Powrót"
    var zwrotButton = document.getElementById("zwrot");

    zwrotButton.addEventListener("click", function (event) {
        event.preventDefault();

        // Wyświetl mojeWizyty
        mojeWizyty.style.display = "block";

        // Ukryj settings-inpt
        settingsInpt.style.display = "none";
        mojeWizytyVisible = true;
    });

});

