<?php
$has_facebook = isset($facebook_comment) && $facebook_comment;
$has_site = !$has_facebook || $is_auth;
?>
<div id="facebook-comments" class="tab-pane active">
    {!! content_place('facebook_comment', [$article]) !!}
</div>
