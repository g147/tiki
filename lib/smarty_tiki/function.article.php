<?php

// (c) Copyright by authors of the Tiki Wiki CMS Groupware Project
//
// All Rights Reserved. See copyright.txt for details and a complete list of authors.
// Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details.
// $Id$

/* inserts the content of an rss feed into a module */
function smarty_function_article($params, $smarty)
{
    $tikilib = TikiLib::lib('tiki');
    $artlib = TikiLib::lib('art');
    extract($params);

    if (empty($max)) {
        $max = 99;
    }



    // skip="x,y" will not print Xth and Yth items
    // useful to avoid default first items
    if (! empty($skip) && preg_match('/^\d+(,\d+)*$/', $skip)) {
        $skipped_items = explode(',', $skip);
        $skip = [];
        foreach ($skipped_items as $i) {
            $skip[$i] = 1;
        }
    } else {
        $skip = [];
    }
    $list_articles = $artlib->list_articles(0, $max, 'publishDate_desc', '', '', '', '', '', '', 1);

    $x = "";

    foreach ($list_articles['data'] as $article_data) {
        $x .= "<div class=\"articles\">";
        $x .= "<a href=\"tiki-read_article.php?articleId=" . $article_data['articleId'] . "\" class=\"article\">";
        $x .= $article_data['title'] . " - " . $tikilib->date_format('%d/%m/%Y', $article_data['publishDate']) . "</a></div>\n";
    }
    echo $x;
}
