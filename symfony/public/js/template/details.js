import { chartGenerateTemplate } from "/js/template/chartGenerateTemplate.js";
export class details {
    /**
     * @var {Array} data - tableau des données en clé les cards et en valeur les données
     */
    data = [];
    /**
     * @var {ChartGenerate} chartGenerate - container du graphique
     */
    chartGenerateTemplate;

    constructor(data) {
        this.data = data;
        this.chartGenerateTemplate = new chartGenerateTemplate();
        console.log(this.data);
        if (this.data !== null) {
            document.querySelector("#titleTemplate").innerHTML = this.data.name;
            document.querySelector(".primaryColor").style.backgroundColor =
                this.data.data.primaryColor;
            document.querySelector(".secondaryColor").style.backgroundColor =
                this.data.data.secondaryColor;
            document.querySelector(".witheColor").style.backgroundColor =
                this.data.data.whiteColor;
            document.querySelector(".blackColor").style.backgroundColor =
                this.data.data.blackColor;

            if (this.data.data.reverseRow) {
                document.querySelector(".reverseRow").innerHTML =
                    '<p>Inversion des colonnes</p><i class="gg-check-o"></i>';
            } else {
                document.querySelector(".reverseRow").innerHTML =
                    '<p>Inversion des colonnes</p><i class="gg-close-o"></i>';
            }

            if (this.data.data.stickyHeader) {
                document.querySelector(".stickyHeader").innerHTML =
                    '<p>Navigation collé</p><i class="gg-check-o"></i>';
            } else {
                document.querySelector(".stickyHeader").innerHTML =
                    '<p>Navigation collé</p><i class="gg-close-o"></i>';
            }

            if (this.data.data.specialButtonForTicket) {
                document.querySelector(".specialButton").innerHTML =
                    '<p>Bouton spécial achat</p><i class="gg-check-o"></i>';
            } else {
                document.querySelector(".specialButton").innerHTML =
                    '<p>Bouton spécial achat</p><i class="gg-close-o"></i>';
            }

            if (this.data.data.contactMapFirst) {
                document.querySelector(".mapFirst").innerHTML =
                    '<p>Contact carte</p><i class="gg-check-o"></i>';
            } else {
                document.querySelector(".mapFirst").innerHTML =
                    '<p>Contact carte</p><i class="gg-close-o"></i>';
            }

            if (this.data.data.changeCheckBoxSelect) {
                document.querySelector(".selecttoCheckBox").innerHTML =
                    '<p>Liste déroulante</p><i class="gg-check-o"></i>';
            } else {
                document.querySelector(".selecttoCheckBox").innerHTML =
                    '<p>Liste déroulante</p><i class="gg-close-o"></i>';
            }

        
            const DATA_COUNT = 5;
            const NUMBER_CFG = {count: DATA_COUNT, min: 0, max: 100};
            
            const test = {
              labels: ['Red', 'Orange', 'Yellow', 'Green', 'Blue'],
              datasets: [
                {
                  label: 'Dataset 1',
                  data: [11, 16, 7, 3, 14],
                  backgroundColor: 'Green',
                }
              ]
            };
            this.chartGenerateTemplate.buildChart(test);
        }
    }
}
