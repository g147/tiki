{* $Id$ *}
{if $base_uri and ($dir_level gt 0 or $prefs.feature_html_head_base_tag eq 'y')}
    <base href="{$base_uri|escape}">
{/if}
<!--Latest IE Compatibility-->
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="generator" content="Tiki Wiki CMS Groupware - https://tiki.org">
{* --- SocialNetwork:Domain ---*}
<meta content="{$base_url_canonical}" name="twitter:domain"> {* may be obsolete when using twitter:card *}
{* --- Canonical URL --- *}
{include file="canonical.tpl"}

{if !empty($forum_info.name) & $prefs.metatag_threadtitle eq 'y'}
    <meta name="keywords" content="{tr}Forum{/tr} {$forum_info.name|escape} {$thread_info.title|escape} {if $prefs.feature_freetags eq 'y'}{foreach from=$freetags.data item=taginfo}{$taginfo.tag|escape} {/foreach}{/if}">
{elseif $prefs.metatag_keywords neq '' or !empty($metatag_local_keywords)}
    <meta name="keywords" content="{if not empty($prefs.metatag_keywords_translated)}{$prefs.metatag_keywords_translated|escape}{else}{$prefs.metatag_keywords|escape}{/if} {if $prefs.feature_freetags eq 'y'}{foreach from=$freetags.data item="taginfo"}{$taginfo.tag|escape} {/foreach}{/if} {$metatag_local_keywords|escape}">
{/if}
{if $prefs.metatag_author neq ''}
    <meta name="author" content="{$prefs.metatag_author|escape}">
{/if}
{* --- Blog description --- *}
{if isset($section) and $section eq "blogs"}
    {if not empty($post_info.parsed_excerpt)}
        {$metatag_description = $post_info.parsed_excerpt|strip_tags:false|truncate:200|escape}
    {elseif not empty($post_info.parsed_data|strip_tags)}
        {$metatag_description = $post_info.parsed_data|strip_tags:false|truncate:200|escape}
    {else}
        {$metatag_description = $post_info.title|cat:' - '|cat:$blog_data.title|escape}
    {/if}
{* --- Article description --- *}
{elseif isset($section) and $section eq "cms"}
    {if not empty($heading)}
        {$metatag_description = $parsed_heading|strip_tags:false|truncate:200|escape}
    {elseif not empty ($body)}
        {$metatag_description = $parsed_body|strip_tags:false|truncate:200|escape}
    {/if}
{* --- File Gallery description --- *}
{elseif isset($section) and $section eq "file_galleries"}
    {if not empty($gal_info.description)}
        {$metatag_description = $gal_info.description|strip_tags:false|truncate:200|escape}
    {/if}
{* --- Page description --- *}
{elseif $prefs.metatag_pagedesc eq 'y' and not empty($description)}
    {$metatag_description = $description|escape}
{elseif not empty($prefs.metatag_description_translated)}
    {$metatag_description = $prefs.metatag_description_translated|escape}
{elseif not empty($prefs.metatag_description)}
    {$metatag_description = $prefs.metatag_description|escape}
{/if}
{if not empty($metatag_description) and not empty($metatag_description|trim)}
    <meta name="description" content="{$metatag_description}">
    <meta content="{$metatag_description}" property="og:description">
    <meta name="twitter:description" content="{$metatag_description}">
{else}
    <meta name="description" content="{if not empty($prefs.browsertitle_translated)}{$prefs.browsertitle_translated|tr_if|escape}{else}{$prefs.browsertitle|tr_if|escape}{/if}{if isset($title)} {$prefs.site_nav_seper} {$title}{/if}">
    <meta content="{if not empty($prefs.browsertitle_translated)}{$prefs.browsertitle_translated|tr_if|escape}{else}{$prefs.browsertitle|tr_if|escape}{/if}{if isset($title)} {$prefs.site_nav_seper} {$title}{/if}" property="og:description">
    <meta name="twitter:description" content="{if not empty($prefs.browsertitle_translated)}{$prefs.browsertitle_translated|tr_if|escape}{else}{$prefs.browsertitle|tr_if|escape}{/if}{if isset($title)} {$prefs.site_nav_seper} {$title}{/if}">
{/if}
{if $prefs.metatag_geoposition neq ''}
    <meta name="geo.position" content="{$prefs.metatag_geoposition|escape}">
{/if}
{if $prefs.metatag_georegion neq ''}
    <meta name="geo.region" content="{$prefs.metatag_georegion|escape}">
{/if}
{if $prefs.metatag_geoplacename neq ''}
    <meta name="geo.placename" content="{$prefs.metatag_geoplacename|escape}">
{/if}
{if (isset($prefs.metatag_robots) and $prefs.metatag_robots neq '') and (!isset($metatag_robots) or $metatag_robots eq '')}
    <meta name="robots" content="{$prefs.metatag_robots|escape}">
{/if}
{if (!isset($prefs.metatag_robots) or $prefs.metatag_robots eq '') and (isset($metatag_robots) and $metatag_robots neq '')}
    <meta name="robots" content="{$metatag_robots|escape}">
{/if}
{if (isset($prefs.metatag_robots) and $prefs.metatag_robots neq '') and (isset($metatag_robots) and $metatag_robots neq '')}
    <meta name="robots" content="{$prefs.metatag_robots|escape}, {$metatag_robots|escape}">
{/if}
{if $prefs.metatag_revisitafter neq ''}
    <meta name="revisit-after" content="{$prefs.metatag_revisitafter|escape}">
{/if}
{* --- SocialNetwork:site_name --- *}
<meta content="{if not empty($prefs.socialnetworks_facebook_site_name)}{$prefs.socialnetworks_facebook_site_name}{elseif not empty($prefs.browsertitle_translated)}{$prefs.browsertitle_translated|tr_if|escape}{else}{$prefs.browsertitle|tr_if|escape}{/if}" property="og:site_name">
<meta content="{if not empty($prefs.socialnetworks_twitter_site)}{$prefs.socialnetworks_twitter_site}{elseif not empty($prefs.browsertitle_translated)}{$prefs.browsertitle_translated|tr_if|escape}{else}{$prefs.browsertitle|tr_if|escape}{/if}" name="twitter:site">
{* --- SocialNetwork: fb:app_id ---*}
{if not empty($prefs.socialnetworks_facebook_application_id)}<meta content="{$prefs.socialnetworks_facebook_application_id}" property="fb:app_id">{/if}

