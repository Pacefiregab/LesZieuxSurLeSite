import { chartGenerateTemplate } from "/js/template/chartGenerateTemplate.js";

function formatTime(seconds) {
    var minutes = Math.floor(seconds / 60);
    var remainingSeconds = seconds % 60;

    // Ajouter un zéro devant les minutes et les secondes si nécessaire
    var formattedMinutes = minutes < 10 ? "0" + minutes : minutes;
    var formattedSeconds =
        remainingSeconds < 10 ? "0" + remainingSeconds : remainingSeconds;

    var formattedTime = parseInt(formattedMinutes) + ":" + parseInt(formattedSeconds);
    return formattedTime;
}

export class details {
    /**
     * @var {Array} data - tableau des données en clé les cards et en valeur les données
     */
    data = [];
    /**
     * @var {ChartGenerate} chartGenerate - container du graphique
     */
    chartGenerateTemplate;

    /**
     * @var {Node} bouton_detail - bouton pour afficher les détails
     */
    bouton_detail = document.querySelector("#details");

    constructor(data) {
        this.data = data;
        this.chartGenerateTemplate = new chartGenerateTemplate();
        console.log(this.data);
        if (this.data !== null) {
            this.bouton_detail.setAttribute(
                "onclick",
                'window.location.href = "' + this.data.id + '/sessions"'
            );

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

            if (this.data.templateStatistics.nbSessions > 0) {
                // Données pour le diagramme
                var chartData = {
                    labels: ["Echec", "Succès"],
                    datasets: [
                        {
                            data: [
                                this.data.templateStatistics.nbSessions -
                                    this.data.templateStatistics.nbSuccess,
                                this.data.templateStatistics.nbSuccess,
                            ],
                            backgroundColor: ["#e30909", "#008a29"],
                        },
                    ],
                };

                this.chartGenerateTemplate.buildChart(chartData, "Nombre de sessions : "+this.data.templateStatistics.nbSessions);
            } else {
                document.querySelector("#templateChart").innerHTML =
                    "<p>Aucune session pour ce template</p>";

            }
            document.querySelector(".minTime").innerHTML =
                "min : " + formatTime(this.data.templateStatistics.minTime);
            document.querySelector(".maxTime").innerHTML =
                "max : " + formatTime(this.data.templateStatistics.maxTime);
            document.querySelector(".averageTime h3").innerHTML = formatTime(
                this.data.templateStatistics.averageTime
            );

            document.querySelector(".minClick").innerHTML =
                "min : " + this.data.templateStatistics.minClicks;
            document.querySelector(".maxClick").innerHTML =
                "max : " + this.data.templateStatistics.maxClicks;
            document.querySelector(".averageClick h3").innerHTML =
                this.data.templateStatistics.averageClicks;

            let statArea = document.querySelector("#statSessionTemplateArea");
            statArea.innerHTML = "";
            let personasStatistics = this.data.personasStatistics;

            Object.keys(personasStatistics).forEach((persona) => {
                let statSessionTemplate = document.createElement("div");
                statSessionTemplate.classList.add("statSessionCard");
                statSessionTemplate.classList.add("card");
                statSessionTemplate.setAttribute(
                    "id",
                    "statSessionCard" + persona
                );

                let statSessionTemplateTitle = document.createElement("p");
                statSessionTemplateTitle.innerHTML = personasStatistics[persona].name;
                statSessionTemplate.appendChild(statSessionTemplateTitle);

                let statSessionContainer = document.createElement("div");
                statSessionContainer.classList.add("statSessionContainer");

                let statTimeContainer = document.createElement("div");
                statSessionContainer.classList.add("statTimeContainer");

                let canvas = document.createElement("canvas");
                canvas.classList.add("statSessionChart");
                canvas.setAttribute("id", "chart" + persona);
                statSessionContainer.appendChild(canvas);

                let statTime = document.createElement("p");
                statTime.innerHTML = "Temps moyen : " +formatTime(personasStatistics[persona].sessions.averageTime);



                statSessionTemplate.appendChild(statSessionContainer);
                statSessionTemplate.appendChild(statTime);
                statArea.appendChild(statSessionTemplate);

                let chart = new Chart(canvas, {
                    type: "doughnut",
                    data: {
                        datasets: [
                            {
                                data: [personasStatistics[persona].sessions.total - personasStatistics[persona].sessions.isSuccess, personasStatistics[persona].sessions.isSuccess],
                                backgroundColor: ["#e30909", "#008a29"],
                            },
                        ],
                    },
                    options: {
                        responsive: true,

                    },
                });
            });
        }
    }
}
