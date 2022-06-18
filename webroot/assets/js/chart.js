$(document).ready(function() {

    // Bar Chart

    $.ajax({
        url: '/project-object/projectsgrantt',

        dataType: 'json',
        success: function(data) {
            console.log(data, 'projectdata');
            let durArr = [];
            let labels = [];

            data.forEach((project) => {
                const time_difference = (new Date(project.expirydate).getTime() - (new Date(project.startdate)).getTime());
                const days_difference = time_difference / (1000 * 60 * 60 * 24);
                durArr.push(days_difference);
                labels.push(project.name);
            });

            console.log(labels);

            Morris.Bar({
                element: 'bar-charts',
                data: [
                    { y: '2006', a: 100, b: 90 },
                    { y: '2007', a: 75, b: 65 },
                    { y: '2008', a: 50, b: 40 },
                    { y: '2009', a: 75, b: 65 },
                    { y: '2010', a: 50, b: 40 },
                    { y: '2011', a: 75, b: 65 },
                    { y: '2012', a: 100, b: 90 }
                ],
                xkey: 'y',
                ykeys: ['a', 'b'],
                labels: labels,
                lineColors: ['#00c5fb', '#0253cc'],
                lineWidth: '3px',
                barColors: ['#00c5fb', '#0253cc'],
                resize: true,
                redraw: true
            });

        },
        error: function(e) {}
    });

    // Line Chart

    Morris.Line({
        element: 'line-charts',
        data: [
            { y: '2006', a: 50, b: 90 },
            { y: '2007', a: 75, b: 65 },
            { y: '2008', a: 50, b: 40 },
            { y: '2009', a: 75, b: 65 },
            { y: '2010', a: 50, b: 40 },
            { y: '2011', a: 75, b: 65 },
            { y: '2012', a: 100, b: 50 }
        ],
        xkey: 'y',
        ykeys: ['a', 'b'],
        labels: ['Total Sales', 'Total Revenue'],
        lineColors: ['#00c5fb', '#0253cc'],
        lineWidth: '3px',
        resize: true,
        redraw: true
    });

    /*   const config = {
            type: 'bar',
            data: data,
            options: {
                indexAxis: 'y',
                // Elements options apply to all of the options unless overridden in a dataset
                // In this case, we are setting the border of each horizontal bar to be 2px wide
                elements: {
                    bar: {
                        borderWidth: 2,
                    }
                },
                responsive: true,
                plugins: {
                    legend: {
                        position: 'right',
                    },
                    title: {
                        display: true,
                        text: 'Chart.js Horizontal Bar Chart'
                    }
                }
            },
        };*/





});