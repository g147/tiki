{* $Id$ *}
<a class="icon" href="tiki-accounting_export.php?action=print&what=journal&bookId={$bookId}{if isset($account.accountId)}&accountId={$account.accountId}{/if}" target="new">
    {icon name="print" alt="{tr}printable version{/tr}"}
</a>
<a class="icon" href="tiki-accounting_export.php?action=settings&what=journal&bookId={$bookId}{if isset($account.accountId)}&accountId={$account.accountId}{/if}">
    {icon name="export" alt="{tr}export table{/tr}"}
</a>
<div class="table-responsive">
    <table class="table normal table-striped table-hover" >
        <tr>
            <th rowspan="2">{tr}Id{/tr}</th>
            <th rowspan="2">{tr}Date{/tr}</th>
            <th rowspan="2">{tr}Description{/tr}</th>
            <th colspan="3">{tr}Debit{/tr}</th>
            <th colspan="3">{tr}Credit{/tr}</th>
            <th rowspan="2">&nbsp;</th>
        </tr>
        <tr>
            <th>{tr}Account{/tr}</th>
            <th>{tr}Amount{/tr}</th>
            <th>{tr}Text{/tr}</th>
            <th>{tr}Account{/tr}</th>
            <th>{tr}Amount{/tr}</th>
            <th>{tr}Text{/tr}</th>
        </tr>
        {foreach from=$journal item=j}{cycle values="odd,even" assign="style"}
            <tr class="{$style}" title="{if $j.journalCancelled==1}Deleted{/if}">
                <td class="journal{if $j.journalCancelled==1}Deleted{/if}"{if $j.maxcount>1} rowspan="{$j.maxcount}"{/if} style="text-align:right">{$j.journalId}</td>
                <td class="journal{if $j.journalCancelled==1}Deleted{/if}"{if $j.maxcount>1} rowspan="{$j.maxcount}"{/if} style="text-align:right">{$j.journalDate|date_format:"%Y-%m-%d"}</td>
                <td class="journal{if $j.journalCancelled==1}Deleted{/if}"{if $j.maxcount>1} rowspan="{$j.maxcount}"{/if}>{$j.journalDescription|escape}</td>
                {section name=posts loop=$j.maxcount}{assign var='i' value=$smarty.section.posts.iteration-1}
                    {if !$smarty.section.posts.first}<tr class="{$style}">{/if}
                        <td class="journal{if $j.journalCancelled==1}Deleted{/if}" style="text-align:right">{if $i<$j.debitcount}{$j.debit[$i].itemAccountId}{/if}&nbsp;</td>
                        <td class="journal{if $j.journalCancelled==1}Deleted{/if}" style="text-align:right">{if $i<$j.debitcount}{if $book.bookCurrencyPos==-1}{$book.bookCurrency} {/if}{$j.debit[$i].itemAmount|number_format:$book.bookDecimals:$book.bookDecPoint:$book.bookThousand}{if $book.bookCurrencyPos==1} {$book.bookCurrency}{/if}&nbsp;{/if}</td>
                        <td class="journal{if $j.journalCancelled==1}Deleted{/if}">{if $i<$j.debitcount}{$j.debit[$i].itemText|escape}{/if}&nbsp;</td>
                        <td class="journal{if $j.journalCancelled==1}Deleted{/if}" style="text-align:right">{if $i<$j.creditcount}{$j.credit[$i].itemAccountId}{/if}&nbsp;</td>
                        <td class="journal{if $j.journalCancelled==1}Deleted{/if}" style="text-align:right">{if $i<$j.creditcount}{if $book.bookCurrencyPos==-1}{$book.bookCurrency} {/if}{$j.credit[$i].itemAmount|number_format:$book.bookDecimals:$book.bookDecPoint:$book.bookThousand}{if $book.bookCurrencyPos==1} {$book.bookCurrency}{/if}&nbsp;{/if}</td>
                        <td class="journal{if $j.journalCancelled==1}Deleted{/if}">{if $i<$j.creditcount}{$j.credit[$i].itemText|escape}{/if}&nbsp;</td>
                        {if $smarty.section.posts.first}
                            <td rowspan="{$j.maxcount}">
                                {if $j.journalCancelled==1}&nbsp;
                                {else}
                                    <form method="post" action="tiki-accounting_cancel.php">
                                        <input type="hidden" name="bookId" value="{$bookId|escape:'attr'}">
                                        <input type="hidden" name="journalId" value="{$j.journalId|escape:'attr'}">
                                        {ticket}
                                        <button
                                            type="submit"
                                            class="btn btn-link tips"
                                            onclick="confirmPopup('{tr _0="{$j.journalId|escape:'attr'}" _1="{$book.bookName|escape:'attr'}"}Cancel transaction ID %0 in book %1?{/tr}')"
                                            style="float:left;padding:0;border:none"
                                            title=":{tr}Cancel transaction{/tr}"
                                        >
                                            {icon name="remove" alt="{tr}Cancel transaction{/tr}"}
                                        </button>
                                    </form>
                                {/if}
                            </td>
                        {/if}
                    </tr>
                {/section}
        {foreachelse}
            {norecords _colspan=9}
        {/foreach}
        {if isset($totals)}
            <tr>
                <td class="journal"><b>{tr}Balance{/tr}</b></td>
                <td class="journal" style="text-align:right"><b>{if $book.bookCurrencyPos==-1}{$book.bookCurrency} {/if}{$totals.total|number_format:$book.bookDecimals:$book.bookDecPoint:$book.bookThousand}{if $book.bookCurrencyPos==1} {$book.bookCurrency}{/if}</b></td>
                <td class="journal">&nbsp;</td>
                <td class="journal"><b>{tr}Debit{/tr}</b></td>
                <td class="journal" style="text-align:right"><b>{if $book.bookCurrencyPos==-1}{$book.bookCurrency} {/if}{$totals.debit|number_format:$book.bookDecimals:$book.bookDecPoint:$book.bookThousand}{if $book.bookCurrencyPos==1} {$book.bookCurrency}{/if}</b></td>
                <td class="journal">&nbsp;</td>
                <td class="journal"><b>{tr}Credit{/tr}</b></td>
                <td class="journal" style="text-align:right"><b>{if $book.bookCurrencyPos==-1}{$book.bookCurrency} {/if}{$totals.credit|number_format:$book.bookDecimals:$book.bookDecPoint:$book.bookThousand}{if $book.bookCurrencyPos==1} {$book.bookCurrency}{/if}</b></td>
                <td class="journal">&nbsp;</td>
            </tr>
        {/if}
    </table>
</div>
