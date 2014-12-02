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
class WhosOnline
{
        var $forum_id;

        function WhosOnline($forum_id)
        {
                $this->forum_id = $forum_id;

                $this->cleanup();
                $this->add_entry();
        }

        function cleanup()
        {
                global $db, $bbTable, $rcxUser;
                $sql = "DELETE FROM ".$bbTable['whosonline']." where timestamp<".(time()-300);
                if ($rcxUser)
                {
                        // remove entry for this user
                        $sql .= " OR user_id=".$rcxUser->getVar('uid');
                }
                else
                {
                        // remove entry for this ip address
                        $sql .= " OR user_ip='"._REMOTE_ADDR."'";
                }
                if(!$db->query($sql)) die ( $sql."<br>".$db->error() );
        }

        function add_entry()
        {
                global $rcxUser, $db, $bbTable;

                $sql = "";
                $user_type = "ANON";
                $uname = "";
                $user_id = 0;
                $user_ip = "";
                if ($rcxUser)
                {
                    $user_id = $rcxUser->getVar('uid');
                    $uname = $rcxUser->getVar('uname');
                    $user_type = "REG";
                    if ($rcxUser->isAdmin()) $user_type = "ADMIN";
                    else
                    {
                        $mods = $this->find_moderators($this->forum_id);
                        if(in_array($rcxUser->getVar('uid'), $mods))
                        {
                            $user_type = "MOD";
                        }
                    }
                }
                else
                {
                    $user_ip = _REMOTE_ADDR;
                }
                $sql  = "INSERT INTO ".$bbTable['whosonline'];
                $sql .= " VALUES(".$this->forum_id.", $user_id, '$user_ip',".time().", '$uname', '$user_type')";

                if(!$db->query($sql)) die ( $sql."<br>".$db->error() );
        }

        function find_moderators($forum_id = 0)
        {
            global $db, $bbTable;
            $sql = "SELECT user_id from ".$bbTable['forum_mods'];
            if ($forum_id > 0) $sql .= " WHERE forum_id=$forum_id";
            $mods = array();
            $r = $db->query($sql);
            while($row =  $db->fetch_array($r))
            {
                $mods[] = $row[0];
            }
            return $mods;
        }

        function show_online_list()
        {
                if ($this->forum_id == 0)
                        $this->show_online_all();
                else
                        $this->show_online_forum();
        }

        function show_online_forum()
        {
                global $db, $bbWidth, $rcxModule, $bbTable, $forumConfig, $bbImage;

                // Total users
                $sql = "select * from ".$bbTable['whosonline']." where forum_id=".$this->forum_id;
                $result = $db->query($sql);
                $num_total = $db->num_rows($result);
?>
<table border="0" cellpadding="0" cellspacing="0" align="center" valign="top" width="<?php echo $bbWidth;?>"><tr><td class="bg2">
<table border="0" cellpadding="4" cellspacing="1" width="100%">
<tr class="bg3" align="left">
<td align="left" nowrap="nowrap" colspan=2><b><?php echo _MD_USERS_ONLINE."  ".$num_total." "._MD_BROWSING_FORUM."<br>";
?></b></td>
</tr>
<tr class="bg1" align="left">
<td align="middle"><img src='<?php echo $bbImage['whosonline']; ?>' alt='#' /></td>
<td width="100%">
<?php

                $num_anon = 0;
                $num_reg = 0;
                $regUsers = array();
                while ($row = $db->fetch_object($result))
                {
                        if (intval($row->user_id) > 0)
                        {
                                $num_reg++;
                                switch ($row->user_type)
                                {
                                    case "ADMIN":
                                    {
                                        $regUsers[] = " <a href='".RCX_URL."/userinfo.php?uid=".$row->user_id."'><font color='".$forumConfig['wol_admin_col']."'>".$row->uname."</font></a>";
                                        break;
                                    }
                                    case "MOD":
                                    {
                                        $regUsers[] = " <a href='".RCX_URL."/userinfo.php?uid=".$row->user_id."'><font color='".$forumConfig['wol_mod_col']."'>".$row->uname."</font></a>";
                                        break;
                                    }
                                    default:
                                    {
                                        $regUsers[] = " <a href='".RCX_URL."/userinfo.php?uid=".$row->user_id."'>".$row->uname."</a>";
                                    }
                                }
                        }
                        else
                        {
                                $num_anon++;
                        }
                }


                echo sprintf(_MD_TOTAL_ONLINE, ($num_anon+$num_reg));
                echo "&nbsp;[ <font color='".$forumConfig['wol_admin_col']."'>"._MD_ADMINISTRATOR."</font> ]";
                echo "&nbsp;[ <font color='".$forumConfig['wol_mod_col']."'>"._MD_MODERATOR."</font> ]";
                echo "<br>";

                echo $num_anon." "._MD_ANONYMOUS_USERS."<br>";
                echo $num_reg." "._MD_REGISTERED_USERS;
                for($i=0; $i<count($regUsers); $i++)
                {
                        echo $regUsers[$i];
                }

?>
</td>
</tr>
</table></table>
<?php
        }

