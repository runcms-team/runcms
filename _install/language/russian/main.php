<?php
// +----------------------------------------------------------------------+
// | Language files for RUNCMS 2.2                                        |
// +----------------------------------------------------------------------+
// | Copyright (c) 2010 runcms.ru team                                    |
// +----------------------------------------------------------------------+
// | This program is free software; you can redistribute it and/or modify |
// | it under the terms of the GNU General Public License as published by |
// | the Free Software Foundation; either version 2 of the License, or    |
// | (at your option) any later version.                                  |
// |                                                                      |
// | This program is distributed in the hope that it will be useful,      |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of       |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the        |
// | GNU General Public License for more details.                         |
// |                                                                      |
// | You should have received a copy of the GNU General Public License    |
// | along with this program; if not, write to:                           |
// |                                                                      |
// | Free Software Foundation, Inc.                                       |
// | 59 Temple Place - Suite 330                                          |
// | Boston, MA 02111-1307, USA.                                          |
// +----------------------------------------------------------------------+
// | Language: Russian                                                    |
// | Version of the translation: 4.3                                      |
// | Last modification: 2010-07-15                                        |
// | Translated by: See /language/russian/credits.txt                     |
// | Homepage: http://www.runcms.ru                                       |
// +----------------------------------------------------------------------+


// Welcome Screen
define("_INSTALL_W_WELCOME"   , "����� ���������� � ��������� ��������� %s");
define("_INSTALL_W_CHOOSE"    , "������� ����������� �������� (���������/����������):");
define("_INSTALL_W_CHOOSELANG", "������� ����, ������� ����� ����������� � �������� ���������");

// Server Tests
define("_INSTALL_ST_TESTS"       , "���������� ������������ �������:");
define("_INSTALL_ST_MAINFILE_OK" , "<img src='images/check.gif' /> <b>mainfile.php</b> �������� ��� ������.");
define("_INSTALL_ST_MAINFILE_BAD", "<img src='images/failed.gif' /> <b>mainfile.php</b> � �������� ���������� ������� ������ ����� ����� ������� 0666 Unix / read-write Win32");
define("_INSTALL_ST_MYSQL_OK"    , "<img src='images/check.gif' /> MySQL %s.");
define("_INSTALL_ST_MYSQL_BAD"   , "<img src='images/failed.gif' /> MySQL %s.");
define("_INSTALL_ST_MYSQL_BAD2"  , "���������� ���������� ������ MySQL. �������������� ������ ���������� � 3.23.xx.");
define("_INSTALL_ST_GLOBALS_OK"  , "<img src='images/check.gif' /> Register Globals �������.");
define("_INSTALL_ST_GLOBALS_BAD" , "<img src='images/question.gif' /> Register Globals �������� (��� �� ������ �� ���������������� �������).");
define("_INSTALL_ST_PHP_OK"      , "<img src='images/check.gif' /> PHP %s.");
define("_INSTALL_ST_PHP_BAD"     , "<img src='images/failed.gif' /> PHP %s.");
define("_INSTALL_ST_NEXT"        , "���� ���������� �������� �� �������� ������, ����� ���������� ���������.");
define("_INSTALL_PHPINFO"        , "���������� � PHP");

