<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
include_once("admin_header.php");
include_once(RCX_ROOT_PATH."/class/rcxtopic.php");
include_once(RCX_ROOT_PATH."/modules/news/class/class.newsstory.php");
include_once(RCX_ROOT_PATH."/class/module.errorhandler.php");
include_once(RCX_ROOT_PATH."/modules/news/cache/config.php");
/**
* Show new submissions
*
* @param type $var description
* @return type description
*/
function newSubmissions()
{
  global $rcxConfig, $db;
  $storyarray = NewsStory::getAllSubmitted();
  if (count($storyarray) > 0)
  {
      
      echo '
            <div class="KPstor" >'._AM_NEWSUB.'</div>
            <br />
            <br />';      
      
    OpenTable();
    echo "<div style='text-align: center;'><table width='100%' border='1'><tr class='bg2'><td align='center'>"._AM_TITLE."</td><td align='center'>"._AM_POSTED."</td><td align='center'>"._AM_POSTER."</td><td align='center'>"._ACTION."</td></tr>";
    foreach ($storyarray as $newstory)
    {
      echo "<tr><td>";
      $title = $newstory->title();
      if (!isset($title) || ($title == ""))
      {
        echo "<a href='index.php?op=edit&amp;storyid=".$newstory->storyid()."'>"._AM_NOSUBJECT."</a>";
      }
      else
      {
        echo "&nbsp;<a href='index.php?op=edit&amp;storyid=".$newstory->storyid()."'>".$title."</a>";
      }
      echo "</td><td align='center'>".formatTimestamp($newstory->created())."</td><td align='center'><a href='".RCX_URL."/userinfo.php?uid=".$newstory->uid()."'>".$newstory->uname()."</a></td><td align='right'><a href='index.php?op=delete&amp;storyid=".$newstory->storyid()."'>"._DELETE."</a></td></tr>";
    }
    echo "</table></div>";
    CloseTable();
    echo "<br />";
  }
}
/**
* Description
*
* @param type $var description
* @return type description
*/
/*
 * Shows automated stories
 */
function autoStories()
{
  global $db, $rcxConfig, $rcxModule;
  $storyarray = NewsStory::getAllAutoStory();
  if (count($storyarray) > 0)
  {
      
   echo '
            <div class="KPstor" >'._AM_AUTOARTICLES.'</div>
            <br />
            <br />';    
      
    OpenTable();
    echo "
      <div style='text-align: center;'>
      <table border='1' width='100%'>
      <tr class='bg2'>
        <td align='center'>"._AM_STORYID."</td>
        <td align='center'>"._AM_TITLE."</td>
        <td align='center'>"._AM_TOPIC."</td>
        <td align='center'>"._AM_POSTER."</td>
        <td align='center'>"._AM_PROGRAMMED."</td>
        <td align='center'>"._ACTION."</td>
      </tr>";
    foreach ($storyarray as $autostory)
    {
      $topic = $autostory->topic();
      echo "
      <tr>
      <td align='center'><b>".$autostory->storyid()."</b></td>
      <td align='left'><a href='".RCX_URL."/modules/news/article.php?storyid=".$autostory->storyid()."'>".$autostory->title()."</a></td>
      <td align='center'>".$topic->topic_title()."</td>
      <td align='center'><a href='".RCX_URL."/userinfo.php?uid=".$autostory->uid()."'>".$autostory->uname()."</a></td><td align='center'>".formatTimestamp($autostory->published())."</td><td align='center'><a href='index.php?op=edit&amp;storyid=".$autostory->storyid()."'>"._EDIT."</a>-<a href='index.php?op=delete&amp;storyid=".$autostory->storyid()."'>"._DELETE."</a></td>
      </tr>";
    }
    echo "</table></div>";
    CloseTable();
    echo "<br />";
  }
}
/**
* Description
*
* @param type $var description
* @return type description
*/
/*
 * Shows last 10 published stories
 */
