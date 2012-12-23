<?php 
	error_reporting (E_ALL);
$messages = Array (
 "noFollow" => Array (
	0 => " <font color=red><b> 没有找到入口。</b></font>. ",
	1 => " 没有找到入口。"
 ),
 "inDatabase" => Array (
	0 => " <font color=red><b> 已经在数据库中</b></font><br>",
	1 => " 已经在数据库中\n"
 ),
 "completed" => Array (
	0 => "<br>完成于 %cur_time.\n<br>",
	1 => "完成于 %cur_time.\n"
 ),
 "starting" => Array (
	0 => " 索引开始于 %cur_time.\n",
	1 => " 索引开始于 %cur_time.\n"
	 ),
 "quit" => Array (
	0 => "</body></html>",
	1 => ""
 ),
 "pageRemoved" => Array (
	0 => " <font color=red>从索引中排除页面。</font><br>\n",
	1 => " 从索引中排除页面。\n"
 ),
  "continueSuspended" => Array (
	0 => "<br>继续暂停的索引。<br>\n",
	1 => "继续暂停的索引。\n"
 ),
  "indexed" => Array (
	0 => "<br><b> <font color=\"green\">索引完成。</font></b><br>\n",
	1 => " \n索引完成。\n"
 ),
"duplicate" => Array (
	0 => " <font color=\"red\"><b>页面重复。</b></font><br>\n",
	1 => " 页面重复。\n"
 ),
"md5notChanged" => Array (
	0 => " <font color=\"red\"><b>MD5 检测，页面无改变。</b></font><br>\n",
	1 => " MD5 检测，页面无改变。\n"
 ),
"metaNoindex" => Array (
	0 => " <font color=\"red\">在meta标签中没有索引标签。</font><br>\n",
	1 => " 在meta标签中没有索引标签。\n"
 ),
  "re-indexed" => Array (
	0 => " <font color=\"green\">重新索引</font><br>\n",
	1 => " 重新索引\n"
 ),
"minWords" => Array (
	0 => " <font color=\"red\">页面包含少于设定的 $min_words_per_page 个关键词。</font><br>\n",
	1 => " 页面包含少于设定的 $min_words_per_page 个关键词。\n"
 )
);

function printRobotsReport($num, $thislink, $cl) {
	global $print_results, $log_format;
	$log_msg_txt = "$num. 链接 $thislink：在robots.txt 文件中被列为禁止索引。\n";
	$log_msg_html = "<b>$num</b>. 链接 <b>$thislink</b>：<font color=red>：在robots.txt 文件中被列为禁止索引。</font></br>";
	if ($print_results) {
		if ($cl==0) {
			print $log_msg_html; 
		} else {
			print $log_msg_txt;
		}
		flush();
	}
	if ($log_format=="html") {
		writeToLog($log_msg_html);
	} else {
		writeToLog($log_msg_txt);
	}

}

function printUrlStringReport($num, $thislink, $cl) {
	global $print_results, $log_format;
	$log_msg_txt = "$num. 链接 $thislink：文件被 required/disallowed 索引规则禁止。\n";
	$log_msg_html = "<b>$num</b>. 链接 <b>$thislink</b>：<font color=red>文件被 required/disallowed 索引规规禁止。</font></br>";
	if ($print_results) {
		if ($cl==0) {
			print $log_msg_html;
		} else {
			print $log_msg_txt;
		}
		flush();
	}

	if ($log_format=="html") {
		writeToLog($log_msg_html);
	} else {
		writeToLog($log_msg_txt);
	}
}

function printRetrieving($num, $thislink, $cl) {
	global $print_results, $log_format;
	$log_msg_txt = "$num. 检索： $thislink 于 " . date("H:i:s")."。\n";
	$log_msg_html = "<b>$num</b>. 检索：<b>$thislink</b> 于 " . date("H:i:s")."。<br>\n";
	if ($print_results) {
		if ($cl==0) {
			print $log_msg_html;
		} else {
			print $log_msg_txt;
		}
		flush();
	}

	if ($log_format=="html") {
		writeToLog($log_msg_html);
	} else {
		writeToLog($log_msg_txt);
	}
}


