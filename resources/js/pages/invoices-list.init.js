/*
Template Name: WBMAHALCRM - Customer Relationship Management Application
Author: WebMahal.com
Website: https://WebMahal.com.in/
Contact: WebMahal.com.in@gmail.com
File: invoice list Js File
*/

// datatable
$(document).ready(function() {
    $('.datatable').DataTable({
        responsive: false
    });
    $(".dataTables_length select").addClass('form-select form-select-sm');
});


// flatpicker

flatpickr('.datepicker-range', {
    mode: "range",
    altInput: true,
    wrap: true
});
