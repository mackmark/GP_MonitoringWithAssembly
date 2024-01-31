function chart1(id, date) {

    var date = date

    $.ajax({
        type: "POST",
        dataType: "JSON",
        url: "../php_repository/index_repo.php",
        data: {
            action:'Chart1',
            date:date
        },
        success: function (data) {
            

             var chart = new CanvasJS.Chart(id, {
                type: 'bar',
                data: [{
                
                    type: "stackedBar",
                    legendText: "dessert",
                    showInLegend: "true",
                    dataPoints: [
                    { x: new Date(2012, 01, 1), y: 61 },
                    { x: new Date(2012, 02, 1), y: 75},
                    { x: new Date(2012, 03, 1), y: 80 },
                    { x: new Date(2012, 04, 1), y: 85 },
                    { x: new Date(2012, 05, 1), y: 105 }
            
                    ]

             },
             {
                
                type: "stackedBar",
                legendText: "dessert",
                showInLegend: "true",
                dataPoints: [
                { x: new Date(2012, 01, 1), y: 61 },
                { x: new Date(2012, 02, 1), y: 75},
                { x: new Date(2012, 03, 1), y: 80 },
                { x: new Date(2012, 04, 1), y: 85 },
                { x: new Date(2012, 05, 1), y: 105 }
        
                ]

         }
            ],
                options: {
                    maintainAspectRatio: false,
                    legend: {
                        display: false,
                        labels: {
                        fontColor: '#ddd',  
                        boxWidth:40
                        }
                    },
                    tooltips: {
                        displayColors:false
                    },	
                    scales: {
                        xAxes: [{
                        ticks: {
                            beginAtZero:true,
                            fontColor: '#ddd'
                        },
                        gridLines: {
                            display: true ,
                            color: "rgba(221, 221, 221, 0.08)"
                        },
                        }],
                        yAxes: [{
                        ticks: {
                            beginAtZero:true,
                            fontColor: '#ddd'
                        },
                        gridLines: {
                            display: true ,
                            color: "rgba(221, 221, 221, 0.08)"
                        },
                        }]
                        }
        
                    }
            }); 

            chart.render();
        }
    });

    
    

}