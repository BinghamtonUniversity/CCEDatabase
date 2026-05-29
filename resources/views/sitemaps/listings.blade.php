<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach($listings as $listing)
    <url>
        <loc>{{url('/listings/'.$listing->key)}}</loc>
        <lastmod><?php echo date('Y-m-d', strtotime($listing->timestamp)); ?></lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.6</priority>
    </url>
    @endforeach
</urlset>