{* $Id$ *}
{title help="Directory"}{tr}Validate sites{/tr}{/title}

{* Display the title using parent *}
{include file='tiki-directory_admin_bar.tpl'} <br>
<h2>{tr}Sites{/tr}</h2>

{* Display the list of categories (items) using pagination *}
{* Links to edit, remove, browse the categories *}
<form action="tiki-directory_validate_sites.php" method="post" name="form_validate_sites">
{jq notonready=true}
var CHECKBOX_LIST = [{{section name=user loop=$items}'sites[{$items[user].siteId}]'{if not $smarty.section.user.last},{/if}{/section}}];
{/jq}
    <br>
    <div class="{if $js}table-responsive{/if}"> {*the table-responsive class cuts off dropdown menus *}
        <table class="table table-striped table-hover">
            <tr>
                <th>
                    {if $items}
                        <input type="checkbox" name="checkall" onclick="checkbox_list_check_all('form_validate_sites',CHECKBOX_LIST,this.checked);">
                    {/if}</th>
                <th><a href="tiki-directory_validate_sites.php?offset={$offset}&amp;sort_mode={if $sort_mode eq 'name_desc'}name_asc{else}name_desc{/if}">{tr}Name{/tr}</a></th>
                <th><a href="tiki-directory_validate_sites.php?offset={$offset}&amp;sort_mode={if $sort_mode eq 'url_desc'}url_asc{else}url_desc{/if}">{tr}URL{/tr}</a></th>
                {if $prefs.directory_country_flag eq 'y'}
                    <th><a href="tiki-directory_validate_sites.php?offset={$offset}&amp;sort_mode={if $sort_mode eq 'country_desc'}country_asc{else}country_desc{/if}">{tr}country{/tr}</a></th>
                {/if}
                <th><a href="tiki-directory_validate_sites.php?offset={$offset}&amp;sort_mode={if $sort_mode eq 'hits_desc'}hits_asc{else}hits_desc{/if}">{tr}Hits{/tr}</a></th>
                <th>{tr}Action{/tr}</th>
            </tr>

            {section name=user loop=$items}
                <tr class="{cycle advance=false}">
                    <td class="checkbox-cell"><div class="form-check"><input type="checkbox" name="sites[{$items[user].siteId}]"></div></td>
                    <td class="text">{$items[user].name}</td>
                    <td class="text"><a href="{$items[user].url}" target="_blank">{$items[user].url}</a></td>
                    {if $prefs.directory_country_flag eq 'y'}
                        <td class="icon"><img src='img/flags/{$items[user].country}.png' alt='{$items[user].country}'></td>
                    {/if}
                    <td class="integer">{$items[user].hits}</td>
                    <td class="action">
                        {actions}
                            {strip}
                                <action>
                                    <a href="tiki-directory_admin_sites.php?offset={$offset}&amp;sort_mode={$sort_mode}&amp;siteId={$items[user].siteId}">
                                        {icon name='edit' _menu_text='y' _menu_icon='y' alt="{tr}Edit{/tr}"}
                                    </a>
                                </action>
                                <action>
                                    <a href="tiki-directory_validate_sites.php?offset={$offset}&amp;sort_mode={$sort_mode}&amp;remove={$items[user].siteId}">
                                        {icon name='remove' _menu_text='y' _menu_icon='y' alt="{tr}Remove{/tr}"}
                                    </a>
                                </action>
                            {/strip}
                        {/actions}
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td colspan="6"><i>{tr}Directory Categories:{/tr}{assign var=fsfs value=1}
                        {section name=ii loop=$items[user].cats}
                            {if $fsfs}{assign var=fsfs value=0}{else}, {/if}
                                {$items[user].cats[ii].path}
                            {/section}</i>
                    </td>
                </tr>
            {sectionelse}
                {norecords _colspan=6}
            {/section}
        </table>
    </div>

    {if $items}
        <br>
        {tr}Perform action with selected:{/tr}
        <input type="submit" class="btn btn-primary btn-sm" name="del" value="{tr}Remove{/tr}">
        <input type="submit" class="btn btn-primary btn-sm" name="validate" value="{tr}Validate{/tr}">
    {/if}
</form>
{pagination_links cant=$cant_pages step=$prefs.maxRecords offset=$offset}{/pagination_links}
