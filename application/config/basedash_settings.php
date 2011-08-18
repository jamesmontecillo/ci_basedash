<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/** For Production www.BaseDash.com 
$basedash_config = array(
    'site_url' => 'http://www.basedash.com',
    'apiengine' => 'https://chtomcat.remotelink.com',
    'callback' => 'http://www.basedash.com/index.php?module=ResetPassword'
);**/
//$config['callback'] = 'http://www.basedash.com/index.php?module=ResetPassword';
$config['callback'] = 'http://html2.com/ci_basedash/home/reset_password';
$config['apiengine'] = 'http://ec2.remotelink.com:6080';//'https://chtomcat.remotelink.com';