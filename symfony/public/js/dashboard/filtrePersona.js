import {Rest} from "/js/Rest.js";
import {ChartGenerate} from "/js/dashboard/chartGenerate.js";

export class filtrePersona {

    /**
     * @var {NodeListOf} personas - tableau des personas
     */
    personas = document.querySelectorAll('.persona');

    /**
     * @var {Rest} rest - objet Rest
     */
    rest = new Rest();

    /**
     * @var {Node} nombreSessions - nombre de sessions card
     */
    nombreSessions = document.querySelector('#nombreSessions');

    /**
     * @var {Node} tauxSucces - nombre tauxSucces card
     */
    tauxSucces = document.querySelector('#tauxSucces');

    /**
     * @var {Node} nombreInterfaces - nombre d'interfaces card
     */
    nombreInterfaces = document.querySelector('#nombreInterfaces');

    /**
     * @var {ChartGenerate} chartGenerate - container du graphique
     */
    chartGenerate;

    /**
     * Constructeur de la classe filtrePersona
     *
     */

    constructor() {
        this.chartGenerate = new ChartGenerate()
        this.personas.forEach(persona => {
            let id = persona.getAttribute('data-bs-target');
            persona.addEventListener('click', () => {

                if (!this.isActive(persona)) {
                    this.personas.forEach(persona => {
                        persona.classList.remove('active');
                    });
                    persona.classList.add('active');
                }

                this.rest.call('/persona/api', 'GET', null, (data) => {
                    this.nombreSessions.querySelector('span').innerHTML = data.nombreSessions;
                    this.tauxSucces.querySelector('span').innerHTML = data.tauxSucces;
                    this.nombreInterfaces.querySelector('span').innerHTML = data.nombreInterfaces;
                    this.chartGenerate.buildChart({test: 12, ok: 23}); //data sous la forme {test:12, ok:23 }
                }, (error) => {
                    console.log(error);
                });
            });
        });
    }

    /**
     * Methode qui va vérifier si element à la classe active
     * @param {Node} element - element à vérifier
     */
    isActive(element) {
        return element.classList.contains('active');

    }
}