function lastStories()
{
  global $db, $rcxConfig, $rcxModule;
  
echo '
            <div class="KPstor" >'._AM_LAST10ARTS.'</div>
            <br />
            <br />';  
  
  OpenTable();

 echo "
    <div style='text-align: center;'>";
  $storyarray = NewsStory::getAllPublished(10, 0, 0, 1);
  echo "
    <table border='1' width='100%'>
    <tr class='bg2'>
      <td align='center'>"._AM_STORYID."</td>
      <td align='center'>"._AM_TITLE."</td>
      <td align='center'>"._AM_TOPIC."</td>
      <td align='center'>"._AM_POSTER."</td>
      <td align='center'>"._AM_PUBLISHED."</td>
      <td align='center'>"._ACTION."</td>
    </tr>";
  foreach ($storyarray as $eachstory)
  {
    $published = formatTimestamp($eachstory->published());
    $topic = $eachstory->topic();
    echo "
    <tr>
      <td align='center'><b>".$eachstory->storyid()."</b></td>
      <td align='left'><a href='".RCX_URL."/modules/news/article.php?storyid=".$eachstory->storyid()."'>".$eachstory->title()."</a></td>
      <td align='center'>".$topic->topic_title()."</td>
      <td align='center'><a href='".RCX_URL."/userinfo.php?uid=".$eachstory->uid()."'>".$eachstory->uname()."</a></td>
      <td align='center'>".$published."</td>
      <td align='center'><a href='index.php?op=edit&amp;storyid=".$eachstory->storyid()."'>"._EDIT."</a>-<a href='index.php?op=delete&amp;storyid=".$eachstory->storyid()."'>"._DELETE."</a></td>
    </tr>";
  }
  echo "
  </table><br />
  <form action='index.php' method='post'>"._AM_STORYID." <input type='text' class='text' name='storyid' size='10' />
    <select class='select' name='op'>
      <option value='edit' selected='selected'>"._EDIT."</option>
      <option value='delete'>"._DELETE."</option>
    </select>
    <input type='submit' class='button' value='"._GO."' />
  </form>
  </div>";
  CloseTable();
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function topicsmanager()
{
  global $db, $rcxConfig, $rcxModule;
  rcx_cp_header();
  $xt = new RcxTopic($db->prefix("topics"));
  // Add a New Main Topic
  
echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" class="fbund">
    <tr>
        <td class="KPindex">
            <div class="KPstor" >'._AM_ADDMTOPIC.'</div>
            <br />
            <br />';

  OpenTable();
  echo "
    <form method='post' action='index.php'>
      <b>"._AM_TOPICNAME."</b> "._AM_MAX40CHAR."
      <br />
      <input type='text' class='text' name='topic_title' size='20' maxlength='255' />
      <br />
      <br />
      <input type='hidden' name='topic_pid' value='0' />
      <input type='hidden' name='op' value='addTopic' />
      <input type='submit' class='button' value="._ADD." /><br /></form>";
  CloseTable();
  echo "<br />";
  // Add a New Sub-Topic
  $result = $db->query("SELECT COUNT(*) FROM ".$db->prefix("topics"));
  list($numrows) = $db->fetch_row($result);
  if ($numrows>0)
  {
      
echo '<div class="KPstor" >'._AM_ADDSUBTOPIC.'</div>
            <br />
            <br />';      
      
    OpenTable();
    echo "
    <form method='post' action='index.php'>
      <b>"._AM_TOPICNAME."</b> "._AM_MAX40CHAR."
      <br />
      <input type='text' class='text' name='topic_title' size='20' maxlength='255' /> &nbsp;"._AM_IN." &nbsp;";
    $xt->makeTopicSelBox(0, 0, 'topic_pid');
    echo "
      <br />
      <br />
      <input type='hidden' name='op' value='addTopic' />
      <input type='submit' class='button' value='"._ADD."' /><br /></form>";
    CloseTable();
    echo "<br />";
  // Modify Topic
    
echo '<div class="KPstor" >'._AM_MODIFYTOPIC.'</div>
            <br />
            <br />';    
    
    OpenTable();
    echo "
    <form method='post' action='index.php'>
      <b>"._AM_TOPIC."</b>
      <br />";
      $xt->makeTopicSelBox();
    echo "
      <br />
      <br />
      <input type='hidden' name='op' value='modTopic' />
      <input type='submit' class='button' value='"._MODIFY."' />
    </form></td>";
    CloseTable();
    
echo "                        
        </td>
    </tr>
</table>";   
  }
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function modTopic()
{
  global $db, $rcxConfig, $rcxOption, $newsConfig, $rcxModule;
  $topic_id = (int)$_REQUEST['topic_id'];// ? $_POST['topic_id'] : $_GET['topic_id'];
  $xt = new RcxTopic($db->prefix("topics"), $topic_id);
  rcx_cp_header();
  
echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" class="fbund">
    <tr>
        <td class="KPindex">
            <div class="KPstor" >'._AM_MODIFYTOPIC.'</div>
            <br />
            <br />';  
  
  OpenTable();
  ?>

  <?php
  if ($xt->topic_imgurl())
  {
    echo "
    <div style='text-align: right;'>
      <img src='".formatURL(RCX_URL."/modules/news/cache/topics/", $xt->topic_imgurl())."'>
    </div>";
  }
  ?>
    <form action="index.php" method="post" enctype="multipart/form-data">
      <b><?php echo _AM_TOPICNAME;?></b> <?php echo _AM_MAX40CHAR;?>
      <br />
      <input type="text" class="text" name="topic_title" size="30" maxlength="255" value="<?php echo $xt->topic_title();?>" />
      <br />
      <br />
      <b><?php echo _AM_TOPICIMG;?></b>
      <br />
      <input type="text" class="text" name="topic_imgurl" size="30" maxlength="255" value="<?php echo $xt->topic_imgurl();?>" /> :: <input type="file" class="file" name="image" />
      <br />
      <?php printf(_AM_IMGLOCATION, "modules/news/cache/topics/");?>
      <br />
      <br />
      <b><?php echo _AM_PARENTTOPIC; ?><b>
      <br />
      <?php $xt->makeTopicSelBox(1, $xt->topic_pid(), "topic_pid");?>
      <br />
      <br />
      <input type="hidden" name="topic_id" value="<?php echo $xt->topic_id();?>" />
      <input type="hidden" name="op" value="modTopicS" />
      <input type="submit" class="button" value="<?php echo _SAVE;?>" />
      <input type="button" class="button" value="<?php echo _DELETE;?>" onclick="location='index.php?topic_pid=<?php echo $xt->topic_pid();?>&amp;topic_id=<?php echo $xt->topic_id();?>&amp;op=delTopic'" />
      <input type="button" class="button" value="<?php echo _CANCEL;?>" onclick="javascript:history.go(-1)" />
    </form>
  <?php
  CloseTable();
  
  echo "                        
        </td>
    </tr>
</table>";
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function modTopicS()
{
  global $db;
  $xt = new RcxTopic($db->prefix("topics"), (int)$_REQUEST['topic_id']);
  if ((int)$_REQUEST['topic_pid'] == (int)$_REQUEST['topic_id'])
  {
    echo "ERROR: Cannot select this topic for parent topic!";
    exit();
  }
  $xt->setTopicPid($_REQUEST['topic_pid']);
  $xt->setTopicTitle($_REQUEST['topic_title']);
  $xt->setTopicImgurl($_REQUEST['topic_imgurl']);
  if (!empty($_FILES['image']['name']))
  {
    include_once(RCX_ROOT_PATH."/class/fileupload.php");
    $upload = new fileupload();
    $upload->set_upload_dir(RCX_ROOT_PATH."/modules/news/cache/topics/", 'image');
    $upload->set_accepted("gif|jpg|png", 'image');
    $upload->set_overwrite(2, 'image');
    $upload->set_basename($_REQUEST['topic_id'], 'image');
    $result = $upload->upload();
    if ($result['image']['filename'])
    {
      $xt->setTopicImgurl($result['image']['filename']);
    }
    else
    {
      redirect_header("index.php?op=topicsmanager", 3, $upload->errors());
      exit();
    }
  }
  $xt->store();
  redirect_header("index.php?op=topicsmanager", 1, _UPDATED);
  exit();
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function delTopic()
{
  global $db, $rcxConfig, $rcxModule;
  if ($_GET['ok'] != 1)
  {
    rcx_cp_header();
    OpenTable();
    echo "
    <h4 style='color: #ff0000'>"._AM_WAYSYWTDTTAL."</h4>
    <table>
    <tr>
      <td>
        ".myTextForm("index.php?op=delTopic&topic_id=".$_GET['topic_id']."&ok=1",_YES)."
      </td>
      <td>
        ".myTextForm("index.php?op=topicsmanager", _NO)."
      </td>
    </tr>
    </table>
    <br />
    <br />";
    CloseTable();
  }
  else
  {
    $xt = new RcxTopic($db->prefix("topics"), $_GET['topic_id']);
    //get all subtopics under the specified topic
    $topic_arr = $xt->getAllChildTopics();
    array_push($topic_arr, $xt);
    foreach ($topic_arr as $eachtopic)
    {
      //get all stories in each topic
      $story_arr = NewsStory::getByTopic($eachtopic->topic_id());
      @unlink(RCX_ROOT_PATH."/modules/news/cache/topics/".basename($eachtopic->topic_imgurl()));
      foreach($story_arr as $eachstory)
      {
        $eachstory->delete();
      }
      //all stories for each topic is deleted, now delete the topic data
      $eachtopic->delete();
    }
    build_rss();
    redirect_header("index.php?op=topicsmanager", 1, _UPDATED);
    exit();
  }
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function addTopic()
{
  global $db;
  $xt = new RcxTopic($db->prefix("topics"));
  $xt->setTopicPid((int)$_REQUEST['topic_pid']);
  $xt->setTopicTitle($_REQUEST['topic_title']);
  $xt->store();
  redirect_header("index.php?op=modTopic&topic_id=".$xt->topic_id(), 1, _UPDATED);
  exit();
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function newsConfig()
{
  global $rcxConfig, $rcxModule, $rcxOption, $newsConfig;
  rcx_cp_header();
  
echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" class="fbund">
    <tr>
        <td class="KPindex">
            <div class="KPstor" >'._AM_GENERALCONF.'</div>
            <br />
            <br />';

  OpenTable();
//echo "</tr></table>";
?>

  <form action="index.php" method="post">
<table border='0' cellpadding='0' cellspacing='0' width='100%'><tr><td class='sysbg2'>
<table width='100%' border='0' cellpadding='4' cellspacing='1'><tr valign='middle' class='sysbg1'>




      <td nowrap><?php echo _AM_STORYHOME;?></td>
      <td width="100%">
        <select class="select" name="storyhome">
          <option value="<?php echo $newsConfig["storyhome"];?>" selected="selected"><?php echo $newsConfig["storyhome"];?></option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="5">5</option>
          <option value="10">10</option>
          <option value="15">15</option>
          <option value="20">20</option>
          <option value="25">25</option>
          <option value="30">30</option>
        </select>
      </td>
    </tr>
    <tr class='sysbg1'>
      <td nowrap><?php echo _AM_ANONSUBMIT;?></td>
      <td>
  <?php
    $chk1 = ""; $chk2 = "";
    $chk = ($newsConfig['anonsubmit'] == 1) ?  $chk1 = "checked='checked'" : $chk2 = "checked='checked'";
  ?>
        <input type="radio" class="radio" name="anonsubmit" value="1" <?php echo $chk1;?> /><?php echo _YES;?>
        <input type="radio" class="radio" name="anonsubmit" value="0" <?php echo $chk2;?> /><?php echo _NO;?>
      </td>
    </tr>
    <tr class='sysbg1'>
      <td nowrap><?php echo _AM_NOTIFYSUBMIT;?></td>
      <td>
  <?php
    $chk1 = ""; $chk2 = "";
    $chk = ($newsConfig["notifysubmit"] == 1) ?  $chk1 = "checked='checked'" : $chk2 = "checked='checked'";
  ?>
        <input type="radio" class="radio" name="notifysubmit" value="1" <?php echo $chk1;?> /><?php echo _YES;?>
        <input type="radio" class="radio" name="notifysubmit" value="0" <?php echo $chk2;?> /><?php echo _NO;?>
      </td>
    </tr>
    <tr class='sysbg1'>
      <td nowrap><?php echo _AM_DISPLAYNAV;?></td>
      <td>
  <?php
    $chk1 = ""; $chk2 = "";
    ($newsConfig["displaynav"] == 1) ? $chk1 = "checked='checked'" : $chk2 = "checked='checked'";
  ?>
        <input type="radio" class="radio" name="displaynav" value="1" <?php echo $chk1;?> /><?php echo _YES;?>
        <input type="radio" class="radio" name="displaynav" value="0" <?php echo $chk2;?> /><?php echo _NO;?>
      </td>
</tr>
<tr class='sysbg1'>
<td nowrap><?php echo _AM_DISPLAYTWO;?></td>
<td>
<?php
$chk1 = ""; $chk2 = "";
($newsConfig["displaytwo"] == 1) ? $chk1 = "checked='checked'" : $chk2 = "checked='checked'";
?>
<input type="radio" class="radio" name="displaytwo" value="1" <?php echo $chk1;?> /><?php echo _YES;?>
<input type="radio" class="radio" name="displaytwo" value="0" <?php echo $chk2;?> /><?php echo _NO;?>
</td>
</tr>
<tr class='sysbg1'>
<td nowrap><?php echo _AM_DISPLAYFIRST;?></td>
<td>
<?php
$chk1 = ""; $chk2 = "";
($newsConfig["displayfirst"] == 1) ? $chk1 = "checked='checked'" : $chk2 = "checked='checked'";
?>
<input type="radio" class="radio" name="displayfirst" value="1" <?php echo $chk1;?> /><?php echo _YES;?>
<input type="radio" class="radio" name="displayfirst" value="0" <?php echo $chk2;?> /><?php echo _NO;?>
</td>
    </tr>
    <tr class='sysbg1'>
      <td colspan=2>&nbsp;</td>
    </tr>
    <tr class='sysbg1'>
  <?php
    $chk1 = ""; $chk2 = "";
    ($newsConfig["rss_enable"] == 1) ? $chk1 = " checked='checked'" : $chk0 = " checked='checked'";
  ?>
      <td nowrap><?php echo _AM_RSS_ENABLE;?></td>
      <td>
        <input type="radio" class="radio" name="rss_enable" value="1"<?php echo $chk1;?> /> <?php echo _YES;?>
        <input type="radio" class="radio" name="rss_enable" value="0"<?php echo $chk0;?> /> <?php echo _NO;?>
      </td>
    </tr>
    <tr class='sysbg1'>
      <td nowrap><?php echo _AM_RSS_MAXITEMS;?></td>
      <td>
        <select class="select" name="rss_maxitems">
          <option value="<?php echo $newsConfig["rss_maxitems"];?>" selected="selected"><?php echo $newsConfig["rss_maxitems"];?></option>
          <option value="5">5</option>
          <option value="10">10</option>
          <option value="15">15</option>
          <option value="20">20</option>
          <option value="25">25</option>
          <option value="30">30</option>
        </select>
      </td>
    </tr>
    <tr class='sysbg1'>
      <td nowrap><?php echo _AM_RSS_MAXDESCRIPTION;?></td>
      <td>
        <select class="select" name="rss_maxdescription">
          <option value="<?php echo $newsConfig["rss_maxdescription"];?>" selected="selected"><?php echo $newsConfig["rss_maxdescription"];?></option>
          <option value="50">50</option>
          <option value="100">100</option>
          <option value="150">150</option>
          <option value="200">200</option>
          <option value="250">250</option>
          <option value="300">300</option>
        </select>
      </td>
      </tr>
    <tr class='sysbg1'>
      <td colspan=2>&nbsp;</td>
    </tr>
    <tr class='sysbg1'>
      <td nowrap><?php echo _ALLOWCAP;?></td>
      <td>
  <?php
    $chk1 = ""; $chk2 = "";
    $chk = ($rcxOption['use_captcha'] == 1) ? $chk1 = "checked='checked'" : $chk2 = "checked='checked'";
  ?>
        <input type="radio" class="radio" name="use_captcha" value="1" <?php echo $chk1;?> /><?php echo _YES;?>
        <input type="radio" class="radio" name="use_captcha" value="0" <?php echo $chk2;?> /><?php echo _NO;?>
      </td>
    </tr>
        <tr class='sysbg1'>
      <td colspan=2>&nbsp;</td>
    </tr>
    <tr class='sysbg1'>
      <td colspan=2>


  <input type="hidden" name="op" value="newsConfigS" />
  <input type="submit" class="button" value="<?php echo _SAVE;?>" />
  <input type="button" class="button" value="<?php echo _CANCEL;?>" onclick="javascript:history.go(-1)" />
  </td>
      </tr></table></td>
    </tr></table>
  </form>
  <?php
  CloseTable();
  
  echo "                        
        </td>
    </tr>
</table>";
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function newsConfigS()
{
//  global $_REQUEST;
  $content .= "<?php\n";
  $content .= "\$newsConfig['anonsubmit']         = ".intval($_REQUEST['anonsubmit']).";\n";
  $content .= "\$newsConfig['storyhome']          = ".intval($_REQUEST['storyhome']).";\n";
  $content .= "\$newsConfig['notifysubmit']       = ".intval($_REQUEST['notifysubmit']).";\n";
  $content .= "\$newsConfig['displaynav']         = ".intval($_REQUEST['displaynav']).";\n";
  $content .= "\$newsConfig['rss_enable']         = ".intval($_REQUEST['rss_enable']).";\n";
  $content .= "\$newsConfig['rss_maxitems']       = ".intval($_REQUEST['rss_maxitems']).";\n";
  $content .= "\$newsConfig['rss_maxdescription'] = ".intval($_REQUEST['rss_maxdescription']).";\n";
  $content .= "\$newsConfig['displaytwo']         = ".intval($_REQUEST['displaytwo']).";\n";
  $content .= "\$newsConfig['displayfirst']       = ".intval($_REQUEST['displayfirst']).";\n";
  $content .= "\$rcxOption['use_captcha']       = ".intval($_REQUEST['use_captcha']).";\n";
  $content .= "?>";
  $filename = "../cache/config.php";
  if ($file = fopen($filename, "w"))
  {
    fwrite($file, $content);
    fclose($file);
  }
  else
  {
    redirect_header("index.php?op=newsConfig", 1, _NOTUPDATED);
    exit();
  }
  redirect_header("index.php", 1, _UPDATED);
  exit();
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function build_rss()
{
  global $db, $newsConfig;
  if ($newsConfig['rss_enable'] == 1)
  {
    $SQL = "SELECT title, storyid, hometext, created FROM ".$db->prefix("stories")." WHERE published>0 AND published<".(time()+10)." ORDER BY published DESC";
    $query = $db->query($SQL, $newsConfig['rss_maxitems']);
    if ($query)
    {
      include_once(RCX_ROOT_PATH . "/class/xml-rss.php");
      $rss = new xml_rss('../cache/news.xml');
      $rss->channel_title .= " :: "._MI_NEWS_NAME;
      $rss->image_title   .= " :: "._MI_NEWS_NAME;
      $rss->max_items            = $newsConfig['rss_maxitems'];
      $rss->max_item_description = $newsConfig['rss_maxdescription'];
      while (list($title, $link, $description, $created) = $db->fetch_row($query))
      {
        $rss->setItemDate($created);
        $link = RCX_URL . '/modules/news/article.php?storyid=' . $link;
        $rss->build($title, $link, $description);
      }
      $rss->save();
    }
  }
}
/**
* Description
*
* @param type $var description
* @return type description
*/
//$op = !empty($_POST['op']) ? $_POST['op'] : $_GET['op'];
$op = $_REQUEST['op'];
switch($op)
{
  case "edit":
    rcx_cp_header();
      echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" class="fbund">
    <tr>
        <td class="KPindex">
            <div class="KPstor" >'._AM_EDITARTICLE.'</div>
            <br />
            <br />';
    OpenTable();
    $story         = new NewsStory($storyid);
    $title         = $story->title("Edit");
    //editor integration
    if ($editorConfig["displayeditor"] == 1)
    {
      $hometext      = $story->hometext("Preview");
      $bodytext      = $story->bodytext("Preview");
    }
    else
    {
      $hometext      = $story->hometext("Edit");
      $bodytext      = $story->bodytext("Edit");
    }
    //Slut på editor integration
    $allow_html    = intval($story->allow_html());
    $allow_smileys = intval($story->allow_smileys());
    $allow_bbcode  = intval($story->allow_bbcode());
    $ihome         = intval($story->ihome());
    $topicid       = intval($story->topicid());
    $published     = $story->published();
    $type          = $story->type();
    $topicdisplay  = $story->topicdisplay();
    $topicalign    = $story->topicalign(false);
    $isedit        = 1;
    include_once("storyform.inc.php");
    CloseTable();
    echo "                        
        </td>
    </tr>
</table>";
    break;
  case "newarticle":
    rcx_cp_header();
      
 echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" class="fbund">
    <tr>
        <td class="KPindex">';     
      
    newSubmissions();
    autoStories();
    lastStories();
echo '<div class="KPstor" >'._AM_POSTNEWARTICLE.'</div>
            <br />
            <br />';

    OpenTable();

    $type = 'admin';
    include_once("storyform.inc.php");
    CloseTable();
    
echo "                        
        </td>
    </tr>
</table>";    
    
    break;
  case "preview":
    rcx_cp_header();
    if (isset($storyid))
    {
      $story = new NewsStory($storyid);
      $published = $story->published();
    }
    else
    {
      $story = new NewsStory();
    }
    $story->setTitle($_REQUEST['title']);
    $story->setHomeText($_REQUEST['hometext']);
    $story->setBodyText($_REQUEST['bodytext']);
    $story->setHtml($_REQUEST['allow_html']);
    $story->setSmileys($_REQUEST['allow_smileys']);
    $story->setBBcode($_REQUEST['allow_bbcode']);
    $story->setTopicalign($_REQUEST['topicalign']);
    $story->setType($_REQUEST['type']);
    $story->setTopicdisplay(intval($_REQUEST['topicdisplay']));
    $autohour   = $_REQUEST['autohour'];
    $automin    = $_REQUEST['automin'];
    $automonth  = $_REQUEST['automonth'];
    $autoday    = $_REQUEST['autoday'];
    $autoyear   = $_REQUEST['autoyear'];
    $xt         = new RcxTopic($db->prefix("topics"));
    $p_title    = $story->title("Preview");
    $p_hometext = $story->hometext("Preview");
    $p_bodytext = $story->bodytext("Preview");
    $title      = $story->title("InForm");
    //editor integration
    if ($editorConfig["displayeditor"] == 1)
    {
      $hometext   = $story->hometext("Preview");
      $bodytext   = $story->bodytext("Preview");
    }
    else
    {
      $hometext   = $story->hometext("InForm");
      $bodytext   = $story->bodytext("InForm");
    }
    //slut på editor integration
    OpenTable();
    OpenTable("70%");
    if ($topicdisplay)
    {
      if ($topicalign == "L")
      {
        $align = "left";
      }
      else
      {
        $align = "right";
      }
      if (empty($topicid))
      {
        $warning = "<div style='text-align: center;'><blink><b>"._AR_SELECTTOPIC."</b></blink></div>";
        $timage  = "";
      }
      else
      {
        $xt      = new RcxTopic($db->prefix("topics"), $topicid);
        $warning = "";
        if ($xt->topic_imgurl())
        {
          $timage  = "<img src='".formatURL(RCX_URL."/modules/news/cache/topics/", $xt->topic_imgurl())."' align='$align' border='0' hspace='10' vspace=10' alt='".$xt->topic_title("P")."' />";
        }
      }
    }
    else
    {
      $timage = "";
    }
    if (!empty($p_bodytext))
    {
      echo "<b>".$p_title."</b><br /><br />".$timage."".$p_hometext."<br /><br />".$p_bodytext."<br /><br />";
    }
    else
    {
      echo "<b>".$p_title."</b><br /><br />".$timage."".$p_hometext."<br /><br />";
    }
    echo $warning;
    CloseTable();
    include_once("storyform.inc.php");
    CloseTable();
    break;
  case "save":
    if (empty($storyid))
    {
      $story = new NewsStory();
      $story->setUid($rcxUser->uid());
      if ($autodate)
      {
        $pubdate   = mktime($_REQUEST['autohour'], $_REQUEST['automin'], 0, $_REQUEST['automonth'], $_REQUEST['autoday'], $_REQUEST['autoyear']);
        $offset    = $rcxUser->timezone() - $rcxConfig['server_TZ'];
        $pubdate   = ($pubdate - ($offset * 3600));
        $story->setPublished($pubdate);
      }
      else
      {
        $story->setPublished(time());
      }
      $story->setType($_REQUEST['type']);
      $story->setHostname(_REMOTE_ADDR);
    }
    else
    {
      $story = new NewsStory($storyid);
      if (!empty($autodate))
      {
        $pubdate = mktime($autohour, $automin, 0, $automonth, $autoday, $autoyear);
        $offset  = $rcxUser->timezone();
        $offset  = ($offset - $rcxConfig['server_TZ']);
        $pubdate = ($pubdate - ($offset * 3600));
        $story->setPublished($pubdate);
      }
      elseif (($story->published() == 0) && ($approve == 1))
      {
        $story->setPublished(time());
        $isnew = 1;
      }
      else
      {
        if (!empty($movetotop))
        {
          $story->setPublished(time());
        }
      }
    }
    $story->setApproved($_REQUEST['approve']);
    $story->setTopicId($_REQUEST['topicid']);
    $story->setTitle($_REQUEST['title']);
    $story->setHometext($_REQUEST['hometext']);
    $story->setBodytext($_REQUEST['bodytext']);
    $story->setHtml($_REQUEST['allow_html']);
    $story->setSmileys($_REQUEST['allow_smileys']);
    $story->setBBcode($_REQUEST['allow_bbcode']);
    $story->setIhome($_REQUEST['ihome']);
    $story->setTopicalign($_REQUEST['topicalign']);
    $story->setTopicdisplay(intval($_REQUEST['topicdisplay']));
    $story->store();
    if (!empty($isnew) && $story->notifypub() && $story->uid() != 0)
    {
      $poster   = new RcxUser($story->uid());
      $subject  = _AM_ARTPUBLISHED;
      $message  = sprintf(_AM_HELLO, $poster->uname());
      $message .= "\n\n"._AM_YOURARTPUB."\n\n";
      $message .= _AM_TITLEC.$story->title()."\n"._AM_URLC.RCX_URL."/modules/news/article.php?storyid=".$story->storyid()."\n"._AM_PUBLISHEDC.formatTimestamp($story->published(),"m",0)."\n\n";
      $message .= $meta['title']."\n".RCX_URL."";

      $rcxMailer =& getMailer();
      $rcxMailer->useMail();
      $rcxMailer->setToEmails($poster->getVar("email"));
      $rcxMailer->setFromEmail($rcxConfig['adminmail']);
      $rcxMailer->setFromName($meta['title']);
      $rcxMailer->setSubject($subject);
      $rcxMailer->setBody($message);
      $rcxMailer->send();
    }
    build_rss();
    redirect_header("index.php?op=newarticle", 1, _UPDATED);
    exit();
    break;
  case "delete":
    if ($ok)
    {
      $story = new NewsStory($storyid);
      $story->delete();
      build_rss();
      redirect_header("index.php?op=newarticle", 1, _UPDATED);
      exit();
    }
    else
    {
      rcx_cp_header();
      OpenTable();
      echo "<div class='KPstor'> <h4 style='color:#ff0000'>"._AM_RUSUREDEL."</h4></div>";
      echo "<br><table width='100px' align='center'><tr><td>";
      echo myTextForm("index.php?op=delete&storyid=".$storyid."&ok=1" ,_YES);
      echo "</td><td>";
      echo myTextForm("javascript:history.go(-1)" , _NO);
      echo "</td></tr></table>";
      CloseTable();
    }
    break;
  case "topicsmanager":
    topicsmanager();
    break;
  case "addTopic":
    addTopic();
    break;
  case "delTopic":
    delTopic();
    break;
  case "modTopic":
    modTopic();
    break;
  case "modTopicS":
    modTopicS();
    break;
  case "newsConfig":
    newsConfig();
    break;
  case "newsConfigS":
    newsConfigS();
    break;
  default:
    rcx_cp_header();
      
echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" class="fbund">
    <tr>
        <td class="KPindex">
            <div class="KPstor" >'._MI_NEWS_ADMIN.'</div>
            <br />
            <br />';      
      
    OpenTable();
?>

	<div class="kpicon"><table><tr><td>
	<a href="index.php?op=newsConfig"><img src="<?php echo RCX_URL;?>/images/system/indstil.png" alt="<?php echo _AM_GENERALCONF;?>">
	<br /><?php echo _AM_GENERALCONF;?></a>
	<a href="index.php?op=topicsmanager"><img src="<?php echo RCX_URL;?>/images/system/moduler.png" alt="<?php echo _AM_TOPICSMNGR;?>"/>	
	<br /><?php echo _AM_TOPICSMNGR;?></a>
	<a href="index.php?op=newarticle"><img src="<?php echo RCX_URL;?>/images/system/indstil.png" alt="<?php echo _AM_PEARTICLES;?>"/>
	<br /><?php echo _AM_PEARTICLES;?></a>
	



	</td></tr></table></div>
<?php
echo "</tr></table>";
    CloseTable();
    
echo "                        
        </td>
    </tr>
</table>";

    break;
}
rcx_cp_footer();
?>