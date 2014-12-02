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
include_once('class.topictable.php');

class SimilarThreads
{
	var $topic_id = 0;
	var $keywords;

	function SimilarThreads($topic_id, $keywords)
	{
		$this->topic_id = $topic_id;
		$this->keywords = $keywords;
	}

	function display()
	{
		global $db, $bbTable, $rcxConfig;

        $sql = "SELECT t.*, p.* FROM ".$bbTable['topics']." t
                        LEFT JOIN ".$bbTable['posts']." p
                        ON p.post_id=t.topic_last_post_id
						WHERE (";
		
		for($i=0; $i<count($this->keywords); $i++)
		{
			$word = $this->keywords[$i];
			if ($i != 0) $sql .= " OR ";
			$sql .= "t.topic_title LIKE '%$word%'";
		
		}
		$sql .=") ORDER BY t.topic_time DESC";

		// Select 20 but only find the first 5, some may be filtered out
		// by permissions.
		$result = $db->query($sql, 20);
	
		if (!$result) echo "$sql<br>".$db->error()."<br>";
		$count = 0;
		$topictable = new TopicTable(10, 100000,false);
		while($row = $db->fetch_object($result))
		{
			if ($row->topic_id != $this->topic_id)
			{
				$perm = new Permissions($row->forum_id);
				if($perm->can_view)
				{
					$topictable->addTopic($row);
					$count++;
				}
			}

			if ($count == 5) break;
		}
		if($count > 0)
		{
			ToggleBlockRenderer::render('similar_threads', _MD_SIMILAR_THREADS, '', $topictable->getHTML());
		}
	}
}
?>
