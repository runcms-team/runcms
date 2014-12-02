<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
include_once("header.php");

if (!isset($forum))
{
	redirect_header("index.php", 2, _MD_ERRORFORUM);
	exit();
}

if (!isset($poll_id))
{
	redirect_header("viewforum.php?forum=$forum", 2, _MD_ERRORPOST);
	exit();
}

if (!$rcxUser || !$rcxUser->isAdmin() || !is_moderator($forum, $rcxUser->getVar('uid')) )
{
	redirect_header("viewforum.php?forum=$forum", 2, _MD_ERRORPOST);
	exit();
}

include_once(RCX_ROOT_PATH."/header.php");
include_once($bbPath['path']."class/forumpoll.php");
include_once($bbPath['path']."class/forumpolloption.php");
include_once($bbPath['path']."class/forumpollrenderer.php");

$poll = new ForumPoll($poll_id);

if($_POST['update_question'])
{
	$poll->setVar('question', $_POST['poll_question']);
	$poll->store();

}

if($_POST['del_option'])
{
	$del_opt = key($_POST['del_option']);

	$all_opts =& ForumPollOption::getAllByPollId($poll_id);
	for ($i=0; $i<count($all_opts); $i++)
	{
		if($all_opts[$i]->getVar('option_id') == $del_opt)
		{
			$all_opts[$i]->delete();
			break;
		}
	}
}

if($_POST['update_option'])
{
	$update_opt = key($_POST['update_option']);

	$opt = new ForumPollOption($update_opt);
	$opt->setVar('option_text', $option[$update_opt]);
	$opt->setVar('option_color', $bar_color[$update_opt]);
	$opt->store();
}

if($_POST['add_option'])
{
	$new_opt = $_POST['new_option'];
	$new_col = $_POST['new_bar_color'];

	$opt = new ForumPollOption();
	$opt->setVar('poll_id', $poll_id);
	$opt->setVar('option_text', $new_opt);
	$opt->setVar('option_color', $new_col);
	$opt->store();
}

if($_POST['update_expdate'])
{
	$poll_exp_day = $_POST['poll_exp_day'];
	$poll_exp_month = $_POST['poll_exp_month'];
	$poll_exp_year = $_POST['poll_exp_year'];
	$poll->setVar('end_time', mktime(0,0,0,$poll_exp_month,$poll_exp_day,$poll_exp_year));
	$poll->store();	
}

$renderer = new ForumPollRenderer($poll);
echo '<table width="100%">';
echo '<tr><td>';
echo $renderer->renderResults();
echo "</td></tr></table><br>";
	
$option = array();
$option_id = array();
$bar_color = array();

$curr_opts =& ForumPollOption::getAllByPollId($poll_id);
for ($i=0; $i<count($curr_opts); $i++)
{
	$option[$i] = $curr_opts[$i]->getVar('option_text');
	$option_id[$i] = $curr_opts[$i]->getVar('option_id');
	$bar_color[$i] = $curr_opts[$i]->getVar('option_color');
}
	
echo "<form action='edit_poll.php' method='post' name='editpollform' id='editpollform'>";
echo "<input type='hidden' name='forum' value='$forum'>";
echo "<input type='hidden' name='poll_id' value='$poll_id'>";
	
echo "<table>";
echo "<tr>";
echo "<td>"._MD_POLLQUESTION.":</td><td><input type='text' name='poll_question' value='".$poll->getVar('question')."' size='60' class='text'/>&nbsp;&nbsp;<input type='submit' class='button' name='update_question' value='"._UPDATE."'</td>\n"; 
echo "</tr>";
$cpt=0;
for($i=0;$i<count($option);$i++)
{ 
	$optiontxt=$option[$i];
	if(($option[$i]!=""))
	{
		echo "<tr>";
		echo "<td>"._MD_POLLOPTIONS.":</td><td><input type='text' class='text' name='option[".$option_id[$cpt]."]' value=\"".$option[$i]."\" size='60' />&nbsp;&nbsp;".print_colorbar_combo('bar_color['.$option_id[$cpt].']', $bar_color[$i])."&nbsp;&nbsp;<input type='submit' name='update_option[".$option_id[$cpt]."]' value=\""._UPDATE."\" class=\"button\" />&nbsp;&nbsp;<input type='submit' name='del_option[".$option_id[$cpt]."]' value=\""._DELETE."\" class=\"button\" /></td>\n"; 
		echo "</tr>";
		$cpt++;
	}
}
echo "<tr>";
echo "<td>"._MD_POLLOPTIONS.":</td><td><input type='text' class='text' name='new_option' size='60' />&nbsp;&nbsp;".print_colorbar_combo('new_bar_color')."&nbsp;&nbsp;<input type='submit' name='add_option' value=\""._MD_ADDPOLLOPTION."\" class=\"button\"/></td>\n";
echo "</tr>";
echo "<tr>";
echo "<td>"._MD_POLLEXPIRETIME.":</td><td>".date_editor($poll->getVar('end_time'))."</td>\n";
echo "</tr>";
echo "</table>";

echo "<br><a href='./viewtopic.php?topic_id=".$poll->getVar('topic_id')."&amp;forum=$forum'><b>"._MD_BACK_TO_TOPIC."</b></a>";
	
include_once(RCX_ROOT_PATH."/footer.php");


function date_editor($sel_date)
{
	$content = '';
	$sel_day = date("d",$sel_date);
	$sel_month = date("m",$sel_date);
	$sel_year = date("Y",$sel_date);
	
	$content .= '<select name="poll_exp_day" class="select">';
	for($i=1; $i<=31; $i++)
	{
		if ($i==intval($sel_day))
			$content .= "<option selected>$i</option>";
		else
			$content .= "<option>$i</option>";
	}
	$content .= '</select>&nbsp;/&nbsp;';
	$content .= '<select name="poll_exp_month" class="select">';
	for($i=1; $i<=12; $i++)
	{
		if ($i==intval($sel_month))
			$content .= "<option selected>$i</option>";
		else
			$content .= "<option>$i</option>";

	}
	$content .= '</select>&nbsp;/&nbsp;';
	
	$curr_year = date("Y");
	$content .= '<select name="poll_exp_year" class="select">';
	for($i=0; $i<5; $i++)
	{
		if (($curr_year+$i)==intval($sel_year))
			$content .= '<option selected>'.($curr_year+$i).'</option>';
		else
			$content .= '<option>'.($curr_year+$i).'</option>';
	}
	$content .= '</select>';
	$content .= "&nbsp;&nbsp;<input type='submit' name='update_expdate' value=\""._UPDATE."\" class=\"button\" />";
	return $content;
}
?>
