<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <sitemap>
        <loc>{{ url('sitemap-base.xml') }}</loc>
    </sitemap>
    <sitemap>
        <loc>{{ url('sitemap-organizations.xml') }}</loc>
    </sitemap>
    <sitemap>
        <loc>{{ url('sitemap-listings.xml') }}</loc>
    </sitemap>
</sitemapindex>