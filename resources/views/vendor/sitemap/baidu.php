<?= '<'.'?'.'xml version="1.0" encoding="UTF-8"?>'."\n" ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:mobile="https://www.baidu.com/schemas/sitemap-mobile/1/">
<?php foreach ($items as $item) : ?>
	<url>
		<loc><?= $item['loc'] ?></loc>
		<mobile:mobile type="pc,mobile"/>
<?php
if ($item['priority'] !== null) {
    echo "\t\t".'<priority>'.$item['priority'].'</priority>'."\n";
}
if ($item['lastmod'] !== null) {
    echo "\t\t".'<lastmod>'.date('Y-m-d', strtotime($item['lastmod'])).'</lastmod>'."\n";
}
if ($item['freq'] !== null) {
    echo "\t\t".'<changefreq>'.$item['freq'].'</changefreq>'."\n";
}
?>
	</url>
<?php endforeach; ?>
</urlset>

