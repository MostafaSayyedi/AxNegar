<?php

namespace App\Http\Controllers\Backend\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SteganoController extends Controller
{

//    public $src = 'result5404.png'; //Change this to the image to decrypt
public $basicDir;
    public $src; //Change this to the image to decrypt
    public $newSrc; // new image after steganography
    public $newImg; // full path of new image after steganography
    public $decryption_key; // Store the decryption key. use generateRandomString() func
    public $encryption_key; // // Store the encryption key . use generateRandomString() func
    public $msg; // //To encrypt

//    make random hash
    function generateRandomString($length = 16)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    //Convert string to binary
    public function toBin($str)
    {
        $str = (string)$str;
//     die($str);
        $l = strlen($str);
        $result = '';
        while ($l--) {
            $result = str_pad(decbin(ord($str[$l])), 8, "0", STR_PAD_LEFT) . $result;
        }
        return $result;
    }

    //Convert binary to string
    public function toString($str)
    {
        $text_array = explode("\r\n", chunk_split($str, 8));
        $newstring = '';
        for ($n = 0; $n < count($text_array) - 1; $n++) {
            $newstring .= chr(base_convert($text_array[$n], 2, 10));
        }
        return $newstring;
    }

    public function decryptions($newImg, $decryption_key=null, $newPathImage = null,$basicDir=null)
    {
        $this->newImg= $newImg;
        if (!is_null($basicDir)) {
            $this->basicDir = $basicDir;
        }
        if (!is_null($newPathImage)) {
            $this->newSrc = $newPathImage;
        }
        $img = imagecreatefrompng($this->newImg); //Returns image identifier
//        $img = imagecreatefromjpeg($this->newImg); //Returns image identifier
//die($img);
        $real_message = ''; //Empty variable to store our message

        $count = 0; //Wil be used to check our last char
        $pixelX = 0; //Start pixel x coordinates
        $pixelY = 0; //start pixel y coordinates

        list($width, $height, $type, $attr) = getimagesize($this->newImg); //get image size

        for ($x = 0; $x < ($width * $height); $x++) { //Loop through pixel by pixel
            if ($pixelX === $width + 1) { //If this is true, we've reached the end of the row of pixels, start on next row
                $pixelY++;
                $pixelX = 0;
            }

            if ($pixelY === $height && $pixelX === $width) { //Check if we reached the end of our file
                echo('انتهای فایل!');
                die();
            }

            $rgb = @imagecolorat($img, $pixelX, $pixelY); //Color of the pixel at the x and y positions
            $r = ($rgb >> 16) & 0xFF; //returns red value for example int(119)
            $g = ($rgb >> 8) & 0xFF; //^^ but green
            $b = $rgb & 0xFF;//^^ but blue

            $blue = $this->toBin($b); //Convert our blue to binary
//    die(strlen($blue[strlen($blue) - 1]));
            $real_message .= $blue[strlen($blue) - 1]; //Ad the lsb to our binary result
//die($real_message);
            $count++; //Coun that a digit was added

            if ($count == 8) { //Every time we hit 8 new digits, check the value
                if ($this->toString(substr($real_message, -8)) === '|') { //Whats the value of the last 8 digits?
//                    echo("انجام شد<br>"); //Yes we're done now
                    $real_message = $this->toString(substr($real_message, 0, -8)); //convert to string and remove /
//                    echo('نتیجه: ');
//          $real_message=password_verify($real_message); // decript password

                    $encryption = $real_message;
                    // Store the cipher method
                    $ciphering = "AES-128-CTR";

// Use OpenSSl Encryption method
                    $iv_length = openssl_cipher_iv_length($ciphering);
                    $options = 0;
                    // Non-NULL Initialization Vector for decryption
                    $decryption_iv = '1234567891011121';
                    if (!is_null($decryption_key)) {
                        $this->decryption_key = $decryption_key;
                    }
                    else{
                        $this->decryption_key= $this->encryption_key;
                    }
//                    $this->decryption_key = "kashefymajid1992@gmail.com";
                    $this->decryption_key = $this->encryption_key;

// Use openssl_decrypt() function to decrypt the data
                    $decryption = openssl_decrypt($encryption, $ciphering,
                        $this->decryption_key, $options, $decryption_iv);
                    $real_message = $decryption;

                    return $real_message; //Show
//                    die;
                }
                $count = 0; //Reset counter
            }

            $pixelX++; //Change x coordinates to next
        }
    }


