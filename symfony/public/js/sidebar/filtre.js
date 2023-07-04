import {Rest} from "/js/Rest.js";
import {ChartGenerate} from "/js/dashboard/chartGenerate.js";

export class filtre {

    /**
     * @var {NodeListOf} personas - tableau des personas
     */
    elements = document.querySelectorAll('.element_filtre');

    /**
     * @var {Rest} rest - objet Rest
     */
    rest = new Rest();

    /**
     * @var {String} url - url de l'api
     */
    url

    /**
     * @var {Callback} callback - callback qui sera une fonction qui affichera les résultats
     */
    callback

    /**
     * Constructeur de la classe filtreSession
     * @param {String} url - url de l'api exemple /sessions/api/
     */
    constructor(url, callback) {
        this.callback = callback;
        this.url = url;

        let id = this.elements[0].getAttribute('data-bs-target');
        console.log(id)
        this.apiCall(this.url+id , 'GET');
        console.log(this.url+id)

        this.elements.forEach(element => {

            element.addEventListener('click', () => {

                id = element.getAttribute('data-bs-target');

                if (!element.classList.contains('active')) {

                    this.elements.forEach(element => {

                        element.classList.remove('active');

                    });

                    element.classList.add('active');
                }

                this.apiCall(this.url+id, 'GET');

            });
        });
    }


    /**
     * Methode qui fais appel à l'api pour les données
     * @param {String} url - url de l'api
     * @param {String} methode - methode de l'api
     */
    apiCall(url,methode  ) {
        this.rest.call(url, methode, null, (data) => {
            this.callback(data);

        }, (error) => {
            console.log(error);
        });
    }


}