// DBFORM
define("_INSTALL_DF_DB"          ,"���� ������");
define("_INSTALL_DF_DB1"         ,"<i>������� ��� ���� ������ (�� ������ ������, ������ MySql)</i>");
define("_INSTALL_DF_HOST"        ,"��� ��� IP-����� ������� ���� ������");
define("_INSTALL_DF_HOST1"       ,"<i>�������� ��� ��� IP-����� ������� �� ������� ����������� ���� ������. <br /><br />��� ���������� ������� (�������� ������ '������') ��� ������� <b>localhost</b></i>");
define("_INSTALL_DF_UNAME"       ,"��� ������������ ���� ������");
define("_INSTALL_DF_UNAME1"      ,"<i>��� ������������ (�����) ��� ������� � ���� ������. <br /><br />��� ���������� ������� (�������� ������ '������') ��� ������� <b>root</b></i>");
define("_INSTALL_DF_PASS"        ,"������ � ���� ������");
define("_INSTALL_DF_PASS1"       ,"<i>������ ������������ ��� ������� � ���� ������. <br /><br />��� ���������� ������� (�������� ������ '������') ������, ��� �������, �� ����������</i>");
define("_INSTALL_DF_DBNAME"      ,"��� ���� ������");
define("_INSTALL_DF_DBNAME1"     ,"<i>��������� ��������� ��������� ������� ����� ���� ������, ���� ���� ������ � ��������� ������ �� ����������</i>");
define("_INSTALL_DF_PREFIX"      ,"������� ������");
define("_INSTALL_DF_PREFIX1"     ,"<i>������� ������������ ��������� �������. ����� ������������ ���� �������. <br /><br />������ ������� ����� �������� �� ���� ����������� ��������, ����� ��������� ��������� � ������� ��������� ���� ������</i>");
define("_INSTALL_DF_PCONNECT"    ,"���������� ���������� ���������� � �������� ���� ������");
define("_INSTALL_DF_PCONNECT1"   ,"<i>������� '���' ���� �� ������� � ����������. <br /><br />��� '���������� ����������', ���������� � �������� ���� ������ �� ����������� �� ��������� ���������� ������ �������</i>");
define("_INSTALL_DF_PATH"        ,"���������� ���� (�������� ����������)");
define("_INSTALL_DF_PATH1"       ,"<i>���������� (��������) ���� � �������� (��������) ���������� RUNCMS (<b>��� ������������ �����</b>). <br /><br />� ����������� ������� ������������� �� ���������, ��� ��� ������������ �������������. <br /><br />��� ����������� � WINDOWS �� �������� ������� ��� �����, �������� <b>c:/���_�����</b></i>");
define("_INSTALL_DF_URL"         ,"HTTP ����� (URL)");
define("_INSTALL_DF_URL1"        ,"<i>HTTP ����� (URL �����) �������� ���������� RUNCMS (<b>��� ������������ �����</b>). <br /><br />� ����������� ������� ������������� �� ���������, ��� ��� ������������ �������������. <br /><br />�������� <b>http://www.�������.ru</b> ��� <b>http://www.�������.ru/���_�����</b></i>");
define("_INSTALL_DF_PLEASE_ENTER","������� ���������� ������ ��� ����: \"%s\"");
define("_INSTALL_DF_ERRORS"      , "�������� ��������� ������:");
define("_INSTALL_DF_BADROOT"     , "���������� ���� ������ �������.");
define("_INSTALL_DF_BADDB"       , "���������� ����������� ��� ������� ���� ������ �� ���������� ������� �� �������.");
define("_INSTALL_DF_OK"          , "��� ��������� ������ ������ ��������, ����� ���������� ���������.");
define("_INSTALL_LANG"           , "���� ���������.");


// Mainfile setup
define("_INSTALL_MF_FAILOPEN" ,"��� ������� � mainfile.php. ��������� ������������� ���� � ���������� �����.");
define("_INSTALL_MF_FAILWRITE","��� ������� � mainfile.php. ��������� � ����� ��������� ��������������� ��� ��������� ������.");
define("_INSTALL_MF_WRITEOK"  ,"������ ������������ ���� ������� �������� � ���� <i>mainfile.php</i>");

// Admin Setup
define("_INSTALL_AD_MSG"     , "������� ������� ������ ��������������:");
define("_INSTALL_AD_UNAME"   , "��� (�����) ��������������:");
define("_INSTALL_AD_EMAIL"   , "E-mail ��������������:");
define("_INSTALL_AD_PASS"    , "������ ��� ����������� �� �����:");
define("_INSTALL_AD_BADPASS" , "������ ������ ��������� ����� %s ��������");
define("_INSTALL_AD_BADUNAME", "� ����� ������������ ����������� ������ ����� � ��������� ������� ��� ��������");
define("_INSTALL_AD_BADEMAIL", "����������� ����� ������ E-mail");

// DB CREATION
define("_INSTALL_DB_DBERROR" , "�������� ���� ������ �� �������. ������������ ������� ���� �������.");
define("_INSTALL_DB_TRYAGAIN", "������� <a href='%s'>����</a> ����� ������ ������� ��������� ��� ���.");

