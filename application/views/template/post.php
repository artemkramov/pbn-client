<?php

/**
 * @var stdClass $page
 */

?>

<!--Content-->
<section class="section-content p-lg-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-9">
                <div id="post-<?= $page->id ?>">
                    <h1><?= $page->title ?></h1>
                    <?= $page->description ?>
                </div>

                <? if (isset($page->ratingValue)): ?>
                    <div itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating">
                        <span itemprop="ratingValue"><?= $page->ratingValue ?></span>/
                        <span itemprop="bestRating"><?= $page->ratingCount ?></span>stars
                    </div>
                <? endif; ?>

                <div class="clearfix">
                    <? if (isset($page->previous)): ?>
                        <div class="float-left">
                            <a href="<?= $page->previous->url ?>">Previous Post</a>
                        </div>
                    <? endif; ?>

                    <? if (isset($page->next)): ?>
                        <div class="float-right">
                            <a href="<?= $page->next->url ?>">Next Post</a>
                        </div>
                    <? endif; ?>
                </div>
            </div>
            <div class="col-lg-3">
                <? $this->load->view('inner/sidebar') ?>
            </div>
        </div>
    </div>
</section>
