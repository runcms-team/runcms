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

define("_UPGRADE_TITLE", "RUNCMS 2.2.2 -> RUNCMS 2.2.3.0 RC");

define("_UPGRADE_FOOTER","
<br /><br />
��� ���������� ������� �� ����� ������ ������ ��������� �������������� ���������� ���� ����� �������. ���� ����� �� ���������:
�� ������ ����� � ������ ����������������� ������, � �������������� �������� ��� ���� ������.<br /><br/>

<b>1.</b> ������� � ������ ����������������� �������� � �������� ��� ������������� ������<br />
<b>2.</b> ������� � ������ �������� �������� ����� - ���������, ��� �������� ����� ������� ������� ����������� �����<br />
<b>3.</b> ������� � ������ ����������������� ����� - ���������, ��� ����������� ����� ������� ��� ������ ������ ����������� �����<br />
<b>4.</b> �����. ������ ���������� � ������������ �����. ������ �����!<br /><br />
<br />
<a href='../user.php' ><b><i>���� �� ����!</i></b></a><br /><br />");

define("_UPGRADE_SAVE_CONFIG", "���������������� ���� ����� ������� �����������");
define("_UPGRADE_NO_SAVE_CONFIG", "�� ������� ������������ ���������������� ���� �����");

define("_UPGRADE_SAVE_META", "���� �������� ����-����� ������� �����������");
define("_UPGRADE_NO_SAVE_META", "�� ������� ������������ ���� �������� ����-�����");

define("_UPGRADE_MODULE_UPDATE", "������ \"%s\" ��������");
define("_UPGRADE_NO_MODULE_UPDATE", "�� ������� �������� ������ \"%s\"");

define("_UPGRADE_CONGRAT" , "���������� ���������! ����������� ������� ����� ");

define("_UPGRADE_RMDIR", "���������� \"%s\" �������");
define("_UPGRADE_NO_RMDIR", "�� ������� ������� ���������� \"%s\"");


$message[0]['noerror'] = "��� ���� title � ������� stories ��� ������� �� VARCHAR( 255 )";
$message[0]['error'] = "��� ���� title � ������� stories �� ��� ������� �� VARCHAR( 255 )";

$message[1]['noerror'] = "��� ���� topic_title � ������� topics ��� ������� �� VARCHAR( 255 )";
$message[1]['error'] = "��� ���� topic_title � ������� topics �� ��� ������� �� VARCHAR( 255 )";

$message[2]['noerror'] = "��� ���� title � ������� nseccont ��� ������� �� VARCHAR( 255 )";
$message[2]['error'] = "��� ���� title � ������� nseccont �� ��� ������� �� VARCHAR( 255 )";

$message[3]['noerror'] = "��� ���� secname � ������� nsections ��� ������� �� VARCHAR( 255 )";
$message[3]['error'] = "��� ���� secname � ������� nsections �� ��� ������� �� VARCHAR( 255 )";

$message[4]['noerror'] = "� ������� session ��� ������ ������ PRIMARY";
$message[4]['error'] = "� ������� session �� ��� ������ ������ PRIMARY";

$message[5]['noerror'] = "������� cpsession �������";
$message[5]['error'] = "������� cpsession �� �������";

$message[6]['noerror'] = "������� login_log �������";
$message[6]['error'] = "������� login_log �� �������";

?>