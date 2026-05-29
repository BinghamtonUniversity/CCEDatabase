<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach($organizations as $org)
    <url>
        <loc>{{url('/organizations/'.$org->key)}}</loc>
        <lastmod><?php echo date('Y-m-d', strtotime($org->timestamp)); ?></lastmod>
        <changefreq>monthly</changefreq>
    </url>
    @endforeach
</urlset>