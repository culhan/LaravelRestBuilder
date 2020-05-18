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

    /**
     * Undocumented function
     *
     * @param [type] $data
     * @param string $append
     * @return void
     */
    static function write($data,$append = '')
    {
        return $append.str_replace("\n","<br>".$append,$data);
    }
    
    /**
     * Executes a command and reurns an array with exit code, stdout and stderr content
     * @param string $cmd - Command to execute
     * @param string|null $workdir - Default working directory
     * @return string[] - Array with keys: 'code' - exit code, 'out' - stdout, 'err' - stderr
     */
    static function execute($cmd, $workdir = null) {

        if (is_null($workdir)) {
            $workdir = __DIR__;
        }

        $descriptorspec = array(
        0 => array("pipe", "r"),  // stdin
        1 => array("pipe", "w"),  // stdout
        2 => array("pipe", "w"),  // stderr
        );

        $process = proc_open($cmd, $descriptorspec, $pipes, $workdir, null);

        $stdout = stream_get_contents($pipes[1]);
        fclose($pipes[1]);

        $stderr = stream_get_contents($pipes[2]);
        fclose($pipes[2]);

        return [
            'code' => proc_close($process),
            'out' => trim($stdout),
            'err' => trim($stderr),
        ];
    }

    /**
     * Undocumented function
     *
     * @param [type] $string
     * @param string $start
     * @param string $end
     * @return void
     */
    static function get_string_between($string, $start = "", $end = ""){
        if (strpos($string, $start)) { // required if $start not exist in $string
            $startCharCount = strpos($string, $start) + strlen($start);
            $firstSubStr = substr($string, $startCharCount, strlen($string));
            $endCharCount = strpos($firstSubStr, $end);
            if ($endCharCount == 0) {
                $endCharCount = strlen($firstSubStr);
            }
            return substr($firstSubStr, 0, $endCharCount);
        } else {
            return '';
        }
    }
}