<?php

namespace KhanCode\LaravelRestBuilder;

use Illuminate\Support\Facades\Schema;

class RepositoryBuilder
{

    /**
     * createRepository function
     *
     * @param [type] $name
     * @param [type] $table
     * @return void
     */
    static function build( $name, $table )
    {
        $repository_file_name = ucwords($name).'Repository';
        $name = UCWORDS($name);
        $base_repository = file_get_contents(__DIR__.'/../base/repository/base.stub', FILE_USE_INCLUDE_PATH);
        $base_repository = str_replace('{{Name}}',$name,$base_repository);
        $base_repository = str_replace('{{title_case_name}}',self::camelToTitle($name),$base_repository);

        FileCreator::create( $repository_file_name, 'app/Http/Repositories', $base_repository );
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