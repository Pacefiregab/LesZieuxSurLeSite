export class personaShow{
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
        console.log(this.data);
    }


}
