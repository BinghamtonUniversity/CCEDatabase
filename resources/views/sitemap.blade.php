<?php echo '<?xml version="1.0" encoding="UTF-8"?>'."\n"; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

@foreach($organizations as $organization)
    <url>
        <loc>{{url('/organizations/'.$organization->key)}}</loc>
        <lastmod><?php echo date('Y-m-d', strtotime($organization->timestamp)); ?></lastmod>
    </url>
@endforeach
@foreach($listings as $listing)
    <url>
        <loc>{{url('/listings/'.$listing->key)}}</loc>
        <lastmod><?php echo date('Y-m-d', strtotime($listing->timestamp)); ?></lastmod>
    </url>
@endforeach
</urlset>