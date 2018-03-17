<?php

/**
 * @var array $links
 */

?>

<!-- BREADCRUMBS START -->
<? if (!empty($links)): ?>
    <ol itemscope itemtype="http://schema.org/BreadcrumbList">
        <? for ($i = 0; $i < count($links); $i++): ?>
            <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                <a itemprop="item" href="<?= $links[$i]['url'] ?>">
                    <span itemprop="name"><?= $links[$i]['title'] ?></span>
                </a>
                <meta itemprop="position" content="<?= $i + 1 ?>"/>
            </li>
        <? endfor; ?>
    </ol>
<? endif; ?>
<!-- BREADCRUMBS END -->