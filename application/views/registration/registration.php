<section class="regCtn">
    <div class="left" style="width:200px">
        <img src="<?php echo base_url(); ?>images/homepage/reg-img.png" />
    </div>
    <div class="right" style="width:330px; margin-top: 20px">
        <article class="" style="margin-bottom:20px;">
            <h2 class="subTitle">Enter your Basecamp details to start your 14 days FREE trial.</h2>
        </article>
        <?php echo validation_errors('<p class="left clear errorCtn error">'); ?>
        <?php echo form_open_multipart('home/register', array('name' => 'registration', 'id' => 'registration')); ?>
        <!--        <form action="index.php?module=registration&action=register" enctype="multipart/form-data" method="POST" name="registration" id="registration">-->
        <input
            type="text" 
            name="username" 
            onblur="if(this.value == '') { this.value = 'Email Address'; }" 
            onfocus="if(this.value == 'Email Address') { this.value = ''; }" 
            value="<?php if (!empty($_SESSION['username'])) {
            echo $_SESSION['username'];
        } else {
            echo 'Email Address';
        } ?>" 
            class="required regfield"
            />
    <!--        <input type="text" value="Password" class="regfield"/>-->
        <input 
            type="<?php if (!empty($_SESSION['password'])) {
            echo 'password';
        } else {
            echo 'text';
        } ?>" 
            name="password" 
            id="pw" 
            onclick="document.getElementById('pw').type='password'; if(this.value=='Password'){ document.getElementById('pw').value=''; }" 
            onblur="if(this.value==''){this.value='Password'; document.getElementById('pw').type='text';};"
            onfocus="document.getElementById('pw').type='password'; if(this.value == 'Password') { this.value = ''; }" 
            value="<?php if (!empty($_SESSION['password'])) {
            echo $_SESSION['password'];
        } else {
            echo 'Password';
        } ?>" 
            class="regfield required"
            />
<!--        <input type="text" value="Confirm Password" class="regfield"/>-->
        <input 
            type="<?php if (!empty($_SESSION['confirm_password'])) {
            echo 'password';
        } else {
            echo 'text';
        } ?>" 
            name="confirm_password" 
            id="pwc" 
            onclick="document.getElementById('pwc').type='password'; if(this.value=='Confirm Password'){ document.getElementById('pwc').value=''; }" 
            onblur="if(this.value==''){this.value='Confirm Password'; document.getElementById('pwc').type='text';};" 
            onfocus="document.getElementById('pwc').type='password'; if(this.value == 'Confirm Password') { this.value = ''; }"
            value="<?php if (!empty($_SESSION['confirm_password'])) {
            echo $_SESSION['confirm_password'];
        } else {
            echo 'Confirm Password';
        } ?>" 
            class="regfield required" 
            />
    <!--        <input type="text" value="Your Basecamp URL" class="regfield"/>-->
        <input 
            type="text" 
            name="basecampUrl" 
            onblur="if(this.value == '') { this.value = 'Basecamp Url'; }" 
            onfocus="if(this.value == 'Basecamp Url') { this.value = ''; }" 
            value="<?php if (!empty($_SESSION['basecampUrl'])) {
            echo $_SESSION['basecampUrl'];
        } else {
            echo 'Basecamp Url';
        } ?>" 
            class="regfield required"
            />
        <p>ex: http://remotelink1.basecampq.com</p>
<!--        <input type="text" value="Basecamp API Token" class="regfield"/>-->
        <input 
            type="text" 
            name="apikey" 
            onblur="if(this.value == '') { this.value = 'Api Key'; }" 
            onfocus="if(this.value == 'Api Key') { this.value = ''; }"
            value="<?php if (!empty($_SESSION['apikey'])) {
            echo $_SESSION['apikey'];
        } else {
            echo 'Api Key';
        } ?>" 
            class="regfield required"
            />
        <p>ex: 012e7050924cc105e12355c9d6c71ecccaf</p>
        <input type="file" name="logo" class="regfield required">
        <p>Upload your company logo (Height: 70px)</p>
        <input type="submit" value="Register"/>
        </form>
    </div>
</section>