const currentDate = document.querySelector(".current_date");
const daysTag = document.querySelector(".days");
const prevIcon = document.querySelector("#prev");
const nextIcon = document.querySelector("#next");

let date = new Date(),
currYear = date.getFullYear(),
currMonth = date.getMonth();

const months = ["Styczeń", "Luty", "Marzec", "Kwiecień", "Maj", "Czerwiec",
    "Lipiec", "Sierpień", "Wrzesień", "Październik", "Listopad", "Grudzień"];

const renderujKalendarz = () => {
    let firstDayOfMonth = new Date(currYear, currMonth, 0).getDay();
    let lastDateOfMonth = new Date(currYear, currMonth + 1, 0).getDate();
    let lastDayOfMonth = new Date(currYear, currMonth, lastDateOfMonth).getDay() - 1;
    let lastDateOfLastMonth = new Date(currYear, currMonth, 0).getDate();
    let liTag = "";

    for (let i = firstDayOfMonth; i > 0; i--) {
        liTag += `<li class="inactive">${lastDateOfLastMonth - i + 1}</li>`;
    }

    for (let i = 1; i <= lastDateOfMonth; i++) {
        let isToday = i === date.getDate() && currMonth === new Date().getMonth() && currYear === new Date().getFullYear ? "active" : "";
        liTag += `<li class="${isToday}">${i}</li>`;
    }

    for (let i = lastDayOfMonth; i < 6; i++) {
        liTag += `<li class="inactive">${i - lastDayOfMonth + 1}</li>`;
    
    }
    currentDate.innerText = `${months[currMonth]} ${currYear}`;
    daysTag.innerHTML = liTag;
}

renderujKalendarz();

prevIcon.addEventListener("click", () => {
    currMonth--;
    if (currMonth < 0) {
        currYear--;
        currMonth = 11;
    }
    renderujKalendarz();
});

nextIcon.addEventListener("click", () => {
    currMonth++;
    if (currMonth > 11) {
        currYear++;
        currMonth = 0;
    }
    renderujKalendarz();
});

