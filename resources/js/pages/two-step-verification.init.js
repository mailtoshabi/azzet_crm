/*
Template Name: WBMAHALCRM - Customer Relationship Management Application
Author: WebMahal.com
Website: https://WebMahal.com.in/
Contact: WebMahal.com.in@gmail.com
File: two step verification Init Js File
*/


// move next
function moveToNext(elem, count){
    if(elem.value.length > 0) {
        $("#digit"+count+"-input").focus();
    }
}
