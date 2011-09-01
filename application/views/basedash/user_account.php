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
    
    <section class="account-setting">
        <?php
            echo form_open_multipart('site/update_user_account');
            echo form_hidden('ident', $user_data['ident']);
        ?>

            <div class="formCtn left spaceTop">
                <div class="left">
                    <label>Username:</label>   
                    <input type="text" name="username" value="<?php echo $user_data['username']; ?>" class="required field regfield" readonly="readonly" />
                </div>

                <div class="left">
                    <label>Password:</label>
                    <input type="password" name="password" value="" class="field regfield required" readonly="readonly"/>
                </div>

                <div class="left">
                    <label>Confirm Password:</label>
                    <input type="password" name="confirm_password" value="" class="field regfield required" readonly="readonly"/>
                </div>

                <div class="left">
                    <label>Basecamp Url:</label>
                    <input type="text" name="basecampUrl" value="<?php echo $user_data['basecamp_url']; ?>" class="field regfield" readonly="readonly"/>
                    <small>ex: http://remotelink1.basecampq.com</small>
                </div>
            </div>
            <!-- end of left -->

            <div class="formCtn left spaceTop">

                <div class="left">
                    <label>Token:</label>
                    <input type="text" name="apikey" value="<?php echo $user_data['apikey']; ?>" class="field regfield" readonly="readonly"/>
                    <small>ex: 012e7050924cc105e12355c9d6c71ecccaf</small>
                </div>
                <div class="left">
                    <label>Logo:</label>
                    <input type="file" name="logo" class="field regfield">
                    <small>Upload your company logo (Height: 70px)</small><br /><br />
                    <input type="submit" value="Update"/>
                </div>

            </div>
        </form>
    </section>