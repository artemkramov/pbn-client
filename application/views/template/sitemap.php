<?php


?>

<ul>
    <? foreach ($page->pages as $pageData): ?>
        <li>
            <a href="<?= $pageData->url ?>"><?= $pageData->title ?></a>
            <? if (!empty($pageData->children)): ?>
                <? foreach ($pageData->children as $child): ?>
                <ol>
                    <li>
                        <a href="<?= $child->url ?>"><?= $child->title ?></a>
                    </li>
                </ol>
                <? endforeach; ?>
            <? endif; ?>
        </li>
    <? endforeach; ?>
</ul>
