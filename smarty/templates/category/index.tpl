{extends file="layout.tpl"}
{block name=title}Categories{/block}
{block name=body}
<ul class="list-unstyled">
    {foreach $categories as $category}
        <li>
            <a href="/categories/{$category.id}" class="text-uppercase">{$category.name|escape}</a>
            {include file="partials/posts.tpl" posts=$category.posts}
        </li>
    {/foreach}
</ul>
{/block}
