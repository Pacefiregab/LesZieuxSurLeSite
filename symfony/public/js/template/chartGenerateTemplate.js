export class chartGenerateTemplate {
    /**
     * @var {HTMLElement} -Element du dom
     */
    ctx;
    myChart;

    constructor(element) {
        this.ctx = document.getElementById("sessionsChart");
    }

    buildChart(data, title) {
        console.log(data);
        if (this.myChart != undefined) {
            this.myChart.destroy();
        }

        document.querySelector("#templateChart").innerHTML =
            '<canvas id="sessionsChart"></canvas>';
        this.ctx = document.getElementById("sessionsChart");

        this.myChart = new Chart(this.ctx, {
            type: "doughnut",
            data: data,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: "right",
                        align: "middle",
                    },
                    title: {
                        display: true,
                        text: title,
                        padding: {
                            top: 10,
                        },
                    },
                },
            },
        });
    }
}
