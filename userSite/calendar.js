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
        let isPastDate = new Date(year, month, i + 1) < date ? "inactive" : "";
        liTag.push(`<li class="${isToday} ${isPastDate}">${i}</li>`);
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
            const formattedMonth = (currMonth + 1).toString().padStart(2, '0'); 
            const formattedDay = day.toString().padStart(2, '0'); 
            selectedDateElement.textContent = `${formattedDay} ${months[currMonth]} ${currYear}`;

            const availableHours = document.getElementById("availableHours");
            availableHours.innerHTML = '';

            const selectedDate = `${currYear}-${formattedMonth}-${formattedDay}`; 

            const selectedHourElement = document.getElementById("selectedHour");
            selectedHourElement.textContent = "Godzina twojej wizyty";

            const queryParams = new URLSearchParams(window.location.search);
            const doctorId = queryParams.get('doctor_id'); 

            fetch(`http://localhost:3000/userSite/calendarConnect.php?selectedDate=${selectedDate}&doctor_id=${doctorId}`, {
                method: 'GET',
            })
            .then(response => response.json())
            .then(data => {
                const dostepneGodziny = data;
                const availableHours = document.getElementById("availableHours");
                availableHours.innerHTML = '';

                dostepneGodziny.forEach(entry => {
                    const godzina = entry.hour;
                    const status = entry.status_wizyty; 

                    if (status !== 'zarezerwowana') { 
                        const button = document.createElement("button");
                        button.classList.add("przykladowa");
                        button.textContent = godzina; 

                        button.addEventListener("click", () => {
                            const wybranaGodzina = godzina;
                            console.log("Wybrano datę:", selectedDate);
                            console.log("Wybrano godzinę:", wybranaGodzina);

                            // Przekierowanie do doctorVisit.php
                            const newUrl = `/userSite/doctorVisit.php?doctor_id=${doctorId}&selectedHour=${wybranaGodzina}&selectedDate=${selectedDate}`;
                            history.pushState(null, '', newUrl);
                        });

                        availableHours.appendChild(button);
                    }
                });
            })
            .catch(error => {
                console.error("Błąd podczas pobierania danych:", error);
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

//Przemieszczanie się aktywnego dnia w kalendarzu
document.addEventListener("DOMContentLoaded", function () {
    const daysTag = document.querySelector(".days");
    let selectedDay = date.getDate(); 

    daysTag.addEventListener("click", (event) => {
        const target = event.target;
        if (target.tagName === 'LI' && !target.classList.contains("inactive")) {
            const day = parseInt(target.textContent, 10);
            if (!isNaN(day) && isFinite(day)) {
                
                const currentActive = document.querySelector('.days li.active');
                if (currentActive) {
                    currentActive.classList.remove('active');
                }

                target.classList.add('active');

                selectedDay = day;

                const selectedDateElement = document.getElementById("selectedDate");
                selectedDateElement.textContent = `${selectedDay} ${months[currMonth]} ${currYear}`;
            }
        }
    });
});
