<?php
/*********************************************************************
��������� chmod 666 ����� ����� ��� ���������� ������.
���� �� ������ �������� ����� �������, �������������� ���� �������.
*********************************************************************/

// ������ �� ������������ - ��������� �������� ������� ������ ����� �� ����� (HTML-������� FRAME ��� IFRAME) �� ������ �����.<br /><br /><span style='font-size:x-small;font-weight:normal;'>�������� �������� �� ����� ��������� ������ � ��� ������, ���� ����� ���������� �� �������� ���� �� �����, ��� � ����������� � ���� ��������.<br /><br /><u>��������! ��� ��������� ���� ����� ����� ��������� �������� ��������� �������� � ��������� ������� ������������ ������� ����� ������.</u></span> (1=�� 0=���)
$rcxConfig['x_frame_options'] = 0;
    
// �������� ���������� � ������� ������ �� XSS-���� (������ ��� Internet Explorer 8 � ����). (1=�� 0=���)
$rcxConfig['x_xss_protection'] = 0;
    
// ��������� MIME �������� � �������� (������ ��� Internet Explorer 8 � ����). (1=�� 0=���)
$rcxConfig['x_content_typ_options_nosniff'] = 0;

// E-Mail ��������������
$rcxConfig['adminmail'] = "admin@mysite.com";

// �������� �������
$rcxConfig['mail_function'] = "mail";

// ���������� ��������� ��������� ���������� � ����� ������ (�� �����):
$rcxConfig['pm_atonce'] = "300";

// ���������� E-mail ��������� ���������� � ����� ������ (�� �����):
$rcxConfig['ml_atonce'] = "20";

// ����� (� ���.) ����� �������� ��������� (��������� ��� E-mail):
$rcxConfig['send_pause'] = "1";

// SMTP ����:
$rcxConfig['smtp_host'] = "localhost";

// SMTP �����:
$rcxConfig['smtp_uname'] = "";

// SMTP ������:
$rcxConfig['smtp_pass'] = "";
    
// SMTP ����:
$rcxConfig['smtp_port'] = "25";

// ���� �� ���������
$rcxConfig['language'] = "russian";

// ������ ��������� ��������
$rcxConfig['startpage'] = "news";

// ���� �� ���������
$rcxConfig['default_theme'] = "runcms2";

// ��������� ������������� ������ �����? (1=�� 0=���)
$rcxConfig['allow_theme'] = 0;

// ��� ��� ��������� ������
$rcxConfig['anonymous'] = "Anonyme";

// ����������� ����� ������
$rcxConfig['minpass'] = 5;

// ��������� �������� ��������� �����������? (1=�� 0=���)
$rcxConfig['anonpost'] = 0;

// �������� �������� ��������� ��� ������������. 0=�������������
$rcxConfig['max_pms'] = 100;

// �������� �������������� �������������� URL � HTML ������: <br /><br /><span style='font-size:x-small;font-weight:normal;'><i>������ ��� ������ ��� �������� HTML (� ������� � ����������� HTML �������������� �� �������� �� ���������)</i><br /><br />����� ���� <br /><br />http://������.ru <br /><br />����� ������������ � HTML ��� <br /><br />&lt;a href="http://������.ru" target="_blank"&gt;</span> (1=�� 0=���)
$rcxConfig['clickable'] = 0;

// ��������� HTML-���� � ������������? (1=�� 0=���)
$rcxConfig['allow_html'] = 0;

// ��������� ������������� ���������� �����������? (1=�� 0=���)
$rcxConfig['allow_library'] = 0;

// ��������� ���������� ���������� ����������� � ����������? (1=�� 0=���)
$rcxConfig['lib_allow_upload'] = 0;

// ������ ������������ ��������
$rcxConfig['lib_width'] = 140;

// ������ ������������ ��������
$rcxConfig['lib_height'] = 140;

// ������ �������� ���������� (����)
$rcxConfig['lib_maxsize'] = 3072;

// ���������� ������� �������� � ����������, ������������ � ��������? (1=�� 0=���)
$rcxConfig['allow_image'] = 0;

// ��������� ����������� �� �����? (1=�� 0=���)
$rcxConfig['allow_register'] = 1;

// �������� ������ �� �����? ����� ����� ������� �������������� ����������� ���. ��������� GD! (1=�� 0=���)
$rcxConfig['img_verify'] = 1;

// ������������� ������������ ����� ������������� ��� �����������? (1=�� 0=���)
$rcxConfig['auto_register'] = 0;

// ���������� � ����� �����������? (1=�� 0=���)
$rcxConfig['new_user_notify'] = 1;

// ��������� ������:
$rcxConfig['new_user_notify_group'] = 1;

