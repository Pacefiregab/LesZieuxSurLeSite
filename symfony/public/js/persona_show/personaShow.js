
import {chartRadar} from "/js/persona_show/chartRadar.js";

export class personaShow{
    /**
     * @var {Array} data - tableau des données en clé les cards et en valeur les données
     */
    data = []

    /**
     * @var {ChartGenerate} chartGenerate - container du graphique
     */
    chartRadar;
    /**
     * @var {NodeListOf} stat_persona
     */
    stat_persona = document.querySelectorAll('.container_stat_persona .stat_persona');

    /**
     * Constructeur de la classe dashboard
     * @param {Array} data - tableau des données
     */
    constructor(data) {
        this.data = data;
        console.log(this.data);
        this.chartRadar = new chartRadar();




        console.log(this.stat_persona);
        if (this.data != null) {
            const donnee = {
                labels: [
                    'Nombre de clique',
                    'Durée',
                    'Taux de scroll',
                ],
                datasets: [{
                    label: 'moyenne des sessions',
                    data: this.data.persona.graph,
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
            let id_session = document.querySelector('.persona.element_filtre.active').getAttribute('data-bs-target');
            console.log(id_session);
            this.chartRadar.buildChart(donnee);
            document.querySelector('#date_session').innerHTML  = this.data.sessionDate
            document.querySelector('#name_persona').innerHTML  = this.data.persona.name;
            document.querySelector('#name_session').innerHTML  = this.data.sessionName;
            document.querySelector('#duree_session').innerHTML = this.data.sessionTime;
            document.querySelector('#nom_template').innerHTML  = this.data.template.name;
            document.querySelector('#nombre_clique').innerHTML = this.data.graph[0];
            document.querySelector('#button_hitmap').addEventListener('click', () => {
                window.location.href = `/ui/${id_session}/heatmap`
            });
        }

    }


}
