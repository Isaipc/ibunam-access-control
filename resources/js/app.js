/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('jquery-validation');
// require('')
require('./bootstrap');
require('bootstrap-select');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app'
});

var today = new Date();
console.log(formatAMPM(today));


jQuery('.multiple-select').selectpicker();
// ********************EVENTS********************
jQuery(document).ready( function ( ) {

    jQuery('#fecha').val(moment(today).format('YYYY-MM-DD'));
    jQuery('#i_entrada').val(dateToLongTime(today));
    jQuery('#i_salida').val(dateToLongTime(today));
    // jQuery('#i_salida').rules('add', { grather_than: '#i_entrada'});

    // jQuery('')

    jQuery('.show-empleado').on('click', function(){
        show_empleado(this.id);
    });

    jQuery('#s_empleados').on('change', function(){
        fill_horario_grid();
    });

    jQuery('#exampleModal').on('show.bs.modal', event => {
        var button = jQuery(event.relatedTarget);
        var modal = jQuery(this);
        // Use above variables to manipulate the DOM
    });


    jQuery('#daterange').daterangepicker({
            opens: 'center',
            // showCustomRangeLabel : true,
            // applyButtonClasses : 'btn btn-md btn-outline-success',
            locale : {
                applyLabel : 'Guardar',
                cancelLabel : 'Dejar vacio',
                daysOfWeek: [
                    'Do',
                    'Lu',
                    'Ma',
                    'Mi',
                    'Ju',
                    'Vi',
                    'Sa'
                ],
                monthNames: [
                    'Enero',
                    'Febrero',
                    'Marzo',
                    'Abril',
                    'Mayo',
                    'Junio',
                    'Julio',
                    'Agosto',
                    'Setiembre',
                    'Octubre',
                    'Noviembre',
                    'Diciembre'
                ],
            },
            maxDate : today,
            fromLabel: 'Desde',
            toLabel: 'Hasta'
            // autoApply: true
        }, function(start, end, label){
            // console.log('new date selection was made: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
        });

        jQuery('#daterange').on('cancel.daterangepicker', function (ev, picker) {
            jQuery('#daterange').val('');
        });
});

// jQuery.validator.addMethod('greather_than', function(value, element, params){
    //     var entrada  = timeToDate(value);
    //     var salida  = timeToDate(jQuery(params).val());
//     return salida > entrada;

// }, 'alv tienes un desmadre!');

function fill_horario_grid()
{
    jQuery.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });

    jQuery.ajax({
        type: 'GET',
        url: 'ajax/horarios',
        dataType: 'json',
        data: {
            empleado : jQuery('#s_empleados').val()
        },
        success: function (data){
            console.log(data);

            jQuery('table thead').empty();
            jQuery('table tbody').empty();

            jQuery('table thead')
            .html('<tr><th>#</th><th>Empleado</th><th>Día</th><th>Entrada</th><th>Salida</th></tr>');
            for(var i = 0 ; i < data.horarios.length; i++){
                jQuery('table tbody').append(
                    '<tr>' +
                    '<td>' + (i+1) +  '</td>'+
                    '<td>' + data.empleado.nombre + ' ' + data.empleado.apellidos +  '</td>'+
                    '<td>' + dayNames[data.horarios[i].dia] + '</td>'+
                    '<td>' + timeToAMPM(data.horarios[i].entrada) + '</td>'+
                    '<td>' + timeToAMPM(data.horarios[i].salida) + '</td>'+
                    '</tr>'
                    );
                }
        },
        error: function(e){
            jQuery('table thead').empty();
            jQuery('table tbody').empty();
        }
    });
}


function show_empleado(empleado_id)
{
    jQuery.ajax({
        type: 'GET',
        url: 'empleados/' + empleado_id,
        dataType: 'json',
        data: { id : empleado_id },
        success: function (data){
            console.log(data);
            jQuery('#empleado_nombre').text(data.empleado.nombre + ' ' + data.empleado.apellidos);
            // jQuery('#empleado_apellidos').text(data.empleado.apellidos);
            jQuery('#empleado_telefono').text(data.empleado.telefono ? data.empleado.telefono  : 'No registrado');
            jQuery('#empleado_direccion').text(data.empleado.direccion ? data.empleado.direccion : 'No registrado');
            jQuery('#empleado_rfc').text(data.empleado.rfc);
            jQuery('#empleado_categoria').text(data.empleado.categoria_id);
            jQuery('#empleado_creacion').text(data.empleado.created_at);
            jQuery('#empleado_actualizacion').text(data.empleado.updated_at);
        },
        error: function(e){ }
    });
}

// jQuery(document).on('change', '#s_empleado', function (e) {
//     jQuery.ajaxSetup({
//         headers: {
//             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         }
//     });

//     jQuery.ajax({
//         type: 'GET',
//         dataType: 'json',
//         url: '',
//         data: ,
//         success : function (data){
//             jQuery('table tbody').empty();
//             for(var i = 0; i < data.)
//         },
//         timeout: 1000
//     });
// });
// ********************END-EVENTS********************
function dateToLongTime(date){
    return date.toLocaleString('es-MX', {
        hour: '2-digit',
        minute: '2-digit'
        // hour12: 'true'
    });
}

function timeToAMPM(strtime){
    var date = timeToDate(strtime);
    return date.toLocaleString('es-MX', {
        hour: '2-digit',
        minute: '2-digit',
        hour12: 'true'
    });
}

function timeToDate(strtime){
    var time = strtime.split(':');
    var _date = new Date();
    _date.setHours(time[0]);
    _date.setMinutes(time[1]);
    _date.setSeconds(time[2]);
    return _date;
}

function formatAMPM(date) {
    var hours = date.getHours();
    var minutes = date.getMinutes();
    var ampm = hours >= 12 ? 'pm' : 'am';
    hours = hours % 12;
    hours = hours ? hours : 12; // the hour '0' should be '12'
    hours = hours < 10 ? '0' + hours : hours;
    minutes = minutes < 10 ? '0'+minutes : minutes;
    // var strTime = hours + ':' + minutes + ampm;
    var strTime = hours + ':' + minutes;
    return strTime;
}

const dayNames = ['Domingo','Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'];

function fillDayNames() {
    var selectDia = document.getElementById('s_dia');

    for( var d = 0 ; d < dayNames.length ; d++){
        let dayName = dayNames[d];
        var dayElement = document.createElement('option');
        dayElement.value = d;
        dayElement.textContent = dayName;
        selectDia.append(dayElement);
    }
}
