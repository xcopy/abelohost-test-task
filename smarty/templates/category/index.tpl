{extends file="layout.tpl"}
{block name=title}Categories{/block}
{block name=body}
<ul>
    {foreach $categories as $category}
        <li>
            <a href="/categories/{$category.id}">{$category.name|escape}</a>
            <ul>
            {foreach $category.posts as $post}
                <li>
                    <time datetime="{$post.created_at}">{$post.created_at|date_format:"%d %b %Y %H:%M"}</time>
                    <a href="/posts/{$post.id}">{$post.name|escape}</a>
                </li>
            {/foreach}
            </ul>
        </li>
    {/foreach}
</ul>
{/block}
