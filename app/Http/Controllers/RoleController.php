<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RoleService;
use App\Http\Controllers\BaseController;
use App\Http\Requests\RoleRequest;

class RoleController extends BaseController
{
    public function __construct(RoleService $role)
    {
        $this->service = $role;
    }

    public function index()
    {
        $this->setPageData('Role','Role','fas fa-th-list');
        return view('role.index');
    }

    public function get_datatable_data(Request $request)
    {
        if($request->ajax()){
            $output = $this->service->get_datatable_data($request);
        }else{
            $output = ['status'=>'error','message'=>'Unauthorized Access Blocked!'];
        }

        return response()->json($output);
    }

    public function create()
    {
        $this->setPageData('Create Role','Create Role','fas fa-th-list');
        $data = $this->service->permission_module_list();
        return view('role.create',compact('data'));
    }

    public function store_or_update_data(RoleRequest $request)
    {
        if($request->ajax()){
            $result = $this->service->store_or_update_data($request);
            if($result){
                return $this->response_json($status='success',$message='Data Has Been Saved Successfully',$data=null,$response_code=200);
            }else{
                return $this->response_json($status='error',$message='Data Cannot Save',$data=null,$response_code=204);
            }
        }else{
           return $this->response_json($status='error',$message=null,$data=null,$response_code=401);
        }
    }

    public function edit(int $id)
    {
        $this->setPageData('Edit Role','Edit Role','fas fa-th-list');
        $data = $this->service->permission_module_list();
        $permission_data = $this->service->edit($id);
        return view('role.edit',compact('data','permission_data'));
    }


    public function delete(Request $request)
    {
        if($request->ajax()){
            $result = $this->service->delete($request);
            if($result){
                return $this->response_json($status='success',$message='Data Has Been Deleted Successfully',$data=null,$response_code=200);
            }else{
                return $this->response_json($status='error',$message='Data Cannot Delete',$data=null,$response_code=204);
            }
        }else{
           return $this->response_json($status='error',$message=null,$data=null,$response_code=401);
        }
    }

    public function bulk_delete(Request $request)
    {
        if($request->ajax()){
            $result = $this->service->bulk_delete($request);
            if($result){
                return $this->response_json($status='success',$message='Data Has Been Deleted Successfully',$data=null,$response_code=200);
            }else{
                return $this->response_json($status='error',$message='Data Cannot Delete',$data=null,$response_code=204);
            }
        }else{
           return $this->response_json($status='error',$message=null,$data=null,$response_code=401);
        }
    }
}