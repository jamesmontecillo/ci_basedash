<?php 
$current_segment = uri_string();
if (($current_segment != 'site/user_account') && ($current_segment != 'site/user_billing')){
?>
<div class="clear">
<?php if (($current_segment == 'site') && ($current_segment != 'site/milestone') && ($current_segment != 'site/update')){ ?>
        <footer class="adjusted-width">
            <div class="globalfooter">
                 Basedash
                <img src="<?php echo base_url(); ?>images/dashboard/logo-footer.png" height="30px" />
            </div>
        </footer>
    <?php } else if (($current_segment == 'site/milestone') || ($current_segment == 'site/update')) { ?>
         <div class="pagemilestone">
            <footer>
                Basedash
                <img src="<?php echo base_url(); ?>images/dashboard/logo-footer.png" height="30px" />
            </footer>
         </div>
    <?php } else { ?>
        <footer class="footer">
            <img src="<?php echo base_url(); ?>images/homepage/logo.png" class="homelogo"/>
        </footer>
    <?php } ?>
</div>
<?php } ?>
</body>
</html>