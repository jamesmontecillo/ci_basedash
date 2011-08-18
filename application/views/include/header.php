<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>BaseDash | The easiest way to visualize the health of your Basecamp projects</title>

    <link rel="stylesheet" href="<?php echo base_url(); ?>css/style.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/password_strength.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/colorbox.css" type="text/css" />

    <link  href="http://fonts.googleapis.com/css?family=Droid+Sans:regular,bold" rel="stylesheet" type="text/css" >
    <link rel="shortcut icon" href="<?php echo base_url(); ?>images/favicon.ico" />
    
    <script src="https://www.google.com/jsapi?key=ABQIAAAA88IoAunmAImlFv-hvUnOoBSnTVK5a-OojRyXF4dibNPRA5J1VBTYP_f__CPQXMn3SESZiFn9UhilCg" type="text/javascript"></script>
    <script type="text/javascript">google.load("jquery", "1.6.1");</script>
    
    <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.validate.min.js" charset="ISO-8859-1"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.colorbox.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/custom.js"></script>

    <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.easing.1.3.js"></script> <!-- SLIDER -->
    <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.anythingslider.js" charset="utf-8"></script><!-- SLIDER -->

    <!--[if IE]>
        <script src="<?php echo base_url(); ?>js/html5.js"></script>
    <![endif]-->
    <!--[if lte IE 7]>
        <script src="<?php echo base_url(); ?>js/IE8.js" type="text/javascript"></script>
    <![endif]-->
    
<!--    basedash only -->
<?php 
$current_segment = uri_string(); 
if ($current_segment == 'site'){
?>
    <script src="<?php echo base_url(); ?>js/jquery_ui_core.js"></script>
    <script src="<?php echo base_url(); ?>js/jquery_ui_widget.js"></script>
    <script src="<?php echo base_url(); ?>js/jquery_ui_mouse.js"></script>
    <script src="<?php echo base_url(); ?>js/jquery_ui_draggable.js"></script>
    <script src="<?php echo base_url(); ?>js/jquery_ui_sortable.js"></script>
    <script type="text/javascript">
        $(function() {
            $( ".dashletCtn" ).sortable({
                connectWith: ".dashletCtn",
                revert: true,
                cursor: 'move',
                opacity: 0.8,
                update: function() {
                    var order = $(this).sortable("serialize") + "&ident=<?php if (isset($user_data['ident'])){ echo $user_data['ident']; } ?>&apikey=<?php if (isset($user_data['apikey'])){ echo $user_data['apikey']; } ?>";
//                    alert(order);
                    $.post("site/change_project_order", order, function(theResponse){
                        //                        window.location.reload();
                        //                        $("#response").html(theResponse);
                        //                        $("#response").slideDown('slow');
                        //                        slideout();
                    });
                }
            });
            $( ".dashletCtn" ).disableSelection();
        });
    </script>
    <script type="text/javascript">
        function disableproject(str){
            $(document).ready( function(){
                $.ajax({
                    type: "POST",
                    url: "site/change_project_status",
                    data: "ident=<?php if (isset($user_data['ident'])){ echo $user_data['ident']; } ?>&project_id="+str+"&apikey=<?php if (isset($user_data['apikey'])){ echo $user_data['apikey']; } ?>&status=<?php echo $project_status; ?>",
                    success: function(){
                        window.location.reload();
                    }
                });
            });
        }
    </script>
        
    <script type="text/javascript">
        $(document).ready(function(){
            $('.dashletBtn ul li a').click(function(){
                var url = $(this).attr('href');
//                alert (url);
                $.post(url,processData);
                function processData(url){
//                    alert (url);
                    window.location.reload();
                }
                return false; // Do nothing.
            });
        });
    </script>
    
    <script type="text/javascript">
        $(document).ready( function(){
            alertSize();
            function alertSize() 
            {
                var myWidth = 0, myHeight = 0;
                if( typeof( window.innerWidth ) == 'number' ) {
                    //Non-IE
                    myWidth = window.innerWidth;
        //                myHeight = window.innerHeight;
                } else if( document.documentElement && ( document.documentElement.clientWidth || document.documentElement.clientHeight ) ) {
                    //IE 6+ in 'standards compliant mode'
                    myWidth = document.documentElement.clientWidth;
        //                myHeight = document.documentElement.clientHeight;
                } else if( document.body && ( document.body.clientWidth || document.body.clientHeight ) ) {
                    //IE 4 compatible
                    myWidth = document.body.clientWidth;
        //                myHeight = document.body.clientHeight;
                }
        //            window.alert( 'Width = ' + myWidth );
        //            window.alert( 'Height = ' + myHeight );
                smartSizes(myWidth);
            }

            function smartSizes(myWidth)
            {
                $("body").css({'width' : myWidth});
                var divbodywidth = "<?php if (isset($dashlet)){ echo $dashlet; } ?>";
                $(".dashboardCtn").css({'width' : divbodywidth});
                if (myWidth <= divbodywidth){
                    $("body").css({'width' : divbodywidth});
                }else{
                    $("body").css({'width' : '100%'});
                }
            }
        });
    </script>
<?php } ?>
</head>
<body>