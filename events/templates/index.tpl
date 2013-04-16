{include file="findInclude:common/templates/header.tpl"}

{block name="searchbox"}
  {include file="findInclude:common/templates/search.tpl"}
{/block}

{block name="recentEvents"}
  {include file="findInclude:common/templates/navlist.tpl" navlistItems=$recentEvents navListHeading=$upcomingEventsHeader subTitleNewline=true}
{/block}

{include file="findInclude:common/templates/footer.tpl"}