{capture assign='header_title'}{strip}
{if !empty($sswindowtitle)}
    {if $sswindowtitle eq 'none'}
        &nbsp;
    {else}
        {$sswindowtitle|escape}
    {/if}
{else}
    {if $prefs.site_title_location eq 'before'}{if not empty($prefs.browsertitle_translated)}{$prefs.browsertitle_translated|tr_if|escape}{else}{$prefs.browsertitle|tr_if|escape}{/if} {$prefs.site_nav_seper} {/if}
    {capture assign="page_description_title"}
        {if ($prefs.feature_breadcrumbs eq 'y' or $prefs.site_title_breadcrumb eq "desc") && isset($trail)}
            {breadcrumbs type=$prefs.site_title_breadcrumb loc="head" crumbs=$trail}
        {/if}
    {/capture}
    {if isset($structure) and $structure eq 'y'} {* get the alias name if item is a wiki page and it is in a structure *}
        {section loop=$structure_path name=ix}
        {assign var="aliasname" value={$structure_path[ix].page_alias}}
        {/section}
    {/if}
    {if $prefs.site_title_location eq 'only'}
        {if not empty($prefs.browsertitle_translated)}{$prefs.browsertitle_translated|tr_if|escape}{else}{$prefs.browsertitle|tr_if|escape}{/if}
    {else}
        {if !empty($page_description_title)}
            {$page_description_title}
        {else}
            {if !empty($tracker_item_main_value)}
                {$tracker_item_main_value|truncate:255|escape}
            {elseif !empty($title) and !is_array($title)}
                {$title|escape}
            {elseif !empty($aliasname)}
                {$aliasname|escape}
            {elseif !empty($arttitle)}
                {$arttitle|escape}
            {elseif !empty($thread_info.title)}
                {$thread_info.title|escape}
            {elseif !empty($forum_info.name)}
                {$forum_info.name|escape}
            {elseif !empty($categ_info.name)}
                {$categ_info.name|escape}
            {elseif !empty($userinfo.login)}
                {$userinfo.login|username}
            {elseif !empty($tracker_info.pagetitle)}
                {$tracker_info.pagetitle|escape}
            {elseif !empty($tracker_info.name)}
                {$tracker_info.name|escape}
             {elseif !empty($description)}
                {$description|escape}{* use description if nothing else is found but this is likely to contain tiki markup *}
                {* add $description|escape if you want to put the description + update breadcrumb_build replace return $crumbs->title; with return empty($crumbs->description)? $crumbs->title: $crumbs->description; *}
            {elseif !empty($page)}
                {$page|escape} {* Must stay after description as it is unlikely to be empty if wiki pages *}
            {elseif !empty($headtitle)}
                {$headtitle|stringfix:"&nbsp;"|escape}{* use $headtitle last if feature specific title not found - Must stay the last one as failback *}
            {/if}
        {/if}
    {/if}
    {if $prefs.site_title_location eq 'after'} {$prefs.site_nav_seper} {if not empty($prefs.browsertitle_translated)}{$prefs.browsertitle_translated|tr_if|escape}{else}{$prefs.browsertitle|tr_if|escape}{/if}{/if}
{/if}
{/strip}{/capture}
{* --- tiki block --- *}
<title>{$header_title}</title>
{* --- SocialNetwork:title --- *}
{* Facebook *}
<meta property="og:title" content="{$header_title}">
{* Twitter *}
<meta name="twitter:title" content="{$header_title}">
{* --- SocialNetwork:type --- *}
{if $prefs.feature_canonical_url eq 'y' and isset($mid)}
    {if $mid eq 'tiki-view_blog.tpl' or $mid eq 'tiki-view_blog_post.tpl' or $mid eq 'tiki-read_article.tpl'}
        <meta content="article" property="og:type">
    {else}
        <meta content="website" property="og:type">
    {/if}
{/if}
{* To be added someday when using cart feature: product, product.group, product.item *}
{* May be usefull too : profile *}
<meta name="twitter:card" content="summary">
{* --- SocialNetwork:image --- *}
{* first we check if there is a featured image to use it *}
{if not empty($header_featured_images)}
    {foreach $header_featured_images as $header_featured_image}
        <meta content="{$header_featured_image|escape}" property="og:image">
        <meta content="{$header_featured_image|escape}" property="twitter:image">
    {/foreach}
{elseif $prefs.feature_canonical_url eq 'y' and isset($mid)}
    {if $mid eq 'tiki-view_blog.tpl'}
    {elseif $mid eq 'tiki-view_blog_post.tpl'}
    {* --- Article --- *}
    {* If there is no featured image we check if an article image or a topic image exist to use it *}
    {elseif ($mid eq 'tiki-read_article.tpl') and ($hasImage eq 'y') or (not empty ($topics.image_name))}
        <meta content="{$base_url_canonical}{if $hasImage eq 'y'}article_image.php?image_type=article&id={$articleId}{elseif not empty ($topics.image_name)}article_image.php?image_type=topic&id={$topicId}{/if}" property="og:image">
        <meta content="{$base_url_canonical}{if $hasImage eq 'y'}article_image.php?image_type=article&id={$articleId}{elseif not empty ($topics.image_name)}article_image.php?image_type=topic&id={$topicId}{/if}" property="twitter:image">
    {* We use the social network image as failsafe - control panel social network *}
    {else}
        {if $prefs.socialnetworks_facebook_site_image}<meta content="{$prefs.socialnetworks_facebook_site_image}" property="og:image">{/if}
        {if $prefs.socialnetworks_twitter_site_image}<meta content="{$prefs.socialnetworks_twitter_site_image}" property="twitter:image">{/if}
    {/if}
{/if}
{* --- universaleditbutton.org --- *}
{if (isset($editable) and $editable) and ($tiki_p_edit eq 'y' or $page|lower eq 'sandbox' or $tiki_p_admin_wiki eq 'y')}
    <link rel="alternate" type="application/x-wiki" title="{tr}Edit this page!{/tr}" href="tiki-editpage.php?page={$page|escape:url}">
{/if}
{* --- Firefox RSS icons --- *}
{if $prefs.feature_wiki eq 'y' and $prefs.feed_wiki eq 'y' and $tiki_p_view eq 'y'}
    <link rel="alternate" type="application/rss+xml" title='{$prefs.feed_wiki_title|escape|default:"{tr}RSS Wiki{/tr}"}' href="tiki-wiki_rss.php?ver={$prefs.feed_default_version|escape:'url'}">
{/if}
{if $prefs.feature_blogs eq 'y' and $prefs.feed_blogs eq 'y' and $tiki_p_read_blog eq 'y'}
    <link rel="alternate" type="application/rss+xml" title='{$prefs.feed_blogs_title|escape|default:"{tr}RSS Blogs{/tr}"}' href="tiki-blogs_rss.php?ver={$prefs.feed_default_version|escape:'url'}">
{/if}
{if $prefs.feature_articles eq 'y' and $prefs.feed_articles eq 'y' and $tiki_p_read_article eq 'y'}
    <link rel="alternate" type="application/rss+xml" title='{$prefs.feed_articles_title|escape|default:"{tr}RSS Articles{/tr}"}' href="tiki-articles_rss.php?ver={$prefs.feed_default_version|escape:'url'}">
{/if}
{if $prefs.feature_file_galleries eq 'y' and $prefs.feed_file_galleries eq 'y' and $tiki_p_view_file_gallery eq 'y'}
    <link rel="alternate" type="application/rss+xml" title='{$prefs.feed_file_galleries_title|escape|default:"{tr}RSS File Galleries{/tr}"}' href="tiki-file_galleries_rss.php?ver={$prefs.feed_default_version|escape:'url'}">
{/if}
{if $prefs.feature_forums eq 'y' and $prefs.feed_forums eq 'y' and $tiki_p_forum_read eq 'y'}
    <link rel="alternate" type="application/rss+xml" title='{$prefs.feed_forums_title|escape|default:"{tr}RSS Forums{/tr}"}' href="tiki-forums_rss.php?ver={$prefs.feed_default_version|escape:'url'}">
{/if}
{if $prefs.feature_directory eq 'y' and $prefs.feed_directories eq 'y' and $tiki_p_view_directory eq 'y'}
    <link rel="alternate" type="application/rss+xml" title='{$prefs.feed_directories_title|escape|default:"{tr}RSS Directories{/tr}"}' href="tiki-directories_rss.php?ver={$prefs.feed_default_version|escape:'url'}">
{/if}
{if $prefs.feature_calendar eq 'y' and $prefs.feed_calendar eq 'y' and $tiki_p_view_calendar eq 'y'}
    <link rel="alternate" type="application/rss+xml" title='{$prefs.feed_calendar_title|escape|default:"{tr}RSS Calendars{/tr}"}' href="tiki-calendars_rss.php?ver={$prefs.feed_default_version|escape:'url'}">
{/if}
{if $prefs.feature_trackers eq 'y' and $prefs.feed_tracker eq 'y'}
    {foreach from=$rsslist_trackers item="tracker"}
        <link rel="alternate" type="application/rss+xml"
            title='{$prefs.feed_tracker_title|cat:" - "|cat:$tracker.name|escape|default:"{tr}RSS Tracker{/tr}"}'
            href="tiki-tracker_rss.php?ver={$prefs.feed_default_version|escape:'url'}&trackerId={$tracker.trackerId}">
    {/foreach}
{/if}

