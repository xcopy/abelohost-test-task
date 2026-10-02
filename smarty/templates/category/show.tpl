{extends file="layout.tpl"}
{block name=title}{$category.name|escape}{/block}
{block name=body}
<h1>{$category.name|escape} ({$posts|count})</h1>
<div>{$category.description|escape}</div>
{include file="partials/posts.tpl" posts=$posts}
{/block}
