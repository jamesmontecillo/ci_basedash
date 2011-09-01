jQuery(document).ready(function() {
    // User Login
    // Expand Panel
    jQuery("#open_user").click(function(){
        jQuery(".panel").slideDown("slow");
        jQuery("#toggle_forgot").hide();
    });
    // Collapse Panel
    jQuery("#close_user").click(function(){
        $(".panel").slideUp("slow");
        jQuery("#toggle_forgot").show();
    });
    // Switch buttons from "Log In | Register" to "Close Panel" on click
    $("#toggle_user a").click(function () {
        $("#toggle_user a").toggle();
    });

    // Forgot password
    // Expand Panel
    jQuery("#open_forgot").click(function(){
        jQuery(".panel_forgot").slideDown("slow");
        jQuery("#toggle_user").hide();
    });
    // Collapse Panel
    jQuery("#close_forgot").click(function(){
        $(".panel_forgot").slideUp("slow");
        jQuery("#toggle_user").show();
    });
    // Switch buttons from "Log In | Register" to "Close Panel" on click
    $("#toggle_forgot a").click(function () {
        $("#toggle_forgot a").toggle();
    });


    $('.boxgrid').hover(function(){
        $(".cover", this).stop().animate({
            bottom:'-250px'
        },{
            queue:false,
            duration:400
        });
    }, function() {
        $(".cover", this).stop().animate({
            bottom:'0px'
        },{
            queue:false,
            duration:400
        });
    });




    $(".screenShot a").hover(function() {
        var defaul = $(this).find('img').attr('src');
        $(".sYellow").find('img').attr('src', 'images/homepage/yellow_2.png');
        $(".sRed").find('img').attr('src', 'images/homepage/red_2.png');
        $(".sGreen").find('img').attr('src', 'images/homepage/green_2.png');

        $(this).find('img').attr('src', defaul);

        $(this).css({
            'z-index' : '4'
        });
        $(this).find('img').addClass("hover").stop() /* Add class of "hover", then stop animation queue buildup*/
        .animate({
            marginTop: '-20'
        }, 1000); /* this value of "200" is the speed of how fast/slow this hover animates */
    } , function() {
        $(".sYellow").find('img').attr('src', 'images/homepage/yellow.png');
        $(".sRed").find('img').attr('src', 'images/homepage/red.png');
        $(".sGreen").find('img').attr('src', 'images/homepage/green.png');
        $(".sGreen").css({
            'z-index' : '2'
        });
        $(".sRed").css({
            'z-index' : '3'
        });
        $(".sYellow").css({
            'z-index' : '1'
        });
        $(this).find('img').removeClass("hover").stop()  /* Remove the "hover" class , then stop animation queue buildup*/
        .animate({
            marginTop: '0px'
        }, 600);
    });

    $(".popupReg").colorbox({
        width:"630px",
        height:"600px",
        iframe:true,
        overlayClose:false,
        onClosed:function(){ window.location.reload(); }
    });
    $(".popupAccountSettings").colorbox({
        width:"800px",
        height:"480px",
        iframe:true,
        overlayClose:false,
        onClosed:function(){ window.location.reload(); }
    });
    $(".popupAccountBilling").colorbox({
        width:"800px",
        height:"550px",
        iframe:true,
        overlayClose:false,
        onClosed:function(){ window.location.reload(); }
    });
});

function formatText(index) {
    return index + "";
}
$(function () {
    $('.anythingSlider').anythingSlider({
        easing: "easeInOutExpo",        // Anything other than "linear" or "swing" requires the easing plugin
        autoPlay: false,                 // This turns off the entire FUNCTIONALY, not just if it starts running or not.
        delay: 7000,                    // How long between slide transitions in AutoPlay mode
        startStopped: false,            // If autoPlay is on, this can force it to start stopped
        animationTime: 1100,             // How long the slide transition takes
        hashTags: true,                 // Should links change the hashtag in the URL?
        buildNavigation: true,          // If true, builds and list of anchor links to link to each slide
        pauseOnHover: true,             // If true, and autoPlay is enabled, the show will pause on hover
        startText: "Go",             // Start text
        stopText: "Stop",               // Stop text
        navigationFormatter: formatText       // Details at the top of the file on this use (advanced use)
    });
});