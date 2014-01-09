<?
$purifierConfig = HTMLPurifier_Config::createDefault();

//allow iframes from trusted sources
$purifierConfig->set('HTML.SafeIframe', true);
$purifierConfig->set('URI.SafeIframeRegexp', '%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%'); //allow YouTube and Vimeo

$purifier = new HTMLPurifier($purifierConfig);
?>
