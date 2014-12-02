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
define("_HP_SE_S1","The above preferences are used for functions Die oberen Einstellungen, durch ja / nein zu kennzeichnen, sind für Funktionen, die öffentlich in der Galerie zu sehen oder nutzbar sind.");
define("_HP_SE_S2","Der Bilderupload für registrierte User kann durch die Rechteverwaltung von Rcx noch weiter unterteilt werden. So kann z.B. hier der Upload ausgeschaltet, jedoch eine neue Gruppe für den Bilderupload angelegt werden. Diese Gruppe kann dann trotzdem Bilder uploaden.");
define("_HP_SE_S3","It is also possible to give single members admin rights for the gallery.");
define("_HP_SE_S4","Die nächsten 5 Werte sind für das Aussehen der Galerie auf der Homepage zuständig.<br>Über die Pixelhöhe sollte man sich vorher Gedanken machen, da eine spätere Änderung nur mit großem Aufwand durchführbar ist.");
define("_HP_SE_S5","Die unteren 3 Werte sind für die Begrenzung des Bilderupload zuständig. Diese Begrenzung wird jedoch nur bei den Usern durchgeführt, nicht bei einem Upload mit dem Filemanager durch den Administrator. Dieser kann auch andere Größen uploaden, denn er sollte ja wissen, was er tut.");
define("_HP_SE_S6","Mit der Einstellung &quot;Thumbnails Breite im Block in Pixel&quot; kann das angezeigte Foto einfach an die Breite der Tabelle angepasst werden. Eingabe = 0 bewirkt, dass die Thumbnails in Orginalgröße angezeigt werden. Empfohlen wird 140.");
define("_HP_SE_S7","Breite der Kategorie-Button in Pixel: hiermit können Sie die Breite der Kategorie Button einstellen und somit an Design und Schriftgröße anpassen. Mindestbreite 70.");

//Hilfe Bilder
define("_HP_BE_S1","Die meisten Felder auf dieser Seite erklären sich von selbst.<br>Es wird deshalb hier nur auf die Besonderheiten hingewiesen.");
define("_HP_BE_S2","Wenn dieses Ikon neben der Email Adresse erscheint, ist diese bereits in der Datenbank vorhanden, d.h., der Bilderupload wurde von einem registrierten User durchgeführt. Durch anklicken dieses Ikon wird Ihnen das persönliche Profil des Useres angezeigt.");
define("_HP_BE_S3","Mit den Optionen ja / nein, können Sie entscheiden, ob das Bild veröffentlicht wird oder nicht.");
define("_HP_BE_S5","");
//Hilfe Übersicht
define("_HP_UE_S1","The preferences of the PhotoAlbum are divided into 5 parts:");
define("_HP_UE_S2","In dieser Übersicht sehen sie 2 Tabellen, zum einen:<br>&quot;gegenwärtige Kategorien in der Galerie&quot;, zum anderen:<br>&quot;gegenwärtige Bilder in der Galerie&quot;.");
define("_HP_UE_S21","Hiermit können Sie sich die jeweiligen Thnumbails (Kategorien) oder Originale (Bilder) ansehen.");
define("_HP_UE_S22","Hiermit rufen Sie den jeweiligen Editor auf.");
define("_HP_UE_S23","read the help below");
define("_HP_UE_S24","Wenn Sie mit dem Filemanager eine neue Kategorie anlegen und das erste Bild uploaden, wird dieses als &quot;Bildauswahl für den Index&quot; übernommen. Wenn noch kein Bild in der Kategorie vorhanden ist, wird es hier angezeigt.");
define("_HP_UE_S25","In der Tabelle Bilder werden in der Spalte &quot;edit&quot; noch weitere Ikon eingeblendet:");
define("_HP_UE_S26","Dieses Ikon zeigt Ihnen an, wenn ein User der &quot;Berechtigung 0&quot; einen Bilderupload durchgeführt hat.");
define("_HP_UE_S27","Dieses Ikon zeigt Ihnen an, wenn ein User der &quot;Berechtigung 2&quot; einen Bilderupload durchgeführt hat.");
define("_HP_UE_S28","Weitere Erklärungen zum Theme Berechtigung finden Sie unter <a href=\"help.php?action=h1\">"._HP_RECHT."</a>.");
define("_HP_UE_S3","Von dieser Übersichts-Seite aus, kommen Sie auch zum Fielmanager und zu den sonstigen Einstellungen.");
define("_HP_UE_S4","Mit dem Filemanager legen Sie neue Kategorien oder Bilder an, können diese umbenennen oder löschen.");
define("_HP_UE_S5","Einstellung und Verwaltung von:<br>Popup Fenster, Emailversand, Musik, Bilderupload und Votum.<br><br>Desweiteren verwalten Sie hier die Thumbnails und können Vorsteinstellungen (Bregrenzungen) des Uploads vornehmen.");
//Hilfe Rechteverwaltung

