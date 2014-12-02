<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

if (!defined('RCX_ROOT_PATH')) {
	exit();
}
include_once('class.linker.php');

   class Toolbar {
        var $forum = 0;
		var $forum_name = '';
        var $topic_id = 0;
        var $topic_name = '';
         
        function ToolBar($forum, $forum_name, $topic_id = 0, $topic_name = '')
        {
            $this->forum = $forum;
			$this->forum_name = $forum_name;
            $this->topic_id = $topic_id;
            $this->topic_name = $topic_name;
        }
         
        function display()
        {
            global $bbPath, $_GET;
     include('hover.css');
            if (intval($this->topic_id) == 0)
            {
?>
<table border="0" cellpadding="0" cellspacing="0" align="center" valign="top" width="100%"><tr><td class="bg2">
<table border="0" cellpadding="4" cellspacing="1" width="100%">
<tr class="bg4">
<td class="bg4" width="100%">
<b><?php echo $this->forum_name; ?></b>
</td><td class="bg4" width="75" align="right">
<?php echo $this->forum_tools_menu(); ?>
</td>
</tr></table>
</td></tr></table>
<?php
            }
			else
			{
?>
<table border="0" cellpadding="0" cellspacing="0" align="center" valign="top" width="100%"><tr><td class="bg2">
<table border="0" cellpadding="4" cellspacing="1" width="100%">
<tr class="bg4">
<td class="bg4" width="100%">
<b><?php echo $this->topic_name; ?></b>
</td>
</td>
<td class="bg4" width="100%">
<?php echo $this->mail_tools_menu(); ?>
</td>
<td class="bg4"  width="100%">
<?php echo $this->topic_tools_menu(); ?>
</td>
<td class="bg4" width="100%">
<?php echo $this->display_modes_menu(); ?>
</td>


</tr></table>
</td></tr></table>
<?php
			}
        }

		function forum_tools_menu()
		{
			global $bbPath;
			$ftools  = '<div id="fdivers"><ul id="ftopmenu" >';
			$ftools .= '	<li><a href="viewforum.php?forum='.$this->forum.'&amp;mark=topics" ><img src="'.$bbPath['images'].'/read.gif" alt="'._MD_MARK_READ.'" /></a></li><li><a href="newtopic.php?forum='.$this->forum.'"><img src="'.$bbPath['images'].'/new.gif" alt="'._MD_NEW_TOPIC.'" /></a></li></ul>';
			$ftools .= '</div>';
			return $ftools;
		}

		function topic_tools_menu()
		{
			global $bbPath, $topicnotif, $rcxUser;
			
			$ttools  = '<div id="fdivers"><ul id="ftopmenu" >
			<li><a href="print.php?forum='.$this->forum.'&topic_id='.$this->topic_id.'"><img src="'.$bbPath['images'].'/print.gif" alt="'._MD_PRINT_TOPIC.'" /></a></li><li><a href="'.Linker::mailto_topic_href($this->topic_id, $this->forum).'"><img src="'.$bbPath['images'].'/email.gif" alt="'._MD_EMAIL_TOPIC.'" /></a></li></ul></div>';

		 		return $ttools;
		}
				function mail_tools_menu()
		{
			global $bbPath, $topicnotif, $rcxUser;

				
				if ( $rcxUser )
			{
				if ( $topicnotif ['email_notify'] == 1 )
				{
						$mtools = '<div id="mdivers"><ul id="ftopmenu" >	
						<li ><a  href="viewtopic.php?topic_id='.$this->topic_id.'&flag_mail=2&amp;forum='.$this->forum.'"><img src="'.$bbPath['images'].'/topic_notifyoff.gif" alt="'._MD_UNSUBSCRIBE.'" align="left"/></a></li></ul></div>';
				}
				else
				{
					$mtools = '<div id="mdivers"><ul id="ftopmenu" >		
					<li ><a   href="viewtopic.php?topic_id='.$this->topic_id.'&flag_mail=1&amp;forum='.$this->forum.'"><img src="'.$bbPath['images'].'/topic_notifyon.gif" alt="'._MD_SUBSCRIBE.'" align="left"/></a></li></ul></div>';
				} 
			}


	

			return $mtools;
		}

		function display_modes_menu()
		{
			global $bbPath, $_GET;
			
			$vars = '';
			foreach($_GET as $var=>$val)
			{
				if($var != 'viewmode')
					$vars .= $var.'='.$val.'&';
			}
			
			$modes  = '<div id="fdivers"><ul id="ftopmenu" ><li><a  href="viewtopic.php?'.$vars.'viewmode=flat&order=1"><img src="'.$bbPath['images'].'/mode_flat_new.gif" alt="'._MD_FLAT_NEWFIRST.'" /></a></li><li><a href="viewtopic.php?'.$vars.'viewmode=flat&order=0"><img src="'.$bbPath['images'].'/mode_flat_old.gif" alt="'._MD_FLAT_OLDFIRST.'" /></a></li><li id="ftopmenu" ><a href="viewtopic.php?'.$vars.'viewmode=thread"><img src="'.$bbPath['images'].'/mode_threaded.gif" alt="'._MD_THREADED.'" /></a></li></ul></div>';
		
	

			return $modes;
		}
  }
?>
