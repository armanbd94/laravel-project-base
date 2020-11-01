<?php
namespace App\Services;

use Illuminate\Http\Request;
use App\Services\BaseService;
use App\Repositories\RoleRepository AS Role;
use App\Repositories\ModuleRepository AS Module;
use Carbon\Carbon;

class RoleService extends BaseService
{
    protected $role;
    protected $module;

    public function __construct(Role $role,Module $module)
    {
        $this->role   = $role;
        $this->module = $module;
    }

    public function get_datatable_data(Request $request)
    {
        if ($request->ajax()) {

            if (!empty($request->role_name)) {
                $this->role->setRoleName($request->role_name);
            }

            $this->role->setOrderValue($request->input('order.0.column'));
            $this->role->setDirValue($request->input('order.0.dir'));
            $this->role->setLengthValue($request->input('length'));
            $this->role->setStartValue($request->input('start'));

            $list = $this->role->getDatatableList();

            $data = [];
            $no = $request->input('start');
            foreach ($list as $value) {
                $no++;
                $action = '';
                $action .= ' <a class="dropdown-item edit_data" href="'.route('role.edit',['id'=>$value->id]).'"><i class="fas fa-edit text-primary"></i> Edit</a>';
                $action .= ' <a class="dropdown-item view_data" href="'.route('role.view',['id'=>$value->id]).'"><i class="fas fa-eye text-warning"></i> View</a>';
                if($value->deletable == 1){
                $action .= ' <a class="dropdown-item delete_data"  data-id="' . $value->id . '" data-name="' . $value->role_name . '"><i class="fas fa-trash text-danger"></i> Delete</a>';
                }
                $btngroup = '<div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-th-list text-white"></i>
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                ' . $action . '
                </div>
              </div>';

                $row = [];
                
                if($value->deletable == 1){
                $row[] = '<div class="custom-control custom-checkbox">
                            <input type="checkbox" value="'.$value->id.'"
                            class="custom-control-input select_data" onchange="select_single_item('.$value->id.')" id="checkbox'.$value->id.'">
                            <label class="custom-control-label" for="checkbox'.$value->id.'"></label>
                        </div>';
                }else{
                    $row[] = '';
                }
                $row[] = $no;
                $row[] = $value->role_name;
                $row[] = DELETABLE[$value->deletable];
                $row[] = $btngroup;
                $data[] = $row;
            }
            return $this->datatable_draw($request->input('draw'),$this->role->count_all(),
             $this->role->count_filtered(), $data);
        }
    }

    public function store_or_update_data(Request $request)
    {
        $collection = collect($request->validated());
        $role = $this->role->updateOrCreate(['id'=>$request->update_id],$collection->all());
        if($role){
            $role->module_role()->sync($request->module);
            $role->permission_role()->sync($request->permission);
            return true;
        }
        return false;
    }

    public function edit(int $id)
    {
        $role = $this->role->find_data_with_module_permission($id);
        $role_module = [];
        if(!$role->module_role->isEmpty())
        {
            foreach ($role->module_role as $value) {
                array_push($role_module,$value->id);
            }
        }
        $role_permission = [];
        if(!$role->permission_role->isEmpty())
        {
            foreach ($role->permission_role as $value) {
                array_push($role_permission,$value->id);
            }
        }

        $data = [
            'role' => $role,
            'role_module' => $role_module,
            'role_permission' => $role_permission,
        ];

        return $data;
    }

    public function delete(Request $request)
    {
        return $this->role->delete($request->id);
    }

    public function bulk_delete(Request $request)
    {
        return $this->role->destroy($request->ids);
    }

    public function permission_module_list(){
        return $this->module->permission_module_list();
    }

    
}