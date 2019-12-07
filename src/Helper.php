<?php

namespace KhanCode\LaravelRestBuilder;

class Helper   
{

    /**
     * queryFormatMoney function
     *
     * @param array $funct
     * @return void
     */
	static function queryFormatMoney(array $funct)
	{

        $column = (empty($funct[0]) ? '':$funct[0]);
        $currency_id = (empty($funct[1]) ? 'empty':$funct[1]);
        $dec_digit = (empty($funct[2]) ? '2':$funct[2]);
        $dec_point = (empty($funct[3]) ? '","':$funct[3]);
        $thousands_sep = (empty($funct[4]) ? '"."':$funct[4]);
        $default_value = (empty($funct[5]) ? '"."':$funct[5]);

        $space = " ";
        if($currency_id=="empty")
        {
            $space = "";
            $currency_id = "''";
        }            

        if(empty($asColumn))
            return ' IFNULL(concat('.$currency_id.',"'.$space.'",REPLACE(REPLACE(REPLACE(CAST(FORMAT('.$column.', '.$dec_digit.') AS CHAR), ".", "@"), '.$dec_point.', '.$thousands_sep.'), "@", '.$dec_point.')),'.$default_value.') ';
    }
    
    /**
	 * [queryFormatDate description]
	 *
     * @param array $funct 
	 */
	static function queryFormatDate($funct)
	{
        $column = (empty($funct[0]) ? '':$funct[0]);            
        $format = (empty($funct[1]) ? '"%d-%b-%Y"':$funct[1]);            
		return 'DATE_FORMAT('.$column.', '.$format.')';
    }
    
    /**
     * str_lreplace function
     *
     * @param [type] $search
     * @param [type] $replace
     * @param [type] $subject
     * @return void
     */
    static function str_lreplace($search, $replace, $subject)
    {
        $pos = strrpos($subject, $search);

        if($pos !== false)
        {
            $subject = substr_replace($subject, $replace, $pos, strlen($search));
        }

        return $subject;
    }

    /**
	 * camelToTitle function
	 *
	 * @param [type] $camelStr
	 * @return void
	 */
	static function camelToTitle($camelStr)
	{
		$intermediate = preg_replace('/(?!^)([[:upper:]][[:lower:]]+)/',
							' $0',
							$camelStr);
		$titleStr = preg_replace('/(?!^)([[:lower:]])([[:upper:]])/',
							'$1 $2',
							$intermediate);
		return $titleStr;
    }
}