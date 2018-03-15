<?

/**
 * @var array $pages
 */
?>
<?= '<?xml version="1.0" encoding="UTF-8" ?>' ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

    <?php foreach($pages as $page): ?>
        <url>
            <loc><?= $page->url ?></loc>
            <lastmod><?= $page->dateModified ?></lastmod>
        </url>
    <?php endforeach; ?>

</urlset>