// Finish
define("_INSTALL_F_CONGRAT" , "�� ������ ������� �� ������� �������� ������ ����� ����� �� ������ ��������� ����"); // �����������! ��������� <b>RUNCMS</b> ���������.
define("_INSTALL_F_CHMOD"   , "���������, ��� ����� �� ������ � ������ ����������:");
define("_INSTALL_F_CHMODMSG", "����� ����������� ����������� ������ ��� ������������� ���� �� ������ � ������");
define("_INSTALL_F_VISIT"   , "�� ������ ������� �� ��� ���� ����� <a href='%s/'><b>�����</b></a>.");

// Some general stuff
define("_INSTALL_G_TITLE" , "���������");
define("_INSTALL_U_CHOOSE", "������� ����� ��� �������:");
define("_INSTALL_U_NOTE"  , "���������: ������ ���� mainfile.php ������ ���� �� ����� � ��������� ���������� ����������");
define("_INSTALL_U_README", "������� <a href='%s' target='_blank'>����</a> ��� ���� ����� ���������� <b>README</b>.");

define("_INSTALL_W"    , "��������� ---->:");

// index.php //
define("_MI_DOCHMOD_TEXT", "����� ������������� ��������� ����� ������� (CHMOD) � ������ � ������ �����, ��������� ����������������� �����, ������ ����������� ������, ��� ������� � ������ FTP-�������.<br /><br />������ ������� ����� ������� � ������ � ������ (CHMOD) ����� �� ������ �������� � �������� ���� �����:");
define("_MI_DOCHMOD_MANUAL", "���� �� ������ ���������� ����� ������� (CHMOD) �������, ����������� FTP-������.<br /><br />���� �� ������� ������ ������ � ������������� ���������� CHMOD, � �������� CHMOD, ������� ��� ������ �����.<br /><br /> ��������� FTP-������, ���������� ���������� �������� CHMOD<br /><br /> ������� ��������, �� �������, ����� ����� �� ����������<br /><br />���� ��� ����� ������� ����������� ���������, �� ������� ������ �� ����� ������������� ����.");
define("_MI_DOCHMOD_FTPDOMAIN","FTP ������ (��������: ftp.yoursite.com)");
define("_MI_DOCHMOD_FTPUSER","������� ������:");
define("_MI_DOCHMOD_FTPPASS","������:");
define("_MI_DOCHMOD_FTPPATH","��� �������� �����, ��� ���������� ���� mainfile.php (��������: httpdocs/ , domainname/, /,  ...)");
define("_MI_DOCHMOD_BUTTON","�����������");
define("_MI_DOCHMOD_BROWSETOMAINFILE","�������� ����������, � ������� ���������� ���� <b>mainfile.php</b>");
define("_MI_DOCHMOD_HASMAINFILEPHP"," ���� <b>mainfile.php</b> ���������, ������ ��������� ���� ������� (CHMOD) � ������ � ������ �����?");
define("_MI_DOCHMOD_ERRORS"," %s  ������.");
define("_MI_DOCHMOD_COMPLETE","������ ���� ������� � ������ � ������ (CHMOD):");
define("_MI_DOCHMOD_TITLEERROR", "<b>������!</b>");
define("_MI_DOCHMOD_CONNERROR1","������ ����������. ����������� � FTP-�������� �� �������. ���������� �����.");
define("_MI_DOCHMOD_CONNERROR2","������� ������");
define("_MI_DOCHMOD_CONNERROR3","�����");
define("_MI_DOCHMOD_CONNERROR4","FTP ������! ���� mainfile.php �� ������!.");
define("_MI_DOCHMOD_OKTITLE","<b>�����������! ��������� <b>RUNCMS</b> ���������.</b><br />"); // <b>��� � ���!</b>
define("_MI_DOCHMOD_OKDESCRIPTION","�� �������� ��� ������������ ������ ����� ������� ����� /_install/<br />�� �������� ��� ������������ ������ ����� ���������� ����� ������� <br />� ����� /mainfile.php - ������ ������ (CHMOD = 444)<br />");
define("_FILEMISSINGUPLOADTHISAGAIN","���� �����������, ��������� ��� ��������");

?>