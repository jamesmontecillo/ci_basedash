<?php
//print_r($user_data);
$username = $user_data['username'];
$logo = $user_data['logo'];
?>
<div class="fullwidth darkBg">
    <nav class="pagemilestone" style="height:25px;" >
        <ul class="dropdown">
            <li class="nobg"><a href="#">Welcome: <?php echo $username; ?></a></li>
            <li class="subnav">Options
                <ul>
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
                ?>
            </li>
        </ul>
    </nav>
</div>

<div class="pagemilestone">
    <section class="">
        <header class="header">
            <div class="imgLogo left">
                <?php
                if (empty($logo)) {
                    echo '<img src="images/dashboard/default.png" height="70px"/>';
                } else {
                    echo '<img src="' . $logo . '" height="70px"/>';
                }
                ?>
            </div>
        </header>
    </section>
    <section class="resultXml">
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
            <h1>Updating Projects</h1>
                <img src="<?php echo base_url(); ?>images/dashboard/resultXML-header.png" />
                <div class="resultXmlTxt" id="resultXmlTxt">
                    <img src='<?php echo base_url(); ?>images/dashboard/load.gif' alt='loading...' />
                    <p>Loading up your Basecamp projects...</p>
                    <p>Please Wait.</p>
                </div>
    </section>
</div>