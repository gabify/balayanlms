const getVisitToday = async() =>{
    response = await fetch('../balayanlms/chart/getVisits.php');
    result = await response.json();
    return result;
}

getVisitToday().then(result =>{

    const showGraph = () =>{
        const visitGraph = document.querySelector(".visits");
        new Chart(visitGraph,{
            type: 'line',
            data: {
                labels: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
                datasets: [
                    {
                        label: 'Weekly Student Visits',
                        data: Object.values(result)
                    },
                ],
            },
            options:{
                backgroundColor: '#b33939',
                tension: 0.2,
                fill: true,
                showLine: false,
                pointRadius: 3,
            }
        });
    }
    
    const graph = document.querySelector('#visitsGraph');
    graph.addEventListener("onload", showGraph());

});