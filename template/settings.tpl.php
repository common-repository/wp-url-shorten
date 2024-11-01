
<div class="update-nag">
    <h2><?php _e('Usage & Shortcodes','eebme') ?>:</h2>
    <li>
    <?php _e('To display the Short link of current page use the following shortcode on post, page or sidebar widget','eebme')?>:
        <div>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>[eebme-url]</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;OR&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>[short-url]</strong>
        </div>
    </li>
    <li>
    <?php _e('To quickly shorten any post URL use the following short code','eebme')?>:
    </li>
    <p>[eebme-url]</p></pre>
    <p>[short-url]</p></pre>
</div>

<div class="wrap">
<form method="post" id="eebme_shorturl_settings" style="margin-top:2em;margin-left:1em;">

<table class="form-table">


        
  
  <tr>
    <th scope="row">
        <label for="Display" style="font-weight:bold;"><?php echo __('EEB.ME APIKEY') ?></label>
    </th>
  
    <td>
    	
        <input type="text" name="eebapikey" value="<?php echo $opt['eebapikey'] ?>" /><p><a target="_blank" href="https://eeb.me/user/register">Get Your Key</a></p>
        
        <p>
        
        <video controls width="550">

    <source src="<?php echo eebme_plugin_url.'/icons/eebme-api.webm' ?> "
            type="video/webm">

    Sorry, your browser doesn't support embedded videos.
</video>
        
        </p>
    </td>
  <tr>
  
  <tr>
    <th scope="row">
        <label for="Display" style="font-weight:bold;"><?php echo __('Display Short URL') ?></label>
    </th>
  
    <td>
        <input type="radio" name="Display" value="Y" <?php echo $opt['Display'] == 'Y' ? 'checked="checked"' : '' ?> /> <?php echo __('Yes') ?>
        <input type="radio" name="Display" value="N" <?php echo $opt['Display'] == 'N' ? 'checked="checked"' : '' ?> /> <?php echo __('No') ?>
    </td>
  <tr>

  <tr>
    <th scope="row">
        <label for="TwitterLink" style="font-weight:bold;"><?php echo __('Display Social Icons') ?></label>
    </th>
  
    <td>
        <input type="radio" name="TwitterLink" value="Y" <?php echo $opt['TwitterLink'] == 'Y' ? 'checked="checked"' : '' ?> /> <?php echo __('Yes') ?>
        <input type="radio" name="TwitterLink" value="N" <?php echo $opt['TwitterLink'] == 'N' ? 'checked="checked"' : '' ?> /> <?php echo __('No') ?>
        <p>
         <a href="#"><img src="<?php echo eebme_plugin_url.'/icons/twitter_letter-32.png' ?>" title="Tweet this link" alt="" /></a>     <a href="#"><img src="<?php echo eebme_plugin_url.'/icons/google-plus-32.png' ?>" title="Share on Google Plus" alt="" /></a>        <a href="#"><img src="<?php echo eebme_plugin_url.'/icons/facebook-32.png' ?>" title="Share on Facebook" alt="" /></a>        <a href="#"><img src="<?php echo eebme_plugin_url.'/icons/delicious-32.png' ?>" title="Share on Delicious" alt="" /></a>    <a href="#"><img src="<?php echo eebme_plugin_url.'/icons/digg-32.png' ?>" title="Stumble Upon" alt="" /></a>    <a href="#"><img src="<?php echo eebme_plugin_url.'/icons/linkedin-32.png' ?>" title="Stumble Upon" alt="" /></a>
         </p>
    </td>
  <tr>
  
  <tr>
    <th scope="row">
        <label for="Domain" style="font-weight:bold;"><?php echo __('Domain') ?></label>
    </th>
  
    <td>
        <select name="Domain">
        	<option value="eeb.me">eeb.me</option>
            <option value="zpit.us">zpit.us</option>
            <option value="cvrd.us">cvrd.us</option>
            <option value="eaby.us">eaby.us</option>
        </select>
    </td>
  <tr>
  
  


  <tr valign="top">
    <th scope="row">
    <?php
	if ( function_exists('wp_nonce_field') ) 
			wp_nonce_field('eebme_action_saveurl');
			?>
        <input type="submit" class="button-primary" name="save" value="<?php echo __('Save') ?>" />
    </th>
    <td>

    </td>
  <tr>


</table>


</form>
<br />
    <a target="_blank" href="http://eeb.me" title="Home">eeb.me</a> |     <a target="_blank" href="http://eeb.me/page/advertise" title="Home">Advertise with us</a>  | <a target="_blank" href="http://eeb.me/page/developer" title="Developer API">Developer API &amp; Extensions</a> | <a target="_blank" href="http://eeb.me/contact" title="Report a link">Report a link</a>  
    
    </div>