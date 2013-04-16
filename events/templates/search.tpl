{include file="findInclude:common/templates/header.tpl"}

{block name="searchbox"}
  {include file="findInclude:common/templates/search.tpl"}
{/block}
<div class="focal">You found <strong>{$total_items}</strong> results found searching with <span class="keywords">{$keywords}</span> </div>
{block name="searchResults"}
  {include file="findInclude:common/templates/results.tpl" results=$results}
{/block}

{include file="findInclude:common/templates/footer.tpl"}