function printLinksReport($numoflinks, $all_links, $cl) {
	global $print_results, $log_format;
	$log_msg_txt = " $all_links 条链接被找到。 新链接：$numoflinks 被找到。\n";
	$log_msg_html = " <font color=\"blue\"><b>$all_links</b>条链接被找到</font>。 新链接：<font color=\"blue\"><b>$numoflinks</b></font>条被找到。<br>\n";
	if ($print_results) {
		if ($cl==0) {
			print $log_msg_html;
		} else {
			print $log_msg_txt;
		}
		flush();
	}

	if ($log_format=="html") {
		writeToLog($log_msg_html);
	} else {
		writeToLog($log_msg_txt);
	}
}

function printHeader($omit, $url, $cl) {
	global $print_results, $log_format;

	if (count($omit) > 0 ) {
		$urlparts = parse_url($url);
		foreach ($omit as $dir) {			
			$omits[] = $urlparts['scheme']."://".$urlparts['host'].$dir;
		}
	}
	
	$log_msg_txt = "索引 $url\n";
	if (count($omit) > 0) {
		$log_msg_txt .= "在robots.txt中禁止被索引的文件和目录：\n";
		$log_msg_txt .= implode("\n", $omits);
		$log_msg_txt .= "\n\n";
	}

	$log_msg_html_1 = "<html><head><LINK REL=STYLESHEET HREF=\"admin.css\" TYPE=\"text/css\"></head>\n";
	$log_msg_html_1 .= "<body style=\"font-family:Verdana, Arial; font-size:12px\">";
	
	$log_msg_html_link = "[返回到 <a href=\"admin.php\">管理员控制面板</a>]";
	$log_msg_html_2 = "<p><font size=\"+1\">索引 <b>$url</b></font></p>\n";

	if (count($omit) > 0) {
		$log_msg_html_2 .=  "在robots.txt中禁止被索引的文件和目录：<br>\n";
		$log_msg_html_2 .=  implode("<br>", $omits);
		$log_msg_html_2 .=  "<br><br>";
	}

	if ($print_results) {
		if ($cl==0) {
			print $log_msg_html_1.$log_msg_html_link.$log_msg_html_2;
		} else {
			print $log_msg_txt;
		}
		flush();
	}

	if ($log_format=="html") {
		writeToLog($log_msg_html_1.$log_msg_html_2);
	} else {
		writeToLog($log_msg_txt);
	}
}

function printPageSizeReport($pageSize) {
	global $print_results, $log_format;
	$log_msg_txt = "页面大小：$pageSize"."kb. ";
	if ($print_results) {
		print $log_msg_txt;
		flush();
	}

	writeToLog($log_msg_txt);
}

function printUrlStatus($report, $cl) {
	global $print_results, $log_format;
	$log_msg_txt = "$report\n";
	$log_msg_html = " <font color=red><b>$report</b></font><br>\n";
	if ($print_results) {
		if ($cl==0) {
			print $log_msg_html; 
		} else {
			print $log_msg_txt;
		}
		flush();
	}
	if ($log_format=="html") {
		writeToLog($log_msg_html);
	} else {
		writeToLog($log_msg_txt);
	}

}



function printConnectErrorReport($errmsg) {
	global $print_results, $log_format;
	$log_msg_txt = "建立 socket 连接失败 ";
	$log_msg_txt .= $errmsg;

	if ($print_results) {
		print $log_msg_txt;
		flush();
	}

	writeToLog($log_msg_txt);
}



function writeToLog($msg) {
	global $keep_log, $log_handle;
	if($keep_log) {
		if (!$log_handle) {
			die ("记录日志文件无法打开。 ");
		}

		if (fwrite($log_handle, $msg) === FALSE) {
			die ("记录日志文件无法写入。 ");
		}
	}
}


function printStandardReport($type, $cl) {
	global $print_results, $log_format, $messages;
	if ($print_results) {
		print str_replace('%cur_time', date("H:i:s"), $messages[$type][$cl]);
		flush();
	}

	if ($log_format=="html") {
		writeToLog(str_replace('%cur_time', date("H:i:s"), $messages[$type][0]));
	} else {
		writeToLog(str_replace('%cur_time', date("H:i:s"), $messages[$type][1]));
	}

}


?>