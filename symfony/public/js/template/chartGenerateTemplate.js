export class chartGenerateTemplate {
    /**
     * @var {HTMLElement} -Element du dom
     */
    ctx;
    myChart;

    constructor() {
        this.ctx = document.getElementById("sessionsChart");
        //vider ctx
    }

    buildChart(data) {
        console.log(data);
        if (this.myChart != undefined){
            this.myChart.destroy()
        }

        document.querySelector("#chart").innerHTML = '<canvas id="sessionsChart"></canvas>';
        this.ctx = document.getElementById('sessionsChart');


        this.myChart = new Chart(this.ctx, {
            type: 'doughnut',
            data: data,
            options: {
              responsive: true,
              plugins: {
                legend: {
                  position: 'top',
                },
                title: {
                  display: true,
                  text: 'Chart.js Doughnut Chart'
                }
              }
            },
        });
    }
}