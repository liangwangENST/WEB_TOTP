<?php


/**
 * Google Authenticator / mod_authn_otp configuration generator by Terry Carmen (terry@cnysupport.com).
 * Copyright 2012, CNY Support, LLC, Licenced under GPL v3/


**** CONFIGURATION ****
How random do you need?

Uncomment /dev/urandom for a "mostly random" key. This is secure enough for most applications.

Uncomment /dev/random if you need a **really random** key and don't mind blocking while the page loads if the system runs out of "random"
Note that this will also block other services that require random bits, like SSH.

*/


define("RANDOM_DEVICE", '/dev/urandom');
# define("RANDOM_DEVICE", '/dev/random');

if (((!isset($_GET["user"])) || (!isset($_GET["user"]))) || ((strlen($_GET["user"]) == 0) || (strlen($_GET["user"]) ==0)))
	{
	echo "<h2>usage: ga.php?site=GumbyMail&amp;user=myname</h2>";
	echo "<h3>Valid characters are: 0-9, A-Z, a-z, - and space</h3>";
	exit (0);
	}


// sanitize the input
$site = preg_replace( "/[^0-9 _a-zA-Z\.-]/", '', substr($_GET["user"],0,64));
$user = preg_replace( "/[^0-9 _a-zA-Z\.-]/", '', substr($_GET["user"],0,64));
$file = realpath($_SERVER["DOCUMENT_ROOT"]) . '/../../etc/apache2/otp/otp.users';
$ga = new PHPGangsta_GoogleAuthenticator();
$secret = $ga->createSecret();
$converted=base_base2base($secret, 32, 16, 0);

// Output the data . . .
?>
<!DOCTYPE html>

<html dir="ltr" lang="fr">
<head>
<title>Générateur de QR code Google Authenticator </title>
</head>
<body>
<h2>Générateur de QR code avec Google Authenticator </h2>
<table>
<!-- <TR><TD>Click <a target="QRCode" href="https://chart.googleapis.com/chart?chs=200x200&chld=M|0&cht=qr&chl=otpauth://totp/<?php echo $site ?>%3Fsecret%3D<?php echo $secret ?>">here</a>, then scan the QR Code with the Google Authenticator to add the &ldquo;<?php echo $site ?>&rdquo; account to your phone.</TD></TR> -->
<TR><TD>Cette ligne sera ajoutée à votre fichier mod_authn_opt users sur votre serveur apache</TD></TR>
<TR><TD><pre style=font-size:larger;">HOTP/T30 <?php echo $user ?>  -  <?php echo $converted ?></pre></TD></TR>
<?php file_put_contents($file, "HOTP/T30 ".$user." - ".$converted."\n", FILE_APPEND);?>
<TR><TD>Then scan this QR Code on your Android phone with Google Authenticator</TD></TR>
<tr><td>
<iframe height="220" width="220"  src="https://chart.googleapis.com/chart?chs=200x200&chld=M|0&cht=qr&chl=otpauth://totp/<?php echo $site ?>%3Fsecret%3D<?php echo $secret ?>"></iframe> 
</td></tr>
<TR><TD>Et ça marche ..!</TD></TR>


</table>

<!--

Google Authenticator / mod_authn_otp configuration generator by Terry Carmen (terry@cnysupport.com).
Copyright 2012, CNY Support, LLC, Licenced under GPL v3

-->

</body>
</html>


<?php

/*
 * PHP Number Base Conversion Functions
 * Version 1.0 - February 2004
 * Version 2.0 - January 2005 - converted to using bcmath
 * Version 2.1 - September 2005 - added decimal point conversion ability
 * (c) 2004,2005 Paul Gregg <pgregg@pgregg.com>
 * http://www.pgregg.com
 *
 * Function: Arbitrary Number Base conversion from base 2 - 62
 * This file should be included by other php scripts
 * For normal base 2 - 36 conversion use the built in base_convert function
 *
 * Open Source Code:   If you use this code on your site for public
 * access (i.e. on the Internet) then you must attribute the author and
 * source web site: http://www.pgregg.com/projects/
 * You must also make this original source code available for download
 * unmodified or provide a link to the source.  Additionally you must provide
 * the source to any modified or translated versions or derivatives.
 *
 */

