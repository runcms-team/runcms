<?php 
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
* converted to Runcms2 serie by Farsus Design www.farsus.dk
*
* Original Author: LARK (balnov@kaluga.net)
* Support of the module : http://www.runcms.ru
* License Type : ATTENTION! See /LICENSE.txt
* Copyright: (C) 2005 Vladislav Balnov. All rights reserved
*
*/ 
defined( 'RCX_ROOT_PATH' ) or exit( '<h1>Forbidden</h1> You don\'t have permission to access' );

function colors_popup()
{
    rcx_header(false);
    $id = $_GET['id'];
    $spacer = RCX_URL . "/modules/system/admin/tpleditor/images/spacer.gif";

    ?>
<script type="text/javascript">
<!--
 if(window.self.name != 'colors_popup')
    window.close();

	function selColor(addColor) {
	var currentMessage = window.opener.rcxGetElementById('<?php echo $id;?>').value;
	window.opener.rcxGetElementById('<?php echo $id;?>').value=addColor;
	window.opener.rcxGetElementById('<?php echo $id;?>ShowColor').style.backgroundColor = addColor;
	window.close();
	return;
	}
	//-->
	</script>
</head>
<body>
<table width= "100%" border="0" cellspacing="1" cellpadding="1">
    <tr>
	<td bgcolor="#000000"><img src="<?php echo $spacer;?>" onClick="selColor('#000000')"></td>
	<td bgcolor="#060606"><img src="<?php echo $spacer;?>" onClick="selColor('#060606')"></td>
	<td bgcolor="#0c0c0c"><img src="<?php echo $spacer;?>" onClick="selColor('#0c0c0c')"></td>
	<td bgcolor="#121212"><img src="<?php echo $spacer;?>" onClick="selColor('#121212')"></td>
	<td bgcolor="#181818"><img src="<?php echo $spacer;?>" onClick="selColor('#181818')"></td>
	<td bgcolor="#1e1e1e"><img src="<?php echo $spacer;?>" onClick="selColor('#1e1e1e')"></td>
	<td bgcolor="#242424"><img src="<?php echo $spacer;?>" onClick="selColor('#242424')"></td>
	<td bgcolor="#000000"><img src="<?php echo $spacer;?>" onClick="selColor('#000000')"></td>
	<td bgcolor="#00002b"><img src="<?php echo $spacer;?>" onClick="selColor('#00002b')"></td>
	<td bgcolor="#000056"><img src="<?php echo $spacer;?>" onClick="selColor('#000056')"></td>
	<td bgcolor="#000081"><img src="<?php echo $spacer;?>" onClick="selColor('#000081')"></td>
	<td bgcolor="#0000ac"><img src="<?php echo $spacer;?>" onClick="selColor('#0000ac')"></td>
	<td bgcolor="#0000d7"><img src="<?php echo $spacer;?>" onClick="selColor('#0000d7')"></td>
	<td bgcolor="#0000ff"><img src="<?php echo $spacer;?>" onClick="selColor('#0000ff')"></td>
	<td bgcolor="#002b00"><img src="<?php echo $spacer;?>" onClick="selColor('#002b00')"></td>
	<td bgcolor="#002b2b"><img src="<?php echo $spacer;?>" onClick="selColor('#002b2b')"></td>
	<td bgcolor="#002b56"><img src="<?php echo $spacer;?>" onClick="selColor('#002b56')"></td>
	<td bgcolor="#002b81"><img src="<?php echo $spacer;?>" onClick="selColor('#002b81')"></td>
	<td bgcolor="#002bac"><img src="<?php echo $spacer;?>" onClick="selColor('#002bac')"></td>
	<td bgcolor="#002bd7"><img src="<?php echo $spacer;?>" onClick="selColor('#002bd7')"></td>
	<td bgcolor="#002bff"><img src="<?php echo $spacer;?>" onClick="selColor('#002bff')"></td>
	<td bgcolor="#005600"><img src="<?php echo $spacer;?>" onClick="selColor('#005600')"></td>
	<td bgcolor="#00562b"><img src="<?php echo $spacer;?>" onClick="selColor('#00562b')"></td>
	<td bgcolor="#005656"><img src="<?php echo $spacer;?>" onClick="selColor('#005656')"></td>
	<td bgcolor="#005681"><img src="<?php echo $spacer;?>" onClick="selColor('#005681')"></td>
	<td bgcolor="#0056ac"><img src="<?php echo $spacer;?>" onClick="selColor('#0056ac')"></td>
	<td bgcolor="#0056d7"><img src="<?php echo $spacer;?>" onClick="selColor('#0056d7')"></td>
	<td bgcolor="#0056ff"><img src="<?php echo $spacer;?>" onClick="selColor('#0056ff')"></td>
    </tr>
    <tr>
	<td bgcolor="#252525"><img src="<?php echo $spacer;?>" onClick="selColor('#252525')"></td>
	<td bgcolor="#2b2b2b"><img src="<?php echo $spacer;?>" onClick="selColor('#2b2b2b')"></td>
	<td bgcolor="#313131"><img src="<?php echo $spacer;?>" onClick="selColor('#313131')"></td>
	<td bgcolor="#373737"><img src="<?php echo $spacer;?>" onClick="selColor('#373737')"></td>
	<td bgcolor="#3d3d3d"><img src="<?php echo $spacer;?>" onClick="selColor('#3d3d3d')"></td>
	<td bgcolor="#434343"><img src="<?php echo $spacer;?>" onClick="selColor('#434343')"></td>
	<td bgcolor="#494949"><img src="<?php echo $spacer;?>" onClick="selColor('#494949')"></td>
	<td bgcolor="#2b0000"><img src="<?php echo $spacer;?>" onClick="selColor('#2b0000')"></td>
	<td bgcolor="#2b002b"><img src="<?php echo $spacer;?>" onClick="selColor('#2b002b')"></td>
	<td bgcolor="#2b0056"><img src="<?php echo $spacer;?>" onClick="selColor('#2b0056')"></td>
	<td bgcolor="#2b0081"><img src="<?php echo $spacer;?>" onClick="selColor('#2b0081')"></td>
	<td bgcolor="#2b00ac"><img src="<?php echo $spacer;?>" onClick="selColor('#2b00ac')"></td>
	<td bgcolor="#2b00d7"><img src="<?php echo $spacer;?>" onClick="selColor('#2b00d7')"></td>
	<td bgcolor="#2b00ff"><img src="<?php echo $spacer;?>" onClick="selColor('#2b00ff')"></td>
	<td bgcolor="#2b2b00"><img src="<?php echo $spacer;?>" onClick="selColor('#2b2b00')"></td>
	<td bgcolor="#2b2b2b"><img src="<?php echo $spacer;?>" onClick="selColor('#2b2b2b')"></td>
	<td bgcolor="#2b2b56"><img src="<?php echo $spacer;?>" onClick="selColor('#2b2b56')"></td>
	<td bgcolor="#2b2b81"><img src="<?php echo $spacer;?>" onClick="selColor('#2b2b81')"></td>
	<td bgcolor="#2b2bac"><img src="<?php echo $spacer;?>" onClick="selColor('#2b2bac')"></td>
	<td bgcolor="#2b2bd7"><img src="<?php echo $spacer;?>" onClick="selColor('#2b2bd7')"></td>
	<td bgcolor="#2b2bff"><img src="<?php echo $spacer;?>" onClick="selColor('#2b2bff')"></td>
	<td bgcolor="#2b5600"><img src="<?php echo $spacer;?>" onClick="selColor('#2b5600')"></td>
	<td bgcolor="#2b562b"><img src="<?php echo $spacer;?>" onClick="selColor('#2b562b')"></td>
	<td bgcolor="#2b5656"><img src="<?php echo $spacer;?>" onClick="selColor('#2b5656')"></td>
	<td bgcolor="#2b5681"><img src="<?php echo $spacer;?>" onClick="selColor('#2b5681')"></td>
	<td bgcolor="#2b56ac"><img src="<?php echo $spacer;?>" onClick="selColor('#2b56ac')"></td>
	<td bgcolor="#2b56d7"><img src="<?php echo $spacer;?>" onClick="selColor('#2b56d7')"></td>
	<td bgcolor="#2b56ff"><img src="<?php echo $spacer;?>" onClick="selColor('#2b56ff')"></td>
    </tr>
    <tr>
	<td bgcolor="#4a4a4a"><img src="<?php echo $spacer;?>" onClick="selColor('#4a4a4a')"></td>
	<td bgcolor="#505050"><img src="<?php echo $spacer;?>" onClick="selColor('#505050')"></td>
	<td bgcolor="#565656"><img src="<?php echo $spacer;?>" onClick="selColor('#565656')"></td>
	<td bgcolor="#5c5c5c"><img src="<?php echo $spacer;?>" onClick="selColor('#5c5c5c')"></td>
	<td bgcolor="#626262"><img src="<?php echo $spacer;?>" onClick="selColor('#626262')"></td>
	<td bgcolor="#686868"><img src="<?php echo $spacer;?>" onClick="selColor('#686868')"></td>
	<td bgcolor="#6e6e6e"><img src="<?php echo $spacer;?>" onClick="selColor('#6e6e6e')"></td>
	<td bgcolor="#560000"><img src="<?php echo $spacer;?>" onClick="selColor('#560000')"></td>
	<td bgcolor="#56002b"><img src="<?php echo $spacer;?>" onClick="selColor('#56002b')"></td>
	<td bgcolor="#560056"><img src="<?php echo $spacer;?>" onClick="selColor('#560056')"></td>
	<td bgcolor="#560081"><img src="<?php echo $spacer;?>" onClick="selColor('#560081')"></td>
	<td bgcolor="#5600ac"><img src="<?php echo $spacer;?>" onClick="selColor('#5600ac')"></td>
	<td bgcolor="#5600d7"><img src="<?php echo $spacer;?>" onClick="selColor('#5600d7')"></td>
	<td bgcolor="#5600ff"><img src="<?php echo $spacer;?>" onClick="selColor('#5600ff')"></td>
	<td bgcolor="#562b00"><img src="<?php echo $spacer;?>" onClick="selColor('#562b00')"></td>
	<td bgcolor="#562b2b"><img src="<?php echo $spacer;?>" onClick="selColor('#562b2b')"></td>
	<td bgcolor="#562b56"><img src="<?php echo $spacer;?>" onClick="selColor('#562b56')"></td>
	<td bgcolor="#562b81"><img src="<?php echo $spacer;?>" onClick="selColor('#562b81')"></td>
	<td bgcolor="#562bac"><img src="<?php echo $spacer;?>" onClick="selColor('#562bac')"></td>
	<td bgcolor="#562bd7"><img src="<?php echo $spacer;?>" onClick="selColor('#562bd7')"></td>
	<td bgcolor="#562bff"><img src="<?php echo $spacer;?>" onClick="selColor('#562bff')"></td>
	<td bgcolor="#565600"><img src="<?php echo $spacer;?>" onClick="selColor('#565600')"></td>
	<td bgcolor="#56562b"><img src="<?php echo $spacer;?>" onClick="selColor('#56562b')"></td>
	<td bgcolor="#565656"><img src="<?php echo $spacer;?>" onClick="selColor('#565656')"></td>
	<td bgcolor="#565681"><img src="<?php echo $spacer;?>" onClick="selColor('#565681')"></td>
	<td bgcolor="#5656ac"><img src="<?php echo $spacer;?>" onClick="selColor('#5656ac')"></td>
	<td bgcolor="#5656d7"><img src="<?php echo $spacer;?>" onClick="selColor('#5656d7')"></td>
	<td bgcolor="#5656ff"><img src="<?php echo $spacer;?>" onClick="selColor('#5656ff')"></td>
    </tr>
    <tr>
	<td bgcolor="#6f6f6f"><img src="<?php echo $spacer;?>" onClick="selColor('#6f6f6f')"></td>
	<td bgcolor="#757575"><img src="<?php echo $spacer;?>" onClick="selColor('#757575')"></td>
	<td bgcolor="#7b7b7b"><img src="<?php echo $spacer;?>" onClick="selColor('#7b7b7b')"></td>
	<td bgcolor="#818181"><img src="<?php echo $spacer;?>" onClick="selColor('#818181')"></td>
	<td bgcolor="#878787"><img src="<?php echo $spacer;?>" onClick="selColor('#878787')"></td>
	<td bgcolor="#8d8d8d"><img src="<?php echo $spacer;?>" onClick="selColor('#8d8d8d')"></td>
	<td bgcolor="#939393"><img src="<?php echo $spacer;?>" onClick="selColor('#939393')"></td>
	<td bgcolor="#810000"><img src="<?php echo $spacer;?>" onClick="selColor('#810000')"></td>
	<td bgcolor="#81002b"><img src="<?php echo $spacer;?>" onClick="selColor('#81002b')"></td>
	<td bgcolor="#810056"><img src="<?php echo $spacer;?>" onClick="selColor('#810056')"></td>
	<td bgcolor="#810081"><img src="<?php echo $spacer;?>" onClick="selColor('#810081')"></td>
	<td bgcolor="#8100ac"><img src="<?php echo $spacer;?>" onClick="selColor('#8100ac')"></td>
	<td bgcolor="#8100d7"><img src="<?php echo $spacer;?>" onClick="selColor('#8100d7')"></td>
	<td bgcolor="#8100ff"><img src="<?php echo $spacer;?>" onClick="selColor('#8100ff')"></td>
	<td bgcolor="#812b00"><img src="<?php echo $spacer;?>" onClick="selColor('#812b00')"></td>
	<td bgcolor="#812b2b"><img src="<?php echo $spacer;?>" onClick="selColor('#812b2b')"></td>
	<td bgcolor="#812b56"><img src="<?php echo $spacer;?>" onClick="selColor('#812b56')"></td>
	<td bgcolor="#812b81"><img src="<?php echo $spacer;?>" onClick="selColor('#812b81')"></td>
	<td bgcolor="#812bac"><img src="<?php echo $spacer;?>" onClick="selColor('#812bac')"></td>
	<td bgcolor="#812bd7"><img src="<?php echo $spacer;?>" onClick="selColor('#812bd7')"></td>
	<td bgcolor="#812bff"><img src="<?php echo $spacer;?>" onClick="selColor('#812bff')"></td>
	<td bgcolor="#815600"><img src="<?php echo $spacer;?>" onClick="selColor('#815600')"></td>
	<td bgcolor="#81562b"><img src="<?php echo $spacer;?>" onClick="selColor('#81562b')"></td>
	<td bgcolor="#815656"><img src="<?php echo $spacer;?>" onClick="selColor('#815656')"></td>
	<td bgcolor="#815681"><img src="<?php echo $spacer;?>" onClick="selColor('#815681')"></td>
	<td bgcolor="#8156ac"><img src="<?php echo $spacer;?>" onClick="selColor('#8156ac')"></td>
	<td bgcolor="#8156d7"><img src="<?php echo $spacer;?>" onClick="selColor('#8156d7')"></td>
	<td bgcolor="#8156ff"><img src="<?php echo $spacer;?>" onClick="selColor('#8156ff')"></td>
    </tr>
    <tr>
	<td bgcolor="#949494"><img src="<?php echo $spacer;?>" onClick="selColor('#949494')"></td>
	<td bgcolor="#9a9a9a"><img src="<?php echo $spacer;?>" onClick="selColor('#9a9a9a')"></td>
	<td bgcolor="#a0a0a0"><img src="<?php echo $spacer;?>" onClick="selColor('#a0a0a0')"></td>
	<td bgcolor="#a6a6a6"><img src="<?php echo $spacer;?>" onClick="selColor('#a6a6a6')"></td>
	<td bgcolor="#acacac"><img src="<?php echo $spacer;?>" onClick="selColor('#acacac')"></td>
	<td bgcolor="#b2b2b2"><img src="<?php echo $spacer;?>" onClick="selColor('#b2b2b2')"></td>
	<td bgcolor="#b8b8b8"><img src="<?php echo $spacer;?>" onClick="selColor('#b8b8b8')"></td>
	<td bgcolor="#ac0000"><img src="<?php echo $spacer;?>" onClick="selColor('#ac0000')"></td>
	<td bgcolor="#ac002b"><img src="<?php echo $spacer;?>" onClick="selColor('#ac002b')"></td>
	<td bgcolor="#ac0056"><img src="<?php echo $spacer;?>" onClick="selColor('#ac0056')"></td>
	<td bgcolor="#ac0081"><img src="<?php echo $spacer;?>" onClick="selColor('#ac0081')"></td>
	<td bgcolor="#ac00ac"><img src="<?php echo $spacer;?>" onClick="selColor('#ac00ac')"></td>
	<td bgcolor="#ac00d7"><img src="<?php echo $spacer;?>" onClick="selColor('#ac00d7')"></td>
	<td bgcolor="#ac00ff"><img src="<?php echo $spacer;?>" onClick="selColor('#ac00ff')"></td>
	<td bgcolor="#ac2b00"><img src="<?php echo $spacer;?>" onClick="selColor('#ac2b00')"></td>
	<td bgcolor="#ac2b2b"><img src="<?php echo $spacer;?>" onClick="selColor('#ac2b2b')"></td>
	<td bgcolor="#ac2b56"><img src="<?php echo $spacer;?>" onClick="selColor('#ac2b56')"></td>
	<td bgcolor="#ac2b81"><img src="<?php echo $spacer;?>" onClick="selColor('#ac2b81')"></td>
	<td bgcolor="#ac2bac"><img src="<?php echo $spacer;?>" onClick="selColor('#ac2bac')"></td>
	<td bgcolor="#ac2bd7"><img src="<?php echo $spacer;?>" onClick="selColor('#ac2bd7')"></td>
	<td bgcolor="#ac2bff"><img src="<?php echo $spacer;?>" onClick="selColor('#ac2bff')"></td>
	<td bgcolor="#ac5600"><img src="<?php echo $spacer;?>" onClick="selColor('#ac5600')"></td>
	<td bgcolor="#ac562b"><img src="<?php echo $spacer;?>" onClick="selColor('#ac562b')"></td>
	<td bgcolor="#ac5656"><img src="<?php echo $spacer;?>" onClick="selColor('#ac5656')"></td>
	<td bgcolor="#ac5681"><img src="<?php echo $spacer;?>" onClick="selColor('#ac5681')"></td>
	<td bgcolor="#ac56ac"><img src="<?php echo $spacer;?>" onClick="selColor('#ac56ac')"></td>
	<td bgcolor="#ac56d7"><img src="<?php echo $spacer;?>" onClick="selColor('#ac56d7')"></td>
	<td bgcolor="#ac56ff"><img src="<?php echo $spacer;?>" onClick="selColor('#ac56ff')"></td>
    </tr>
    <tr>
	<td bgcolor="#b9b9b9"><img src="<?php echo $spacer;?>" onClick="selColor('#b9b9b9')"></td>
	<td bgcolor="#bfbfbf"><img src="<?php echo $spacer;?>" onClick="selColor('#bfbfbf')"></td>
	<td bgcolor="#c5c5c5"><img src="<?php echo $spacer;?>" onClick="selColor('#c5c5c5')"></td>
	<td bgcolor="#cbcbcb"><img src="<?php echo $spacer;?>" onClick="selColor('#cbcbcb')"></td>
	<td bgcolor="#d1d1d1"><img src="<?php echo $spacer;?>" onClick="selColor('#d1d1d1')"></td>
	<td bgcolor="#d7d7d7"><img src="<?php echo $spacer;?>" onClick="selColor('#d7d7d7')"></td>
	<td bgcolor="#dddddd"><img src="<?php echo $spacer;?>" onClick="selColor('#dddddd')"></td>
	<td bgcolor="#d70000"><img src="<?php echo $spacer;?>" onClick="selColor('#d70000')"></td>
	<td bgcolor="#d7002b"><img src="<?php echo $spacer;?>" onClick="selColor('#d7002b')"></td>
	<td bgcolor="#d70056"><img src="<?php echo $spacer;?>" onClick="selColor('#d70056')"></td>
	<td bgcolor="#d70081"><img src="<?php echo $spacer;?>" onClick="selColor('#d70081')"></td>
	<td bgcolor="#d700ac"><img src="<?php echo $spacer;?>" onClick="selColor('#d700ac')"></td>
	<td bgcolor="#d700d7"><img src="<?php echo $spacer;?>" onClick="selColor('#d700d7')"></td>
	<td bgcolor="#d700ff"><img src="<?php echo $spacer;?>" onClick="selColor('#d700ff')"></td>
	<td bgcolor="#d72b00"><img src="<?php echo $spacer;?>" onClick="selColor('#d72b00')"></td>
	<td bgcolor="#d72b2b"><img src="<?php echo $spacer;?>" onClick="selColor('#d72b2b')"></td>
	<td bgcolor="#d72b56"><img src="<?php echo $spacer;?>" onClick="selColor('#d72b56')"></td>
	<td bgcolor="#d72b81"><img src="<?php echo $spacer;?>" onClick="selColor('#d72b81')"></td>
	<td bgcolor="#d72bac"><img src="<?php echo $spacer;?>" onClick="selColor('#d72bac')"></td>
	<td bgcolor="#d72bd7"><img src="<?php echo $spacer;?>" onClick="selColor('#d72bd7')"></td>
	<td bgcolor="#d72bff"><img src="<?php echo $spacer;?>" onClick="selColor('#d72bff')"></td>
	<td bgcolor="#d75600"><img src="<?php echo $spacer;?>" onClick="selColor('#d75600')"></td>
	<td bgcolor="#d7562b"><img src="<?php echo $spacer;?>" onClick="selColor('#d7562b')"></td>
	<td bgcolor="#d75656"><img src="<?php echo $spacer;?>" onClick="selColor('#d75656')"></td>
	<td bgcolor="#d75681"><img src="<?php echo $spacer;?>" onClick="selColor('#d75681')"></td>
	<td bgcolor="#d756ac"><img src="<?php echo $spacer;?>" onClick="selColor('#d756ac')"></td>
	<td bgcolor="#d756d7"><img src="<?php echo $spacer;?>" onClick="selColor('#d756d7')"></td>
	<td bgcolor="#d756ff"><img src="<?php echo $spacer;?>" onClick="selColor('#d756ff')"></td>
    </tr>
    <tr>
	<td bgcolor="#dedede"><img src="<?php echo $spacer;?>" onClick="selColor('#dedede')"></td>
	<td bgcolor="#e4e4e4"><img src="<?php echo $spacer;?>" onClick="selColor('#e4e4e4')"></td>
	<td bgcolor="#eaeaea"><img src="<?php echo $spacer;?>" onClick="selColor('#eaeaea')"></td>
	<td bgcolor="#f0f0f0"><img src="<?php echo $spacer;?>" onClick="selColor('#f0f0f0')"></td>
	<td bgcolor="#f6f6f6"><img src="<?php echo $spacer;?>" onClick="selColor('#f6f6f6')"></td>
	<td bgcolor="#fcfcfc"><img src="<?php echo $spacer;?>" onClick="selColor('#fcfcfc')"></td>
	<td bgcolor="#ffffff"><img src="<?php echo $spacer;?>" onClick="selColor('#ffffff')"></td>
	<td bgcolor="#ff0000"><img src="<?php echo $spacer;?>" onClick="selColor('#ff0000')"></td>
	<td bgcolor="#ff002b"><img src="<?php echo $spacer;?>" onClick="selColor('#ff002b')"></td>
	<td bgcolor="#ff0056"><img src="<?php echo $spacer;?>" onClick="selColor('#ff0056')"></td>
	<td bgcolor="#ff0081"><img src="<?php echo $spacer;?>" onClick="selColor('#ff0081')"></td>
	<td bgcolor="#ff00ac"><img src="<?php echo $spacer;?>" onClick="selColor('#ff00ac')"></td>
	<td bgcolor="#ff00d7"><img src="<?php echo $spacer;?>" onClick="selColor('#ff00d7')"></td>
	<td bgcolor="#ff00ff"><img src="<?php echo $spacer;?>" onClick="selColor('#ff00ff')"></td>
	<td bgcolor="#ff2b00"><img src="<?php echo $spacer;?>" onClick="selColor('#ff2b00')"></td>
	<td bgcolor="#ff2b2b"><img src="<?php echo $spacer;?>" onClick="selColor('#ff2b2b')"></td>
	<td bgcolor="#ff2b56"><img src="<?php echo $spacer;?>" onClick="selColor('#ff2b56')"></td>
	<td bgcolor="#ff2b81"><img src="<?php echo $spacer;?>" onClick="selColor('#ff2b81')"></td>
	<td bgcolor="#ff2bac"><img src="<?php echo $spacer;?>" onClick="selColor('#ff2bac')"></td>
	<td bgcolor="#ff2bd7"><img src="<?php echo $spacer;?>" onClick="selColor('#ff2bd7')"></td>
	<td bgcolor="#ff2bff"><img src="<?php echo $spacer;?>" onClick="selColor('#ff2bff')"></td>
	<td bgcolor="#ff5600"><img src="<?php echo $spacer;?>" onClick="selColor('#ff5600')"></td>
	<td bgcolor="#ff562b"><img src="<?php echo $spacer;?>" onClick="selColor('#ff562b')"></td>
	<td bgcolor="#ff5656"><img src="<?php echo $spacer;?>" onClick="selColor('#ff5656')"></td>
	<td bgcolor="#ff5681"><img src="<?php echo $spacer;?>" onClick="selColor('#ff5681')"></td>
	<td bgcolor="#ff56ac"><img src="<?php echo $spacer;?>" onClick="selColor('#ff56ac')"></td>
	<td bgcolor="#ff56d7"><img src="<?php echo $spacer;?>" onClick="selColor('#ff56d7')"></td>
	<td bgcolor="#ff56ff"><img src="<?php echo $spacer;?>" onClick="selColor('#ff56ff')"></td>
    </tr>
    <tr>
	<td bgcolor="#008100"><img src="<?php echo $spacer;?>" onClick="selColor('#008100')"></td>
	<td bgcolor="#00812b"><img src="<?php echo $spacer;?>" onClick="selColor('#00812b')"></td>
	<td bgcolor="#008156"><img src="<?php echo $spacer;?>" onClick="selColor('#008156')"></td>
	<td bgcolor="#008181"><img src="<?php echo $spacer;?>" onClick="selColor('#008181')"></td>
	<td bgcolor="#0081ac"><img src="<?php echo $spacer;?>" onClick="selColor('#0081ac')"></td>
	<td bgcolor="#0081d7"><img src="<?php echo $spacer;?>" onClick="selColor('#0081d7')"></td>
	<td bgcolor="#0081ff"><img src="<?php echo $spacer;?>" onClick="selColor('#0081ff')"></td>
	<td bgcolor="#00ac00"><img src="<?php echo $spacer;?>" onClick="selColor('#00ac00')"></td>
	<td bgcolor="#00ac2b"><img src="<?php echo $spacer;?>" onClick="selColor('#00ac2b')"></td>
	<td bgcolor="#00ac56"><img src="<?php echo $spacer;?>" onClick="selColor('#00ac56')"></td>
	<td bgcolor="#00ac81"><img src="<?php echo $spacer;?>" onClick="selColor('#00ac81')"></td>
	<td bgcolor="#00acac"><img src="<?php echo $spacer;?>" onClick="selColor('#00acac')"></td>
	<td bgcolor="#00acd7"><img src="<?php echo $spacer;?>" onClick="selColor('#00acd7')"></td>
	<td bgcolor="#00acff"><img src="<?php echo $spacer;?>" onClick="selColor('#00acff')"></td>
	<td bgcolor="#00d700"><img src="<?php echo $spacer;?>" onClick="selColor('#00d700')"></td>
	<td bgcolor="#00d72b"><img src="<?php echo $spacer;?>" onClick="selColor('#00d72b')"></td>
	<td bgcolor="#00d756"><img src="<?php echo $spacer;?>" onClick="selColor('#00d756')"></td>
	<td bgcolor="#00d781"><img src="<?php echo $spacer;?>" onClick="selColor('#00d781')"></td>
	<td bgcolor="#00d7ac"><img src="<?php echo $spacer;?>" onClick="selColor('#00d7ac')"></td>
	<td bgcolor="#00d7d7"><img src="<?php echo $spacer;?>" onClick="selColor('#00d7d7')"></td>
	<td bgcolor="#00d7ff"><img src="<?php echo $spacer;?>" onClick="selColor('#00d7ff')"></td>
	<td bgcolor="#00ff00"><img src="<?php echo $spacer;?>" onClick="selColor('#00ff00')"></td>
	<td bgcolor="#00ff2b"><img src="<?php echo $spacer;?>" onClick="selColor('#00ff2b')"></td>
	<td bgcolor="#00ff56"><img src="<?php echo $spacer;?>" onClick="selColor('#00ff56')"></td>
	<td bgcolor="#00ff81"><img src="<?php echo $spacer;?>" onClick="selColor('#00ff81')"></td>
	<td bgcolor="#00ffac"><img src="<?php echo $spacer;?>" onClick="selColor('#00ffac')"></td>
	<td bgcolor="#00ffd7"><img src="<?php echo $spacer;?>" onClick="selColor('#00ffd7')"></td>
	<td bgcolor="#00ffff"><img src="<?php echo $spacer;?>" onClick="selColor('#00ffff')"></td>
    </tr>
    <tr>
	<td bgcolor="#2b8100"><img src="<?php echo $spacer;?>" onClick="selColor('#2b8100')"></td>
	<td bgcolor="#2b812b"><img src="<?php echo $spacer;?>" onClick="selColor('#2b812b')"></td>
	<td bgcolor="#2b8156"><img src="<?php echo $spacer;?>" onClick="selColor('#2b8156')"></td>
	<td bgcolor="#2b8181"><img src="<?php echo $spacer;?>" onClick="selColor('#2b8181')"></td>
	<td bgcolor="#2b81ac"><img src="<?php echo $spacer;?>" onClick="selColor('#2b81ac')"></td>
	<td bgcolor="#2b81d7"><img src="<?php echo $spacer;?>" onClick="selColor('#2b81d7')"></td>
	<td bgcolor="#2b81ff"><img src="<?php echo $spacer;?>" onClick="selColor('#2b81ff')"></td>
	<td bgcolor="#2bac00"><img src="<?php echo $spacer;?>" onClick="selColor('#2bac00')"></td>
	<td bgcolor="#2bac2b"><img src="<?php echo $spacer;?>" onClick="selColor('#2bac2b')"></td>
	<td bgcolor="#2bac56"><img src="<?php echo $spacer;?>" onClick="selColor('#2bac56')"></td>
	<td bgcolor="#2bac81"><img src="<?php echo $spacer;?>" onClick="selColor('#2bac81')"></td>
	<td bgcolor="#2bacac"><img src="<?php echo $spacer;?>" onClick="selColor('#2bacac')"></td>
	<td bgcolor="#2bacd7"><img src="<?php echo $spacer;?>" onClick="selColor('#2bacd7')"></td>
	<td bgcolor="#2bacff"><img src="<?php echo $spacer;?>" onClick="selColor('#2bacff')"></td>
	<td bgcolor="#2bd700"><img src="<?php echo $spacer;?>" onClick="selColor('#2bd700')"></td>
	<td bgcolor="#2bd72b"><img src="<?php echo $spacer;?>" onClick="selColor('#2bd72b')"></td>
	<td bgcolor="#2bd756"><img src="<?php echo $spacer;?>" onClick="selColor('#2bd756')"></td>
	<td bgcolor="#2bd781"><img src="<?php echo $spacer;?>" onClick="selColor('#2bd781')"></td>
	<td bgcolor="#2bd7ac"><img src="<?php echo $spacer;?>" onClick="selColor('#2bd7ac')"></td>
	<td bgcolor="#2bd7d7"><img src="<?php echo $spacer;?>" onClick="selColor('#2bd7d7')"></td>
	<td bgcolor="#2bd7ff"><img src="<?php echo $spacer;?>" onClick="selColor('#2bd7ff')"></td>
	<td bgcolor="#2bff00"><img src="<?php echo $spacer;?>" onClick="selColor('#2bff00')"></td>
	<td bgcolor="#2bff2b"><img src="<?php echo $spacer;?>" onClick="selColor('#2bff2b')"></td>
	<td bgcolor="#2bff56"><img src="<?php echo $spacer;?>" onClick="selColor('#2bff56')"></td>
	<td bgcolor="#2bff81"><img src="<?php echo $spacer;?>" onClick="selColor('#2bff81')"></td>
	<td bgcolor="#2bffac"><img src="<?php echo $spacer;?>" onClick="selColor('#2bffac')"></td>
	<td bgcolor="#2bffd7"><img src="<?php echo $spacer;?>" onClick="selColor('#2bffd7')"></td>
	<td bgcolor="#2bffff"><img src="<?php echo $spacer;?>" onClick="selColor('#2bffff')"></td>
    </tr>
    <tr>
	<td bgcolor="#568100"><img src="<?php echo $spacer;?>" onClick="selColor('#568100')"></td>
	<td bgcolor="#56812b"><img src="<?php echo $spacer;?>" onClick="selColor('#56812b')"></td>
	<td bgcolor="#568156"><img src="<?php echo $spacer;?>" onClick="selColor('#568156')"></td>
	<td bgcolor="#568181"><img src="<?php echo $spacer;?>" onClick="selColor('#568181')"></td>
	<td bgcolor="#5681ac"><img src="<?php echo $spacer;?>" onClick="selColor('#5681ac')"></td>
	<td bgcolor="#5681d7"><img src="<?php echo $spacer;?>" onClick="selColor('#5681d7')"></td>
	<td bgcolor="#5681ff"><img src="<?php echo $spacer;?>" onClick="selColor('#5681ff')"></td>
	<td bgcolor="#56ac00"><img src="<?php echo $spacer;?>" onClick="selColor('#56ac00')"></td>
	<td bgcolor="#56ac2b"><img src="<?php echo $spacer;?>" onClick="selColor('#56ac2b')"></td>
	<td bgcolor="#56ac56"><img src="<?php echo $spacer;?>" onClick="selColor('#56ac56')"></td>
	<td bgcolor="#56ac81"><img src="<?php echo $spacer;?>" onClick="selColor('#56ac81')"></td>
	<td bgcolor="#56acac"><img src="<?php echo $spacer;?>" onClick="selColor('#56acac')"></td>
	<td bgcolor="#56acd7"><img src="<?php echo $spacer;?>" onClick="selColor('#56acd7')"></td>
	<td bgcolor="#56acff"><img src="<?php echo $spacer;?>" onClick="selColor('#56acff')"></td>
	<td bgcolor="#56d700"><img src="<?php echo $spacer;?>" onClick="selColor('#56d700')"></td>
	<td bgcolor="#56d72b"><img src="<?php echo $spacer;?>" onClick="selColor('#56d72b')"></td>
	<td bgcolor="#56d756"><img src="<?php echo $spacer;?>" onClick="selColor('#56d756')"></td>
	<td bgcolor="#56d781"><img src="<?php echo $spacer;?>" onClick="selColor('#56d781')"></td>
	<td bgcolor="#56d7ac"><img src="<?php echo $spacer;?>" onClick="selColor('#56d7ac')"></td>
	<td bgcolor="#56d7d7"><img src="<?php echo $spacer;?>" onClick="selColor('#56d7d7')"></td>
	<td bgcolor="#56d7ff"><img src="<?php echo $spacer;?>" onClick="selColor('#56d7ff')"></td>
	<td bgcolor="#56ff00"><img src="<?php echo $spacer;?>" onClick="selColor('#56ff00')"></td>
	<td bgcolor="#56ff2b"><img src="<?php echo $spacer;?>" onClick="selColor('#56ff2b')"></td>
	<td bgcolor="#56ff56"><img src="<?php echo $spacer;?>" onClick="selColor('#56ff56')"></td>
	<td bgcolor="#56ff81"><img src="<?php echo $spacer;?>" onClick="selColor('#56ff81')"></td>
	<td bgcolor="#56ffac"><img src="<?php echo $spacer;?>" onClick="selColor('#56ffac')"></td>
	<td bgcolor="#56ffd7"><img src="<?php echo $spacer;?>" onClick="selColor('#56ffd7')"></td>
	<td bgcolor="#56ffff"><img src="<?php echo $spacer;?>" onClick="selColor('#56ffff')"></td>
    </tr>
    <tr>
	<td bgcolor="#818100"><img src="<?php echo $spacer;?>" onClick="selColor('#818100')"></td>
	<td bgcolor="#81812b"><img src="<?php echo $spacer;?>" onClick="selColor('#81812b')"></td>
	<td bgcolor="#818156"><img src="<?php echo $spacer;?>" onClick="selColor('#818156')"></td>
	<td bgcolor="#818181"><img src="<?php echo $spacer;?>" onClick="selColor('#818181')"></td>
	<td bgcolor="#8181ac"><img src="<?php echo $spacer;?>" onClick="selColor('#8181ac')"></td>
	<td bgcolor="#8181d7"><img src="<?php echo $spacer;?>" onClick="selColor('#8181d7')"></td>
	<td bgcolor="#8181ff"><img src="<?php echo $spacer;?>" onClick="selColor('#8181ff')"></td>
	<td bgcolor="#81ac00"><img src="<?php echo $spacer;?>" onClick="selColor('#81ac00')"></td>
	<td bgcolor="#81ac2b"><img src="<?php echo $spacer;?>" onClick="selColor('#81ac2b')"></td>
	<td bgcolor="#81ac56"><img src="<?php echo $spacer;?>" onClick="selColor('#81ac56')"></td>
	<td bgcolor="#81ac81"><img src="<?php echo $spacer;?>" onClick="selColor('#81ac81')"></td>
	<td bgcolor="#81acac"><img src="<?php echo $spacer;?>" onClick="selColor('#81acac')"></td>
	<td bgcolor="#81acd7"><img src="<?php echo $spacer;?>" onClick="selColor('#81acd7')"></td>
	<td bgcolor="#81acff"><img src="<?php echo $spacer;?>" onClick="selColor('#81acff')"></td>
	<td bgcolor="#81d700"><img src="<?php echo $spacer;?>" onClick="selColor('#81d700')"></td>
	<td bgcolor="#81d72b"><img src="<?php echo $spacer;?>" onClick="selColor('#81d72b')"></td>
	<td bgcolor="#81d756"><img src="<?php echo $spacer;?>" onClick="selColor('#81d756')"></td>
	<td bgcolor="#81d781"><img src="<?php echo $spacer;?>" onClick="selColor('#81d781')"></td>
	<td bgcolor="#81d7ac"><img src="<?php echo $spacer;?>" onClick="selColor('#81d7ac')"></td>
	<td bgcolor="#81d7d7"><img src="<?php echo $spacer;?>" onClick="selColor('#81d7d7')"></td>
	<td bgcolor="#81d7ff"><img src="<?php echo $spacer;?>" onClick="selColor('#81d7ff')"></td>
	<td bgcolor="#81ff00"><img src="<?php echo $spacer;?>" onClick="selColor('#81ff00')"></td>
	<td bgcolor="#81ff2b"><img src="<?php echo $spacer;?>" onClick="selColor('#81ff2b')"></td>
	<td bgcolor="#81ff56"><img src="<?php echo $spacer;?>" onClick="selColor('#81ff56')"></td>
	<td bgcolor="#81ff81"><img src="<?php echo $spacer;?>" onClick="selColor('#81ff81')"></td>
	<td bgcolor="#81ffac"><img src="<?php echo $spacer;?>" onClick="selColor('#81ffac')"></td>
	<td bgcolor="#81ffd7"><img src="<?php echo $spacer;?>" onClick="selColor('#81ffd7')"></td>
	<td bgcolor="#81ffff"><img src="<?php echo $spacer;?>" onClick="selColor('#81ffff')"></td>
    </tr>
    <tr>
	<td bgcolor="#ac8100"><img src="<?php echo $spacer;?>" onClick="selColor('#ac8100')"></td>
	<td bgcolor="#ac812b"><img src="<?php echo $spacer;?>" onClick="selColor('#ac812b')"></td>
	<td bgcolor="#ac8156"><img src="<?php echo $spacer;?>" onClick="selColor('#ac8156')"></td>
	<td bgcolor="#ac8181"><img src="<?php echo $spacer;?>" onClick="selColor('#ac8181')"></td>
	<td bgcolor="#ac81ac"><img src="<?php echo $spacer;?>" onClick="selColor('#ac81ac')"></td>
	<td bgcolor="#ac81d7"><img src="<?php echo $spacer;?>" onClick="selColor('#ac81d7')"></td>
	<td bgcolor="#ac81ff"><img src="<?php echo $spacer;?>" onClick="selColor('#ac81ff')"></td>
	<td bgcolor="#acac00"><img src="<?php echo $spacer;?>" onClick="selColor('#acac00')"></td>
	<td bgcolor="#acac2b"><img src="<?php echo $spacer;?>" onClick="selColor('#acac2b')"></td>
	<td bgcolor="#acac56"><img src="<?php echo $spacer;?>" onClick="selColor('#acac56')"></td>
	<td bgcolor="#acac81"><img src="<?php echo $spacer;?>" onClick="selColor('#acac81')"></td>
	<td bgcolor="#acacac"><img src="<?php echo $spacer;?>" onClick="selColor('#acacac')"></td>
	<td bgcolor="#acacd7"><img src="<?php echo $spacer;?>" onClick="selColor('#acacd7')"></td>
	<td bgcolor="#acacff"><img src="<?php echo $spacer;?>" onClick="selColor('#acacff')"></td>
	<td bgcolor="#acd700"><img src="<?php echo $spacer;?>" onClick="selColor('#acd700')"></td>
	<td bgcolor="#acd72b"><img src="<?php echo $spacer;?>" onClick="selColor('#acd72b')"></td>
	<td bgcolor="#acd756"><img src="<?php echo $spacer;?>" onClick="selColor('#acd756')"></td>
	<td bgcolor="#acd781"><img src="<?php echo $spacer;?>" onClick="selColor('#acd781')"></td>
	<td bgcolor="#acd7ac"><img src="<?php echo $spacer;?>" onClick="selColor('#acd7ac')"></td>
	<td bgcolor="#acd7d7"><img src="<?php echo $spacer;?>" onClick="selColor('#acd7d7')"></td>
	<td bgcolor="#acd7ff"><img src="<?php echo $spacer;?>" onClick="selColor('#acd7ff')"></td>
	<td bgcolor="#acff00"><img src="<?php echo $spacer;?>" onClick="selColor('#acff00')"></td>
	<td bgcolor="#acff2b"><img src="<?php echo $spacer;?>" onClick="selColor('#acff2b')"></td>
	<td bgcolor="#acff56"><img src="<?php echo $spacer;?>" onClick="selColor('#acff56')"></td>
	<td bgcolor="#acff81"><img src="<?php echo $spacer;?>" onClick="selColor('#acff81')"></td>
	<td bgcolor="#acffac"><img src="<?php echo $spacer;?>" onClick="selColor('#acffac')"></td>
	<td bgcolor="#acffd7"><img src="<?php echo $spacer;?>" onClick="selColor('#acffd7')"></td>
	<td bgcolor="#acffff"><img src="<?php echo $spacer;?>" onClick="selColor('#acffff')"></td>
    </tr>
    <tr>
	<td bgcolor="#d78100"><img src="<?php echo $spacer;?>" onClick="selColor('#d78100')"></td>
	<td bgcolor="#d7812b"><img src="<?php echo $spacer;?>" onClick="selColor('#d7812b')"></td>
	<td bgcolor="#d78156"><img src="<?php echo $spacer;?>" onClick="selColor('#d78156')"></td>
	<td bgcolor="#d78181"><img src="<?php echo $spacer;?>" onClick="selColor('#d78181')"></td>
	<td bgcolor="#d781ac"><img src="<?php echo $spacer;?>" onClick="selColor('#d781ac')"></td>
	<td bgcolor="#d781d7"><img src="<?php echo $spacer;?>" onClick="selColor('#d781d7')"></td>
	<td bgcolor="#d781ff"><img src="<?php echo $spacer;?>" onClick="selColor('#d781ff')"></td>
	<td bgcolor="#d7ac00"><img src="<?php echo $spacer;?>" onClick="selColor('#d7ac00')"></td>
	<td bgcolor="#d7ac2b"><img src="<?php echo $spacer;?>" onClick="selColor('#d7ac2b')"></td>
	<td bgcolor="#d7ac56"><img src="<?php echo $spacer;?>" onClick="selColor('#d7ac56')"></td>
	<td bgcolor="#d7ac81"><img src="<?php echo $spacer;?>" onClick="selColor('#d7ac81')"></td>
	<td bgcolor="#d7acac"><img src="<?php echo $spacer;?>" onClick="selColor('#d7acac')"></td>
	<td bgcolor="#d7acd7"><img src="<?php echo $spacer;?>" onClick="selColor('#d7acd7')"></td>
	<td bgcolor="#d7acff"><img src="<?php echo $spacer;?>" onClick="selColor('#d7acff')"></td>
	<td bgcolor="#d7d700"><img src="<?php echo $spacer;?>" onClick="selColor('#d7d700')"></td>
	<td bgcolor="#d7d72b"><img src="<?php echo $spacer;?>" onClick="selColor('#d7d72b')"></td>
	<td bgcolor="#d7d756"><img src="<?php echo $spacer;?>" onClick="selColor('#d7d756')"></td>
	<td bgcolor="#d7d781"><img src="<?php echo $spacer;?>" onClick="selColor('#d7d781')"></td>
	<td bgcolor="#d7d7ac"><img src="<?php echo $spacer;?>" onClick="selColor('#d7d7ac')"></td>
	<td bgcolor="#d7d7d7"><img src="<?php echo $spacer;?>" onClick="selColor('#d7d7d7')"></td>
	<td bgcolor="#d7d7ff"><img src="<?php echo $spacer;?>" onClick="selColor('#d7d7ff')"></td>
	<td bgcolor="#d7ff00"><img src="<?php echo $spacer;?>" onClick="selColor('#d7ff00')"></td>
	<td bgcolor="#d7ff2b"><img src="<?php echo $spacer;?>" onClick="selColor('#d7ff2b')"></td>
	<td bgcolor="#d7ff56"><img src="<?php echo $spacer;?>" onClick="selColor('#d7ff56')"></td>
	<td bgcolor="#d7ff81"><img src="<?php echo $spacer;?>" onClick="selColor('#d7ff81')"></td>
	<td bgcolor="#d7ffac"><img src="<?php echo $spacer;?>" onClick="selColor('#d7ffac')"></td>
	<td bgcolor="#d7ffd7"><img src="<?php echo $spacer;?>" onClick="selColor('#d7ffd7')"></td>
	<td bgcolor="#d7ffff"><img src="<?php echo $spacer;?>" onClick="selColor('#d7ffff')"></td>
    </tr>
    <tr>
	<td bgcolor="#ff8100"><img src="<?php echo $spacer;?>" onClick="selColor('#ff8100')"></td>
	<td bgcolor="#ff812b"><img src="<?php echo $spacer;?>" onClick="selColor('#ff812b')"></td>
	<td bgcolor="#ff8156"><img src="<?php echo $spacer;?>" onClick="selColor('#ff8156')"></td>
	<td bgcolor="#ff8181"><img src="<?php echo $spacer;?>" onClick="selColor('#ff8181')"></td>
	<td bgcolor="#ff81ac"><img src="<?php echo $spacer;?>" onClick="selColor('#ff81ac')"></td>
	<td bgcolor="#ff81d7"><img src="<?php echo $spacer;?>" onClick="selColor('#ff81d7')"></td>
	<td bgcolor="#ff81ff"><img src="<?php echo $spacer;?>" onClick="selColor('#ff81ff')"></td>
	<td bgcolor="#ffac00"><img src="<?php echo $spacer;?>" onClick="selColor('#ffac00')"></td>
	<td bgcolor="#ffac2b"><img src="<?php echo $spacer;?>" onClick="selColor('#ffac2b')"></td>
	<td bgcolor="#ffac56"><img src="<?php echo $spacer;?>" onClick="selColor('#ffac56')"></td>
	<td bgcolor="#ffac81"><img src="<?php echo $spacer;?>" onClick="selColor('#ffac81')"></td>
	<td bgcolor="#ffacac"><img src="<?php echo $spacer;?>" onClick="selColor('#ffacac')"></td>
	<td bgcolor="#ffacd7"><img src="<?php echo $spacer;?>" onClick="selColor('#ffacd7')"></td>
	<td bgcolor="#ffacff"><img src="<?php echo $spacer;?>" onClick="selColor('#ffacff')"></td>
	<td bgcolor="#ffd700"><img src="<?php echo $spacer;?>" onClick="selColor('#ffd700')"></td>
	<td bgcolor="#ffd72b"><img src="<?php echo $spacer;?>" onClick="selColor('#ffd72b')"></td>
	<td bgcolor="#ffd756"><img src="<?php echo $spacer;?>" onClick="selColor('#ffd756')"></td>
	<td bgcolor="#ffd781"><img src="<?php echo $spacer;?>" onClick="selColor('#ffd781')"></td>
	<td bgcolor="#ffd7ac"><img src="<?php echo $spacer;?>" onClick="selColor('#ffd7ac')"></td>
	<td bgcolor="#ffd7d7"><img src="<?php echo $spacer;?>" onClick="selColor('#ffd7d7')"></td>
	<td bgcolor="#ffd7ff"><img src="<?php echo $spacer;?>" onClick="selColor('#ffd7ff')"></td>
	<td bgcolor="#ffff00"><img src="<?php echo $spacer;?>" onClick="selColor('#ffff00')"></td>
	<td bgcolor="#ffff2b"><img src="<?php echo $spacer;?>" onClick="selColor('#ffff2b')"></td>
	<td bgcolor="#ffff56"><img src="<?php echo $spacer;?>" onClick="selColor('#ffff56')"></td>
	<td bgcolor="#ffff81"><img src="<?php echo $spacer;?>" onClick="selColor('#ffff81')"></td>
	<td bgcolor="#ffffac"><img src="<?php echo $spacer;?>" onClick="selColor('#ffffac')"></td>
	<td bgcolor="#ffffd7"><img src="<?php echo $spacer;?>" onClick="selColor('#ffffd7')"></td>
	<td bgcolor="#ffffff"><img src="<?php echo $spacer;?>" onClick="selColor('#ffffff')"></td>
    </tr>
</table>


<?php
rcx_footer(0);
} 

?>