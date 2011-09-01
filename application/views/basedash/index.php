<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
//print_r($basedash_data);
//print_r($user_data);
//echo $project_view;

$view_all = false;
$view_disabled = false;

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
    <section class="fullwidth darkBg">
        <nav class="adjusted-width darkBg" style="height:25px;">
            <ul class="dropdown mright10">
                <li class="nobg"><a href="#">Welcome: <?php echo $username; ?></a></li>
                <li class="subnav">Options
                    <ul>
                        <li><a class="popupAccountSettings" href="site/user_account" title="Account Settings">Account Settings</a></li>
                        <li><a class="popupAccountBilling" href="site/user_billing" title="Billing Information:">Billing Information</a></li>
                    </ul>
                </li>
                <li><a href="home/logout">Logout</a></li>
            </ul>
        </nav>
    </section>

    <section class="adjusted-width">
        <header class="header mleftright">
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

        <nav class="statBtn mleft10">
            <ul>
                <li class="whiteb <?php if ($project_view == 'all') {
                    echo 'active';
                } ?>"><a href="?view=all">all</a></li>
                <?php if ($num_red != 0) { ?><li class="redb <?php if ($project_view == 'red') {
                    echo 'active';
                } ?>"><a href="?view=red">red (<?php echo $num_red; ?>)</a></li><?php } ?>
                <?php if ($num_orange != 0) { ?><li class="orangeb <?php if ($project_view == 'orange') {
                    echo 'active';
                } ?>"><a href="?view=orange">orange (<?php echo $num_orange; ?>)</a></li><?php } ?>
                <?php if ($num_yellow != 0) { ?><li class="yellowb <?php if ($project_view == 'yellow') {
                        echo 'active';
                    } ?>"><a href="?view=yellow">yellow (<?php echo $num_yellow; ?>)</a></li><?php } ?>
                <?php if ($num_green != 0) { ?><li class="greenb <?php if ($project_view == 'green') {
                        echo 'active';
                    } ?>"><a href="?view=green">green (<?php echo $num_green; ?>)</a></li><?php } ?>
                <?php if ($num_disabled != 0) { ?><li class="disb <?php if ($project_view == 'disabled') {
                    echo 'active';
                } ?>"><a href="?view=disabled">disabled (<?php echo $num_disabled; ?>)</a></li><?php } ?>
                <li class="disb <?php if ($project_view == 'update') {
                    echo 'active';
                } ?>"><a href="site/update?return_view=<?php echo $project_view; ?>" title="Update Projects:">Update</a></li>
            </ul>
        </nav>

       <aside class="dashletCount">
            <ul>
                <?php
                $i = 1;
                foreach ($basedash_data as $data) {
                    $class = '';
                    $width = $i * 345;
                    if ($i == 3) {
                        if ($dashlet == $width) {
                            $class = "class='greenb'";
                        }
                        echo '<li ' . $class . '><a href="site/change_project_dashlet?project_dashlet=' . $width . '&ident=' . $user_data['ident'] . '">' . $i . '</a></li>';
                    }
                    if (($i >= 4) && (!($i % 2)) && ($i <= 10)) {
                        if ($dashlet == $width) {
                            $class = "class='greenb'";
                        }
                        echo '<li ' . $class . '><a href="site/change_project_dashlet?project_dashlet=' . $width . '&ident=' . $user_data['ident'] . '">' . $i . '</a></li>';
                    }
                    $i++;
                }
                ?>
            </ul>
        </aside>
    </section>

    <div class="clear"></div>
    <section class="adjusted-width dashletWrap">
        <?php
            $k = 0;
            $current_view = $project_view;
            foreach ($basedash_data as $data) {
                if ($project_view == 'all') {
                    $project_view = $data['color'];
                    $view_all = true;
                    $view_disabled = false;
                }


                if ($project_view == 'disabled') {
                    $project_view = $data['color'];
                    $view_all = false;
                    $view_disabled = true;
                }

                if (($data['color'] == $project_view) && ($data['enabled'] == $project_enabled)) {
        ?>
        <!-- start of widget -->
        <div class="widgetCtn" id="id_<?php echo $data['id']; ?>">
            <div class="widgetTitle">
                <form action="">
                    <h2>
                        <input type="checkbox" name="<?php echo $data['id']; ?>" value="<?php echo $data['id']; ?>" onclick="disableproject(this.value)" title="Disable Widget"/><?php echo $data['title']; ?>
                    </h2>
                </form>
                <a href="<?php echo $user_data['basecamp_url']; ?>/projects/<?php echo $data['id']; ?>/posts" target="blank" title="Goto Basecamp" ><img src="images/dashboard/arrow.png" class="right imgArrow"/></a>
            </div>
            
            <div class="widgetText">
                <div class="update">
                    updated
                    <?php echo $data['last_update']; ?>

                    <span class="milestone"><a href="site/milestone?return_view=<?php echo $current_view; ?>&pid=<?php echo $data['id']; ?>">Milestone</a></span>
                </div>
                
                <div class="contentText"><?php echo $data['status']; ?></div>
                
                <div class="statusCtn">
                    <div class="sub"><?php echo $data['total_done']; ?> of <?php echo $data['total_items']; ?> to do's complete</div>
                    <div class="right">
                        <h3 class="<?php echo $data['milestonecolor']; ?>text">
                        <?php
                            if (round($data['progress']) < 100) {
                                echo $data['milestonedue'];
                            } else {
                        ?>
                        <img src="images/dashboard/complete.png" alt="Project Completed" />
                        <?php } ?> 
                        </h3>
                    </div>
                    <div class="progress-status">
                        <div style="width: <?php echo round($data['progress']); ?>%" class="<?php echo $data['color']; ?>"><?php echo round($data['progress']); ?>% &nbsp;</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end of widget -->
        <?php
            } else {
                $k++;
            }
            if ($view_all) {
                $project_view = 'all';
            }
            if ($view_disabled) {
                $project_view = 'disabled';
            }
            if ($k == $basedash_projects) {
                echo "No " . ucfirst($project_view) . " Status Projects.";
            }
        }
        ?>
    </section>

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