define("_HP_RE_U1","Die Rechte- und Gruppenverwaltung in Rcx dürfte Ihnen bekannt sein, jedoch nachstehend, speziell für den Dateiupload :");
define("_HP_RE_U","Permissions ");
define("_HP_RE_U0","Die Berechtigungen 0, 1, 2 brauchen nicht extra vergeben werden, dies geschieht automatisch im Programm, je nach Kombination der Einstellungen.");
define("_HP_RE_U3","Durch nachfolgende Einstellungen können berechtigte User einen Dateiupload durchführen, auch wenn unter &quot;sonst. Einstellungen&quot; der Datei upload abgeschaltet ist.");
define("_HP_RE_U2","In der Übersicht des Admin erscheint in der Spalte &quot;edit&quot; : ");
define("_HP_RE_R0","Der Dateiupload kann je nach Optionen unter &quot;sonst. Einstellung&quot; erfolgen. Die Bilder werden nicht sofort veröffentlicht, erst nach Genehmigung durch den Admin.");
define("_HP_RE_R1","Die Bilder werden sofort veröffentlich, z.B. Bilderupload über den Filemanager durch den Admin. Weitere Möglichkeit unter Gruppenrechte unten.");
define("_HP_RE_R2","Die Bilder werden sofort veröffentlich, da der User spezielle Rechte zum Dateiupload erhalten hat. Erklärung weiter unten.");
define("_HP_RE_G0","Sie legen in Rcx Sytem Admin unter &quot;Gruppen&quot; einen neue Gruppe an: z.B. &quot;PhotoAlbum&quot;. Wichtig ist, dass Sie nur bei der Option &quot;Zugriffsrechte&quot; ein Häckchen bei PhotoAlbum setzen.<br>Speichern Sie die neue Gruppe ab. Klicken Sie auf Gruppe modifizieren und ändern Sie unten die Mitglieder dieser Gruppe.<br>Abspeichern, fertig.<br>Die Bilder werden nicht sofort veröffentlicht, erst nach Genehmigung durch den Admin.");
define("_HP_RE_G1","Sie legen in Rcx Sytem Admin unter &quot;Gruppen&quot; einen neue Gruppe an: z.B. &quot;PhotoAlbum&quot;. Wichtig ist, dass Sie nicht nur bei der Option &quot;Zugriffsrechte&quot;, sondern auch bei der Option &quot;adminrechte&quot; ein Häckchen bei PhotoAlbum setzen.<br>Speichern Sie die neue Gruppe ab. Klicken Sie auf Gruppe modifizieren und ändern Sie unten die Mitglieder dieser Gruppe.<br>Abspeichern, fertig.<br>Die Mitglieder dieser Gruppe haben jetzt für PhotoAlbum Admin Rechte.");
define("_HP_RE_G2","Sie legen in Rcx Sytem Admin unter &quot;Mitglieder Ränge&quot; einen neuen Rang an: z.B. &quot;Bilder upload&quot;. Wichtig ist, dass Sie bei Option &quot;Spezial&quot; ein Häckchen setzen.<br>Bei dem  Mitglied, welchen Sie jetzt diese Berechtigung geben möchten, setzen Sie in seinen Mitgliederdaten den Rang &quot;Bilder upload&quot;. Die Bilder werden sofort veröffentlich.");
// Keine Hilfe
define("_HP_NOHELP","Sorry, there is no help available for this topic.");
//Hilfe Kategorien
define("_HP_UEBERCAT","Category overview");
define("_HP_KA1","In der oberen Übersicht wird Ihnen ein Verzeichnisbaum Ihrer Kategorien angezeigt.");
define("_HP_KA2","Wenn Sie noch keine Kategorien angelegt haben, sehen Sie nur Ihren Grundpfad.<br>Die darunter liegende Tabelle ist demnach noch leer.");
define("_HP_KA3","Im darunter liegenden Formular können Sie die Hauptkategorien anlegen.<br>Der Name des Kategorienpfades darf keine Sonderzeichen enthalten, Leerzeichen werden durch einen Unterstrich ersetzt. Dieser Name wird als Verzeichnispfad am Server angelegt. Maximal 25 Zeichen. Um ein besseres Erscheinungsbild auf der Page zu haben, müssen Sie der Kategorie einen Titel geben, dieser wird dann an Stelle des Verzeichnispfades angezeigt.");

define("_HP_KA4","Im darunter liegenden Formular können Sie die Subkategorien anlegen.<br>Der Name des Kategorienpfades darf keine Sonderzeichen enthalten, Leerzeichen werden durch einen Unterstrich ersetzt. Dieser Name wird als Verzeichnispfad am Server angelegt. Maximal 25 Zeichen. Um ein besseres Erscheinungsbild auf der Page zu haben, müssen Sie der Kategorie einen Titel geben (maximal 50 Zeichen), dieser wird dann an Stelle des Verzeichnispfades angezeigt.<br>Im Selectfeld können Sie unter den Ihnen zur Verfügung stehenden Kategorien auswählen, in denen Sie eine Subkategorie anlegen möchten.");

define("_HP_KA5","Im wiederum darunter liegenden Formular können Sie die Subkategorien anlegen.<br>Es gilt die gleiche Spezifikation wie bei den Hauptkategorien.<br>Im Selectfeld können Sie unter den Ihnen zur Verfügung stehenden Kategorien auswählen, in denen Sie eine Subkategorie anlegen möchten.");
define("_HP_KA6","When you create a categroy it will be shown in this table. If you click on a category you can edit it's data.");
//Hilfe Kategorie ändern
define("_HP_UEBERCATMOD","Change category");
define("_HP_KA_S1","In den beiden Textfeldern &quot;Name des Kategoriepfades&quot; und &quot;Titel der Kategorie&quot; können Sie Ihre bisherigen Eingaben ändern.");
define("_HP_KA_S2","Mit dem Selectfeld &quot;in Kategorie&quot; können Sie die gesamte Kategorie einschl. evtl. vorhandener Subkategorien mit den darin enthaltenen Bildern in andere Kategorien verschieben.");
define("_HP_KA_S3","Im Selectfeld &quot;Bildauswahl für den Index&quot; können Sie aus den vorhandenen Bildern auswählen, welches auf der Hauptseite der Kategorieübersicht angezeigt werden soll.");

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