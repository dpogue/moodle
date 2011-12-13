<?php

/**
 * Makes our changes to the CSS
 *
 * @param string $css
 * @param theme_config $theme
 * @return string 
 */
function thss_process_css($css, $theme) {

    // Set the link color
    if (!empty($theme->settings->linkcolor)) {
        $linkcolor = $theme->settings->linkcolor;
    } else {
        $linkcolor = null;
    }
    $css = thss_set_linkcolor($css, $linkcolor);

// Set the link hover color
    if (!empty($theme->settings->linkhover)) {
        $linkhover = $theme->settings->linkhover;
    } else {
        $linkhover = null;
    }
    $css = thss_set_linkhover($css, $linkhover);
    
    // Set the main color
    if (!empty($theme->settings->maincolor)) {
        $maincolor = $theme->settings->maincolor;
    } else {
        $maincolor = null;
    }
    $css = thss_set_maincolor($css, $maincolor);
    
    // Set the main accent color
    if (!empty($theme->settings->maincoloraccent)) {
        $maincoloraccent = $theme->settings->maincoloraccent;
    } else {
        $maincoloraccent = null;
    }
    $css = thss_set_maincoloraccent($css, $maincoloraccent);
   
    // Set the block headings color
    if (!empty($theme->settings->blockcolor)) {
        $blockcolor = $theme->settings->blockcolor;
    } else {
        $blockcolor = null;
    }
    $css = thss_set_blockcolor($css, $blockcolor);
    
    // Set the forum background color
    if (!empty($theme->settings->forumback)) {
        $forumback = $theme->settings->forumback;
    } else {
        $forumback = null;
    }
    $css = thss_set_forumback($css, $forumback);
    
      // Set the forum subject font color color
    if (!empty($theme->settings->forumcolor)) {
        $forumcolor = $theme->settings->forumcolor;
    } else {
        $forumcolor = null;
    }
    $css = thss_set_forumcolor($css, $forumcolor);
    
    // Return the CSS
    return $css;
}



/**
 * Sets the link color variable in CSS
 *
 */
function thss_set_linkcolor($css, $linkcolor) {
    $tag = '[[setting:linkcolor]]';
    $replacement = $linkcolor;
    if (is_null($replacement)) {
        $replacement = '#0e53a7';
    }
    $css = str_replace($tag, $replacement, $css);
    return $css;
}

function thss_set_linkhover($css, $linkhover) {
    $tag = '[[setting:linkhover]]';
    $replacement = $linkhover;
    if (is_null($replacement)) {
        $replacement = '#6899d3';
    }
    $css = str_replace($tag, $replacement, $css);
    return $css;
}

function thss_set_maincolor($css, $maincolor) {
    $tag = '[[setting:maincolor]]';
    $replacement = $maincolor;
    if (is_null($replacement)) {
        $replacement = '#0e53a7';
    }
    $css = str_replace($tag, $replacement, $css);
    return $css;
}

function thss_set_blockcolor($css, $blockcolor) {
    $tag = '[[setting:blockcolor]]';
    $replacement = $blockcolor;
    if (is_null($replacement)) {
        $replacement = '#a68100';
    }
    $css = str_replace($tag, $replacement, $css);
    return $css;
}

function thss_set_maincoloraccent($css, $maincoloraccent) {
    $tag = '[[setting:maincoloraccent]]';
    $replacement = $maincoloraccent;
    if (is_null($replacement)) {
        $replacement = '#4284d3';
    }
    $css = str_replace($tag, $replacement, $css);
    return $css;
}

function thss_set_forumback($css, $forumback) {
    $tag = '[[setting:forumback]]';
    $replacement = $forumback;
    if (is_null($replacement)) {
        $replacement = '#ffe073';
    }
    $css = str_replace($tag, $replacement, $css);
    return $css;
}

function thss_set_forumcolor($css, $forumcolor) {
    $tag = '[[setting:forumcolor]]';
    $replacement = $forumcolor;
    if (is_null($replacement)) {
        $replacement = '#04346c';
    }
    $css = str_replace($tag, $replacement, $css);
    return $css;
}
