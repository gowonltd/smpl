<?php
/* SMPL Utils Classes
//  A collection of static utility functions and constants 
//
//*/


static class Utils
{
    // Convert strings to SEO-friendly strings, with optional flags to remove integers
    public static function Munge($string, $length = 30, $removeIntegers = false)
    {
        // Remove noise phrases: "the, and, a, an, or, my, our, us" etc.
        
        // Remove everything but standard ASCII characters "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWYXZ1234567890"
        $mung = trim($string);
        
        // Convert accented and international characters  
        $table = array(
            '�'=>'S', '�'=>'s', '�'=>'Dj', '�'=>'Z', '�'=>'z', 'C'=>'C', 'c'=>'c', 'C'=>'C', 'c'=>'c',
            '�'=>'A', '�'=>'A', '�'=>'A', '�'=>'A', '�'=>'A', '�'=>'A', '�'=>'A', '�'=>'C', '�'=>'E', '�'=>'E',
            '�'=>'E', '�'=>'E', '�'=>'I', '�'=>'I', '�'=>'I', '�'=>'I', '�'=>'N', '�'=>'O', '�'=>'O', '�'=>'O',
            '�'=>'O', '�'=>'O', '�'=>'O', '�'=>'U', '�'=>'U', '�'=>'U', '�'=>'U', '�'=>'Y', '�'=>'B', '�'=>'Ss',
            '�'=>'a', '�'=>'a', '�'=>'a', '�'=>'a', '�'=>'a', '�'=>'a', '�'=>'a', '�'=>'c', '�'=>'e', '�'=>'e',
            '�'=>'e', '�'=>'e', '�'=>'i', '�'=>'i', '�'=>'i', '�'=>'i', '�'=>'o', '�'=>'n', '�'=>'o', '�'=>'o',
            '�'=>'o', '�'=>'o', '�'=>'o', '�'=>'o', '�'=>'u', '�'=>'u', '�'=>'u', '�'=>'y', '�'=>'y', '�'=>'b',
            '�'=>'y', 'R'=>'R', 'r'=>'r',
        );
   
        $mung = strtr($mung, $table);
        
        // Remove integers from mung string if flagged
        if ($removeIntegers)
        {
            $key = '/[^A-Za-z \-]+/';
        }
        else
        {
            $key = '/[^A-Za-z0-9 \-]+/';
        }
        
        $replace = array($key, '/(\s|\-)+/', '/^-+|-+$/');
        $with = array('', '-', '');
        $mung = preg_replace($replace, $with, $mung);

        // Truncate string to the defined length
        $mung = Utils::Truncate($mung, $length);
        
        // Lower all cases
        $mung = strtolower($mung);
        return $mung;
    }

    public static function Truncate($string, $stringLimit = 30, $breakpointDelimeter = null)
    {
        if(null === $breakpointDelimeter)
        {
            if(strlen($string) <= $stringLimit)
            {
                return $string;
            }
            
            $string = substr($string, 0, $stringLimit);
            if(false !== ($breakpoint = strrpos($string, ' ')))
            {
                $string = substr($string, 0, $breakpoint);
            }
        }
        elseif(false !== ($breakpoint = strrpos($string, $breakpointDelimeter)))
        {
            $string=substr($string, 0, $breakpoint);
        }
                
        return $string;
    }

}




?>