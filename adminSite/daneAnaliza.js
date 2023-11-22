const columnSelect = document.getElementById("selectColumn");
const chartTypeSelect = document.getElementById("chartTypeSelect");
const generateChartButton = document.getElementById("generateChart");
const ctx = document.getElementById("myCharts").getContext("2d");

let ageChartCanvas = document.getElementById("myCharts").getContext("2d");
let ageChart;

fetch("../analiza_danych2.csv")
    .then(response => response.text())
    .then(data => {
        const lines = data.split("\n");
        const header = lines[0].split(",");

        columnSelect.innerHTML = '';

        for (let i = 2; i < header.length; i++) {
            const column = header[i];
            const option = document.createElement("option");
            option.value = column;
            option.text = column;
            columnSelect.appendChild(option);
        }
    });

generateChartButton.addEventListener("click", () => {
    const selectedColumn = columnSelect.value;
    const selectedChartType = chartTypeSelect.value;

    if (ageChart) {
        ageChart.destroy();
    }

    fetch("../analiza_danych2.csv")
        .then(response => response.text())
        .then(data => {
            const lines = data.split("\n");
            const header = lines[0].split(",");

            const categories = [];
            const dataValues = Array(header.length - 2).fill(0);

            for (let i = 1; i < lines.length; i++) {
                const row = lines[i].split(",");
                const value = row[header.indexOf(selectedColumn)];
                const index = header.indexOf(selectedColumn);

                if (!categories.includes(value)) {
                    categories.push(value);
                }

                dataValues[categories.indexOf(value)]++;
            }

            const chartData = {
                labels: categories,
                datasets: [{
                    data: dataValues,
                    backgroundColor: getRandomColors(dataValues.length),
                }],
            };

            ageChart = new Chart(ageChartCanvas, {
                type: selectedChartType,
                data: chartData,
            });

            if (selectedChartType === 'bar') {
                ageChart.options.plugins.legend.display = false;
                ageChart.update();
            }
        });
});

function getRandomColors(numColors) {
    const colors = [];
    for (let i = 0; i < numColors; i++) {
        colors.push(getRandomColor());
    }
    return colors;
}

function getRandomColor() {
    const letters = '0123456789ABCDEF';
    let color = '#';
    for (let i = 0; i < 6; i++) {
        color += letters[Math.floor(Math.random() * 16)];
    }
    return color;
}
