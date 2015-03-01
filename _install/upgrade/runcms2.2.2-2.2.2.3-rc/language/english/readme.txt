RUNCMS 2.2.3.0 RC

* [Sec] Fix SQL injection in the module /partners/ - unprotected variable $id in /modules/partners/index.php (SecurityFocus BugTraq ID 47388)
* [Sec] Fix SQL injection in /register.php - unprotected variable $timezone_offset (SecurityFocus BugTraq ID 46342)
* [Sec] Fix SQL injection and XSS vulnerabilities in /modules/forum/topicmanager.php unprotected variables $topic_id, $forum, $post_id, $newforum (Secunia Advisory SA43542)
* [Sec] Fix SQL injection in /modules/forum/post.php - unprotected variables $topic_id and $forum (Secunia Advisory SA43542)
* [Sec] Fix SQL injection in /modules/forum/search.php - unprotected variable $forum (Secunia Advisory SA43542)
* [Sec] Fix SQL injection in /modules/forum/class/class.forumtable.php - unprotected variable $last_visit (Secunia Advisory SA43542)
* [Sec] Fix SQL injection in /modules/pm/index.php and /modules/pm/pmsend.php - unprotected variables $sort and $by (Secunia Advisory SA43542)
* [Sec] Fix SQL injection in /modules/banners/index.php - unprotected variables $bid, $cid, $url (Secunia Advisory SA43542)
* [Sec] Fix SQL injection in /modules/links/viewcat.php - unprotected variable $orderby (Secunia Advisory SA43542)
* [Sec] Fix SQL injection in /modules/galleri/carte.php - unprotected variable $key (Secunia Advisory SA43542)
* [Sec] Fix SQL injection in /modules/galleri/index.php - unprotected variable $orderby (Secunia Advisory SA43542)
* [Sec] Fix XSS vulnerability in /user.php (OSVDB-ID 72840)
* [Sec] Fix  Full Path Disclosure (FPD) vulnerability in /include/registerform.php (OSVDB-ID 72848)
* [Sec] Fixing Upload Shell vulnerability /modules/galleri/uploaduser.php (OSVDB-ID 71309) (Secunia Advisory SA43542)
* [Sec] Fixing Cross-site request forgery (CSRF) vulnerability in the module /news/ (OSVDB-ID 71310)
* [Sec] Fixing Upload Shell vulnerability in admin panel module /downloads/ - unprotected variables $accepted_files and $shot_accepted_files
* [Sec] No stopping the PHP script after detecting SQL injection.
* [Sec] Fixing Cross-site request forgery (CSRF) vulnerability in the registration form - /include/registerform.php
* [Sec] Fix SQL injection in /class/sessions.class.php - unprotected variable $uid (CVE-2006-4667)
* [Sec] Fix SQL injection in /edituser.php - unprotected variables $umode and $timezone_offset (CVE-2006-4667)
* [Sec] Fix SQL injection in /include/registerform.php - unprotected variable $timezone_offset (CVE-2006-4667)

# [Fix] Fix error text double cleaning (shielding quotes, etc.) /galleri/uploaduser.php and /galleri/include/admin_edit_img.php
# [Fix] Correction of an error in the file /galleri/sql/mysql.sql - Incorrect record type date timestamp table galli_category
# [Fix] Fix syntax error when adding the content of the variable $description in the database module /downloads/
# [Fix] Fix error display HP/MP/EXP module /forum/ - /forum/class/class.forumposts.php
# [Fix] Adding a standard CSS style for the field in the captcha /contact/include/contactform.php
# [Fix] Correction of errors in /class/rcxmailer.php - Replacement $rcxConfig ['sleeptime'] to $rcxConfig ['send_pause'] (fixed by ZlydenGL)
# [Fix] Correction of errors in /class/rcxmailer.php - methods RcxMailer::setToGroups() and RcxMailer::setToUsers() - failure to check the parameter object.
# [Fix] Fix a /class/class_sql_inject.php. Cmd removal from the filter SQL injection
# [Fix] Correction of an error in the method RcxObject::cleanVars() - failure to check whether a variable $v['value'] string
# [Fix] Correction of an error in the method RcxBlock::getAllBlocksByGroup() - lack of DISTINCT in SQL query
# [Fix] Fix syntax errors in /modules/system/admin/disclaimer/language/english/modinfo.php
# [Fix] Correction of errors in the meta-generator (meta-generator), which occurred when deleting all "desirable" and "undesirable" words.
# [Fix] Fix a bug that occurs when adding and removing users to groups in the admin panel (not in the form of anti-CSRF token)
# [Fix] Correction of errors arising in the pagination on the page a list of users in the admin panel (added to the regeneration of the anti-CSRF token)
# [Fix] Correction of an error output in the form of an empty header class RcxThemeForm
# [Fix] Correction of an error in the class /class/xml-rss.php - lack of correct processing of the variable $description in the method xml_rss::build(), incorrect "cleaning" the text in the method xml_rss::cleanup()
# [Fix] Added missing emoticons
# [Fix] denied access to the registration form authorized users
# [Fix] Fixed authorization (The system can not update the database ...), associated with the key field of the table session
# [Fix] Fixed error checking e-mail when new user registration
# [Fix] Correction of errors in pagination module /news/ (ZlydenGL)
# [Fix] Fixed incorrect coding of pages in the installer.
# [Fix] Fixed incorrect encoding function redirect_header ().
# [Fix] Correction of an error in the block NewsLight modules /news/

