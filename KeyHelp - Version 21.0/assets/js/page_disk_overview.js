//======================================================================================================================
// Action: index
//======================================================================================================================

    var canvas = $('.app-chart');

    canvas.each(function() {
        var config = $(this).data('chart');

        new Chart(this, {
            type: 'doughnut',
            options: {
                cutout: '35%',
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return ' ' + context.label;
                            }
                        }
                    }
                }
            },
            data: {
                labels: config.labels,
                datasets: [{
                    data: config.data,
                    backgroundColor: ['#FF2B56', '#3273DC', (hash['theme.is_dark_mode'] ? '#3D3D3D' : '#CCCCCC')],
                    borderColor: hash['theme.is_dark_mode'] ? ['#222'] : ['#fff'],
                    borderWidth: 2
                }]
            }
        });
    });