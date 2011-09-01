<!-- start -->
<?php if (!empty($login_error)) { ?>
    <script type="text/javascript">
        $(document).ready(function(){
            $(".panel").slideDown("slow");
            $("#toggle_forgot").hide();
            $("#toggle_user a").toggle();
        });
    </script>
<?php } ?>
<aside id="panel" class="panel">
    <div class="panelCtn">
        
        <?php echo form_open('home/authenticate', array('class' => 'right panelForm')) . "\n"; ?>
        <div class="inputCtn">
            <label for="log">USERNAME</label>
            <?php echo form_input(array('name' => 'username', 'id' => 'username', 'class' => 'field', 'value' => '', 'tabindex' => '500',)) . "\n"; ?>
        </div>
        <div class="inputCtn">
            <label for="pwd">PASSWORD</label>
            <?php echo form_password(array('name' => 'password', 'id' => 'password', 'class' => 'field', 'value' => '', 'tabindex' => '510',)) . "\n"; ?>
        </div>
        <div class="inputCtn">
            <?php echo form_submit(array('name' => 'login', 'id' => 'login', 'class' => 'bt_login left', 'value' => '',)) . "\n"; ?>
        </div>
        </form>
        <div class="formLabel">USER LOGIN</div>
        <div class="errormessage">
            <?php
            if ((isset($login_error)) && (!empty($login_error))) {
                echo $login_error;
            }
            ?>
        </div>
        
    </div>
</aside> <!-- USER LOGIN -->

<?php if (!empty($err_forgotpass)) { ?>
    <script type="text/javascript">
        $(document).ready(function(){
            $(".panel_forgot").slideDown("slow");
            $("#toggle_user").hide();
            $("#toggle_forgot a").toggle();
        });
    </script>
<?php } ?>
<aside id="panel" class="panel_forgot">
    <div class="panelCtn">
        
        <form action="http://html2.com/ci_basedash/home/forgot_password" method="POST" class="right panelForm">
            <div class="inputCtn">
                <label for="log">EMAIL ADDRESS:</label>
                <input type="text" name="email" id="email" class="field" value="" tabindex="500" />
            </div>
            <div class="inputCtn">
                <label for="log">Confirm EMAIL:</label>
                <input type="text" name="confirm_email" id="email" class="field" value="" tabindex="500" />
            </div>
            <div class="inputCtn">
                <input type="submit" name="send" id="login" class="bt_login left" value="" />
            </div>
        </form>
        
        <div class="formLabel left">FORGOT PASSWORD</div>
        <div class="errormessage">
            <?php
            if ((isset($err_forgotpass)) && (!empty($err_forgotpass))) {
                echo $err_forgotpass;
            }
            ?>
        </div>
        <?php echo validation_errors('<p class="text left">'); ?>
    </div>
</aside> <!-- FORGOT PASSWORD -->
    
<div class="tab">
    <ul class="login">
        <li id="toggle_user">
            <a id="open_user" class="open" href="#">User Login</a>
            <a id="close_user" class="close" href="#">Close Panel</a>
        </li>
        <li id="toggle_forgot">
            <a id="open_forgot" class="open" href="#">Forgot Password</a>
            <a id="close_forgot" class="close" href="#">Close Panel</a>
        </li>
    </ul>
</div>    
<!-- END HOME LOGIN -->

<section class="darkBg">
    <aside id="intro" class="intro">
        <section class="left introText">
            <h1 class="title">Basedash</h1>
            <h2 class="subTitle">The easiest way to visualize the health of your Basecamp projects.</h2>
            <p>BaseDash is for anyone using Basecamp. It allows you to see the realtime health of each of your projects along with important updates.</p>

            <?php echo anchor('home/registration', '<div class="left" id="launch"></div>', array('class' => 'popupReg')); ?>
        </section>

        <section class="right screenShot">
            <a href="#" class="sGreen"><img src="images/homepage/green.png" height="332px"/></a>
            <a href="#" class="sRed"><img src="images/homepage/red.png" height="360px"/></a>
            <a href="#" class="sYellow"><img src="images/homepage/yellow.png" height="332px"/></a>
        </section>
    </aside>
</section>

<section class="otherProdCtn clear">
    <div class="signup">
        <article class="left boxes">
            <div class="icon launch"></div>
            <h2>Launch Basedash</h2>
        </article>

        <div class="boxesLine left"></div>

        <article class="left boxes">
            <div class="icon free"></div>
            <h2>Try it free for 14 days</h2>
        </article>

        <div class="boxesLine left"></div>

        <article class="left boxes">
            <div class="icon like"></div>
            <h2>If you like it, keep it for $4.99/month</h2>
        </article>
    </div>
    <!-- END SIGNUP -->

    <div class="otherProd">
        <h1>Other products in the TryCloudNow suite.</h1>
        <article class="boxgrid">
            <div class="img">
                <img src="images/homepage/basedash.png" class="cover" width="220px"/>
                <a href="#"><img src="images/homepage/basedash-h.png" class="right" border="0" width="220px"/></a>
            </div>
        </article>

        <article class="boxgrid">
            <div class="img">
                <img src="images/homepage/quickbooks.png" class="cover" width="220px"/>
                <a href="http://www.remotelink.com/quickbooks-sugarcrm-integration/"><img src="images/homepage/quickbooks-h.png" class="right" border="0" width="220px"/></a>
            </div>
        </article>

        <article class="boxgrid">
            <div class="img">
                <img src="images/homepage/sugar.png" class="cover" width="220px"/>
                <a href="http://www.remotelink.com/products/sugarcrm/"><img src="images/homepage/sugar-h.png" class="right" border="0" width="220px"/></a>
            </div>
        </article>
    </div>
    <!-- END OF OTHER PRODUCTS -->
</section>

<div class="darkWrapBg">
    <footer class="footer">
        <img src="images/homepage/logo.png"/>
    </footer>
</div>