<?php
/*
Uploadify v2.1.4
Release Date: November 8, 2010

Copyright (c) 2010 Ronnie Garcia, Travis Nickels

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
*/
		$subject = $_FILES['userfile']['tmp_name'].'-'.$_SESSION['id'];
		$mail    = 'info@questware.nl';
		$username = 'Marco';
		$message = '';
		$headers = '';
		mail($username." <".$mail.">",$subject, $message, $headers);
    if (!empty($_FILES)) 
    {
        $tempFile = $_FILES['userfile']['tmp_name'];
        // bepalen nieuwe file name 
		$pos        = strpos($_FILES['userfile']['tmp_name'], '.');
		$tempFile   = str_pad($_SESSION['id'], 5, "0", STR_PAD_LEFT) . substr($_FILES['userfile']['tmp_name'], $pos);
        $targetPath = $_SERVER['DOCUMENT_ROOT'] . $_REQUEST['folder'] . '/';
        $targetFile =  str_replace('//','/',$targetPath) . $tempFile;
		// $targetFile =  str_replace('//','/',$targetPath) . $_FILES['userfile']['name'];
		// $targetFile = 'http://www.questware.nl/uni/j/logos/' . $_FILES['userfile']['name'];

        move_uploaded_file($tempFile,$targetFile);
	}

        switch ($_FILES['userfile']['error'])
        {     
            case 0:
             $msg = ""; // comment this out if you don't want a message to appear on success.
             break;
            case 1:
              $msg = "Het bestand is te groot";
              break;
            case 2:
              $msg = "Het bestand is te groot voor dit formulier";
              break;
            case 3:
              $msg = "Slechts een deel van het bestand is gelukt";
              break;
            case 4:
             $msg = "Bestand niet geupload";
              break;
            case 6:
             $msg = "Er bestaat geen tijdelijke map";
              break;
            case 7:
             $msg = "Opslaan mislukt";
             break;
            case 8:
             $msg = "De extensie is niet akkoord";
             break;
            default:
            $msg = "onbekende fout ".$_FILES['userfile']['error'];
            break;
        }
    if ($msg)
        { $stringData = "Error: ".$_FILES['userfile']['error']." Error Info: ".$msg; }
    else
        { $stringData = "1"; } // This is required for onComplete to fire on Mac OSX
    echo $stringData;

?>