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
        if (this.data != null) {
            document.querySelector('#date_session').innerHTML = this.data.sessionDate
            document.querySelector('#name_persona').innerHTML = document.querySelector('#name_persona').innerHTML + this.data.persona.name;
            document.querySelector('#name_session').innerHTML = "Gabin le nom stp";
            document.querySelector('#duree_session').innerHTML = document.querySelector('#duree_session').innerHTML + this.data.sessionTime;
            document.querySelector('#nom_template').innerHTML = document.querySelector('#nom_template').innerHTML + this.data.template.name;
            document.querySelector('#nombre_clique').innerHTML = document.querySelector('#nombre_clique').innerHTML + this.data.template.count;
        }

    }


}
