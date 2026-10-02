<ul>
    {foreach $posts as $post}
        <li>
            <time datetime="{$post.created_at}">{$post.created_at|date_format:"%d %b %Y %H:%M"}</time>
            <a href="/posts/{$post.id}">{$post.name|escape}</a>
        </li>
    {/foreach}
</ul>
