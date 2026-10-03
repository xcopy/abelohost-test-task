{extends file="layout.tpl"}
{block name=title}{$category.name|escape}{/block}
{block name=body}
<h1>{$category.name|escape}</h1>
<div>{$category.description|escape}</div>
{include file="partials/posts.tpl" posts=$posts}
{include file="partials/pagination.tpl" totalPages=$totalPages page=$page}
{/block}
