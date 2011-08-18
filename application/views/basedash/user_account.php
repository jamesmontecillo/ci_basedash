<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
//print_r($user_data);
?>

<section class="billingStn">
    <?php echo validation_errors('<div class="clear errorCtn">', '</div>'); ?>
    <?php
    if ((isset($account_error)) && (!empty($account_error))) {
        echo '<div class="clear errorCtn">' . $account_error . '</div>';
    }
    ?>
</section>

<div class="clear"></div>

<section class="billingCtn">
    <?php
    echo form_open_multipart('site/update_user_account');
    echo form_hidden('ident', $user_data['ident']);
    ?>
    <div class="billingStn left spaceTop">
        <div class="left">
            Username:   
            <input type="text" name="username" value="<?php echo $user_data['username']; ?>" class="required regfield" readonly="readonly" />
        </div>
        <div class="left">
            Password:
            <input type="password" name="password" value="<?php echo $user_data['password']; ?>" class="regfield required" readonly="readonly"/>
        </div>
        <div class="left">
            Confirm Password:
            <input type="password" name="confirm_password" value="<?php echo $user_data['password']; ?>" class="regfield required" readonly="readonly"/>
        </div>
        <div class="left">
            Basecamp Url:
            <input type="text" name="basecampUrl" value="<?php echo $user_data['basecamp_url']; ?>" class="regfield" readonly="readonly"/>
            <small>ex: http://remotelink1.basecampq.com</small>
        </div>
    </div>
    <div class="billingStn left spaceTop">
        <div class="left">
            Token:
            <input type="text" name="apikey" value="<?php echo $user_data['apikey']; ?>" class="regfield" readonly="readonly"/>
            <small>ex: 012e7050924cc105e12355c9d6c71ecccaf</small>
        </div>
        <div class="left">
            Logo:
            <input type="file" name="logo" class="regfield">
            <small>Upload your company logo (Height: 70px)</small><br /><br />
            <input type="submit" value="Update"/>
        </div>
    </div>
</form>
</section>