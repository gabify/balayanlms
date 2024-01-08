
const getData = async() =>{
    const getAvailable = await fetch('../balayanlms/chart/getData.php?status=Available');
    const available = parseInt(await getAvailable.text());
    const getBorrowed = await fetch('../balayanlms/chart/getData.php?status=Borrowed');
    const borrowed = parseInt(await getBorrowed.text());
    const getMissing = await fetch('../balayanlms/chart/getData.php?status=Missing');
    const missing = parseInt(await getMissing.text());
    const getWeededOut = await fetch('../balayanlms/chart/getData.php?status=Weeded-out');
    const weededout = parseInt(await getWeededOut.text());
    return {
        "Avaialble" : available,
        "Borrowed" : borrowed,
        "Missing": missing,
        "Weededout" : weededout
    }
}

getData().then(result=> {
    const showChart = () =>{
        const bookChart = document.querySelector(".book-chart");
    
        new Chart(bookChart, {
            type: "pie",
            data: {
                labels: Object.keys(result),
                datasets: [
                    {
                        data: Object.values(result)
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
    chart.addEventListener("onload", showChart());
});




