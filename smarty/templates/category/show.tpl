{extends file="layout.tpl"}
{block name=title}{$category.name|escape}{/block}
{block name=body}
<h1 class="text-uppercase">{$category.name|escape}</h1>
<p>{$category.description|escape}</p>
<div>
    <span>Sort by:</span>
    <ul class="list-inline">
        <li>
            {if $sort == 'created_at'}
                <span>date</span>
            {else}
                <a href="?sort=created_at&direction={$direction}">date</a>
            {/if}
        </li>
        <li>
            {if $sort == 'views'}
                <span>views</span>
            {else}
                <a href="?sort=views&direction={$direction}">views</a>
            {/if}
        </li>
        <li><a href="?sort={$sort}&direction={($direction == 'desc') ? 'asc' : 'desc'}">{if $direction == 'desc'}asc{else}desc{/if}</a></li>
    </ul>
</div>
{include file="partials/posts.tpl" posts=$posts}
{include file="partials/pagination.tpl" totalPages=$totalPages page=$page sort=$sort direction=$direction}
{/block}
