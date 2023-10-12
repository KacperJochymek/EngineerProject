//Kod odpowiedzialny za tworzenie kalendarza i generowanie w nim dni.

const currentDate = document.querySelector(".current_date");
const daysTag = document.querySelector(".days");
const prevIcon = document.querySelector("#prev");
const nextIcon = document.querySelector("#next");

let date = new Date();
let currYear = date.getFullYear();
let currMonth = date.getMonth();

const months = ["Styczeń", "Luty", "Marzec", "Kwiecień", "Maj", "Czerwiec",
    "Lipiec", "Sierpień", "Wrzesień", "Październik", "Listopad", "Grudzień"];

const renderujKalendarz = (year, month) => {
    const firstDayOfMonth = new Date(year, month, 0).getDay();
    const lastDateOfMonth = new Date(year, month + 1, 0).getDate();
    const lastDayOfMonth = new Date(year, month, lastDateOfMonth).getDay() - 2;
    const liTag = [];

    for (let i = firstDayOfMonth - 1; i >= 0; i--) {
        liTag.push(`<li class="inactive">${new Date(year, month, -i).getDate()}</li>`);
    }

    for (let i = 1; i <= lastDateOfMonth; i++) {
        let isToday = i === date.getDate() && month === date.getMonth() && year === date.getFullYear() ? "active" : "";
        liTag.push(`<li class="${isToday}">${i}</li>`);
    }

    for (let i = 1; i < 6 - lastDayOfMonth; i++) {
        liTag.push(`<li class="inactive">${i}</li>`);
    }

    currentDate.innerText = `${months[month]} ${year}`;
    daysTag.innerHTML = liTag.join("");
};

renderujKalendarz(currYear, currMonth);

prevIcon.addEventListener("click", () => {
    currMonth--;
    if (currMonth < 0) {
        currYear--;
        currMonth = 11;
    }
    renderujKalendarz(currYear, currMonth);
});

nextIcon.addEventListener("click", () => {
    currMonth++;
    if (currMonth > 11) {
        currYear++;
        currMonth = 0;
    }
    renderujKalendarz(currYear, currMonth);
});

daysTag.addEventListener("click", (event) => {
    const target = event.target;
    if (target.tagName === 'LI' && !target.classList.contains("inactive")) {
        const day = parseInt(target.textContent, 10);
        if (!isNaN(day) && isFinite(day)) {
            const selectedDateElement = document.getElementById("selectedDate");
            selectedDateElement.textContent = `${day} ${months[currMonth]} ${currYear}`;

            const availableHours = document.getElementById("availableHours");
            availableHours.innerHTML = '';

            // Tutaj bedzie kod, który wzcytuje godziny do tabeli z pliku php

            const dostepneGodziny = ["8:00", "15:30", "16:00", "17:00"];

            // Tworzenie nowych przycisków po przez iterację

            dostepneGodziny.forEach(godzina => {
                const button = document.createElement("button");
                button.classList.add("przykladowa");
                button.textContent = godzina;

                button.addEventListener("click", () => {
                    const wybranaGodzina = godzina;
                    console.log("Wybrano godzinę:", wybranaGodzina);
                });

                availableHours.appendChild(button);
            });
        }
    }
});

availableHours.addEventListener("click", (event) => {
    const target = event.target;
    if (target.tagName === 'BUTTON') {
        const wybranaGodzina = target.textContent;
        const selectedHourElement = document.getElementById("selectedHour");
        selectedHourElement.textContent = wybranaGodzina;
    }
});