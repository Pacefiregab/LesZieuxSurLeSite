import {filtre} from "/js/sidebar/filtre.js";
import {personaShow} from "/js/persona_show/personaShow.js";

let filtre2 = new filtre('/sessions/api/', (data) => {
    let personaShow2 = new personaShow(data);
});
