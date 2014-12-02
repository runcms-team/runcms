<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
/**
* Description
*
* @param type $var description
* @return type description
*/
function make_jumpbox() {
global $db, $myts, $rcxUser, $rcxModule, $bbTable;

echo '<form action="viewforum.php" method="get">';
echo '<select class="select" name="forum"><option value="-1">'._MD_SELFORUM.'</option>';

$sql = "SELECT cat_id, cat_title FROM ".$bbTable['categories']." ORDER BY cat_order";

if ($result = $db->query($sql)) {
        $myrow = $db->fetch_array($result);
        $myrow['cat_title'] = $myts->makeTboxData4Show($myrow['cat_title']);
        do {
                echo "
                <option value='-1'>&nbsp;</option>
                <option value='-1'>".$myrow['cat_title']."</option>
                <option value='-1'>----------------</option>";
                $sub_sql = "SELECT forum_id, forum_name FROM ".$bbTable['forums']." WHERE cat_id ='$myrow[cat_id]' ORDER BY forum_id";
                if ($res = $db->query($sub_sql)) {
                        while (list($forum_id, $forum_name) = $db->fetch_row($res))
                        {
                                $permissions = new Permissions($forum_id);
                                if ($permissions->can_view == 0)
                                {
                                        continue;
                                }
                        $name = $myts->makeTboxData4Show($forum_name);
                        echo "<option value='".$forum_id."'>$name</option>";
                        }
                        } else {
                                echo "<option value='0'>Error Connecting to DB</option>";
                        }
                } while ($myrow = $db->fetch_array($result));
        } else {
                echo "<option value='-1'>ERROR</option>";
        }

echo "</select> <input type='submit' class='button' value='"._GO."' /></form>";
}

function print_colorbar_combo($name, $selected='')
{
        global $bbPath;

        $content = "<select name='$name' class='select'>";
        $path = $bbPath['path']."images/colorbars/";
        $d = dir($path);
        while (false !== ($entry = $d->read()))
        {
           if(!is_dir($path.$entry) && substr($entry, -4)=='.gif')
           {
                           $content .= "<option";
                        if ($selected == $entry) $content .= " selected ";
                        $content .= ">$entry</option>";
           }
        }
        $d->close();
        $content .= "</select>";
        return $content;
}

?>