        function show_online_all()
        {
                global $db, $bbWidth, $rcxModule, $bbTable, $forumConfig, $bbImage;

                // Total users
                $sql = "select * from ".$bbTable['whosonline'];
                $result = $db->query($sql);
                $num_total = $db->num_rows($result);
?>
<table border="0" cellpadding="0" cellspacing="0" align="center" valign="top" width="<?php echo $bbWidth;?>"><tr><td class="bg2">
<table border="0" cellpadding="4" cellspacing="1" width="100%">
<tr class="bg3" align="left">
<td align="left" nowrap="nowrap" colspan=2><b><?php echo _MD_USERS_ONLINE."  ".$num_total." "._MD_BROWSING_ALL."<br>";
?></b></td>
</tr>
<tr class="bg1" align="left">
<td align="middle"><img src='<?php echo $bbImage['whosonline']; ?>' alt='#' /></td>
<td width="100%">
<?php

                $num_anon = 0;
                $num_reg = 0;
                $regUsers = array();
                while ($row = $db->fetch_object($result))
                {
                        if (intval($row->user_id) > 0)
                        {
                                $num_reg++;
                                switch ($row->user_type)
                                {
                                    case "ADMIN":
                                    {
                                        $regUsers[] = " <a href='".RCX_URL."/userinfo.php?uid=".$row->user_id."'><font color='".$forumConfig['wol_admin_col']."'>".$row->uname."</font></a>";
                                        break;
                                    }
                                    case "MOD":
                                    {
                                        $regUsers[] = " <a href='".RCX_URL."/userinfo.php?uid=".$row->user_id."'><font color='".$forumConfig['wol_mod_col']."'>".$row->uname."</font></a>";
                                        break;
                                    }
                                    default:
                                    {
                                        $regUsers[] = " <a href='".RCX_URL."/userinfo.php?uid=".$row->user_id."'>".$row->uname."</a>";
                                    }
                                }
                        }
                        else
                        {
                                $num_anon++;
                        }
                }

                echo sprintf(_MD_TOTAL_ONLINE, ($num_anon+$num_reg));
                echo "&nbsp;[ <font color='".$forumConfig['wol_admin_col']."'>"._MD_ADMINISTRATOR."</font> ]";
                echo "&nbsp;[ <font color='".$forumConfig['wol_mod_col']."'>"._MD_MODERATOR."</font> ]";
                echo "<br>";

                echo $num_anon." "._MD_ANONYMOUS_USERS."<br>";
                echo $num_reg." "._MD_REGISTERED_USERS;
                for($i=0; $i<count($regUsers); $i++)
                {
                        echo $regUsers[$i];
                }
?>
</td>
</tr>
</table></table>
<?php
        }
}

?>