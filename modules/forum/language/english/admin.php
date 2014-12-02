<?php

// index.php
define("_MD_A_FORUM_INDEX","Forum Admininistration");
define("_MD_A_FORUM_MANAGER","Forum Manager");
define("_MD_A_LINK2_FORUM_MANAGER","This is the main panel for creating and modifying forums and categories.");
define("_MD_A_SYNCFORUM","<br />Sync forum/topic");
define("_MD_A_LINK2SYNC","This link will allow you to sync up the forum and topic indexes to fix any
descrepancies that might arise");
define("_MD_A_PRUNEFORUM", "Prune Forums");
define("_MD_A_LINK2PRUNEFORUM","Delete old & stale posts from your forums.");
define("_MD_A_FORUM_CONFIG","Configuration");
define("_MD_A_LINK2_FORUM_CONFIG","General forum configuration.");

// forum_manager.php
define("_MD_A_NAME","Name");
define("_MD_A_EDIT","Edit");
define("_MD_A_ACCESS","Access");
define("_MD_A_DELETE","Delete");
define("_MD_A_ADD","Add");
define("_MD_A_MOVE","Move");
define("_MD_A_ORDER","Order");
define("_MD_A_ADD_CATEGORY","Add Category");
define("_MD_A_BACK_TO_FM","Back to Forum Manager");

// cat_functions.php
define("_MD_A_EDITCATEGORY","Edit Category:");
define("_MD_A_CATEGORYTITLE","Category Title:");
define("_MD_A_DELETECATEGORY","Delete Category:");
define("_MD_A_MSG_CAT_CREATED","Category created.");
define("_MD_A_MSG_ERR_CAT_CREATED","Failed to create category.");
define("_MD_A_MSG_ERR_CAT_NO_TITLE","Please specify a category title.");
define("_MD_A_MSG_CAT_DELETED","Category deleted.");
define("_MD_A_MSG_ERR_CAT_DELETED","Failed to delete category.");
define("_MD_A_MSG_RETURN_TO_FM","Returning to Forum Manager.");
define("_MD_A_MSG_CAT_UPDATED","Category updated.");
define("_MD_A_MSG_ERR_CAT_UPDATED","Failed to update category.");
define("_MD_A_MSG_CAT_MOVED","Category moved!");
define("_MD_A_MSG_ERR_CAT_MOVED","Failed to move category.");

// forum_functions.php
define("_MD_A_CREATENEWFORUM","Create a New Forum");
define("_MD_A_FORUMNAME","Forum Name:");
define("_MD_A_FORUMDESCRIPTION","Forum Description:");
define("_MD_A_MODERATOR","Moderator(s):");
define("_MD_A_ALLOWHTML","Allow HTML:");
define("_MD_A_ALLOWSIGNATURES","Allow Signatures:");
define("_MD_A_HOTTOPICTHRESHOLD","Hot Topic Threshold:");
define("_MD_A_POSTPERPAGE","Posts per Page:");
define("_MD_A_TITNOPPTTWBDPPOT","(This is the number of posts per topic that will be displayed per page of a topic)");
define("_MD_A_TOPICPERFORUM","Topics per Forum:");
define("_MD_A_TITNOTPFTWBDPPOAF","(This is the number of topics per forum that will be displayed per page of a forum)");
define("_MD_A_ALLOW_ATTACHMENTS","Allow Attachments");
define("_MD_A_ATTACHMENT_SIZE","Max. size for an attachment in kb");
define("_MD_A_ALLOWED_EXTENSIONS","Allowed File extensions");
define("_MD_A_EXTENSIONS_DELIMITED_BY","File extensions delimited by '|' i.e. (.txt|.zip)");
define("_MD_A_ALLOW_POLL","Allow Polls");
define("_MD_A_YDNFOATPOTFDYAA","You did not fill out all the parts of the form.<br />Did you assign at least one moderator? Please go back and correct the form.");
define("_MD_A_CLEAR","Clear");
define("_MD_A_EDITTHISFORUM","Edit This Forum");
define("_MD_A_REMOVE","Remove");
define("_MD_A_WARNING", "Warning");
define("_MD_A_WARNING_DEL_FORUM", "Deleting this forum will delete the forum, it's posts and any subforums.<br><br>Continue?");
define("_MD_A_WARNING_DEL_CAT", "Deleting this category will delete all forums, subforums and posts belonging to this category.<br><br>Continue?");
define("_MD_A_DELETEFORUM","Delete Forum:");
define("_MD_A_MOVE2CAT","Move to category:");
define("_MD_A_MAKE_SUBFORUM_OF","Make subforum of:");
define("_MD_A_SELECT","< Select >");
define("_MD_A_MSG_FORUM_ADD","Forum created.");
define("_MD_A_MSG_FORUM_DEL","Forum deleted.");
define("_MD_A_MSG_ERR_FORUM_DEL","Failed to delete forum.");
define("_MD_A_MSG_FORUM_MOVED","Forum moved!");
define("_MD_A_MSG_ERR_FORUM_MOVED","Failed to move forum.");
define("_MD_A_MSG_FORUM_UPDATED","Forum updated.");
define("_MD_A_MOVETHISFORUM", "Move Forum");

// forum_access.php
define("_MD_A_ALLOW_GROUP", "Allow Group");
define("_MD_A_ALLOW_USER", "Allow User");
define("_MD_A_PERMISSIONS_FORUM","Permissions for Forum:");
define("_MD_A_PERMISSIONS_GROUP","Group Permissions");
define("_MD_A_PERMISSIONS_USER","User Permissions");
define("_MD_A_GROUP_NAME","Group Name");
define("_MD_A_USER_NAME","User Name");
define("_MD_A_UPDATE_GROUPS","Update Groups");
define("_MD_A_UPDATE_USERS","Update Users");
define("_MD_A_CAN_VIEW","Can View");
define("_MD_A_CAN_POST","Can Post");
define("_MD_A_CAN_REPLY","Can Reply");
define("_MD_A_CAN_EDIT","Can Edit");
define("_MD_A_CAN_DELETE","Can Delete");
define("_MD_A_CAN_ADDPOLL","Can Add Poll");
define("_MD_A_CAN_VOTE","Can Vote");
define("_MD_A_CAN_ATTACH","Can Attach");
define("_MD_A_APPR_POST","Auto-Approve Post");
define("_MD_A_APPR_ATTACH","Auto-Approve Attachments");
define("_MD_A_ACTION","Action");
define("_MD_A_MSG_GROUP_ADD","Allowed group added.");
define("_MD_A_MSG_ERR_GROUP_ADD","Failed to add allowed group.");
define("_MD_A_MSG_GROUP_REVOKE","Group access revoked.");
define("_MD_A_MSG_ERR_GROUP_REVOKE","Failed to revoke group.");
define("_MD_A_MSG_GROUPS_UPDATED","Groups updated.");
define("_MD_A_MSG_USER_ADD","Allowed user added.");
define("_MD_A_MSG_ERR_USER_ADD","Failed to add allowed user.");
define("_MD_A_MSG_USER_REVOKE","User access revoked.");
define("_MD_A_MSG_ERR_USER_REVOKE","Failed to revoke user.");
define("_MD_A_MSG_USERS_UPDATED","Users updated.");
define("_MD_A_COPY_PERMISSIONS","Copy permisions from forum:");
define("_MD_A_COPY","Copy");
define("_MD_A_REVOKE","Revoke");
define("_MD_A_REVOKEUSER","Revoke User");

// forum_config.php
define("_MD_A_CONFIGFORUM","Configuration");

define("_MD_A_GENERAL_OPTS","General Options");
define("_MD_A_ALLOW_POSTANON", "Allow Post Anonymously");
define("_MD_A_LEVELS_ENABLE", "Enable HP/MP/EXP Levels Mod");
define("_MD_A_IMG_SET","Image Set");
define("_MD_A_MAX_IMG_WIDTH","Maximum Image Attachment Width");
define("_MD_A_ALLOW_SIMILAR_THREADS","Enable Similar Threads");

define("_MD_A_DISCLAIMER","Disclaimer");
define("_MD_A_SHOW_DIS","Show Disclaimer On");
define("_MD_A_BOTH","Both");

define("_MD_A_RSS_OPTS","RSS Feed Options");
define("_MD_A_RSS_ENABLE","Enable RSS Feed");
define("_MD_A_RSS_MAX_ITEMS", "Max. Items");
define("_MD_A_RSS_MAX_DESCRIPTION", "Max. Description Length");

define("_MD_A_WOL_OPTS","Who's Online Options");
define("_MD_A_WOL_ENABLE","Enable Who's Online");
define("_MD_A_WOL_ADMIN_COL","Administrator Highlight Color");
define("_MD_A_WOL_MOD_COL","Moderator Highlight Color");

// sync.php
define("_MD_A_CLICKBELOWSYNC","Clicking the button below will sync up your forums and topics pages with the correct data from the database. Use this section whenever you notice anomolies in the topics and forums lists.");
define("_MD_A_SYNCHING","Synchronizing forum index and topics (This may take a while)");
define("_MD_A_START", "Start");

// prune.php
define("_MD_A_PRUNE", "Prune Forums");
define("_MD_A_PLIST", "List topics that match");
define("_MD_A_PSTICKY", "Sticky");
define("_MD_A_PLOCKED", "Locked");
define("_MD_A_PLAST", "Last reply older than (days)");
define("_MD_A_PLIMIT", "Limit to (results)");
define("_MD_A_PCHECK", "Check / Uncheck");
define("_MD_A_PFOUND", "Found <b>%d</b> results:");
define("_MD_A_PNFOUND", "No topics corresponding to that criteria found.");
define("_MD_A_PDELETED", "Deleted: <b>%s</b>!");
define("_MD_A_PCONFIRM", "Are you sure you want to delete these topics & all their child messages?");

define("_MD_A_MODERATORCURRENT", "Current :");
define("_MD_A_MODERATORASSIGNEDADD", "Add :");
?>