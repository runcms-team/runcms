<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
    function mimetype($datei,$img_or_text){
         global $cid, $op_coad, $rcxConfig,$HTTP_USER_AGENT;
         if(!eregi("MSIE",$HTTP_USER_AGENT)) {$client="netscape.gif";} else {$client="html.gif";}
         if(eregi("\.mid$",$datei)){$image="mid.gif";$nom_type=""._MidiFile."";}
         else if(eregi("\.txt$",$datei)){$image="txt.gif";$nom_type=""._Textfile."";}
         else if(eregi("\.sql$",$datei)){$image="txt.gif";$nom_type=""._Textfile."";}
         else if(eregi("\.js$",$datei)){$image="js.gif";$nom_type=""._Javascript."";}
         else if(eregi("\.gif$",$datei)){$image="gif.gif";$nom_type=""._GIFpicture."";}
         else if(eregi("\.jpg$",$datei)){$image="jpg.gif";$nom_type=""._JPGpicture."";}
     else if(eregi("\.jpeg$",$datei)){$image="jpeg.gif";$nom_type=""._JPEGpicture."";}
         else if(eregi("\.html$",$datei)){$image=$client;$nom_type=""._HTMLpage."";}
         else if(eregi("\.htm$",$datei)){$image=$client;$nom_type=""._HTMLpage."";}
         else if(eregi("\.rar$",$datei)){$image="rar.gif";$nom_type="".RARFile."";}
         else if(eregi("\.gz$",$datei)){$image="zip.gif";$nom_type=""._GZFile."";}
         else if(eregi("\.tgz$",$datei)){$image="zip.gif";$nom_type=""._GZFile."";}
         else if(eregi("\.z$",$datei)){$image="zip.gif";$nom_type=""._GZFile."";}
         else if(eregi("\.ra$",$datei)){$image="ram.gif";$nom_type=""._REALfile."";}
         else if(eregi("\.ram$",$datei)){$image="ram.gif";$nom_type=""._REALfile."";}
         else if(eregi("\.rm$",$datei)){$image="ram.gif";$nom_type=""._REALfile."";}
         else if(eregi("\.pl$",$datei)){$image="pl.gif";$nom_type=""._PERLscript."";}
         else if(eregi("\.zip$",$datei)){$image="zip.gif";$nom_type=""._ZIPfile."";}
         else if(eregi("\.wav$",$datei)){$image="wav.gif";$nom_type=""._WAVfile."";}
         else if(eregi("\.php$",$datei)){$image="php.gif";$nom_type=""._PHPscript."";}
         else if(eregi("\.php$",$datei)){$image="php.gif";$nom_type=""._PHPscript."";}
         else if(eregi("\.phtml$",$datei)){$image="php.gif";$nom_type=""._PHPscript."";}
         else if(eregi("\.exe$",$datei)){$image="exe.gif";$nom_type=""._Exefile."";}
         else if(eregi("\.bmp$",$datei)){$image="bmp.gif";$nom_type=""._BMPpicture."";}
         else if(eregi("\.png$",$datei)){$image="gif.gif";$nom_type=""._PNGpicture."";}
         else if(eregi("\.css$",$datei)){$image="css.gif";$nom_type=""._CSSFile."";}
         else if(eregi("\.mp3$",$datei)){$image="mp3.gif";$nom_type=""._MP3File."";}
         else if(eregi("\.xls$",$datei)){$image="xls.gif";$nom_type=""._XLSFile."";}
         else if(eregi("\.doc$",$datei)){$image="doc.gif";$nom_type=""._WordFile."";}
         else if(eregi("\.pdf$",$datei)){$image="pdf.gif";$nom_type=""._PDFFile."";}
         else if(eregi("\.mov$",$datei)){$image="mov.gif";$nom_type=""._MOVFile."";}
         else if(eregi("\.avi$",$datei)){$image="avi.gif";$nom_type=""._AVIFile."";}
         else if(eregi("\.mpg$",$datei)){$image="mpg.gif";$nom_type=""._MPGFile."";}
         else if(eregi("\.mpeg$",$datei)){$image="mpeg.gif";$nom_type=""._MPEGFile."";}
         else if(eregi("\.swf$",$datei)){$image="flash.gif";$nom_type=""._FLASHFile."";}
         else {$image="defaut.gif";$nom_type=""._File."";}
         if($img_or_text=="image"){return $image;} else {return $nom_type;}
    }
?>
