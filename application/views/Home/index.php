<aside id="panel" class="panel">
    <div class="panelCtn">
        <div class="panelLogin right">
            <div class="formLabel left">USER LOGIN</div>
            <?php echo form_open('home/authenticate') . "\n"; ?>
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
            <!--            <form action="index.php?module=Users&action=authenticate" method="POST" class="left">
                            <div class="inputCtn">
                                <label for="log">USERNAME</label>
                                <input type="text" name="username" id="username" class="field" value="" tabindex="500" />
                            </div>
                            <div class="inputCtn">
                                <label for="pwd">PASSWORD</label>
                                <input type="password" name="password" id="password" class="field" value="" tabindex="510" />
                            </div>
                            <div class="inputCtn">
                                <input type="submit" name="login" id="login" class="bt_login left" value="" />
                            </div>-->
            </form>
        </div>
        <p class="text left">
            <?php
            if ((isset($login_error)) && (!empty($login_error))) {
                echo $login_error;
            }
            ?>
        </p>
    </div>
</aside>

<aside id="panel" class="panel_forgot">
    <div class="panelCtn">
        <div class="panelLogin right">
            <div class="formLabel left">FORGOT PASSWORD</div>
            <form action="http://html2.com/ci_basedash/home/forgot_password" method="POST" class="left">
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
        </div>
        <p class="text left">
            <?php
            if ((isset($err_forgotpass)) && (!empty($err_forgotpass))) {
                echo $err_forgotpass;
            }
            ?>
        </p>
        <?php echo validation_errors('<p class="text left">'); ?>
    </div>
</aside>
<!-- end of top login container -->
<section class="darkWrapBg">
    <div class="tab">
        <ul class="login">
            <li id="toggle_user">
                <a id="open_user" class="open" href="#">User Login</a>
                <a id="close_user" style="display: none;" class="close" href="#">Close Panel</a>
            </li>
            <li id="toggle_forgot">
                <a id="open_forgot" class="open" href="#">Forgot Password</a>
                <a id="close_forgot" style="display: none;" class="close" href="#">Close Panel</a>
            </li>
        </ul>
    </div>
    <!-- end of tab btn -->
    <aside id="intro" class="intro">

        <section class="left introText">
            <h1 class="title">Basedash</h1>
            <h2 class="subTitle">The easiest way to visualize the health of your Basecamp projects.</h2>
            <p>BaseDash is for anyone using Basecamp. It allows you to see the realtime health of each of your projects along with important updates.</p>

            <?php echo anchor('home/registration', '<div class="left" id="launch"></div>', array('class' => 'popupReg')); ?>
            <!--            <a class='popupReg' href="index.php?module=registration&action=registration"><div class="left" id="launch"></div></a>-->
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
            <img src="images/homepage/launch.png" width="50px" class="boxesImg"/>
            <div class="boxesTxt">
                Launch Basedash
            </div>
        </article>
        <div class="boxesLine left"></div>
        <article class="left boxes">
            <img src="images/homepage/free.png" width="50px" class="boxesImg"/>
            <div class="boxesTxt">
                Try it free for 14 days
            </div>
        </article>
        <div class="boxesLine left"></div>
        <article class="left boxes">
            <img src="images/homepage/like.png" width="50px" class="boxesImg"/>
            <div class="boxesTxt">
                If you like it, keep it for $4.99/month
            </div>
        </article>
    </div>

    <div class="otherProd">
        <hgroup class="prodTitle">Other products in the TryCloudNow suite.</hgroup>
        <article class="boxgrid">
            <!--            <hgroup class="prodTitle p1">BaseDash</hgroup>
                        <p>The easiest way to visualize the health of your Basecamp projects.</p>-->
            <div class="img">
                <img src="images/homepage/basedash.png" class="cover" width="220px"/>
                <a href="#"><img src="images/homepage/basedash-h.png" class="right" border="0" width="220px"/></a>
            </div>
        </article>

        <article class="boxgrid">
            <!--            <hgroup class="prodTitle p2">Quickbooks to SugarCRM</hgroup>
                        <p>The easiest way to visualize the health of your Basecamp projects.</p>-->
            <div class="img">
                <img src="images/homepage/quickbooks.png" class="cover" width="220px"/>
                <a href="http://www.remotelink.com/products/sugarcrm/quickbooks-sugarcrm-integration-quickbooks-crm/"><img src="images/homepage/quickbooks-h.png" class="right" border="0" width="220px"/></a>
            </div>
        </article>

        <article class="boxgrid">
            <!--            <hgroup class="prodTitle p3">SugarCRM</hgroup>
                        <p>The easiest way to visualize the health of your Basecamp projects.</p>-->
            <div class="img">
                <img src="images/homepage/sugar.png" class="cover" width="220px"/>
                <a href="http://www.remotelink.com/products/sugarcrm/"><img src="images/homepage/sugar-h.png" class="right" border="0" width="220px"/></a>
            </div>
        </article>
    </div>
</section>

<div class="darkWrapBg">
    <footer class="footer">
        <img src="images/homepage/logo.png"/>
    </footer>
</div>