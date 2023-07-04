import {Rest} from "/js/Rest.js";

let rest = new Rest();

document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[data-bs-target]').forEach(function (element) {
        element.addEventListener('click', function (event) {
            let id = this.getAttribute('data-bs-target');
            document.querySelector('.side-bar .active')?.classList.remove('active');
            this.classList.add('active');
            rest.call(
                id?'/personas/form/' + id :'/personas/form/0',
                'GET',
                null,
                (data) => {
                    document.querySelector('.form-persona').innerHTML = data.html;
                }
            );
        });
    });
});
