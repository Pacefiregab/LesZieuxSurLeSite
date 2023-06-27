import {Rest} from "/js/Rest.js";
export class filtrePersona{

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
    /**
   * Constructeur de la classe filtrePersona
   *
   */
  constructor(){

    this.personas.forEach(persona => {
      //dans element persona il faut l'attribut data-id
      let id = persona.getAttribute('data-bs-target');
      persona.addEventListener('click', () => {
        //faire un appel api localhost/persona/api/{id}
        this.rest.call('/persona/api/' + id, 'GET', null, (data) => {

            console.log(data);
            this.nombreSessions.innerHTML = data.nombreSessions;
            this.tauxSucces.innerHTML = data.tauxSucces;
            this.nombreInterfaces.innerHTML = data.nombreInterfaces;

        }, (error) => {
          console.log(error);
        });
      });
    });
  }
}
