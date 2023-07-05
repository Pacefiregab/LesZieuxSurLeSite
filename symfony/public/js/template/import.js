import {details} from "/js/template/details.js";
import {filtre} from "/js/sidebar/filtre.js";

let perso = new details(null);

new filtre('/templates/api/', (data) => {
 new details(data);
});


