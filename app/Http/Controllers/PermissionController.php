<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PermissionService;
use App\Http\Controllers\BaseController;
use App\Http\Requests\PermissionRequest;
use App\Http\Requests\PermissionUpdateRequest;

class PermissionController extends BaseController
{
    public function __construct(PermissionService $permission)
    {
        $this->service = $permission;
    }

    public function index()
    {
        $this->setPageData('Permission','Permission','fas fa-th-list');
        $data = $this->service->index();
        return view('permission.index',compact('data'));
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

    public function store(PermissionRequest $request)
    {
        if($request->ajax()){
            $result = $this->service->store($request);
            if($result){
                return $this->response_json($status='success',$message='Data Has Been Saved Successfully',$data=null,$response_code=200);
            }else{
                return $this->response_json($status='error',$message='Data Cannot Save',$data=null,$response_code=204);
            }
        }else{
           return $this->response_json($status='error',$message=null,$data=null,$response_code=401);
        }
    }

    public function edit(Request $request)
    {
        if($request->ajax()){
            $data = $this->service->edit($request);
            if($data->count()){
                return $this->response_json($status='success',$message=null,$data=$data,$response_code=201);
            }else{
                return $this->response_json($status='error',$message='No Data Found',$data=null,$response_code=204);
            }
        }else{
           return $this->response_json($status='error',$message=null,$data=null,$response_code=401);
        }
    }

    public function update(PermissionUpdateRequest $request)
    {
        if($request->ajax()){
            $result = $this->service->update($request);
            if($result){
                return $this->response_json($status='success',$message='Data Has Been Updated Successfully',$data=null,$response_code=200);
            }else{
                return $this->response_json($status='error',$message='Data Cannot Update',$data=null,$response_code=204);
            }
        }else{
           return $this->response_json($status='error',$message=null,$data=null,$response_code=401);
        }
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
