<?php

namespace KhanCode\LaravelRestBuilder;

use DB;
use Request;
use Session;
use KhanCode\LaravelRestBuilder\Models\Moduls;
use KhanCode\LaravelRestBuilder\Models\ModulFiles;

class ModulBuilder
{
    /**
     * Undocumented function
     *
     * @param [type] $id
     * @return void
     */
    public function destroy($id)
    {
        \DB::beginTransaction();

        $files = ModulFiles::getAll()->where('modul_id',$id)->get();
        
        foreach ($files as $key => $value) {
            // chown($value->name, 666); //Insert an Invalid UserId to set to Nobody Owern; 666 is my standard for "Nobody" 
            if ( file_exists($value->name) ){
                unlink($value->name);
            }
            $value->delete();
        }
        
        $dataModul = Moduls::find($id);

        $route_file = $dataModul->name;
        
        $system_route = file_get_contents(base_path().config('laravelrestbuilder.copy_to').'/routes/api.php', FILE_USE_INCLUDE_PATH);
        $system_route = str_replace("\r\n\r\n"."include '".$route_file.".stub';",'',$system_route);        
        $system_route = str_replace("\n\n"."include '".$route_file.".stub';",'',$system_route);                                
        FileCreator::create( 'api', config('laravelrestbuilder.copy_to').'/routes', $system_route, 'route', false );

        // delete modul
        $dataModul->delete();

        \DB::commit();

        return [
            'success' => 1
        ];
    }
}
