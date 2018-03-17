<?php

/**
 * @var array $links
 */

?>
<nav class="site-navbar" role="navigation" itemscope itemtype="http://schema.org/SiteNavigationElement">
    <div class="wrap">
        <ul class="site-navbar-nav">
            <? foreach ($links as $link): ?>
                <li>
                    <a itemprop="url" href="<?= $link->siteUrl ?>"><span itemprop="name"><?= $link->title ?></span></a>
                </li>
            <? endforeach;; ?>
        </ul>
    </div>
</nav>
