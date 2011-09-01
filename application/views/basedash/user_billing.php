<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
//print_r($user_data);
?>

<section class="formMessage">
    <?php echo validation_errors('<div class="clear errorCtn">', '</div>'); ?>
    <?php
    if ((isset($account_error)) && (!empty($account_error))) {
        echo '<div class="left clear successCtn">' . $account_error . '</div>';
    }
    ?>
</section>
<div class="clear"></div>
<section class="billing-info">
    <form action="index.php?module=Accounts&action=billing_update" enctype="multipart/form-data" method="POST">
        
        <div class="formCtn left spaceTop">
            <div class="left">
                <label>Firstname:</label>
                <input type="text" name="first_name" value="<?php echo $user_data; ?>" class="field"/>
            </div>
            <div class="left">
                <label>Lastname:</label>
                <input type="text" name="last_name" value="<?php echo $user_data; ?>" class="field"/>
            </div>
            <div class="left">
                <label>Billing Address:</label>
                <input type="text" name="billing_address" value="<?php echo $user_data; ?>"  class="field"/>
            </div>
            <div class="left">
                <label>Billing City:</label>
                <input type="text" name="billing_city" value="<?php echo $user_data; ?>"  class="field"/>
            </div>
            <div class="left">
                <label>Billing State:</label>
                <input type="text" name="billing_state" value="<?php echo $user_data; ?>"  class="field"/>
            </div>
            <div class="left">
                <label>Billing Zip:</label>
                <input type="text" name="billing_zip" value="<?php echo $user_data; ?>" class="field"/>
            </div>
        </div>
        <!-- end -->

        <div class="formCtn left spaceTop">
            <div class="left">
                <label>Billing Phone:</label>
                <input type="text" name="billing_phone" value="<?php echo $user_data; ?>"  class="field"/>
            </div>
            <div class="left">
                <label>Billing Email:</label>
                <input type="text" name="billing_email" value="<?php echo $user_data; ?>"  class="field"/>
            </div>
            <div class="left">
                <label>Credit Card Number:</label>
                <input type="text" name="cc_number" value="<?php echo $user_data; ?>"  class="field"/>
            </div>

            <div class="left">
                <label>Credit Card expiration month:</label>
                <input type="text" name="cc_exp_month" value="<?php echo $user_data; ?>"  class="field"/>
            </div>
            <div class="left">
                <label>Credit Card expiration year:</label>
                <input type="text" name="cc_exp_year" value="<?php echo $user_data; ?>"  class="field"/>
            </div>

    </form>
    <div class="left spaceTop">
        <form action="" id="form_cancel" enctype="multipart/form-data" method="POST">
<!--            <input type="submit" value="Cancel Account" id="cancel_account"/>-->
        </form>
    </div>
</div>
</section>