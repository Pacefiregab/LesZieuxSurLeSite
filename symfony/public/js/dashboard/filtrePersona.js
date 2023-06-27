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
        }, (error) => {
          console.log(error);
        });
      });
    });
  }
}
