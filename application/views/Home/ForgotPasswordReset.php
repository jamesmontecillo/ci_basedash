<?php echo validation_errors('<div class="clear errorCtn">', '</div>'); ?>
<?php
$hidden = array('username' => $email, 'apikey' => $apikey);
echo form_open('home/reset_forgotten_password', '', $hidden) . "\n";
?>
<div class="clear" style="color: #fff; margin: 30px auto; padding: 10px; width: 340px; min-height: 100px; border: 5px solid #000">
    <div>
        New Password:<br />
        <input type="password" name="password" id="inputPassword" class="regfield"/>
        <div id="complexity" class="default"></div>
    </div>
    <div>
        Confirm new Password:<br />
        <input type="password" name="confirm_password" class="regfield"/>
    </div>
    <div class="spaceTop" style="text-align: right">
        <?php echo anchor('', 'Home'); ?> <input type="Submit" name="submit" value="Submit"/>
    </div>
</div>
</form>

