<section class="registration">
    <div class="col1"></div>
    <div class="col2">
        <h2 class="subTitle">Enter your Basecamp details to start your 14 days FREE trial.</h2>

        <?php
        if (!empty($_SESSION["err_reg"])) {
            echo
            '<div class="left clear errorCtn">' .
            $_SESSION["err_reg"] .
            '</div>';
        }
        ?>

            <?php echo validation_errors('<p class="left clear errorCtn error">'); ?>
            <?php echo form_open_multipart('home/register', array('name' => 'registration', 'id' => 'registration')); ?>
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
                class="required field regfield"
            />
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
                class="field regfield required"
            />
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
                class="field regfield required" 
            />
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
                class="field regfield required"
            />
            <p>ex: http://remotelink1.basecampq.com</p>
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
                class="field regfield required"
            />
            <p>ex: 012e7050924cc105e12355c9d6c71ecccaf</p>
            <input type="file" name="logo" class="field regfield required">
            <p>Upload your company logo (Height: 70px)</p>
            <input type="submit" value="Register"/>
        </form>
    </div>
</section>