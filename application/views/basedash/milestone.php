<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
//print_r($basedash_data);
//print_r($user_data);
//print_r($project_milestone_data);
//print_r($project_milestone_order);
//echo $project_view;

$username = $user_data['username'];
$logo = $user_data['logo'];

$num_red = 0;
$num_orange = 0;
$num_yellow = 0;
$num_green = 0;
$num_disabled = 0;
foreach ($basedash_data as $data) {
    if (($data['color'] == 'red') && ($data['enabled'] == 'true')) {
        $num_red++;
    }
    if (($data['color'] == 'orange') && ($data['enabled'] == 'true')) {
        $num_orange++;
    }
    if (($data['color'] == 'yellow') && ($data['enabled'] == 'true')) {
        $num_yellow++;
    }
    if (($data['color'] == 'green') && ($data['enabled'] == 'true')) {
        $num_green++;
    }
    if ($data['enabled'] == 'false') {
        $num_disabled++;
    }
}
?>
    <div class="fullwidth darkBg">
        <nav class="pagemilestone" style="height:25px;" >
            <ul class="dropdown">
                <li class="nobg"><a href="#">Welcome: <?php echo $username; ?></a></li>
                <li class="subnav">Options
                    <ul>
                        <li><a class="popupAccountSettings" href="site/user_account" title="Account Settings">Account Settings</a></li>
                        <li><a class="popupAccountBilling" href="index.php?module=Accounts&action=billing" title="Billing Information:">Billing Information</a></li>
                    </ul>
                </li>
                <li><a href="home/logout">Logout</a></li>
            </ul>
        </nav>
    </div>
    <div class="pagemilestone">
        <section class="fullwidth">
            <header class="header">
                <div class="imgLogo left">
                    <?php
                    if (empty($logo)) {
                        echo '<img src="images/dashboard/default.png" height="70px"/>';
                    } else {
                        echo '<img src="' . $logo . '" height="70px"/>';
                    }
                    ?>
                </div>
                <hgroup class="projects">
                    <h1><?php echo $basedash_projects ?></h1> <span class="topSub">projects</span>
                </hgroup>
            </header>

            <div class="clear"></div>

            <nav class="statBtn">
                <ul>
                    <li class="whiteb <?php if ($project_view == 'all') { echo 'active'; } ?>"><a href="../site?view=all">all</a></li>
                    <?php if ($num_red != 0) { ?><li class="redb <?php if ($project_view == 'red') { echo 'active'; } ?>"><a href="../site?view=red">red (<?php echo $num_red; ?>)</a></li><?php } ?>
                    <?php if ($num_orange != 0) { ?><li class="orangeb <?php if ($project_view == 'orange') { echo 'active'; } ?>"><a href="../site?view=orange">orange (<?php echo $num_orange; ?>)</a></li><?php } ?>
                    <?php if ($num_yellow != 0) { ?><li class="yellowb <?php if ($project_view == 'yellow') { echo 'active'; } ?>"><a href="../site?view=yellow">yellow (<?php echo $num_yellow; ?>)</a></li><?php } ?>
                    <?php if ($num_green != 0) { ?><li class="greenb <?php if ($project_view == 'green') { echo 'active'; } ?>"><a href="../site?view=green">green (<?php echo $num_green; ?>)</a></li><?php } ?>
                    <?php if ($num_disabled != 0) { ?><li class="disb <?php if ($project_view == 'disabled') { echo 'active'; } ?>"><a href="../site?view=disabled">disabled (<?php echo $num_disabled; ?>)</a></li><?php } ?>
                    <li class="disb <?php if ($project_view == 'update') { echo 'active'; }?>"><a href="../site/update?return_view=<?php echo $project_view; ?>" title="Update Projects:">Update</a></li>
                </ul>
            </nav>
        </section>

        <section class="clear left milestonCtn">
            <h1>Project Name: <b> <?php echo $project_name; ?></b></h1>
            <h2>Project Milestones As of <?php echo date('M j, Y'); ?></h2>
            <div class="milestoneHeading left">
                <div class="milestone-title">Title</div>
                <div class="responsible">Responsible</div>
                <div class="status">Status</div>
                <div class="complete">% Completed</div>
                <div class="orig-due">Orig Due</div>
                <div class="due-date">Due Date</div>
            </div>
            <?php
            if (!empty($project_milestone_order)) {
                foreach ($project_milestone_order as $milestone_data) {
                    ?>
                <div class="milestoneContent left">                   
                    <div class="milestone-title">
                        <?php echo $milestone_data['milestone_title']; ?>
                    </div>
                    <div class="responsible">
                        <?php echo $milestone_data['milestone_responsible']; ?>
                    </div>
                    <div class="status <?php echo $milestone_data['milestone_color']; ?>">
                        <?php echo $milestone_data['status']; ?>    
                    </div>
                    <div class="complete">
                        <?php echo $milestone_data['progress']; ?>
                    </div>
                    <div class="orig-due">
                        <?php echo $milestone_data['milestone_deadline']; ?>
                    </div>
                    <div class="due-date">
                        <?php echo $milestone_data['milestone_due_date']; ?>
                    </div>
                </div>
                <!-- end -->
            <?php 
                }
            } 
            ?>
        </section>
    </div>
<?php
//    global $basedash_config;
//    $ch = curl_init();
//    curl_setopt($ch, CURLOPT_URL, 'http://abcache.remotelink.com/abcache');
//    curl_setopt($ch, CURLOPT_POST, 1);
////    $url = 'url=http://http://www.basedash.com/index.php?module=Generate&action=generate&uid=' . $_SESSION['UID'] . '&token=' . $_SESSION['token'] . '&basecampUrl=' . $_SESSION['basecampUrl'];
//    $url = 'url='.$basedash_config['site_url'].'/index.php?module=Generate&action=generate&uid=' . $_SESSION['UID'] . '&token=' . $_SESSION['token'] . '&basecampUrl=' . $_SESSION['basecampUrl'];
//    curl_setopt($ch, CURLOPT_POSTFIELDS, $url);
//    $result = curl_exec($ch);
//    curl_close($ch);
//    echo $result;
?>
