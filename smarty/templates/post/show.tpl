{extends file="layout.tpl"}
{block name=title}{$post.name|escape}{/block}
{block name=body}
<article>
    <figure>
        <img src="{$post.image_url|escape}" alt="{$post.name|escape}" loading="lazy">
    </figure>
    <p>
        <span>Created at:</span>
        <time datetime="{$post.created_at}">{$post.created_at|date_format:"%d %b %Y %H:%M"}</time>
        <span>Views:</span>
        <span>{$post.views}</span>
    </p>
    <h1>{$post.name|escape}</h1>
    <p>{$post.description|escape}</p>
    <p>{$post.body|escape}</p>
    <hr>
    Related posts:
    {include file="partials/posts.tpl" posts=$similarPosts}
    <span>Categories:</span>
    <ul class="list-inline">
        {foreach $categories as $category}
            <li>
                <a href="/categories/{$category.id}">{$category.name|escape}</a>
            </li>
        {/foreach}
    </ul>
</article>
{/block}
