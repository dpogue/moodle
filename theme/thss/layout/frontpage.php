<?php
require_once($CFG->libdir.'/../message/lib.php');

$hasheading = ($PAGE->heading);
$hasnavbar = (empty($PAGE->layout_options['nonavbar']) && $PAGE->has_navbar());
$hasfooter = (empty($PAGE->layout_options['nofooter']));

$hassidepre = $PAGE->blocks->region_has_content('side-pre', $OUTPUT);
$hassidepost = $PAGE->blocks->region_has_content('side-post', $OUTPUT);

$showsidepre = ($hassidepre && !$PAGE->blocks->region_completely_docked('side-pre', $OUTPUT));
$showsidepost = ($hassidepost && !$PAGE->blocks->region_completely_docked('side-post', $OUTPUT));

$custommenu = $OUTPUT->custom_menu();
$hascustommenu = (empty($PAGE->layout_options['nocustommenu']) && !empty($custommenu));

$bodyclasses = array();
if ($hascustommenu) {
    $bodyclasses[] = 'has_custom_menu';
}

$daily = thss_get_daily_news();

echo $OUTPUT->doctype() ?>
<!--[if IE 8]> <html class="ie8"<?php echo $OUTPUT->htmlattributes(); ?>> <![endif]-->
<!--[if gt IE 8]><!--> <html<?php echo $OUTPUT->htmlattributes() ?>> <!--<![endif]-->
<head>
    <meta charset="utf-8">

    <title><?php echo $PAGE->title ?></title>
    <link rel="shortcut icon" href="<?php echo $OUTPUT->pix_url('favicon', 'theme')?>">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo $OUTPUT->pix_url('icons/apple-touch-icon-114x114-precomposed', 'theme'); ?>">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo $OUTPUT->pix_url('icons/apple-touch-icon-72x72-precomposed', 'theme'); ?>">
    <link rel="apple-touch-icon-precomposed" href="<?php echo $OUTPUT->pix_url('icons/apple-touch-icon-precomposed', 'theme'); ?>">
    <?php echo $OUTPUT->standard_head_html() ?>
</head>
<body id="<?php echo $PAGE->bodyid ?>" class="<?php echo $PAGE->bodyclasses.' '.join(' ', $bodyclasses) ?>">
<?php echo $OUTPUT->standard_top_of_body_html() ?>
    <ul id="blackbar">
        <li class="left">
            <a class="active" href="<?php echo $CFG->wwwroot; ?>"><?php echo $SITE->fullname; ?></a>
        </li>
<?php if (isloggedin()) { ?>
        <li class="left">
            <a href="<?php echo $CFG->wwwroot.'/my/'; ?>">My Moodle</a>
        </li>
<?php }
/* LEFT SIDE LINKS                                                           */
/* --------------------------------------------------------------------------*/
/* RIGHT SIDE LINKS                                                          */
        /* Rightmost link first */ ?>
        <li class="right">
            <a class="popup img" title="Info"><img src="<?php echo $OUTPUT->pix_url('bb_info', 'theme'); ?>" alt="Info"></a>
            <div>
                <a href="#">Terms of Service</a><br>
                <a href="#">Privacy Policy</a><br>
                <a href="http://moodle.org/about/">About Moodle</a><br>
                <a href="#">Contributors</a>
            </div>
        </li>
<?php if (isloggedin()) { ?>
        <li class="right">
            <a href="<?php echo $CFG->wwwroot.'/login/logout.php'; ?>">Logout</a>
        </li>
        <li class="right">
<?php $notify_count = message_count_unread_messages($USER); ?>
            <a class="popup" title="Notifications"><b class="notify<?php echo $notify_count === 0 ? '' : '-unread'; ?>"><?php echo $notify_count; ?></b></a>
            <div>
                You have <?php echo $notify_count; ?> notifications.
                <?php message_print_recent_messages_table(message_get_recent_notifications($USER, 0, 10), $USER); ?>
            </div>
        </li>
        <li class="right">
            <span><?php echo fullname($USER) ?></span>
        </li>
<?php } else { ?>
        <li class="right">
            <a href="<?php echo get_login_url(); ?>">Login</a>
        </li>
<?php } ?>
        <li class="motto">Seek Challenge and Experience Success</li>
    </ul>

	<header>
        <nav>
            <?php echo $custommenu; ?>
        </nav>
        <div id="banners">
