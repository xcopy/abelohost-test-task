<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{block name=title}AbeloHost{/block}</title>
    <link href="/css/app.css" rel="stylesheet" type="text/css">
  </head>
  <body>
    <main class="container">
        <nav class="breadcrumbs">
            <ol>
                {foreach $breadcrumbs as $item}
                    <li>
                        {if $item.url && !$item@last}
                            <a href="{$item.url|escape}">{$item.label|escape}</a>
                        {else}
                            <span>{$item.label|escape}</span>
                        {/if}
                    </li>
                {/foreach}
            </ol>
        </nav>

        {block name=body}{/block}
    </main>
  </body>
</html>
