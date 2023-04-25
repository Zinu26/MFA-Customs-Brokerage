

new Chart(document.getElementById("line-chart"), {
    type: 'line',
    data: {
    labels: [0,1,2,3,4,5,6,7,8,9],
    datasets: [{ 
        data: [86,114,106,106,107,111,133,221,783,2478],
        label: "",
        borderColor: "#3e95cd",
        fill: false,
        lineTension: 0,
        pointRadius: 0,
        borderWidth: 1
                }, { 
                    data: [282,350,411,502,635,809,947,1402,3700,5267],
                    label: "",
                    borderColor: "#8e5ea2",
                    fill: false,
                    lineTension: 0,
                    pointRadius: 0,
                    borderWidth: 1
                }, { 
                    data: [168,170,178,190,203,276,408,547,675,734],
                    label: "",
                    borderColor: "#3cba9f",
                    fill: false,
                    lineTension: 0,
                    pointRadius: 0,
                    borderWidth: 1
                }, { 
                    data: [40,20,10,16,24,38,74,167,508,784],
                    label: "",
                    borderColor: "#e8c3b9",
                    fill: false,
                    lineTension: 0,
                    pointRadius: 0,
                    borderWidth: 1
                }, { 
                    data: [6,3,2,2,7,26,82,172,312,433],
                    label: "",
                    borderColor: "#c45850",
                    fill: false,
                    lineTension: 0,
                    pointRadius: 0,
                    borderWidth: 1
                }
                ]
            },
            options: {
                responsive: true,
                title: {
                display: true,
                text: ''
                },
                legend: {
                    display: false
                  }
                
            }
            
});

new Chart(document.getElementById("doughnut-chart"), {
                type: 'doughnut',
                data: {
                labels: ["Africa", "Asia", "Europe", "Latin America", "North America"],
                datasets: [
                    {
                    label: "",
                    backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850"],
                    data: [2478,5267,734,784,433]
                    }
                ]
                },
                options: {
                title: {
                    display: true,
                    text: ''
                },
                legend: {
                    display: false
                  }
                }
            });



