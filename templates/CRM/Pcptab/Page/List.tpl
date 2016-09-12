<div class="help">
{ts}This screen shows all the Personal Campaign Pages created in the system and allows administrator to review them and change their status.{/ts} {help id="id-pcp-intro"}
</div>
{if $rows}
<div id="ltype">
<p></p>
{include file="CRM/common/pager.tpl" location="top"}
{*include file="CRM/common/pagerAToZ.tpl"*}
{include file="CRM/common/jsortable.tpl"}
{strip}
<table id="options" class="display">
  <thead>
    <tr>
    <th>{ts}Page Title{/ts}</th>
    <th>{ts}Contribution Page / Event{/ts}</th>
    <th>{ts}Status{/ts}</th>
    <th>{ts}No of Contributions{/ts}</th>
    <th>{ts}Amount Raised{/ts}</th>
    <th>{ts}Goal{/ts}</th>
    </tr>
  </thead>
  <tbody>
  {foreach from=$rows item=row}
  <tr id="row_{$row.id}" class="{$row.class}">
    <td><a href="{crmURL p='civicrm/pcp/info' q="reset=1&id=`$row.id`" fe='true'}" title="{ts}View Personal Campaign Page{/ts}" target="_blank">{$row.title}</a></td>
    <td><a href="{$row.page_url}" title="{ts}View page{/ts}" target="_blank">{$row.page_title}</td>
    <td>{$row.status_id}</td>
    <td><a href="{crmURL p='civicrm/contribute/search' q="force=1&pcpid=`$row.id`" fe='true'}"
    title="{ts}View contribution details{/ts}" target="_blank">{$row.numcontributions}</a></td>
    <td>{$row.raised|crmMoney}</td>
    <td>{$row.goal|crmMoney}</td>
  </tr>
  {/foreach}
  </tbody>
</table>
{/strip}
</div>
{else}
<div class="messages status no-popup">
<div class="icon inform-icon"></div>
    {if $isSearch}
        {ts}There are no Personal Campaign Pages which match your search criteria.{/ts}
    {else}
        {ts}There are currently no Personal Campaign Pages.{/ts}
    {/if}
</div>
{/if}
{if $smarty.get.debug}
{$debug}
{/if}