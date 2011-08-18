<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery.validate.min.js" charset="ISO-8859-1"></script>
<script type="text/javascript" src="js/jquery.colorbox.js"></script>
<script type="text/javascript" src="js/custom.js"></script>

<script type="text/javascript" src="js/jquery.easing.1.3.js"></script> <!-- SLIDER -->
<script type="text/javascript" src="js/jquery.anythingslider.js" charset="utf-8"></script><!-- SLIDER -->

<!--[if IE]>
    <script src="js/html5.js"></script>
<![endif]-->
<!--[if lte IE 7]>
    <script src="js/IE8.js" type="text/javascript"></script>
<![endif]-->

<?php if (($_REQUEST['module'] == 'Users') && ($_REQUEST['action'] == 'Forgot_Password_Reset')) { ?>
<script type="text/javascript" src="js/mocha.js" charset="utf-8"></script><!-- Strength of the Password -->
<?php } ?>

<?php if ($_REQUEST['module'] == 'basedash') { ?>
    <script src="js/jquery_ui_core.js"></script>
    <script src="js/jquery_ui_widget.js"></script>
    <script src="js/jquery_ui_mouse.js"></script>
    <script src="js/jquery_ui_draggable.js"></script>
    <script src="js/jquery_ui_sortable.js"></script>

<script type="text/javascript">
    $(document).ready(function(){
        $('.dashletBtn ul li a').click(function(){
            var url = $(this).attr('href');
//            alert (url);
            $.post(url,processData);
            function processData(url){
//                alert (url);
                window.location.reload();
            }
            return false; // Do nothing.
        });
    });
</script>
    
    <script type="text/javascript">
        $(document).ready( function(){
        alertSize();
        function alertSize() {
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
        function smartSizes(myWidth){
            $("body").css({'width' : myWidth});
            var divbodywidth = "<?php if (isset($_SESSION['dashlet'])){ echo $_SESSION['dashlet']; } ?>";//$(".dashboardCtn").width();
            $(".dashboardCtn").css({'width' : divbodywidth});
            if (myWidth <= divbodywidth){
                $("body").css({'width' : divbodywidth});
            }else{
                $("body").css({'width' : '100%'});
            }
        }
        });
    </script>
    <script type="text/javascript">
        function disableproject(str){
            $(document).ready( function(){
                $.ajax({
                    type: "POST",
                    url: "index.php?module=basedash&action=config_enabled",
                    data: "uid=<?php if (isset($_SESSION['UID'])){ echo $_SESSION['UID']; } ?>&project_id="+str+"&token=<?php if (isset($_SESSION['token'])){ echo $_SESSION['token']; } ?>&enabled=<?php echo $disabled; ?>",
                    success: function(){
                        window.location.reload();
                    }
                });
            });
        }
    </script>
    <script type="text/javascript">
        $(function() {
            $( ".dashletCtn" ).sortable({
                connectWith: ".dashletCtn",
                revert: true,
                cursor: 'move',
                opacity: 0.8,
                update: function() {
                    var order = $(this).sortable("serialize") + "&uid=<?php if (isset($_SESSION['UID'])){ echo $_SESSION['UID']; } ?>&token=<?php if (isset($_SESSION['token'])){ echo $_SESSION['token']; } ?>";
                    //alert(order);
                    $.post("index.php?module=basedash&action=config_order", order, function(theResponse){
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
<?php } ?>
<script type="text/javascript">
    $(document).ready(function(){
        $('#cancel_account').click(function(){
            var response = confirm('Are your sure? \nDo you want to Cancel your account?');
            if(response){
                $.ajax({
                    url: "index.php?module=Accounts&action=cancel_account",
                    cache: false,
                    success: function(html){
//                      alert(html);
                        window.location.href = "index.php?module=Users&action=Logout";
                        parent.$.colorbox.close();
                    }
                });
                return false; // Do nothing.
            }
            return false;
        });
    });
</script>

