<?php

// (c) Copyright by authors of the Tiki Wiki CMS Groupware Project
//
// All Rights Reserved. See copyright.txt for details and a complete list of authors.
// Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details.
// $Id$

require_once('tiki-setup.php');
$performanceLib = TikiLib::lib('performancestats');

$access->check_feature('tiki_monitor_performance');
$access->check_permission('tiki_p_admin');

if (! empty($_REQUEST['clear']) && $access->checkCsrf()) {
    $performanceLib->clearPerformanceRecords();
}

$find = $_REQUEST['find'] ?? '';
$averageStatOffset = $_REQUEST['average_stat_offset'] ?? 0;
$averageStatOrder = $_REQUEST['average_stat_order'] ?? 'DESC';
$maximumStatOffset = $_REQUEST['maximum_stat_offset'] ?? 0;
$maximumStatOrder = $_REQUEST['maximum_stat_order'] ?? 'DESC';

$smarty->assign('performance_stats_lib', $performanceLib);
$smarty->assign('find', $find);
$smarty->assign('cant_pages', $performanceLib->getRequestsGroupedByAmount());
$smarty->assign_by_ref('average_stat_offset', $averageStatOffset);
$smarty->assign_by_ref('average_stat_order', $averageStatOrder);
$smarty->assign_by_ref('maximum_stat_offset', $maximumStatOffset);
$smarty->assign_by_ref('maximum_stat_order', $maximumStatOrder);
$smarty->assign_by_ref('average_load_time_stats', $performanceLib->getRequestsBasedOnAverageRequestTime(25, $averageStatOffset, $find, $averageStatOrder)->result);
$smarty->assign_by_ref('maximum_load_time_stats', $performanceLib->getRequestsBasedOnMaximumProcessingTime(25, $maximumStatOffset, $find, $maximumStatOrder)->result);
$smarty->assign('mid', 'tiki-performance_stats.tpl');
$smarty->display("tiki.tpl");
