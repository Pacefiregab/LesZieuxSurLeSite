export class ChartGenerate {
    /**
     * @var {HTMLElement} -Element du dom
     */
    ctx;

    constructor() {
        this.ctx = document.getElementById('myChart');
    }

    buildChart(data) {
        new Chart(this.ctx, {
            type: 'bar',
            data: {
                labels: Object.keys(data),
                datasets: [{
                    data: Object.values(data),
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Durée moyenne (s)'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Interface'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }

            }
        });
    }

}
