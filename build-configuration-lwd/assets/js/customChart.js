jQuery(document).ready(function($){
    const ctx = document.getElementById('chart-analytics').getContext('2d');
    var data_month = data_chart.data;
    if (data_month !== null) {
    var array_month = Object.values(data_month);
        const myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Tháng 01','Tháng 02','Tháng 03','Tháng 04','Tháng 05','Tháng 06','Tháng 07','Tháng 08','Tháng 09','Tháng 10','Tháng 11','Tháng 12'],
                datasets: [{
                    label: 'Doanh số',
                    data: array_month,
                    backgroundColor: [
                        'rgb(255, 99, 132)',
                        'rgb(75, 192, 192)',
                        'rgb(255, 205, 86)',
                        '#9400d3',
                        'rgb(54, 162, 235)',
                        '#4b0082',
                        'rgb(75, 192, 192)',
                        '#7b68ee',
                        '#ff4500',
                        '#db7093',
                        '#ff0000',
                        '#2e8b57'
                    ],
                    borderWidth: 1
                }
                ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
        $('#user_name').on('change',function(){
            var name_user = $(this).val();
            $.ajax({
                type: 'POST',
                url:  data_chart.ajaxurl,
                data: {
                    action: 'filter_analytics_of_user',
                    name_user: name_user
                },
                dataType: 'json',
                success:function(responsive){
                    console.log(responsive);
                    if (responsive.success) {
                        myChart.data.datasets[0].data = responsive.data.data_month;
                        myChart.data.datasets[0].label = 'Doanh số của ' + name_user;
                        myChart.update();
                    }
                }
            });
        });
    }





});
