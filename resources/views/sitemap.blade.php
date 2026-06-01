<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:news="http://www.google.com/schemas/sitemap-news/0.9"
        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">

  {{-- Static pages --}}
  <url>
    <loc>{{ route('home') }}</loc>
    <changefreq>daily</changefreq>
    <priority>1.0</priority>
  </url>
  <url>
    <loc>{{ route('articles.index') }}</loc>
    <changefreq>daily</changefreq>
    <priority>0.9</priority>
  </url>
  <url>
    <loc>{{ route('products.index') }}</loc>
    <changefreq>weekly</changefreq>
    <priority>0.8</priority>
  </url>
  <url>
    <loc>{{ route('companies.index') }}</loc>
    <changefreq>weekly</changefreq>
    <priority>0.8</priority>
  </url>
  <url>
    <loc>{{ route('events.index') }}</loc>
    <changefreq>daily</changefreq>
    <priority>0.8</priority>
  </url>

  {{-- Articles --}}
  @foreach($articles as $article)
  <url>
    <loc>{{ route('articles.show', $article->slug) }}</loc>
    <lastmod>{{ $article->updated_at->toAtomString() }}</lastmod>
    <changefreq>monthly</changefreq>
    <priority>0.7</priority>
  </url>
  @endforeach

  {{-- Products --}}
  @foreach($products as $product)
  <url>
    <loc>{{ route('products.show', $product->slug) }}</loc>
    <lastmod>{{ $product->updated_at->toAtomString() }}</lastmod>
    <changefreq>monthly</changefreq>
    <priority>0.6</priority>
  </url>
  @endforeach

  {{-- Companies --}}
  @foreach($companies as $company)
  <url>
    <loc>{{ route('companies.show', $company->slug) }}</loc>
    <lastmod>{{ $company->updated_at->toAtomString() }}</lastmod>
    <changefreq>monthly</changefreq>
    <priority>0.6</priority>
  </url>
  @endforeach

  {{-- Events --}}
  @foreach($events as $event)
  <url>
    <loc>{{ route('events.show', $event->slug) }}</loc>
    <lastmod>{{ $event->updated_at->toAtomString() }}</lastmod>
    <changefreq>weekly</changefreq>
    <priority>0.6</priority>
  </url>
  @endforeach

</urlset>
