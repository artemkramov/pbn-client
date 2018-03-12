<?php

$recentPosts = getRecentPosts(5);

?>

<div class="sidebar">
    <div class="item-sidebar recommended-sites mb-3 p-3">
        <h3>Recommended Sites:</h3>
        <ul class="list-unstyled">
            <li><a href="http://www.audiotales.tv/category1/kinyu9">Japanese car insurance</a></li>
            <li><a href="http://www.confreda.com/cat1/margin5">Japanese interactive</a></li>
            <li><a href="http://www.mustangmendez.com/fld1/kuruma11">Ace loans</a></li>
        </ul>
    </div>
    <div class="item-sidebar recent-posts mb-3 p-3">
        <h3>Recent Posts:</h3>
        <ul class="list-unstyled">
            <? foreach ($recentPosts as $post): ?>
                <li>
                    <a href="<?= $post->url ?>" title="<?= $post->title ?>">
                        <?= $post->title ?>
                    </a>
                </li>
            <? endforeach; ?>
        </ul>
    </div>
</div>
