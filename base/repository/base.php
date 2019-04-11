<?php
namespace App\Http\Repositories;

use Request;
use App\Http\Models\{{Name}};
use App\Exceptions\DataEmptyException;
// use KhanCode\LaravelBaseRest\BaseRepository;

/**
 * code for system logic
 */
class {{Name}}Repository extends BaseRepository
{
    /**
     * [$module description]
     * @var string
     */
    static $module = '{{title_case_name}}';

    /**
     * [__construct description]
     */
    public function __construct()
    {
        $this->model = new {{Name}};
    }

    /**
     * [getIndexData description]
     * @param  array  $sortableAndSearchableColumn [description]
     * @return [type]                              [description]
     */
    public function getIndexData(array $sortableAndSearchableColumn)
    {
        $this->model::validate(Request::all(), [
            'per_page'  =>  ['numeric'],
        ]);

        $data = $this->model
            ->getAll()
            ->setSortableAndSearchableColumn($sortableAndSearchableColumn)
            ->search()
            ->sort()
            ->distinct()
            ->orderBy($this->model->getKeyName(),'DESC')
            ->paginate(Request::get('per_page'));

        $data->sortableAndSearchableColumn = $sortableAndSearchableColumn;
            
        if($data->total() == 0) throw new DataEmptyException(trans('validation.attributes.dataNotExist',['attr' => self::$module]));

        return $data;
    }

    /**
     * [getSingleData description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function getSingleData($id)
    {
        $return = $this->model
                ->getAll()
                ->where($this->model->getKeyName(),$id)
                ->first();

        if($return === null) throw new DataEmptyException(trans('validation.attributes.dataNotExist',['attr' => self::$module]));

        return $return;
    }
    
}