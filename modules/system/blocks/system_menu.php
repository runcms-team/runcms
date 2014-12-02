<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
function b_system_main_dynshow($options)
{
    global $db, $rcxUser, $rcxModule, $rcxConfig;
    $groups   = array();
    $block    = array();
    $sublinks = array();
    $subcont  = array();
    $groups   = $rcxUser ? $rcxUser->groups() : RcxGroup::getByType('Anonymous');
    $block['title']    = _MB_SYSTEM_MMENU;
    $menu = 'var mainmenu =['."\n";
    $sql    = '
        SELECT M.mid, M.dirname, M.name
            FROM '.RC_MODULES_TBL.' M, '.RC_GRP_MOD_LINK_TBL.' L
            WHERE M.hasmain=1
                AND M.isactive=1
                AND M.weight>0
                AND M.mid = L.mid
                AND L.groupid IN('.join(',', $groups).')
            GROUP BY M.dirname
            ORDER BY M.weight ASC';
    $result = $db->query($sql);
    $j = 0;
    $count = $db->num_rows($result);
  if ( $count > 0  ) {
      while ( $myrow = $db->fetch_array($result) ) {
          $array[] = $myrow;
      }
      unset ($myrow);
	  //MENU 1
    foreach ( $array as $key => $myrow ) {
      if ( @file_exists(RCX_ROOT_PATH.'/modules/'.$myrow['dirname'].'/include/rcxv.php') ) {
        $module = new RcxModule($myrow);
        $link = $module->mainLink2();
        $tree1[$key]['link']  = $link['link'];
        $tree1[$key]['name']  = $link['name'];
        $tree1[$key]['mid']   = $module->mid();
        if ( $sublinks = $module->subLink2() ) {
          foreach($sublinks as $key2 => $sublink) {
            $tree1[$key]['leaves'][$key2]['name']  = $sublink['name'];
            $tree1[$key]['leaves'][$key2]['link']  = $sublink['link'];
            $tree1[$key]['leaves'][$key2]['image'] = '<img src="'.RCX_URL.'/images/menu/pointer.gif" alt="" />';
          }
        }
      }
    } 
    @array_unshift ($tree1, array('name' => _MB_SYSTEM_HOME, 'link' => RCX_URL.'/'));
    //MENU 4
    foreach ( $array as $key => $myrow ) {
      if ( @file_exists(RCX_ROOT_PATH.'/modules/'.$myrow['dirname'].'/include/rcxv.php') ) {
        $module = new RcxModule($myrow);
        $link = $module->mainLink2();
        $tree[$key]['image'] = '<img src="'.RCX_URL.'/images/menu/d_tree_close.gif" alt="" />';
        $tree[$key]['link']  = $link['link'];
        $tree[$key]['name']  = $link['name'];
        $tree[$key]['mid']   = $module->mid();
        if ( $sublinks = $module->subLink2() ) {
          foreach($sublinks as $key2 => $sublink) {
            $tree[$key]['leaves'][$key2]['name']  = $sublink['name'];
            $tree[$key]['leaves'][$key2]['link']  = $sublink['link'];
            $tree[$key]['leaves'][$key2]['image'] = '<img src="'.RCX_URL.'/images/menu/pointer.gif" alt="" />';
          }
        }
      }
    } 
    @array_unshift ($tree, array('image'=> '<img src="'.RCX_URL.'/images/menu/d_tree_home.gif" alt="" />', 'name' => _MB_SYSTEM_HOME, 'link' => RCX_URL.'/'));
    switch ($options[0]) {
           case 1:
       include_once(RCX_ROOT_PATH.'/class/jsmenu/jstree.class.php');
        $mainmenu = New jstree('mainmenu', $tree1);
        $mainmenu->setCSS(RCX_URL.'/themes/'.getTheme().'/style/style.css');
        $block['content'] = $mainmenu->render();
		break;
      case 2:
      $menu='';
      foreach ($tree as $nodekey => $node) {
        if ($rcxModule) {
          if ((is_array($node['leaves'])) && ($node['mid'] == $rcxModule->mid())) {
            $menu .= '<img src="'.RCX_URL.'/images/menu/tree_open.gif">';
            $menu .= '&nbsp;&nbsp;<a href="'.$node['link'].'">'.$node['name'].'</a>';
            $menu .='<br />';
            foreach ($node['leaves'] as $leavekey => $leave) {
              $menu .= '&nbsp;&nbsp;&nbsp;&nbsp;<img src="'.RCX_URL.'/images/menu/tree_content.gif">';
            $menu .= '&nbsp;&nbsp;<a href="'.$leave['link'].'">'.$leave['name'].'</a>';
              if ($leavekey+1 != count($node['leaves'])) $menu .='<br />';
            }
          } else {
            $menu .= '<img src="'.RCX_URL.'/images/menu/tree_close.gif">';
            $menu .= '&nbsp;&nbsp;<a href="'.$node['link'].'">'.$node['name'].'</a>';
          }
        } else {
          $menu .= '<img src="'.RCX_URL.'/images/menu/tree_close.gif">';
          $menu .= '&nbsp;&nbsp;<a href="'.$node['link'].'">'.$node['name'].'</a>';
        }
        if ($nodekey+1 != count($tree)) $menu .='<br />';
      }
      $block['content'] = $menu;
      break;
      case 3:
      $block['content'] = "
          <script type='text/javascript'>
          function toggle_dynmenu(id)  {
            if (rcxGetElementById(id + '_sub')) {
              var dom = rcxGetElementById(id + '_sub').style.display;
                            if (dom == 'none') {
        rcxGetElementById(id + '_sub').style.display = 'inline';
                                rcxGetElementById(id + '_sign').src   = '".RCX_URL."/images/menu/minus.gif';
                                rcxGetElementById(id + '_folder').src = '".RCX_URL."/images/menu/tree_open.gif';
        } else if (dom == 'inline') {
          rcxGetElementById(id + '_sub').style.display = 'none';
                                  rcxGetElementById(id + '_sign').src   = '".RCX_URL."/images/menu/plus.gif';
                                  rcxGetElementById(id + '_folder').src = '".RCX_URL."/images/menu/tree_close.gif';
                            }
                         }
                    }
                    </script>";
      $block['content'] .= "<img src='".RCX_URL."/images/menu/d_tree_home.gif' alt='' /> <a href='".RCX_URL."/'>"._MB_SYSTEM_HOME."</a>";
      foreach ($array as $myrow) {
        if ( @file_exists(RCX_ROOT_PATH.'/modules/'.$myrow['dirname'].'/include/rcxv.php') ) {
          $module = new RcxModule($myrow);
          if ($sublinks = $module->subLink()) {
			  $subcont[] = $myrow['dirname'];
            $block['content'] .= "<br /><a href='javascript:toggle_dynmenu(\"".$myrow['dirname']."\");'><img id='".$myrow['dirname']."_sign' name='".$myrow['dirname']."_sign' src='".RCX_URL."/images/menu/minus.gif' height='9' width='9' align='absmiddle' border='0' /></a> ";
            $block['content'] .= "<img id='".$myrow['dirname']."_folder' name='".$myrow['dirname']."_folder' src='".RCX_URL."/images/menu/tree_open.gif' alt='' /> ".$module->mainLink()."";
            $block['content'] .= "<span id='".$myrow['dirname']."_sub' name='".$myrow['dirname']."_sub' style='display:inline;'>";
            foreach($sublinks as $sublink) {
                        $block['content'] .= "<br /> <img src='".RCX_URL."/images/menu/d_tree_content.gif' alt='' /> ".$sublink;
            }
            $block['content'] .= "</span>";
          } else {
            $block['content'] .= "<br /><img src='".RCX_URL."/images/menu/d_tree_close.gif' alt='' /> ".$module->mainLink()."\n";
          }
        }
      }
      if ( !empty($subcont) ) {
        $block['content'] .= "<script type='text/javascript'>\n";
        foreach($subcont as $value) {
          if (!$rcxModule || ($rcxModule->dirname() != $value)) {
                    $block['content'] .= "toggle_dynmenu('$value');\n";
          }
        }
        $block['content'] .= "</script>";
      }
      break;
      case 4:
        include_once(RCX_ROOT_PATH.'/class/jsmenu/jstree.class.php');
        $mainmenu = New jstree('mainmenu', $tree);
        $mainmenu->setCSS(RCX_URL.'/themes/'.getTheme().'/style/style.css');
        $block['content'] = $mainmenu->render();
      break;
       case 5:
      $block['content'] = "
      <script type='text/javascript'>
      function expand_menu(id)  {
        if (rcxGetElementById(id + '_submenu')) {
          rcxGetElementById(id + '_submenu').style.display = 'inline';
        }
      }
      function collapse_menu(id)  {
        if (id != '".$myrow['dirname']."') {
          if (rcxGetElementById(id + '_submenu')) {
            rcxGetElementById(id + '_submenu').style.display = 'none';
          }
        }
      }
      </script>";
      $block['content'] .= "<span id='hmenu' class='top'><a href='".RCX_URL."/'>"._MB_SYSTEM_HOME."</a></span>";
      foreach ($array as $myrow) {
        if ( @file_exists(RCX_ROOT_PATH.'/modules/'.$myrow['dirname'].'/include/rcxv.php') ) {
          $module = new RcxModule($myrow);
          $block['content'] .= "<span onmouseover,Duration=0.63='expand_menu(\"".$myrow['dirname']."\")' onmouseout,Duration=0.63='collapse_menu(\"".$myrow['dirname']."\")'>";
          if ($sublinks = $module->subLink()) {
            $subcont[] = $myrow['dirname'];
            // hoved menu indgang
            $block['content'] .= "<span id='hmenu' class='hmenu'>".$module->mainLink()."</span>";
            // Submenu entry, if any..
            $block['content'] .= "<span id='".$myrow['dirname']."_submenu' name='".$myrow['dirname']."_submenu' style='display:none;'>";
            foreach($sublinks as $sublink) {
              $block['content'] .= "<span id='hmenu2' class='sub'>$sublink</span>";
            }
            $block['content'] .= "</span>";
            } else {
              $block['content'] .= "<span id='hmenu' class='hmenu'>".$module->mainLink()."</span>";
            }
        $block['content'] .= "</span>";
      }
    }
           if ( !empty($subcont) ) {
        $block['content'] .= "<script type='text/javascript'>\n";
        foreach($subcont as $value) {
          if ($rcxModule && ($rcxModule->dirname() == $value)) {
            $block['content'] .= "expand_menu('$value');\n";
          }
        }
        $block['content'] .= "</script>";
      }
     break;
    }
    return $block;
  }
}
/**
 * @return unknown
 * @param unknown $options
 * @desc Enter description here...
*/
function b_system_main_edit($options)
{
    $form  = _MB_SYSTEM_MENU_LOOK."&nbsp;
        <select name='options[]' class='select'>";
    $chk = ( $options[0] == 1 ) ? " selected" : "";
    $form .= '<option value ="1"'.$chk.'>'._MB_SYSTEM_MENU_JAVADYN.'</option>';
    $chk = ( $options[0] == 2 ) ? " selected" : "";
    $form .= '<option value ="2"'.$chk.'>'._MB_SYSTEM_MENU_PLAIN.'</option>';
    $chk = ( $options[0] == 3 ) ? " selected" : "";
    $form .= '<option value ="3"'.$chk.'>'._MB_SYSTEM_MENU_OLDDYN.'</option>';
    $chk = ( $options[0] == 4 ) ? " selected" : "";
    $form .= '<option value ="4"'.$chk.'>'._MB_SYSTEM_MENU_NEWDYN.'</option>';
    $chk = ( $options[0] == 5 ) ? " selected" : "";
    $form .= '<option value ="5"'.$chk.'>'._MB_SYSTEM_MENU_MYDYN.'</option>
       </select>';
    return $form;
}
?>