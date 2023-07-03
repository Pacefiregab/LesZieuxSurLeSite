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
        if (this.myChart){
            this.myChart.destroy()
        }

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
