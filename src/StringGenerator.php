<?php
/**
 * @author Amina Kombo <https://aminakombo.work>
 */

class StringGenerator{

    /**
     * @param int $length
     * @return string -> result of generateRandomCode function call
     */
    public static function generateCode($length=6):string{

        return self::generateRandomCode($length);

    }

    /**
     * @param int $length
     * @return string $code
     */
    public static function generateRandomCode($length=6):string{

        $length=abs(intval($length));

        $codex="23456789qwertyupasdfghjkzxcvbnm";

        $code="";

        if($length>0){

            $codexLength=strlen($codex);

            for($x=0;$x<$length;$x++){

                $index=mt_rand(0,$codexLength-1);

                if(isset($codex[$index])){

                    $code.=$codex[$index];

                }

            }

        }

        return $code;

    }

}
