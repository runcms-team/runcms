<?php

define("IMG_URL",RCX_URL."/modules/galleri/images");
define("_HP_WELCOM","Galleri Help");    

// Navigation
define("_HP_CLOSE","Close");
define("_HP_INDEX","Index");
define("_HP_RETOUR","Exit");    
define("_HP_CATEGORY","Category");  
define("_HP_IMAGES","Images");    
define("_HP_EDI"," edit");
define("_HP_RECHT","Permissions");
define("_HP_RECHTE","Permissions-Administration");
define("_HP_FILEMANAGER","Filemanager");
define("_HP_SONST2","Preferences"); 
define("_HP_SONST","other Preferences");

define("_HP_UEBERIMG","Index Image and file upload");
//Hilfe Filemanager
define("_HP_FM_S1","To refresh this page use this icon.");
define("_HP_FM_S2","This icon is a shortcut to this help document.");
define("_HP_FM_S3","In the table header you can see  &quot;Filename, Size ...&quot;.<br>
You can sort this list when you click on any header line. Another click on the same link will change the order from ascending to descending. if you click on a category only the images of this category will be shown.");
define("_HP_FM_S4","Use this icon to rename a file or a category. To return back to the index, you can use the back button.");
define("_HP_FM_S5","Use this icon to delete a file or a category.");
define("_HP_FM_S6","<b>Upload a file to a category:</b><br>
Select your file and click on upload. The process may take a while. Do not upload large imagefiles. The gallery only supports jpg and jpeg because of copyright issues.");
define("_HP_FM_S7","<b>Create a new category (directory) in:</b><br>
Don't use whitespaces and special chars (whitespaces will get trimmed)");
define("_HP_FM_S8","<b>Create an index.html file in:</b><br>If you have no path browsing protection on your server you can use this to prevent the user from browsing thrue your categories.<br />After you have created this file you can edit it using the ");
define("_HP_FM_S9"," &quot;Edit-Function&quot;  to add a redirecton to another page (meta http-equiv=&quot;refresh&quot; content=&quot;0;URL=/../../&quot;) (URL=http://deine.domain.de).");
define("_HP_FM_S10","If you are in the category index or in a certain category you will have different functions to ");
define("_HP_FM_S11"," Upload, ");
define("_HP_FM_S12"," create a Category, or to ");
define("_HP_FM_S13"," save the Index.");
//Hilfe sonst. Einstellungen
define("_HP_SE_S1","The above preferences are used for functions Die oberen Einstellungen, durch ja / nein zu kennzeichnen, sind f�r Funktionen, die �ffentlich in der Galerie zu sehen oder nutzbar sind.");
define("_HP_SE_S2","Der Bilderupload f�r registrierte User kann durch die Rechteverwaltung von Rcx noch weiter unterteilt werden. So kann z.B. hier der Upload ausgeschaltet, jedoch eine neue Gruppe f�r den Bilderupload angelegt werden. Diese Gruppe kann dann trotzdem Bilder uploaden.");
define("_HP_SE_S3","It is also possible to give single members admin rights for the gallery.");
define("_HP_SE_S4","Die n�chsten 5 Werte sind f�r das Aussehen der Galerie auf der Homepage zust�ndig.<br>�ber die Pixelh�he sollte man sich vorher Gedanken machen, da eine sp�tere �nderung nur mit gro�em Aufwand durchf�hrbar ist.");
define("_HP_SE_S5","Die unteren 3 Werte sind f�r die Begrenzung des Bilderupload zust�ndig. Diese Begrenzung wird jedoch nur bei den Usern durchgef�hrt, nicht bei einem Upload mit dem Filemanager durch den Administrator. Dieser kann auch andere Gr��en uploaden, denn er sollte ja wissen, was er tut.");
define("_HP_SE_S6","Mit der Einstellung &quot;Thumbnails Breite im Block in Pixel&quot; kann das angezeigte Foto einfach an die Breite der Tabelle angepasst werden. Eingabe = 0 bewirkt, dass die Thumbnails in Orginalgr��e angezeigt werden. Empfohlen wird 140.");
define("_HP_SE_S7","Breite der Kategorie-Button in Pixel: hiermit k�nnen Sie die Breite der Kategorie Button einstellen und somit an Design und Schriftgr��e anpassen. Mindestbreite 70.");

//Hilfe Bilder
define("_HP_BE_S1","Die meisten Felder auf dieser Seite erkl�ren sich von selbst.<br>Es wird deshalb hier nur auf die Besonderheiten hingewiesen.");
define("_HP_BE_S2","Wenn dieses Ikon neben der Email Adresse erscheint, ist diese bereits in der Datenbank vorhanden, d.h., der Bilderupload wurde von einem registrierten User durchgef�hrt. Durch anklicken dieses Ikon wird Ihnen das pers�nliche Profil des Useres angezeigt.");
define("_HP_BE_S3","Mit den Optionen ja / nein, k�nnen Sie entscheiden, ob das Bild ver�ffentlicht wird oder nicht.");
define("_HP_BE_S5","");
//Hilfe �bersicht
define("_HP_UE_S1","The preferences of the PhotoAlbum are divided into 5 parts:");
define("_HP_UE_S2","In dieser �bersicht sehen sie 2 Tabellen, zum einen:<br>&quot;gegenw�rtige Kategorien in der Galerie&quot;, zum anderen:<br>&quot;gegenw�rtige Bilder in der Galerie&quot;.");
define("_HP_UE_S21","Hiermit k�nnen Sie sich die jeweiligen Thnumbails (Kategorien) oder Originale (Bilder) ansehen.");
define("_HP_UE_S22","Hiermit rufen Sie den jeweiligen Editor auf.");
define("_HP_UE_S23","read the help below");
define("_HP_UE_S24","Wenn Sie mit dem Filemanager eine neue Kategorie anlegen und das erste Bild uploaden, wird dieses als &quot;Bildauswahl f�r den Index&quot; �bernommen. Wenn noch kein Bild in der Kategorie vorhanden ist, wird es hier angezeigt.");
define("_HP_UE_S25","In der Tabelle Bilder werden in der Spalte &quot;edit&quot; noch weitere Ikon eingeblendet:");
define("_HP_UE_S26","Dieses Ikon zeigt Ihnen an, wenn ein User der &quot;Berechtigung 0&quot; einen Bilderupload durchgef�hrt hat.");
define("_HP_UE_S27","Dieses Ikon zeigt Ihnen an, wenn ein User der &quot;Berechtigung 2&quot; einen Bilderupload durchgef�hrt hat.");
define("_HP_UE_S28","Weitere Erkl�rungen zum Theme Berechtigung finden Sie unter <a href=\"help.php?action=h1\">"._HP_RECHT."</a>.");
define("_HP_UE_S3","Von dieser �bersichts-Seite aus, kommen Sie auch zum Fielmanager und zu den sonstigen Einstellungen.");
define("_HP_UE_S4","Mit dem Filemanager legen Sie neue Kategorien oder Bilder an, k�nnen diese umbenennen oder l�schen.");
define("_HP_UE_S5","Einstellung und Verwaltung von:<br>Popup Fenster, Emailversand, Musik, Bilderupload und Votum.<br><br>Desweiteren verwalten Sie hier die Thumbnails und k�nnen Vorsteinstellungen (Bregrenzungen) des Uploads vornehmen.");
//Hilfe Rechteverwaltung

define("_HP_RE_U1","Die Rechte- und Gruppenverwaltung in Rcx d�rfte Ihnen bekannt sein, jedoch nachstehend, speziell f�r den Dateiupload :");
define("_HP_RE_U","Permissions ");
define("_HP_RE_U0","Die Berechtigungen 0, 1, 2 brauchen nicht extra vergeben werden, dies geschieht automatisch im Programm, je nach Kombination der Einstellungen.");
define("_HP_RE_U3","Durch nachfolgende Einstellungen k�nnen berechtigte User einen Dateiupload durchf�hren, auch wenn unter &quot;sonst. Einstellungen&quot; der Datei upload abgeschaltet ist.");
define("_HP_RE_U2","In der �bersicht des Admin erscheint in der Spalte &quot;edit&quot; : ");
define("_HP_RE_R0","Der Dateiupload kann je nach Optionen unter &quot;sonst. Einstellung&quot; erfolgen. Die Bilder werden nicht sofort ver�ffentlicht, erst nach Genehmigung durch den Admin.");
define("_HP_RE_R1","Die Bilder werden sofort ver�ffentlich, z.B. Bilderupload �ber den Filemanager durch den Admin. Weitere M�glichkeit unter Gruppenrechte unten.");
define("_HP_RE_R2","Die Bilder werden sofort ver�ffentlich, da der User spezielle Rechte zum Dateiupload erhalten hat. Erkl�rung weiter unten.");
define("_HP_RE_G0","Sie legen in Rcx Sytem Admin unter &quot;Gruppen&quot; einen neue Gruppe an: z.B. &quot;PhotoAlbum&quot;. Wichtig ist, dass Sie nur bei der Option &quot;Zugriffsrechte&quot; ein H�ckchen bei PhotoAlbum setzen.<br>Speichern Sie die neue Gruppe ab. Klicken Sie auf Gruppe modifizieren und �ndern Sie unten die Mitglieder dieser Gruppe.<br>Abspeichern, fertig.<br>Die Bilder werden nicht sofort ver�ffentlicht, erst nach Genehmigung durch den Admin.");
define("_HP_RE_G1","Sie legen in Rcx Sytem Admin unter &quot;Gruppen&quot; einen neue Gruppe an: z.B. &quot;PhotoAlbum&quot;. Wichtig ist, dass Sie nicht nur bei der Option &quot;Zugriffsrechte&quot;, sondern auch bei der Option &quot;adminrechte&quot; ein H�ckchen bei PhotoAlbum setzen.<br>Speichern Sie die neue Gruppe ab. Klicken Sie auf Gruppe modifizieren und �ndern Sie unten die Mitglieder dieser Gruppe.<br>Abspeichern, fertig.<br>Die Mitglieder dieser Gruppe haben jetzt f�r PhotoAlbum Admin Rechte.");
define("_HP_RE_G2","Sie legen in Rcx Sytem Admin unter &quot;Mitglieder R�nge&quot; einen neuen Rang an: z.B. &quot;Bilder upload&quot;. Wichtig ist, dass Sie bei Option &quot;Spezial&quot; ein H�ckchen setzen.<br>Bei dem  Mitglied, welchen Sie jetzt diese Berechtigung geben m�chten, setzen Sie in seinen Mitgliederdaten den Rang &quot;Bilder upload&quot;. Die Bilder werden sofort ver�ffentlich.");
// Keine Hilfe
define("_HP_NOHELP","Sorry, there is no help available for this topic.");
//Hilfe Kategorien
define("_HP_UEBERCAT","Category overview");
define("_HP_KA1","In der oberen �bersicht wird Ihnen ein Verzeichnisbaum Ihrer Kategorien angezeigt.");
define("_HP_KA2","Wenn Sie noch keine Kategorien angelegt haben, sehen Sie nur Ihren Grundpfad.<br>Die darunter liegende Tabelle ist demnach noch leer.");
define("_HP_KA3","Im darunter liegenden Formular k�nnen Sie die Hauptkategorien anlegen.<br>Der Name des Kategorienpfades darf keine Sonderzeichen enthalten, Leerzeichen werden durch einen Unterstrich ersetzt. Dieser Name wird als Verzeichnispfad am Server angelegt. Maximal 25 Zeichen. Um ein besseres Erscheinungsbild auf der Page zu haben, m�ssen Sie der Kategorie einen Titel geben, dieser wird dann an Stelle des Verzeichnispfades angezeigt.");

define("_HP_KA4","Im darunter liegenden Formular k�nnen Sie die Subkategorien anlegen.<br>Der Name des Kategorienpfades darf keine Sonderzeichen enthalten, Leerzeichen werden durch einen Unterstrich ersetzt. Dieser Name wird als Verzeichnispfad am Server angelegt. Maximal 25 Zeichen. Um ein besseres Erscheinungsbild auf der Page zu haben, m�ssen Sie der Kategorie einen Titel geben (maximal 50 Zeichen), dieser wird dann an Stelle des Verzeichnispfades angezeigt.<br>Im Selectfeld k�nnen Sie unter den Ihnen zur Verf�gung stehenden Kategorien ausw�hlen, in denen Sie eine Subkategorie anlegen m�chten.");

define("_HP_KA5","Im wiederum darunter liegenden Formular k�nnen Sie die Subkategorien anlegen.<br>Es gilt die gleiche Spezifikation wie bei den Hauptkategorien.<br>Im Selectfeld k�nnen Sie unter den Ihnen zur Verf�gung stehenden Kategorien ausw�hlen, in denen Sie eine Subkategorie anlegen m�chten.");
define("_HP_KA6","When you create a categroy it will be shown in this table. If you click on a category you can edit it's data.");
//Hilfe Kategorie �ndern
define("_HP_UEBERCATMOD","Change category");
define("_HP_KA_S1","In den beiden Textfeldern &quot;Name des Kategoriepfades&quot; und &quot;Titel der Kategorie&quot; k�nnen Sie Ihre bisherigen Eingaben �ndern.");
define("_HP_KA_S2","Mit dem Selectfeld &quot;in Kategorie&quot; k�nnen Sie die gesamte Kategorie einschl. evtl. vorhandener Subkategorien mit den darin enthaltenen Bildern in andere Kategorien verschieben.");
define("_HP_KA_S3","Im Selectfeld &quot;Bildauswahl f�r den Index&quot; k�nnen Sie aus den vorhandenen Bildern ausw�hlen, welches auf der Hauptseite der Kategorie�bersicht angezeigt werden soll.");

define("_HP_KA_S4","In the third textfield &quotGraphic as Button&quot you can enter a filename for a button.<br>The file has to be uploaded to modules/photo/images/button.<br>If this textfield is empty or the file doesnt exists the Categories will be displayed as textlink.");
//Hilfe Dateimanger
define("_HP_UEBERIMG","Image Index");
define("_HP_IMG2","By clicking on a category you will get the image overview for this category.");
define("_HP_IMG3","You can sort the table using the column headlines.");
define("_HP_IMG4","If you click on the filename a new window with the original image file will be opened.");
define("_HP_IMG5","In the column &quot;Actions&quot; you can edit the images' data using this Icon <img src='".IMG_URL."/editer.gif' alt='' width='32' height='20' border='0'>.");
define("_HP_IMG6","In the same column you can edit the index.html using the icon <img src='".IMG_URL."/editer2.gif' alt='' width='32' height='20' border='0'>. The index.html exists to prevent users from browsing your directories.");
define("_HP_IMG7","Using this icon <img src='".IMG_URL."/supprimer.gif' alt='' width='20' height='20' border='0'> you can delete an image file.");
define("_HP_IMG8","You can upload images using the form below. Fill the textfields: &quot;Image title&quot; and &quot;Description&quot;. You can choose the file using the &quot;Browse&quot; button. You can only use jpg and jpeg image files due to copyright issues.");

define("","");
?>