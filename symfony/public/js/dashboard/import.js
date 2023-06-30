
import {filtre} from "/js/sidebar/filtre.js";
import {dashboard} from "/js/dashboard/dashboard.js";

let filtre2 = new filtre('/persona/api/', (data) => {
    let dashboard2 = new dashboard(data);
});

