<?php
//print_r($user_data);
$username = $user_data['username'];
$logo = $user_data['logo'];
?>
<aside class="darkWrapBg" >
    <div class="userPanel">
        <ul id="navigation-1">
            <li style="width: auto;"> <a href="#">Welcome! <?php echo $username; ?></a></li>
            <li><a href="#" title="Options">Options</a>
                <ul class="navigation-2">
                    <li><a class="popupAccountSettings" href="index.php?module=Accounts&action=accounts" title="Account Settings">Account Settings</a></li>
                    <li><a class="popupAccountBilling" href="index.php?module=Accounts&action=billing" title="Billing Information:">Billing Information</a></li>
                </ul>
            </li>
            <li><a href="home/logout">Logout</a></li>
            <li class="hlight">
                <?php
                if (isset($user_data['daysleft'])) {
                    echo $user_data['daysleft'];
                }
                ?></li>
        </ul>
    </div>
</aside>
<div class="dashboardCtn">
    <header class="header left">
        <div class="imgLogo left">
            <?php
            if (empty($logo)) {
                echo '<img src="images/dashboard/default.png" height="70px"/>';
            } else {
                echo '<img src="' . $logo . '" height="70px"/>';
            }
            ?>
        </div>

        <hgroup class="right" style="margin-right: 5px;">
            <h1>&nbsp;</h1> <span class="topSub">&nbsp;</span>
        </hgroup>
    </header>

    <section class="statBtn">
        <ul>
            <li class="disb active"><a href="#" title="Update Projects:">Updating Projects</a></li>
        </ul>
    </section>

    <div class="clear"></div>

    <section class="dashletCtn1">

        <script type="text/javascript">
            setTimeout("loadingAjax()",3000);
            function loadingAjax(){
                $(document).ready(function(){
                    $.ajaxSetup ({
                        global: false,
                        cache: false,
                        async: false
                    });
                    $.ajax({
                        url: "<?php echo base_url(); ?>site/generate_xml_data",
                        data: "ident=<?php echo $user_data['ident']; ?>&apikey=<?php echo $user_data['apikey']; ?>&basecampUrl=<?php echo $user_data['basecamp_url']; ?>&from=basedash",
                        type: "POST",
                        success: function(html){
                            //                                alert("Updated");
                            location.href = "<?php echo base_url(); ?>site?view=<?php echo $return_view; ?>";
                            $(".resultXmlTxt").html(html);
                        }
                    });
                });
            }
        </script>

        <section class="resultXml">
            <img src="<?php echo base_url(); ?>images/homepage/image1.png" />
            <div class="resultXmlTxt">
                <img src='<?php echo base_url(); ?>images/dashboard/load.gif' alt='loading...' />
                <p>Loading up your Basecamp projects...</p>
                <p>Please Wait.</p>
            </div>
        </section>

    </section>
</div><!-- End of dashboardCtn -->
<?php
//    global $basedash_config;
//    $ch = curl_init();
//    curl_setopt($ch, CURLOPT_URL, 'http://abcache.remotelink.com/abcache');
//    curl_setopt($ch, CURLOPT_POST, 1);
//    $url = 'url='.$basedash_config['site_url'].'/index.php?module=Generate&action=generate&uid=' . $_SESSION['UID'] . '&token=' . $_SESSION['token'] . '&basecampUrl=' . $_SESSION['basecampUrl'];   
//    curl_setopt($ch, CURLOPT_POSTFIELDS, $url);
//    $result = curl_exec($ch);
//    curl_close($ch);
//    echo $result;
?>

<div class="darkWrapBgBD">
    <footer class="footerBD">
        <div class="dashboard">
            Basedash
            <img src="<?php echo base_url(); ?>images/dashboard/logo-footer.png" height="30px" style="margin:0 30px 0 0"/>
        </div>
    </footer>
</div>