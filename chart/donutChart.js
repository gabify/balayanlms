const chartData = {
    labels: ["Borrowed", "Available", "Missing", "Weeded out"],
    data: [5, 120, 3, 45]
};

const showChart = (chartData) =>{
    const bookChart = document.querySelector(".book-chart");
    const thesisChart = document.querySelector(".thesis-chart");
    const studentChart = document.querySelector(".student-chart");

    new Chart(bookChart, {
        type: "doughnut",
        data: {
            labels: chartData.labels,
            datasets: [
                {
                    label: "Book Status",
                    data: chartData.data
                },
            ],
        },
        options:{
            borderWidth:1,
            borderRadius:3,
            hoverBorderWidth: 0,
            plugins:{
                legend:{
                    display:false
                },
            },
        },
    });
    
    new Chart(thesisChart, {
        type: "doughnut",
        data: {
            labels: chartData.labels,
            datasets: [
                {
                    label: "Book Status",
                    data: chartData.data
                },
            ],
        },
        options:{
            borderWidth:1,
            borderRadius:3,
            hoverBorderWidth: 0,
            plugins:{
                legend:{
                    display:false
                },
            },
        },
    });
    
    new Chart(studentChart, {
        type: "doughnut",
        data: {
            labels: chartData.labels,
            datasets: [
                {
                    label: "Book Status",
                    data: chartData.data
                },
            ],
        },
        options:{
            borderWidth:1,
            borderRadius:3,
            hoverBorderWidth: 0,
            plugins:{
                legend:{
                    display:false
                },
            },
        },
    });
}

const chart = document.querySelector('#charts');
chart.addEventListener("onload", showChart(chartData));