+ [Feature] Adding text CAPTCHAs (test question) in the form of new user registration (optional).
+ [Feature] Adding hiding (via redirect) external links posted on this site (optional).

! [Note] only links posted by BB-code and external links to the site user, which he entered in their profile (the link will be displayed in the user information in the comments on the forum, and on the page the user).

+ [Feature] Added the ability to make websites in the "white list", which redirects (concealment of external links) will not be placed.
+ [Feature] Added the ability to optionally enable / disable the automatic conversion of URL, for the entire site

! [Note] In RUNCMS text processing is the automatic conversion of the URL and e-mail addresses in an HTML link. Moreover, this also applies when the HTML disabled (as allowed, for example, BB-code). Accordingly, these are spammers. This feature allows you to fix this problem

+ [Feature] Added a separate authorization for the administrators of the site (optional).

! [Note] The difference between the authorization for the administrator:

1) Use only PHP session.
2) Authorization lasts only 20 minutes
3) When forming the hash authentication using the IP and USER_AGENT administrator
5) The authorization form is protected by captcha (optional)

+ [Feature] Added the ability to send e-mail to the administrator indicating that you are in the administration panel (optional)
+ [Feature] Added protection from password guessing authorization

! [Note] Optionally, you can specify:

1) The number of failed login attempts.
2) Time (min.), To which will be blocked by the visitor's IP
3) is sent to the e-mail notification of the administrator password guessing attempts.

+ [Feature] Added protection against Clickjacking (optional)
+ [Feature] Added the ability to turn on the built-in browser protection against XSS-attacks

! [Note] Only for Internet Explorer 8 and above

+ [Feature] Added option to disable MIME sniffing in the browser

! [Note] only for Internet Explorer 8 and above

+ [Feature] Added the ability to set up access to cookies only authentication via HTTP protocol.
+ [Feature] Added the ability to prohibit the use of PHP session identifier in the URL
+ [Feature] Added the ability to change the identifier to include PHP session and specify the lifetime of the session identifier.
+ [Feature] Added option to disable BB-code in a user's signature
+ [Feature] Added the ability to deny access strangers to user profiles
+ [Feature] Added the ability to globally disable smilies for all portal
+ [Feature] Added new CSS classes for system messages (notification) / [URL] http://www.paulund.co.uk [/URL] /
+ [Feature] Added the ability to set the encoding connection to the database server (SET NAMES)
+ [Feature] Added HTTP caching (optionally enabled and configured in the admin panel)
+ [Feature] Added Page 404
+ [Feature] Added issuing HTTP header HTTP/1.1 404 missing pages in the module /news/
+ [Feature] Added disable redirect to the home page of the portal (optional in the admin panel)
+ [Feature] In the module /galleri/ option is added to the prohibition of voting for guests
+ [Feature] Added a separate file for CSS /include/admin.css admin panel
+ [Feature] Added the ability to specify the SMTP port in the admin panel
+ [Feature] Added ability to disable meta-tags "generator", "author" and "copyright"
+ [Feature] Added auto-detect language in the installer

^ [Change] Added support for PHP 5.4
^ [Change] Library KCAPTCHA 1.0 is replaced by KCAPTCHA 2.0 (http://www.captcha.ru), (from ZlydenGL)
^ [Change] Added ability to send from admin panel HTML text to send private messages to users (if used WYSIWYG)
^ [Change] Added correct HTML when sending messages to users from admin panel using WYSIWYG
^ [Change] In /modules/news/admin/index.php in function build_rss() is added to set the date of creating news
^ [Change] In the module /headlines/ old library MagpieRSS was replaced by SimplePie
^ [Change] Adding a class RcxFormSelect able to do list item is inactive (disabled)
^ [Change] Adding the ability to disable smilies in a class RcxFormDhtmlTextArea
^ [Change] Adding support for multiple choice lists for block settings page
^ [Change] Adding /class/database/mysql.php a method Database::query() indicate the possibility of cache lifetime
^ [Change] Adding a data type array in class RcxObject
^ [Change] Length of the field title in the table stories increased to 255 characters
^ [Change] Length of the field in the table topics topic_title increased to 255 characters
^ [Change] Length of the field title in the table nseccont increased to 255 characters
^ [Change] Length of the field in the table secname nsections increased to 255 characters
^ [Change] Changed field type version table modules
^ [Change] Files /include/rcxjs.php /class/form/formdhtmltextarea.js.php and isolated in a separate Java-Script files
^ [Change] Returned sub-menu in the admin panel for modules and system modules
^ [Change] Removed the left panel in the admin panel

$ [Language] Minor edits Russian translation