import {personaShow} from '/js/persona_show/personaShow.js';
import {filtre} from "/js/sidebar/filtre.js";

let perso = new personaShow(null);

new filtre('/sessions/api/', (data) => {
    console.log(data)
    new personaShow(data);
});