// ��������� ������������� ������� �������? (1=�� 0=���)
$rcxConfig['self_delete'] = 0;

// ���������� �������� ��������? (1=�� 0=���)
$rcxConfig['display_loading_img'] = 0;

// ������������ gzip-������? ��� PHP ������ 4.0.5 ��� ����. � ��� ����������� ������ 5.4.29 (1=�� 0=���)
$rcxConfig['gzip_compression'] = 1;

// ��� ������ ����������� ����������� ������� � �����?  (������ (������ ����� � �����)=0 ������=1 ����� (������������� ��� ������������ ��������)=2)
$rcxConfig['uname_test_level'] = 0;

// ��� ��� cookies, � ������� ����� ����������� ��� ������������ � ������� ����. ���� cookie ����, ��� ����� ������������� ���������� � ���� ������.
$rcxConfig['cookie_name'] = "rc2_user";

// ��� ������/cookies. ���� ������������ ����������� �������� � �������, ���� ����� ������/cookies �� �������.
$rcxConfig['session_name'] = "rc2_sess";

// ����� ���������� �� ����� (� ��������) ����� �������������� ����������� ������������ �� �������.
$rcxConfig['session_expire'] = 2678400;

// ������������ ��� ����������� ������ ������ cookies?
$rcxConfig['use_sessions'] = 0;

// ������� ���� �������
$rcxConfig['server_TZ'] = "4";

// ������� ���� �� ���������
$rcxConfig['default_TZ'] = "1";

// ������������ ��������� ������� �� �����? (1=�� 0=���)
$rcxConfig['banners'] = 1;

// ������� �������: �������������� �����.
$rcxConfig['debug_mode'] = 1;

// ����� HTML ����������� �������, ���.
$rcxConfig['cache_time'] = 0;

// ������ ����������� ������������ �� ��������� (0=��� ������������ flat=� ���� ����� thread=� ���� ������)
$rcxConfig['com_mode'] = "flat";

// ������� ����������� ������������ �� ��������� (0=������ ������� 1=����� �������)
$rcxConfig['com_order'] = 0;

// ��������� �������� ����� ��������? (1=�� 0=���)
$rcxConfig['avatar_allow_upload'] = 0;

// ������ �������
$rcxConfig['avatar_width'] = 75;

// ������ �������
$rcxConfig['avatar_height'] = 100;

// ������ ������� (����)
$rcxConfig['avatar_maxsize'] = 4000;

// HTML-����, ������� ������ ����� ������������ � ���������� (��� ���������)
$rcxConfig['admin_html'] = "a|abbr|acronym|address|applet|area|b|bdo|big|blockquote|br|button|caption|center|cite|code|col|colgroup|dd|del|dfn|dir|div|dl|dt|em|embed|fieldset|font|form|frameset|h1|h2|h3|h4|h5|h6|hr|i|iframe|img|input|ins|kbd|label|legend|li|map|menu|noscript|object|ol|optgroup|option|p|param|pre|q|s|samp|script|select|small|span|strike|strong|sub|sup|table|tbody|td|textarea|tfoot|th|thead|tr|tt|u|ul|var";

// HTML-����, ������� ������������ ����� ������������ � ���������� (��� ���������)
$rcxConfig['user_html'] = "br";

// �������/������� ����
$rcxConfig['maintenance'] = 0;

// �������� ��������� ����������� ��� �������������� (1=�� 0=���)
$rcxConfig['use_auth_admin'] = 0;

// �������� ����� �������������� ������.<br /><br /><span style='font-size:x-small;font-weight:normal;'>������������� ����� �������� ����� ��������� ���� �������� �������. ��������� � ������ ��������������� ��� ��������.</span> (1=�� 0=���)
$rcxConfig['use_session_regenerate_id'] = 0;

// ����� ����� �������������� ����� (� ��������)<br /><br /><span style='font-size:x-small;font-weight:normal;'>���������� �������, ����� ������� ������������� ������ ����� ��������.<br /><br /><u>������ ���� �������� ����� �������������� ������.</u></span> (1=�� 0=���)
$rcxConfig['session_regenerate_id_lifetime'] = 60;

// �������� ����� ��� ����� � ������ �����������������<br /><br /><span style='font-size:x-small;font-weight:normal;'>������ ���� �������� <u>��������� ����������� ��� ��������������</u></span> (1=�� 0=���)
$rcxConfig['use_captcha_for_admin'] = 0;

// �������� �� e-mail �������������� ���������� � ������ � ������ �����������������<br /><br /><span style='font-size:x-small;font-weight:normal;'>������ ���� �������� <u>��������� ����������� ��� ��������������</u></span> (1=�� 0=���)
$rcxConfig['admin_login_notify'] = 0;

