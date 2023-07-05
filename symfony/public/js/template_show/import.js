import {templateShow} from '/js/template_show/templateShow.js';
import {filtre} from "/js/sidebar/filtre.js";

let perso = new templateShow(null);

new filtre('/sessions/api/', (data) => {
    console.log(data)
    new templateShow(data);
});

