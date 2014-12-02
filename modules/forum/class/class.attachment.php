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
class Attachment
{
	var $attach_id = 0;
	var $post_id;
	var $file_name;
	var $file_pseudoname;
	var $file_size;
	var $file_hits;
	var $is_approved = 0;

	function Attachment($db_row = false)
	{
		if ($db_row)
		{
			$this->attach_id		= $db_row->attach_id;
			$this->post_id			= $db_row->post_id;
			$this->file_name		= $db_row->file_name;
			$this->file_pseudoname	= $db_row->file_pseudoname;
			$this->file_size		= $db_row->file_size;
			$this->file_hits		= $db_row->file_hits;
			$this->is_approved		= $db_row->is_approved;
		}
	}

	function getByID($attach_id)
	{
		global $db, $bbTable;

		$sql = "SELECT * FROM ".$bbTable['attachments']." WHERE attach_id=$attach_id";
		$result = $db->query($sql);

		$ret = false;
		if ($result)
		{
			$row = $db->fetch_object($result);
			$ret = new Attachment($row);
		}
		return $ret;
	}

	function getAllByPost($post_id, $bIncludeUnapproved = 0)
	{
		global $db, $bbTable;

		$sql = "SELECT * FROM ".$bbTable['attachments']." WHERE post_id=$post_id";
		if (!$bIncludeUnapproved)
		{
			$sql .= " AND is_approved=1";
		}

		$result = $db->query($sql);

		$ret = array();
		if ($result)
		{
			while($row = $db->fetch_object($result))
			{
				$ret[] = new Attachment($row);
			}
		}
		return $ret;
	}

	function showAttachment()
	{
		global $bbPath, $forumConfig, $bbImage;

		$content = '';

		// If it's an image... display it!
		$info = pathinfo($bbPath['path'].'cache/attachments/'.$this->file_pseudoname);
		if($info && ($info["extension"] == 'gif' || $info["extension"] == 'jpg' || $info["extension"] == 'png' || $info["extension"] == 'jpeg'))
		{
			$maxwidth = $forumConfig['max_img_width'];
			$imagehw = @GetImageSize($bbPath['path'].'cache/attachments/'.$this->file_pseudoname);
			$imagewidth = $imagehw[0];
			$imageheight = $imagehw[1];
			$imgorig = $imagewidth;
			if ($imagewidth > $maxwidth)
			{
				$imageprop=($maxwidth*100)/$imagewidth;
				$imagevsize= ($imageheight*$imageprop)/100 ;
				$imagewidth=$maxwidth; 
				$imageheight=ceil($imagevsize);
			}
			$content .='<br><a href="'.$bbPath['url'].'cache/attachments/'.$this->file_pseudoname.'" target="new"><img src="'.$bbPath['url'].'cache/attachments/'.$this->file_pseudoname.'" alt="#" border="0" width="'.$imagewidth.'" height="'.$imageheight.'"></a><br><br>';	
		}

		// Download Link
		$content .='<a href="'.$bbPath['url'].'dl_attachment.php?attach_id='.$this->attach_id.'"><img src="'.$bbImage['attachment'].'" alt="#" border="0"> '.$this->file_name.'</a> ('.sprintf(_MD_FILESIZE,$this->file_size/1024).'</i>; '.$this->file_hits.' '._MD_HITS.')';	

		return $content;
	}

	function store()
	{
		global $db, $bbTable;

		if ($this->attach_id == 0)
		{
			$sql  = "INSERT INTO ".$bbTable['attachments']." SET ";
			$sql .= "post_id=".$this->post_id.", ";
			$sql .= "file_name='".$this->file_name."', ";
			$sql .= "file_pseudoname='".$this->file_pseudoname."', ";
			$sql .= "file_size=".$this->file_size.", ";
			$sql .= "is_approved=".$this->is_approved;
		}
		else
		{
			$sql = "UPDATE ".$bbTable['attachments']." SET ";
			$sql .= "post_id=".$this->post_id.", ";
			$sql .= "file_name='".$this->file_name."', ";
			$sql .= "file_pseudoname='".$this->file_pseudoname."', ";
			$sql .= "file_size=".$this->file_size.", ";
			$sql .= "file_hits=".$this->file_hits.", ";
			$sql .= "is_approved=".$this->is_approved;
			$sql .= " WHERE attach_id=".$this->attach_id;
		}
		
		$result = $db->query($sql);
		if (!$result)
		{
			echo $sql."<br>".$db->error()."<br>";
		}
		return $result;
	}

	function download()
	{
		global $bbPath;
		if(!file_exists($bbPath['path'].'cache/attachments/'.$this->file_pseudoname))
		{
			die(_MD_NO_SUCH_FILE);
		}

		$this->incrementHitCount();

		header("Content-type: ".$this->file_size);
		header("Content-Disposition: attachment; filename=".$this->file_name);
		readfile($bbPath['path'].'cache/attachments/'.$this->file_pseudoname);

	}

	function incrementHitCount()
	{
		$this->file_hits = $this->file_hits + 1;
		return $this->store();
	}

	function delete()
	{
		global $db, $bbTable, $bbPath;

		$sql = "DELETE FROM ".$bbTable['attachments']." WHERE attach_id=".$this->attach_id;
		if ($db->query($sql))
		{
			$this->deletePseudoFile();
		}
		else
		{
			echo $sql."<br>".$db->error()."<br>";
		}

	}

	function deletePseudoFile()
	{
		global $bbPath;

		@unlink($bbPath['path'].'cache/attachments/'.$this->file_pseudoname);
	}

	function isImage()
	{
		global $bbPath;

		$bImage = false;
		// If it's an image... display it!
		$info = pathinfo($bbPath['path'].'cache/attachments/'.$this->file_pseudoname);
		if($info && ($info["extension"] == 'gif' || $info["extension"] == 'jpg' || $info["extension"] == 'png' || $info["extension"] == 'jpeg'))
		{
			$bImage = true;
		}
		return $bImage;
	}
}

?>