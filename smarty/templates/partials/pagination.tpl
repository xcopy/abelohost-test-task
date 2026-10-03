<hr>
{if $totalPages > 1}
    <nav class="pagination">
        {if $page > 1}
            <a href="?page=1&sort={$sort}&direction={$direction}">First</a>
            <a href="?page={$page-1}&sort={$sort}&direction={$direction}">Prev</a>
        {/if}

        {for $i=1 to $totalPages}
            {if $i == $page}
                <span>{$i}</span>
            {else}
                <a href="?page={$i}&sort={$sort}&direction={$direction}">{$i}</a>
            {/if}
        {/for}

        {if $page < $totalPages}
            <a href="?page={$page+1}&sort={$sort}&direction={$direction}">Next</a>
            <a href="?page={$totalPages}&sort={$sort}&direction={$direction}">Last</a>
        {/if}
    </nav>
{/if}
