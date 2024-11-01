<?php 
$shortUrl = empty($shortUrl) ? get_permalink() : $shortUrl ;
$shortUrlEncoded = empty($shortUrlEncoded) ? get_permalink() : $shortUrlEncoded;
		?>
<div style="margin-top:2em;">
  <?php if ($opt['Display'] !== 'N'): ?>
    <?php echo __('Shortlink') ?>:
    <a href="<?php echo 'https://'.$shortUrl ?>"><?php echo $shortUrl ?></a>
  <?php endif ?>
</div>

<div id="eebsocial" style="margin-top:1em;">
  <?php if ($opt['TwitterLink'] !== 'N'): ?>
    <?php echo __('') ?>
    <a href="https://twitter.com/intent/tweet?url=<?php echo $shortUrlEncoded ?>" target="_blank">
    <img src="<?php echo eebme_plugin_url.'/icons/twitter-32.png' ?>" title="Tweet this link" alt="" />
</a>
<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $shortUrlEncoded ?>" target="_blank">
    <img src="<?php echo eebme_plugin_url.'/icons/facebook-32.png' ?>" title="Share on Facebook" alt="" />
</a>
<a href="https://www.linkedin.com/shareArticle?url=<?php echo $shortUrlEncoded ?>&title=<?php echo get_the_title() ?>" target="_blank">
    <img src="<?php echo eebme_plugin_url.'/icons/linkedin-32.png' ?>" title="Share on LinkedIn" alt="" />
</a>
<a href="https://api.whatsapp.com/send?text=<?php echo $shortUrlEncoded ?>" target="_blank">
    <img src="<?php echo eebme_plugin_url.'/icons/whatsapp-32.png' ?>" title="Share on WhatsApp" alt="" />
</a>
<a href="https://www.pinterest.com/pin/create/button/?url=<?php echo $shortUrlEncoded ?>&media=<?php echo $imageURL ?>&description=<?php echo get_the_title() ?>" target="_blank">
    <img src="<?php echo eebme_plugin_url.'/icons/pinterest-32.png' ?>" title="Share on Pinterest" alt="" />
</a>
<a href="https://www.reddit.com/submit?url=<?php echo $shortUrlEncoded ?>&title=<?php echo get_the_title() ?>" target="_blank">
    <img src="<?php echo eebme_plugin_url.'/icons/reddit-32.png' ?>" title="Share on Reddit" alt="" />
</a>
<a href="https://t.me/share/url?url=<?php echo $shortUrlEncoded ?>&text=<?php echo get_the_title() ?>" target="_blank">
    <img src="<?php echo eebme_plugin_url.'/icons/telegram-32.png' ?>" title="Share on Telegram" alt="" />
</a>
<a href="https://www.tiktok.com/share?url=<?php echo $shortUrlEncoded ?>" target="_blank">
    <img src="<?php echo eebme_plugin_url.'/icons/tiktok-32.png' ?>" title="Share on TikTok" alt="" />
</a>
<a href="https://www.instagram.com/?url=<?php echo $shortUrlEncoded ?>" target="_blank">
    <img src="<?php echo eebme_plugin_url.'/icons/instagram-32.png' ?>" title="Share on Instagram" alt="" />
</a>

    
   
  <?php endif ?>
</div>