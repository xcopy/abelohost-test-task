{extends file="layout.tpl"}
{block name=title}{$status} {$message}{/block}
{block name=body}
<h1>{$status} {$message}</h1>
<p>An error occurred while processing your request.</p>
<div><code>{$file}:{$line}</code></div>
<div><code>{$trace}</code></div>
{/block}
