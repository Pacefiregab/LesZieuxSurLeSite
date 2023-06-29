/**
 * Classe Rest qui va permette de faire des appels API Ajax
 */
export class Rest {

  /**
   * @var {XMLHttpRequest} xhr - Objet XMLHttpRequest
   */
  xhr;

  /**
   * Constructeur de la classe Rest
   */
  constructor() {
    this.xhr = new XMLHttpRequest();
  }

  /**
   * Methode qui va permettre de faire un appel API Ajax
   * @param {string} url - url de l'API
   * @param {string} method - methode de l'API
   * @param {string} data - data de l'API
   * @param {function} callbackSuccess - callback en cas de succes
   * @param {function} callbackError - callback en cas d'erreur
   *
   */
  call(url, method, data, callbackSuccess, callbackError) {
    this.xhr.open(method, url);
    this.xhr.setRequestHeader('Content-Type', 'application/json');
    this.xhr.onload = () => {
      if (this.xhr.status === 200) {
        callbackSuccess(JSON.parse(this.xhr.responseText));
      } else {
        callbackError(this.xhr);
      }
    };
    this.xhr.send(data);
  }
}