// �������� ������ �� ������� ������ ��� �����������<br /><br /><span style='font-size:x-small;font-weight:normal;'>����� N (��������������� ����) ��������� ������� ����� ������, IP ���������� ����������� �� X (��������������� ����) �����.</span> (1=�� 0=���)
$rcxConfig['check_bruteforce_login'] = 1;

// ���������� ��������� ������� �����.<br /><br /><span style='font-size:x-small;font-weight:normal;'>����� ���������� ����� �����, IP ���������� ����� ������������ �� ������������� �����.<br /><br /><u>������ ���� �������� ������ �� ������� ������.</u></span>
$rcxConfig['count_failed_auth'] = "5";

// ����� (� ���.), �� �������, ����� ������������ IP ����������.<br /><br /><span style='font-size:x-small;font-weight:normal;'>����� ���������� �������������� ���������� ��������� ������� �����.<br /><br /><u>������ ���� �������� ������ �� ������� ������.</u></span>
$rcxConfig['failed_lock_time'] = "15";

// �������� �� e-mail �������������� ���������� � ������� ������� ������.<br /><br /><span style='font-size:x-small;font-weight:normal;'>��� ���������� �������������� ���������� ��������� ������� �����.<br /><br /><u>������ ���� �������� ������ �� ������� ������.</u></span> (1=�� 0=���)
$rcxConfig['admin_bruteforce_notify'] = 0;

// �������� ������� ������ (����� ��������)<br /><br /><span style='font-size:x-small;font-weight:normal;'><i>������ ����������� ����������� BB-����</i><br /><br />� ������������, � ������� ������������, ������ �� ���� ������������ � �.�.</span> (1=�� 0=���)
$rcxConfig['hide_external_links'] = 0;

// ���������� ������ � cookies <u>��������������</u> ������ ����� HTTP �������� (�� ������ cookies ��� �� ����� �����������)<br /><br /><span style='font-size:x-small;font-weight:normal;'>��� ��������, ��� cookies �� ����� �������� ����� ���������� �����, ����� ��� JavaScript. ������ ��������� ��������� ���������� �������� �� XSS ���� (��� ������� �������������� �� ����� ������� �������� ���������)</span> (1=�� 0=���)
$rcxConfig['cookie_httponly'] = 0;

// ��������� ������������ ������������� ������ � URL<br /><br /><span style='font-size:x-small;font-weight:normal;'>����������, ����� �� PHP ������������ ������ cookies ��� �������� �������������� ������ �� ������� �������. ��������� ����� ��������� ������������� ����� � �������������� �������������� ������, ������������ � URL.</span> (1=�� 0=���)
$rcxConfig['use_only_cookies'] = 0;

// ��������� ������ �������������������� ����������� � �������� ������������� (1=�� 0=���)
$rcxConfig['ban_profile_viewer'] = 0;

// ��������� ��������<br /><br /><span style='font-size:x-small;font-weight:normal;'>���� ��������� �� ����� ����������������� � �������������� ������ � ����� ��������� � DHTML ���������. ���������� �����, ��� ����� �����. </span> (1=�� 0=���)
$rcxConfig['no_smile'] = 0;

// ��������� BB-��� � ������� ������������ (1=�� 0=���)
$rcxConfig['no_bbcode_user_sig'] = 0;
    
// ���������� ���� ��������� ���������� � �������� ���� ������<br /><br /><span style='font-size:x-small;font-weight:normal;'>��������, ���� �������� ����� ����������� ������������ ("����������", ����� ������� ������ �������� � �.�.).</span> (1=�� 0=���)
$rcxConfig['bd_set_names'] = 0;
    
// ��������� ��� ���������� � �������� ���� ������
$rcxConfig['bd_charset_name'] = "cp1251";
    
// �������� HTTP �����������<br /><br /><span style='font-size:x-small;font-weight:normal;'>������������� HTTP ��������� If-Modified-Since</span> (1=�� 0=���)
$rcxConfig['use_http_caching'] = 0;
    
// ����� HTTP ����������� �������, ���.
$rcxConfig['http_cache_time'] = "10080";
    
// USER AGENT ��� ������� �������� HTTP �����������<br /><br /><span style='font-size:x-small;font-weight:normal;'>����������� ���������� ��������� � �� ��������� ������������ ��������� �������, ����� ��� ����� �������� � ������<br /><br />� ��������� �� ��������� ������������ �����, ������ ����: <b>\.</b></span>
$rcxConfig['http_caching_user_agent'] = "Yandex|Googlebot|Yahoo|msnbot|StackRambler|WebAlta Crawler|aport|Mail\.Ru";
    
// ��������� �������� � ������� �������� (1=�� 0=���)
$rcxConfig['no_redirect'] = 0;

?>