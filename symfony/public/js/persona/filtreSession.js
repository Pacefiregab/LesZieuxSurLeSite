import {Rest} from "/js/Rest.js";
import {ChartGenerate} from "/js/dashboard/chartGenerate.js";

export class filtreSession {

    /**
     * @var {NodeListOf} personas - tableau des personas
     */
     sessions = document.querySelectorAll('.session');

    /**
     * @var {Rest} rest - objet Rest
     */
    rest = new Rest();


    /**
     * Constructeur de la classe filtreSession
     *
     */
    constructor() {

        // let id = this.sessions[0].childNodes[1].getAttribute('data-bs-target');
        this.apiCall('/sessions/api/'+id , 'GET');
        this.sessions.forEach(session => {
            session.addEventListener('click', () => {
                // id = session.childNodes[1].getAttribute('data-bs-target');
                //
                // if (!session.classList.contains('active')) {
                //     this.sessions.forEach(session => {
                //         session.classList.remove('active');
                //     });
                //     session.classList.add('active');
                // }

                // this.apiCall('/session/api/'+id, 'GET');

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
            console.log(data)

        }, (error) => {
            console.log(error);
        });
    }

}
