
import {chartRadar} from "/js/template_show/chartRadar.js";

export class templateShow{
    /**
     * @var {Array} data - tableau des données en clé les cards et en valeur les données
     */
    data = []

    /**
     * @var {ChartGenerate} chartGenerate - container du graphique
     */
    chartRadar;
    /**
     * @var {NodeListOf} stat_template
     */
    stat_template = document.querySelectorAll('.container_stat_template .stat_template');

    /**
     * Constructeur de la classe dashboard
     * @param {Array} data - tableau des données
     */
    constructor(data) {
        this.data = data;
        console.log(this.data);
        this.chartRadar = new chartRadar();




        console.log(this.stat_template);
        if (this.data != null) {
            const donnee = {
                labels: [
                    'Nombre de clique',
                    'Durée',
                    'Taux de scroll',
                ],
                datasets: [{
                    label: 'moyenne des sessions',
                    data: this.data.template.graph,
                    fill: true,
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgb(255, 99, 132)',
                    pointBackgroundColor: 'rgb(255, 99, 132)',
                    pointBorderColor: '#fff',
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: 'rgb(255, 99, 132)'
                }, {
                    label: 'la session sélectionnée',
                    data: this.data.graph,
                    fill: true,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgb(54, 162, 235)',
                    pointBackgroundColor: 'rgb(54, 162, 235)',
                    pointBorderColor: '#fff',
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: 'rgb(54, 162, 235)'
                }]
            };
            let id_session = document.querySelector('.template.element_filtre.active').getAttribute('data-bs-target');
            console.log(id_session);
            this.chartRadar.buildChart(donnee);
            document.querySelector('#date_session').innerHTML  = this.data.sessionDate
            document.querySelector('#name_template').innerHTML  = this.data.template.name;
            document.querySelector('#name_session').innerHTML  = this.data.sessionName;
            document.querySelector('#duree_session').innerHTML = this.data.sessionTime;
            document.querySelector('#nom_template').innerHTML  = this.data.template.name;
            document.querySelector('#nombre_clique').innerHTML = this.data.graph[0];
            document.querySelector('#button_hitmap').addEventListener('click', () => {
                window.open(`/ui/${id_session}/heatmap`, '_blank');
            });
        }

    }


}
