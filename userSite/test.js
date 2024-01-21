document.addEventListener("DOMContentLoaded", function () {
    var dalejButton = document.querySelector(".lekarz-btn[name='submit']");
    
    // Pobierz wartości kalendarza, formularza, "guziczki" i "availableHours"
    var calendarContainer = document.getElementById("calendarContainer");
    var formContainer = document.getElementById("formContainer");
    var guziczkiContainer = document.getElementById("guziczki");
    var availableHoursContainer = document.getElementById("availableHours");
    
    var powrotButton = document.getElementById("powrotButton");
    var lekarzWybierzText = document.getElementById("lekarz-wybierz-text");
    
    //Obsługa zdarzenia po kliknięciu "Dalej"
    dalejButton.addEventListener("click", function (event) {
        event.preventDefault();

        const selectedDate = document.getElementById("selectedDate").textContent;
        const selectedHour = document.getElementById("selectedHour").textContent;
    
        // Czy tekst nie jest pusty - sprawdzenie
        if (!selectedDate.trim()) {
            document.querySelector('.messageSent').textContent = "Proszę wybrać datę wizyty.";
            return;
        }

        if (selectedHour === "Godzina twojej wizyty") {
            document.querySelector('.messageSent').textContent = "Proszę wybrać godzinę wizyty.";
            return false;
        }
        
        calendarContainer.style.display = "none";
        
        guziczkiContainer.style.display = "none";
        availableHoursContainer.style.display = "none";
        
        formContainer.style.display = "block";
        lekarzWybierzText.textContent = "Podaj dane osobowe:";

        document.querySelector('.messageSent').textContent = "";
    });

    // Obsługa "Powrót"
    powrotButton.addEventListener("click", function (event) {
        event.preventDefault();

        document.getElementById("selectedDate").innerHTML = '<i class="fa-solid fa-calendar-days"></i>';
        document.getElementById("selectedHour").textContent = "Godzina twojej wizyty";
        
        calendarContainer.style.display = "block";
        
        guziczkiContainer.style.display = "block";
        availableHoursContainer.style.display = "block";
        
        formContainer.style.display = "none";
        
        lekarzWybierzText.textContent = "Wybierz date i godzine wizyty:";
    });
});

//Największe miasta i przypisanie do nich województw
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

    alertDiv.textContent = "";

    return true;
}

// Skrypt do ukrywania i pokazywania diva w myAccount
document.addEventListener("DOMContentLoaded", function () {

    var settingi = document.querySelector(".settingi");
    var mojeWizyty = document.querySelector(".mojeWizyty");
    var settingsInpt = document.querySelector(".settings-inpt");

    settingsInpt.style.display = "none";
    var mojeWizytyVisible = true;

    settingi.addEventListener("click", function (event) {
        event.preventDefault();

        if (mojeWizytyVisible) {
            mojeWizyty.style.display = "none";
            settingsInpt.style.display = "block";
            mojeWizytyVisible = false;
        } else {
            mojeWizyty.style.display = "block";
            settingsInpt.style.display = "none";
            mojeWizytyVisible = true;
        }
    });

    // Pobierz przycisk "Powrót"
    var zwrotButton = document.getElementById("zwrot");

    zwrotButton.addEventListener("click", function (event) {
        event.preventDefault();

        mojeWizyty.style.display = "block";

        settingsInpt.style.display = "none";
        mojeWizytyVisible = true;
    });

});

