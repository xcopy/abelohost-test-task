{extends file="layout.tpl"}
{block name=title}{$category.name|escape}{/block}
{block name=body}
<h1>{$category.name|escape}</h1>
<div>{$category.description|escape}</div>
<div>
    <span>Sort by:</span>
    <a href="?sort=created_at&direction={$direction}">date</a>
    <a href="?sort=views&direction={$direction}">views</a>
    <a href="?sort={$sort}&direction={($direction == 'desc') ? 'asc' : 'desc'}">{if $direction == 'desc'}asc{else}desc{/if}</a>
</div>
{include file="partials/posts.tpl" posts=$posts}
{include file="partials/pagination.tpl" totalPages=$totalPages page=$page sort=$sort direction=$direction}
{/block}
