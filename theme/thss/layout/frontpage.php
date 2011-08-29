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

    
echo $OUTPUT->doctype() ?>
<!--[if IE 8]> <html class="ie8"<?php echo $OUTPUT->htmlattributes(); ?>> <![endif]-->
<!--[if gt IE 8]><!--> <html<?php echo $OUTPUT->htmlattributes() ?>> <!--<![endif]-->
<head>
    <meta charset="utf-8">

    <title><?php echo $PAGE->title ?></title>
    <link rel="shortcut icon" href="<?php echo $OUTPUT->pix_url('favicon', 'theme')?>" />
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
    </ul>

	<header>
        <nav>
            <?php echo $custommenu; ?>
        </nav>
        <div id="banners">
<!--[if lt IE 9]>
            <object width="290" height="130">
                <param name="movie" value="http://www.wunderground.com/swf/pws_mini_rf_nc.swf?station=IBCMAPLE3&freq=2.5&units=metric&lang=EN" />
                <embed src="http://www.wunderground.com/swf/pws_mini_rf_nc.swf?station=IBCMAPLE3&freq=2.5&units=metric&lang=EN" type="application/x-shockwave-flash" width="290" height="130" />
            </object>
<![endif]--><!--[if gte IE 9]><!-->
            <svg height="100px" width="64px" viewBox="0 0 64 100" preserveAspectRatio="xMidYMid meet">
                <g>
                    <text text-anchor="middle" dominant-baseline="middle" x="32" y="5" font-weight="bold">Wind:</text>
                    <text id="windspeed" text-anchor="middle" dominant-baseline="middle" x="32" y="20">&mdash; km/h</text>
                    <circle cx="32" cy="64" r="30" fill="#dddddd" />
                    <text id="winddir" text-anchor="middle" dominant-baseline="middle" x="32" y="64">&hellip;</text>
                    <g id="winddirrot" transform="rotate(0, 32, 64)">
                        <polygon points="32,40 25,32 39,32" fill="#800000" />
                    </g>
                </g>
            </svg>
            <h3>Current Conditions</h3>
            <span>Temperature:</span>           <b id="temperature">&mdash; &deg;C</b><br><br>
            <span>Relative Humidity:</span>     <b id="humidity">&mdash;%</b><br>
            <span>Daily Precipitation:</span>   <b id="precip_daily">&mdash; mm</b><br>
            <span>Hourly Precipitation:</span>  <b id="precip_hourly">&mdash; mm</b><br>
            <span>Air Pressure:</span>          <b id="pressure">&mdash; mb</b><br>
            <span>UV Index:</span>              <b id="uv_index">&mdash;</b><br>
            <span>Dewpoint:</span>              <b id="dewpoint">&mdash; &deg;C</b><br><br>
<!--<![endif]-->
            <a href="http://www.wunderground.com/weatherstation/WXDailyHistory.asp?ID=IBCMAPLE3">Weather data is available on Wunderground &raquo;</a>
        </div>
		<div id="slideshow">
<?php
    if ($fd = opendir($PAGE->theme->dir.'/pix/slideshow')) {
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
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
<script>
    if (!Modernizr.flexbox) {
        Modernizr.load({
            load: '<?php echo $CFG->wwwroot; ?>/theme/thss/javascript/flexie.min.js'
        });
    }
</script>
<?php echo $OUTPUT->standard_end_of_body_html() ?>
</body>
</html>
