import {ChartGenerate} from "/js/dashboard/chartGenerate.js";
export class dashboard{

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
     * @var {Node} bouton_detail - bouton pour afficher les détails
     */
    bouton_detail = document.querySelector('#details');

    /**
     * @var {Array} data - tableau des données en clé les cards et en valeur les données
     */
    data = []
    /**
     * Constructeur de la classe dashboard
     * @param {Array} data - tableau des données
     */
    constructor(data) {

            this.data = data;
            this.chartGenerate = new ChartGenerate();
            this.afficherResultat();

    }
    /**
     * Methode qui va afficher les résultats de la requete
     */
    afficherResultat() {
        console.log(this.data)
        //parcourir this.data qui est un retour api e, json { cle : valeur }
        Object.keys(this.data).forEach(key => {

            let card = document.querySelector('#' + key);
            let data = this.data[key];

            if(key == 'successRate'){
                data = data + '%';
            }

            let diff = 0;

            if (key == 'graph') {

                this.chartGenerate.buildChart(data);

            } else if (key == 'detail') {

                this.bouton_detail.setAttribute('onclick', 'window.location.href = "' + data + '"');

            } else {
                card.querySelector('span').innerHTML = data;
                let cardEvolution = card.querySelector('.evolution');

                if (diff > 0) {

                    diff = '&#x2B06; +' + diff;
                    cardEvolution.classList.remove('negative');

                    if (!cardEvolution.classList.contains('positive')) {

                        cardEvolution.classList.add('positive');
                    }

                } else {

                    diff = '&#x2B07; ' + diff;
                    cardEvolution.classList.remove('positive');

                    if (!cardEvolution.classList.contains('negative')) {

                        cardEvolution.classList.add('negative');
                    }

                }

                cardEvolution.innerHTML = diff;
            }
        });
    }

}
