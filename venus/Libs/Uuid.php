<?php

namespace Shared;

class Uuid{
    public static function generate($entropy = false)
    {
        $s=uniqid("",$entropy);
        $num= hexdec(str_replace(".","",(string)$s));
        $index = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $base= strlen($index);
        $out = '';
        for($t = floor(log10($num) / log10($base)); $t >= 0; $t--) {
            $a = floor($num / pow($base,$t));
            $out = $out.substr($index,$a,1);
            $num = $num-($a*pow($base,$t));
        }
        return $out;
    }

    function unix(){
        $n = time() - 495891900;
        $index = '123456789ABCDEFGHIJKLMNPQRSTUVWXYZ';
        $l=strlen($index); 
        $s = ''; 
        for ($i = 1; $n >= 0 && $i < 10; $i++) { 
            $s =  substr($index,($n % pow($l, $i) / pow($l, $i - 1)),1).$s;
            $n -= pow($l, $i); 
        } 
    return $s;
}
}
?>