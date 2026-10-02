{extends file="layout.tpl"}
{block name=title}{$post.name|escape}{/block}
{block name=body}
<h1>{$post.name|escape}</h1>
<p>{$post.description|escape}</p>
<p>{$post.body|escape}</div>
{include file="partials/posts.tpl" posts=$similarPosts}
{/block}