<?php if ($daily) {
        $link = new moodle_url('/blocks/newsletter/daily.php', array('id' => $daily->id));
        $action = new popup_action('click', $link);
?>
            <p class="happenings">
                <?php echo $OUTPUT->action_link($link, get_string('readdaily', 'block_newsletter'), $action); ?>
            </p>
<?php } ?>
        </div>
		<div id="slideshow">
<?php
    if ($fd = @opendir($PAGE->theme->dir.'/pix/slideshow')) {
        $slideshow = array();
        while (false !== ($file = readdir($fd))) {
            if ($file[0] === '.') continue;
            $name = substr($file, 0, strrpos($file, '.'));
            $slideshow[] = $OUTPUT->pix_url("slideshow/$name", 'theme');
        }
?>
            <script>M.thss_slideshow = ["<?php echo join('", "', $slideshow); ?>"];</script>
            <div id="slideshow_current" data-slideshow-index="0"></div>
<?php } ?>
			<p>
<?php if (isloggedin()) { ?>
                <b>Welcome</b><br>
                <?php echo fullname($USER); ?><br><br>
                <?php echo $OUTPUT->user_picture($USER, array('size' => 100, 'link' => false)); ?>
<?php } else { ?>
				<b>Thomas Haney<br />Secondary School</b><br>
				23000 116<sup>th</sup> Avenue<br>
				Maple Ridge, BC<br>
				V2X 0T8<br><br>
				<i>Phone:</i> 604-463-2001<br>
                <i>Fax:</i> 604-467-9081
<?php } ?>
			</p>
		</div>
	</header>

    <div id="page">
        <div id="content">
            <?php echo core_renderer::MAIN_CONTENT_TOKEN ?>
        </div>
        <div id="leftside">
            <?php echo $OUTPUT->blocks_for_region('side-pre') ?>
        </div>
        <div id="rightside">
            <?php echo $OUTPUT->blocks_for_region('side-post') ?>
        </div>
    </div>

<div>

<!-- START OF FOOTER -->
<div id="footer-wrap"><div id="page-footer"></div>
	<div id="footer-container">
		<div id="footer">
		
		 <?php if ($hasfooter) {
		 echo "<div class='johndocsleft'>";
        echo $OUTPUT->login_info();
       // echo $OUTPUT->home_link();
        echo $OUTPUT->standard_footer_html();
        echo "</div>";
        }
        ?>
		
	
       
         
    <?php if ($hasfooter) { ?>
    <div class="johndocs">
      
            <?php echo page_doc_link(get_string('moodledocslink')) ?>
       		
       
       
    </div>
    <?php } ?>
        
		</div>
	</div>
</div>




</div>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<?php if ($PAGE->theme->settings->snow && date('m') == 12) { ?>
<script src="<?php echo $CFG->wwwroot; ?>/theme/thss/javascript/snowfall.jquery.js"></script>
<?php } ?>
<script>
    if (!Modernizr.flexbox) {
        Modernizr.load({
            load: '<?php echo $CFG->wwwroot; ?>/theme/thss/javascript/flexie.min.js'
        });
    }
    $('#page-site-index .forumpost .header').on('click', function(e) {
        if ($(e.currentTarget).next().css('display') == 'none') {
            $('#page-site-index .forumpost .maincontent').slideUp();
            $(e.currentTarget).next().slideDown('slow');
        }
    });
    $('#page-site-index .forumpost .author').append('<span style="float:right;font-style:italic;cursor:pointer;font-weight:bold;color:#333333;">Click to expand</span>');
<?php if ($PAGE->theme->settings->snow && date('m') == 12) { ?>
    $(document).snowfall({minSize: 3, maxSize: 5, round: true, flakeCount: 200});
<?php } ?>
<?php if (!empty($PAGE->theme->settings->ga)) { ?>
    var _gaq=[['_setAccount','<?php echo $PAGE->theme->settings->ga; ?>'],['_trackPageview']];
    (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
    g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
    s.parentNode.insertBefore(g,s)}(document,'script'));
<?php } ?>
</script>
<?php echo $OUTPUT->standard_end_of_body_html() ?>
<!--[if lt IE 8 ]>
    <script defer src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
    <script defer>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
<![endif]-->
</body>
</html>
