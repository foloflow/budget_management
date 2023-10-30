/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.scss in this case)
import './styles/app.scss';

// start the Stimulus application
//import './bootstrap';

import 'select2';
const $ = require('jquery');
require('bootstrap');

document.addEventListener('DOMContentLoaded', function() {
    $('.select2').select2();

    $('#myTabs a').on('click', function (e) {
        e.preventDefault()
        $(this).tab('show')
    });
    
    // Récupérez le mois actuel (0 pour janvier, 1 pour février, etc.)
    var currentMonth = new Date().getMonth();
    
    // Activez l'onglet du mois actuel
    $('#myTabs a:eq(' + currentMonth + ')').tab('show');
});