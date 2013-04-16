{include file="findInclude:common/templates/header.tpl"}

<h2 class="nonfocal">{$eventTitle}</h2>
<div class="smallprint nonfocal">{$start_date}</div>

{include file="findInclude:common/templates/dataObjectTabs.tpl"}

<div class="focal">{$body}</div>
<div class="focal"><a class="rsvpbutton" href="{$url}"><span class="buttontext">RSVP</span></a></div>

{include file="findInclude:common/templates/footer.tpl"}
