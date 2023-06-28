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
    tauxReussite = document.querySelector('#tauxSucces');

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
        this.apiCall('/persona/api', 'GET');
        this.personas.forEach(persona => {
            let id = persona.getAttribute('data-bs-target');
            persona.addEventListener('click', () => {

                if (!persona.classList.contains('active')) {
                    this.personas.forEach(persona => {
                        persona.classList.remove('active');
                    });
                    persona.classList.add('active');
                }
                this.apiCall('/persona/api/', 'GET');

            });
        });
    }

    /**
     * Methode qui va afficher les résultats de la requete
     * @param {Node} card - card à modifier
     * @param {Object} data - données à afficher
     */
    afficherResultat(card, data) {

        card.querySelector('span').innerHTML =  data.donnee;
        let diff = data.diff;
        let cardEvolution = card.querySelector('.evolution');

        if (diff > 0) {

            diff = '&#x2B06; +' + diff;
            cardEvolution.classList.remove('negative');

            if(!cardEvolution.classList.contains('positive')){

                cardEvolution.classList.add('positive');
            }

        }else{

            diff = '&#x2B07; ' + diff;
            cardEvolution.classList.remove('positive');

            if(!cardEvolution.classList.contains('negative')){

                cardEvolution.classList.add('negative');
            }

        }

        cardEvolution.innerHTML = diff;
    }

    /**
     * Methode qui fais appel à l'api pour les données
     * @param {String} url - url de l'api
     * @param {String} methode - methode de l'api
     */
    apiCall(url,methode  ) {
        this.rest.call(url, methode, null, (data) => {
            console.log(data)
            //parcourir data
            this.afficherResultat(this.nombreSessions, data.nombreSessions);
            this.afficherResultat(this.tauxReussite, data.tauxReussite);
            this.afficherResultat(this.nombreInterfaces, data.nombreInterfaces);
            this.chartGenerate.buildChart(data.graph);

        }, (error) => {
            console.log(error);
        });
    }
}
