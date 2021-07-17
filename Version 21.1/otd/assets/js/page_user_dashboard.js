//======================================================================================================================
// Disk space usage chart
//======================================================================================================================

    var canvas = $('#app-chart');

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
                        },
                        position: "nearest"
                    }
                }
            },
            data: {
                labels: config.labels,
                datasets: [{
                    data: config.data,
                    backgroundColor: ['#3273DC', '#23D160', '#FF2B56', (hash['theme.is_dark_mode'] ? '#3D3D3D' : '#CCCCCC')],
                    borderColor: hash['theme.is_dark_mode'] ? ['#222'] : ['#fff'],
                    borderWidth: 2
                }]
            }
        });
    });

//======================================================================================================================
// Show more domains
//======================================================================================================================

$('#app-show-more-domains').on('click', function() {
    $('#app-domain-items > .is-hidden').each(function() {
        $(this).removeClass('is-hidden');
    });
    $(this).remove();
});