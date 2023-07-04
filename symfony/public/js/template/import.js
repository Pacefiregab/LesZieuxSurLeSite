
import {filtre} from "/js/sidebar/filtre.js";
import {details} from "/js/template/details.js";

let filtre2 = new filtre('/templates/api/', (data) => {
 details(data);
});


