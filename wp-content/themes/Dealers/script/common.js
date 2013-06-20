jQuery(document).ready(function(){

    // Menu

    jQuery("ul.menu").superfish();

    // Date Picker

    $( "#submit_start_picker" ).datepicker();
    $( "#submit_end_picker" ).datepicker();


    //Search style

    jQuery(".footer_box .screen-reader-text").remove();

    //Pirobox
 /*       
    jQuery('.pirobox').each(function(){
        jQuery('img',this).animate({
            opacity:1
        },0);
    });
	
    jQuery('img','.pirobox').hover(function(){
        jQuery(this).stop().animate({
            opacity:0.4
        },500);
    },function(){
        jQuery(this).stop().animate({
            opacity:1
        },300);
    });
	
    jQuery('.images img').hover(function(){
        jQuery('img',this).stop().animate({
            opacity:0.4
        },500);
    },function(){
        jQuery('img',this).stop().animate({
            opacity:1
        },300);
    });*/




});