Function base_dec2base($iNum, $iBase, $iScale=0) { // cope with base 2..62
  $LDEBUG = FALSE;
  $sChars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
  $sResult = ''; // Store the result

  // special case for Base64 encoding
  if ($iBase == 64)
   $sChars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/';

  $sNum = is_integer($iNum) ? "$iNum" : (string)$iNum;
  $iBase = intval($iBase); // incase it is a string or some weird decimal

  // Check to see if we are an integer or real number
  if (strpos($sNum, '.') !== FALSE) {
    list ($sNum, $sReal) = explode('.', $sNum, 2);
    $sReal = '0.' . $sReal;
  } else
    $sReal = '0';

  while (bccomp($sNum, 0, $iScale) != 0) { // still data to process
    $sRem = bcmod($sNum, $iBase); // calc the remainder
    $sNum = bcdiv( bcsub($sNum, $sRem, $iScale), $iBase, $iScale );
    $sResult = $sChars[$sRem] . $sResult;
  }
  if ($sReal != '0') {
    $sResult .= '.';
    $fraciScale = $iScale;
    while($fraciScale-- && bccomp($sReal, 0, $iScale) != 0) { // still data to process
      if ($LDEBUG) print "<br> -> $sReal * $iBase = ";
      $sReal = bcmul($sReal, $iBase, $iScale); // multiple the float part with the base
      if ($LDEBUG) print "$sReal  => ";
      $sFrac = 0;
      if (bccomp($sReal ,1, $iScale) > -1)
        list($sFrac, $dummy) = explode('.', $sReal, 2); // get the intval
      if ($LDEBUG) print "$sFrac\n";
      $sResult .= $sChars[$sFrac];
      $sReal = bcsub($sReal, $sFrac, $iScale);
    }
  }

  return $sResult;
}


Function base_base2dec($sNum, $iBase=0, $iScale=0) {
  $sChars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
  $sResult = '';

  $iBase = intval($iBase); // incase it is a string or some weird decimal

  // special case for Base64 encoding
  if ($iBase == 64)
   $sChars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/';

  // special case for RFC Base32 encoding - terry@cnysupport.com
if ($iBase == 32)
   $sChars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';


  // clean up the input string if it uses particular input formats
  switch ($iBase) {
    case 16: // remove 0x from start of string
      if (strtolower(substr($sNum, 0, 2)) == '0x') $sNum = substr($sNum, 2);
      break;
    case 8: // remove the 0 from the start if it exists - not really required
      if (strpos($sNum, '0')===0) $sNum = substr($sNum, 1);
      break;
    case 2: // remove an 0b from the start if it exists
      if (strtolower(substr($sNum, 0, 2)) == '0b') $sNum = substr($sNum, 2);
      break;
    case 64: // remove padding chars: =
      $sNum = str_replace('=', '', $sNum);
      break;
    default: // Look for numbers in the format base#number,
             // if so split it up and use the base from it
      if (strpos($sNum, '#') !== false) {
        list ($sBase, $sNum) = explode('#', $sNum, 2);
        $iBase = intval($sBase);  // take the new base
      }
      if ($iBase == 0) {
        print("base_base2dec called without a base value and not in base#number format");
        return '';
      }
      break;
  }

  // Convert string to upper case since base36 or less is case insensitive
  if ($iBase < 37) $sNum = strtoupper($sNum);

  // Check to see if we are an integer or real number
  if (strpos($sNum, '.') !== FALSE) {
    list ($sNum, $sReal) = explode('.', $sNum, 2);
    $sReal = '0.' . $sReal;
  } else
    $sReal = '0';


  // By now we know we have a correct base and number
  $iLen = strlen($sNum);

  // Now loop through each digit in the number
  for ($i=$iLen-1; $i>=0; $i--) {
    $sChar = $sNum[$i]; // extract the last char from the number
    $iValue = strpos($sChars, $sChar); // get the decimal value
    if ($iValue > $iBase) {
      print("base_base2dec: $sNum is not a valid base $iBase number ($iValue > $iBase - char $sChar: $sChars)");
      return '';
    }
    // Now convert the value+position to decimal
    $sResult = bcadd($sResult, bcmul( $iValue, bcpow($iBase, ($iLen-$i-1))) );
  }

  // Now append the real part
  if (strcmp($sReal, '0') != 0) {
    $sReal = substr($sReal, 2); // Chop off the '0.' characters
    $iLen = strlen($sReal);
    for ($i=0; $i<$iLen; $i++) {
      $sChar = $sReal[$i]; // extract the first, second, third, etc char
      $iValue = strpos($sChars, $sChar); // get the decimal value
      if ($iValue > $iBase) {
        print("base_base2dec: $sNum is not a valid base $iBase number");
        return '';
      }
      $sResult = bcadd($sResult, bcdiv($iValue, bcpow($iBase, ($i+1)), $iScale), $iScale);
    }
  }

  return $sResult;
}