    public function encryptions($msg, $encryption_key, $imgSrc, $newPathImage,$basicDir)
    {

        $this->basicDir = $basicDir;
        $this->newSrc = $newPathImage;
//Edit below variables
//$msg = 'here'; //To encrypt
//        $this->msg = '{"FILE": {"FileName": "php29A3.tmp", "FileSize": 23623, "FileType": 2, "MimeType": "image/jpeg", "FileDateTime": 1586794371, "SectionsFound": ""}, "COMPUTED": {"html": "width=\"485\" height=\"648\"", "Width": 485, "Height": 648, "IsColor": 1}}'; //To encrypt
        $this->msg = $msg; //To encrypt
//$msg = 'تت'; //To encrypt
//$msg=password_hash($msg, PASSWORD_DEFAULT); // hash message

        $simple_string = $this->msg;
//$simple_string=json_decode($simple_string);
// Store the cipher method
        $ciphering = "AES-128-CTR";

// Use OpenSSl Encryption method
        $iv_length = openssl_cipher_iv_length($ciphering);
        $options = 0;

// Non-NULL Initialization Vector for encryption
        $encryption_iv = '1234567891011121';

// Store the encryption key
        $this->encryption_key = $encryption_key;

// Use openssl_encrypt() function to encrypt the data
        $encryption = openssl_encrypt($simple_string, $ciphering,
            $this->encryption_key, $options, $encryption_iv);
//die($encryption);
        $msg = $encryption;

        $this->src = $imgSrc; //Start image

        $msg .= '|'; //EOF sign, decided to use the pipe symbol to show our decrypter the end of the message
        $msgBin = $this->toBin($msg); //Convert our message to binary
        $msgLength = strlen($msgBin); //Get message length
        $img = imagecreatefromjpeg($this->src); //returns an image identifier

        list($width, $height, $type, $attr) = getimagesize($this->src); //get image size
        if ($msgLength > ($width * $height)) { //The image has more bits than there are pixels in our image
            echo('پیام مورد نظر طولانی و بیشتر از اندازه عکس میباشد!');
            die();
        }

        $pixelX = 0; //Coordinates of our pixel that we want to edit
        $pixelY = 0; //^

        for ($x = 0; $x < $msgLength; $x++) { //Encrypt message bit by bit (literally)
            if ($pixelX === $width + 1) { //If this is true, we've reached the end of the row of pixels, start on next row
                $pixelY++;
                $pixelX = 0;
            }

            if ($pixelY === $height && $pixelX === $width) { //Check if we reached the end of our file
                echo('انتهای فایل');
                die();
            }

            $rgb = @imagecolorat($img, $pixelX, $pixelY); //Color of the pixel at the x and y positions
            $r = ($rgb >> 16) & 0xFF; //returns red value for example int(119)
            $g = ($rgb >> 8) & 0xFF; //^^ but green
            $b = $rgb & 0xFF;//^^ but blue
//dd($r,$g,$b);

            $newR = $r; //we dont change the red or green color, only the lsb of blue
            $newG = $g; //^
            $newB = $this->toBin($b); //Convert our blue to binary
            $newB[strlen($newB) - 1] = $msgBin[$x]; //Change least significant bit with the bit from out message
            $newB = $this->toString($newB); //Convert our blue back to an integer value (even though its called tostring its actually toHex)
            $new_color = imagecolorallocate($img, $newR, $newG, $newB); //swap pixel with new pixel that has its blue lsb changed (looks the same)
            imagesetpixel($img, $pixelX, $pixelY, $new_color); //Set the color at the x and y positions
            $pixelX++; //next pixel (horizontally)

        }
//        die(storage_path($this->basicDir . $this->newSrc));
        imagepng($img, public_path($this->basicDir . $this->newSrc)); //Create image
//        imagejpeg($img, public_path($this->basicDir . $this->newSrc)); //Create image

        imagedestroy($img); //get rid of it
    }
}
