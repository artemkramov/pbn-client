<?php

/**
 * @var stdClass $page
 */

?>

<!-- Posts -->
<section class="section-posts p-lg-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-9">
                <? foreach ($page->children as $child): ?>
                    <div id="post-<?= $child->id ?>" class="pb-5">
                        <a href="<?= $child->url ?>"><h2 class="text-uppercase"><?= $child->title ?></h2>
                        </a>
                        <p>
                            <?= $child->descriptionShort ?>
                        </p>
                        <div class="clearfix">
                            <div class="float-right">
                                <a href="<?= $child->url ?>">Read the full article</a>
                            </div>
                        </div>
                    </div>
                <? endforeach; ?>
                <? echo $page->paginationLinks ?>
<!--                <ul class="pagination">-->
<!--                    <li class="active"><a href="/">1</a></li>-->
<!--                    <li><a href="/page/2">2</a></li>-->
<!--                </ul>-->
            </div>
            <div class="col-lg-3">
                <? $this->load->view('inner/sidebar') ?>
            </div>
        </div>
    </div>
</section>
