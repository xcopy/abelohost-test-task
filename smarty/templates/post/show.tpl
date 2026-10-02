{extends file="layout.tpl"}
{block name=title}{$post.name|escape}{/block}
{block name=body}
<img src="{$post.image_url|escape}" alt="{$post.name|escape}" loading="lazy">
<div>
    <span>Created at:</span>
    <time datetime="{$post.created_at}">{$post.created_at|date_format:"%d %b %Y %H:%M"}</time>
</div>
<div>
    <span>Views:</span>
    <span>{$post.views}</span>
</div>

<div>
    <span>Categories:</span>
    <ul>
        {foreach $categories as $category}
            <li>
                <a href="/categories/{$category.id}">{$category.name|escape}</a>
            </li>
        {/foreach}
    </ul>
</div>
<h1>{$post.name|escape}</h1>
<p>{$post.description|escape}</p>
<p>{$post.body|escape}</p>
{include file="partials/posts.tpl" posts=$similarPosts}
{/block}
