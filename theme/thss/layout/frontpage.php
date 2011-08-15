<?php
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
            <a class="active" href="<?php echo $CFG->wwwroot; ?>"><?php echo $PAGE->heading; ?></a>
        </li>
<?php if (isloggedin()) { ?>
        <li class="left">
            <a href="#">My Moodle</a>
        </li>
<?php }
/* LEFT SIDE LINKS                                                           */
/* --------------------------------------------------------------------------*/
/* RIGHT SIDE LINKS                                                          */
        /* Rightmost link first */ ?>
        <li class="right">
            <a class="popup img" title="Info"><img src="<?php echo $OUTPUT->pix_url('bb_info', 'theme'); ?>" alt="Info"></a>
            <div>
                <a href="#">Privacy Policy</a><br>
                <a href="http://moodle.org/">About Moodle</a><br>
                <a href="#">Contributors</a>
            </div>
        </li>
<?php if (isloggedin()) { ?>
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
<script src="http://moodle.dpogue.ca/theme/thss/flexie.js"></script>
<?php echo $OUTPUT->standard_end_of_body_html() ?>
</body>
</html>
