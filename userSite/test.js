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

        const selectedDate = document.getElementById("selectedDate").textContent;
        const selectedHour = document.getElementById("selectedHour").textContent;
    
        // Sprawdź, czy tekst nie jest pusty
        if (!selectedDate.trim()) {
            document.querySelector('.messageSent').textContent = "Proszę wybrać datę wizyty.";
            return;
        }

        if (selectedHour === "Godzina twojej wizyty") {
            document.querySelector('.messageSent').textContent = "Proszę wybrać godzinę wizyty.";
            return false;
        }
        
        // Ukryj kalendarz
        calendarContainer.style.display = "none";
        
        // Ukryj "guziczki" i "availableHours"
        guziczkiContainer.style.display = "none";
        availableHoursContainer.style.display = "none";
        
        // Wyświetl formularz
        formContainer.style.display = "block";
        
        // Zaktualizuj tekst na "Podaj dane osobowe:"
        lekarzWybierzText.textContent = "Podaj dane osobowe:";

        document.querySelector('.messageSent').textContent = "";
    });

    // Dodaj obsługę zdarzenia kliknięcia przycisku "Powrót"
    powrotButton.addEventListener("click", function (event) {
        event.preventDefault();

        document.getElementById("selectedDate").innerHTML = '<i class="fa-solid fa-calendar-days"></i>';
        document.getElementById("selectedHour").textContent = "Godzina twojej wizyty";
        
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
    "Katowice": "Śląskie",
    "Kraków": "Małopolskie",
    "Warszawa": "Mazowieckie",
    "Rzeszów": "Podkarpackie",
    "Wrocław": "Dolnośląskie",
    "Poznań": "Wielkopolskie",
    "Lublin": "Lubelskie", 
    "Zielona-Góra": "Lubuskie",
    "Gdańsk": "Pomorskie",
    "Szczecin": "Zachodniopomorskie", 
    "Olsztyn": "Warmińsko-mazurskie",
    "Toruń": "Kujawsko-pomorskie", 
    "Kielce": "Świętokrzyskie", 
    "Łódź": "Łódzkie", 
    "Opole": "Opolskie",
    "Białystok": "Podlaskie", 
};


//Walidacja formularza po kalendarzu  

function validateForm() {
    var imie = document.getElementById("imie").value;
    var nazwisko = document.getElementById("nazwisko").value;
    var wiek = document.getElementById("wiek").value;
    var pesel = document.getElementById("pesel").value;
    var miasto = document.getElementById("miasto").value;
    var wojewodztwo = document.getElementById("wojewodztwo").value;

    var alertDiv = document.querySelector(".alertDiv");

    if (imie === "" || nazwisko === "") {
        alertDiv.textContent = "Imię i nazwisko są wymagane.";
        return false;
    }

    if (isNaN(parseInt(wiek, 10))) {
        alertDiv.textContent = "Wiek musi być liczbą.";
        return false;
    }

    if (pesel.length !== 11 || isNaN(pesel)) {
        alertDiv.textContent = "Pesel musi składać się z 11 cyfr.";
        return false;
    }

    if (miasto === "" || wojewodztwo === "") {
        alertDiv.textContent = "Miasto i województwo są wymagane.";
        return false;
    }

    if (miastaWojewodztwa[miasto] !== wojewodztwo) {
        alertDiv.textContent = "Podane miasto nie znajduje się w wybranym województwie.";
        return false;
    }

    // Wyczyść alertDiv, jeśli nie ma problemów z walidacją
    alertDiv.textContent = "";

    return true;
}

// Skrypt do ukrywania i pokazywania diva w myAccount
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

