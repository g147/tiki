{extends 'layout_view.tpl'}

{block name="title"}
    {title}{$title}{/title}
{/block}

{block name="content"}
    <form method="post" action="{service controller=api_token action=create}">
        {ticket}
        <div class="form-group row">
            <label class="col-form-label col-sm-2">
                {tr}User{/tr}
                <a class="tikihelp text-info" title="{tr}User account:{/tr} {tr}All API requests with this token will authenticate against the selected user account.{/tr}">
                    {icon name=information}
                </a>
            </label>
            <div class="col-sm-10">
                {user_selector id="user_selector_api_token" realnames="n"}
            </div>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-sm-2">
                {tr}Valid until{/tr}
                <a class="tikihelp text-info" title="{tr}Valid until:{/tr} {tr}Optionally specify the time when this token will expire.{/tr}">
                    {icon name=information}
                </a>
            </label>
            <div class="col-sm-10">
                {jscalendar id="api_token_expire_after" date="" fieldname="expireAfter" showtime='y' isutc=0}
            </div>
        </div>
        <div class="submit">
            <input
                type="submit"
                class="btn btn-primary"
                value="{tr}Create{/tr}"
            >
        </div>
    </form>
{/block}
