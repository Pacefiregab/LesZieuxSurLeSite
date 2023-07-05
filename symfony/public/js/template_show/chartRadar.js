export class chartRadar {
    /**
     * @var {HTMLElement} -Element du dom
     */
    ctx;
    myChart;

    constructor() {
        this.ctx = document.getElementById('myChart');
        //vider ctx

    }

    buildChart(data) {
        console.log(data)
        if (this.myChart != undefined){
            this.myChart.destroy()
        }

        document.querySelector("#chart").innerHTML = '<canvas id="myChart"></canvas>';
        this.ctx = document.getElementById('myChart');

        this.myChart = new Chart(this.ctx,{
            type: 'radar',
            data: data,
            options: {
                elements: {
                    line: {
                        borderWidth: 3
                    }
                }
            },
        });
    }

}
