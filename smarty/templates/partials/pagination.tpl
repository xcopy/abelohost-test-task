{if $totalPages > 1}
    <nav>
        {if $page > 1}
            <a href="?page=1">First</a>
            <a href="?page={$page-1}">Prev</a>
        {/if}

        {for $i=1 to $totalPages}
            {if $i == $page}
                <span>{$i}</span>
            {else}
                <a href="?page={$i}">{$i}</a>
            {/if}
        {/for}

        {if $page < $totalPages}
            <a href="?page={$page+1}">Next</a>
            <a href="?page={$totalPages}">Last</a>
        {/if}
    </nav>
{/if}