{if $prefs.tiki_monitor_performance eq 'y'}
	<script type="text/javascript" src="vendor_bundled/vendor/npm-asset/boomerangjs/boomerang.js"></script>
	<script type="text/javascript" src="vendor_bundled/vendor/npm-asset/boomerangjs/plugins/rt.js"></script>
{/if}

{if ($prefs.feature_blogs eq 'y' and $prefs.feature_blog_sharethis eq 'y') or ($prefs.feature_articles eq 'y' and $prefs.feature_cms_sharethis eq 'y') or ($prefs.feature_wiki eq 'y' and $prefs.feature_wiki_sharethis eq 'y')}
    {if $prefs.blog_sharethis_publisher neq "" and $prefs.article_sharethis_publisher neq ""}
        <script type="text/javascript" src="https://ws.sharethis.com/button/sharethis.js#publisher={$prefs.blog_sharethis_publisher}&amp;type=website&amp;buttonText=&amp;onmouseover=false&amp;send_services=aim"></script>
    {elseif $prefs.blog_sharethis_publisher neq "" and $prefs.article_sharethis_publisher eq ""}
        <script type="text/javascript" src="https://ws.sharethis.com/button/sharethis.js#publisher={$prefs.blog_sharethis_publisher}&amp;type=website&amp;buttonText=&amp;onmouseover=false&amp;send_services=aim"></script>
    {elseif $prefs.blog_sharethis_publisher eq "" and $prefs.article_sharethis_publisher neq ""}
        <script type="text/javascript" src="https://ws.sharethis.com/button/sharethis.js#publisher={$prefs.article_sharethis_publisher}&amp;type=website&amp;buttonText=&amp;onmouseover=false&amp;send_services=aim"></script>
    {elseif $prefs.blog_sharethis_publisher eq "" and $prefs.article_sharethis_publisher eq ""}
        <script type="text/javascript" src="https://ws.sharethis.com/button/sharethis.js#type=website&amp;buttonText=&amp;onmouseover=false&amp;send_services=aim"></script>
    {/if}
{/if}
{if $prefs.vuejs_enable eq 'y'}
    <meta name="importmap-type" content="systemjs-importmap" />
    <script type="systemjs-importmap">
        {
            "imports": {
                "vue": "{$tikiroot}lib/vue/lib/vue.runtime.global.prod.js",
                "@vue-mf/styleguide": "{$tikiroot}storage/public/vue-mf/styleguide/vue-mf-styleguide.min.js",
                "@vue-mf/root-config": "{$tikiroot}storage/public/vue-mf/root-config/vue-mf-root-config.min.js",
                "@vue-mf/kanban": "{$tikiroot}storage/public/vue-mf/kanban/vue-mf-kanban.min.js"
            }
        }
    </script>
    <script type="text/javascript" src="vendor_bundled/vendor/npm-asset/import-map-overrides/dist/import-map-overrides.js"></script>
    <script type="text/javascript" src="vendor_bundled/vendor/npm-asset/systemjs/dist/system.min.js"></script>
    <script type="text/javascript" src="lib/vue/lib/vue.runtime.global.prod.js"></script>
    {* How to load Vue 3 (race conditions issue solved): https://github.com/systemjs/systemjs/issues/2272#issuecomment-744636282 *}
    <script>
        System.set(System.resolve('vue'), window.Vue);
        System.import("@vue-mf/root-config");
        window.Vue = undefined;
    </script>
{/if}
<!--[if lt IE 9]>{* according to http://remysharp.com/2009/01/07/html5-enabling-script/ *}
    <script src="vendor_bundled/vendor/afarkas/html5shiv/dist/html5shiv.min.js" type="text/javascript"></script>
<![endif]-->
{if $headerlib}        {$headerlib->output_headers()}{/if}
{if $prefs.feature_custom_html_head_content}
    {eval var=$prefs.feature_custom_html_head_content}
{/if}
{* END of html head content *}