Function base_base2base($iNum, $iBase, $oBase, $iScale=0) {

  if ($iBase != 10) $oNum = base_base2dec($iNum, $iBase, $iScale);
  else $oNum = $iNum;
  $oNum = base_dec2base($oNum, $oBase, $iScale);
  return $oNum;

}


/**
 * PHPGangsta_GoogleAuthenticator modified by Terry Carmen (terry@cnysupport.com) to output the secret in the Base32 format required by mod_authn_opt.
 *
 * PHP Number Base Conversion Functions (c) 2004,2005 Paul Gregg <pgregg@pgregg.com>
 * base_base2dec modified by Terry Carmen (terry@cnysupport.com) to convert handle rfc4648 Base32 conversions, and to use /dev/random or /dev/urandom
 *
 * PHP Class for handling Google Authenticator 2-factor authentication
 *
 * @author Michael Kliewe
 * @copyright 2012 Michael Kliewe
 * @license http://www.opensource.org/licenses/bsd-license.php BSD License
 * @link http://www.phpgangsta.de/
 *
 * Modified by Terry Carmen, CNY Support, LLC to use /dev/random or /dev/urandom
 */

class PHPGangsta_GoogleAuthenticator
{
    protected $_codeLength = 6;

    /**
     * Create new secret.
     * 16 characters, randomly chosen from the allowed base32 characters.
     *
     * @param int $secretLength
     * @return string
     */
    public function createSecret($secretLength = 16)
    {
        $validChars = $this->_getBase32LookupTable();
        unset($validChars[32]);
        $secret = '';

       	$hand=fopen(RANDOM_DEVICE, 'r');
	if ($hand)
		{
			for ($i = 0; $i < $secretLength; $i++)
				{
					$RChar=fread($hand, 1);
					$RByte=ord($RChar);
					$B32Byte= $RByte >> 3;
					/*
						Shift all the bits to the right three places and zero off the left
						This gives us a 5 bit random number, usable an an index into the base32 array.
					*/
					$secret .= $validChars[$B32Byte];
				}

			fclose($hand);

	        }
        return $secret;
    }


    /**
     * Get array with all 32 characters for decoding from/encoding to base32
     *
     * @return array
     */
    protected function _getBase32LookupTable()
    {
        return array(
            'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', //  7
            'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', // 15
            'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', // 23
            'Y', 'Z', '2', '3', '4', '5', '6', '7', // 31
            '='  // padding char
        );
    }
}



 ?>
