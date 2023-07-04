import {Rest} from "/js/Rest.js";

let rest = new Rest();

document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[data-bs-target]').forEach(function (element) {
        element.addEventListener('click', function (event) {
            let id = this.getAttribute('data-bs-target');
            document.querySelector('.side-bar .active')?.classList.remove('active');
            this.parentNode.classList.add('active');
            rest.call(
                '/templates/form/' + id || '',
                'GET',
                null,
                (data) => {
                    document.querySelector('.form-template').innerHTML = data.html;
                }
            );
        });
    });
});
