export class personaShow{
    /**
     * @var {Array} data - tableau des données en clé les cards et en valeur les données
     */
    data = []

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
        console.log(this.stat_persona);
        let date_sessions = document.querySelector('#date_sessions');
        if (date_sessions != null) {
            date_sessions
        }
        if (this.data != null) {
            this.stat_persona.forEach((stat) => {
                let element = stat.childNodes[1];
                console.log(element);
                console.log(this.data)
                element.innerHTML = element.innerHTML + this.data[element.id];
            });
        }

    }


}
