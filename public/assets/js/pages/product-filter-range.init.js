/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*********************************************************!*\
  !*** ./resources/js/pages/product-filter-range.init.js ***!
  \*********************************************************/
/*
Template Name: WBMAHALCRM - Customer Relationship Management Application
Author: WebMahal.com
Website: https://WebMahal.com.in/
Contact: WebMahal.com.in@gmail.com
File: Property list filter init js
*/
var slider = document.getElementById('priceslider');
noUiSlider.create(slider, {
  start: [250, 800],
  connect: true,
  tooltips: true,
  range: {
    'min': 0,
    'max': 1000
  },
  pips: {
    mode: 'count',
    values: 5
  }
});
/******/ })()
;
