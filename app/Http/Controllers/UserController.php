<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return view('pages.dashboard');
    }

    public function indexDatatable(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'email',
            3 => 'role_id',
            4 => 'active',
            5 => 'created_at',

        );
        $current_user = Auth::user()->id;
        $totalData = User::where('id', '!=', $current_user)->count();
        $totalFiltered = $totalData;

        if ($request->input('length') != -1)
            $limit = $request->input('length');
        else
            $limit = $totalData;
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        if (empty($request->input('search.value')))
            $user_list = User::where('id', '!=', $current_user)
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        else {
            $search = $request->input('search.value');
            $user_list = User::where([
                ['name', 'LIKE', "%{$search}%"],
                ['email', 'LIKE', "%{$search}%"],
            ])->where('id', '!=', $current_user)->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)->get();

            $totalFiltered = User::where([
                ['name', 'LIKE', "%{$search}%"],
                ['email', 'LIKE', "%{$search}%"],
            ])->where('id', '!=', $current_user)->count();
        }
        $data = array();
        if (!empty($user_list)) {
            foreach ($user_list as $key => $user) {
                $nestedData['id'] = $user->id;
                $nestedData['name'] = $user->name;
                $nestedData['email'] = $user->email;
                $nestedData['role_id'] = $user->user_role->name;
                $nestedData['active'] = $user->active == 1 ? 'Active' : ( $user->active == 2 ? 'Inactive' : 'Block' ) ;
                $nestedData['created_at'] = date('d/m/Y', strtotime($user->created_at));
                $nestedData['options'] = '<a href="'.url('admin/user/'.$user->id.'/edit').'" class="btn btn-success btn-sm mr-2">Edit</a>';
                if($user->active == 2)
                    $nestedData['options'] .= '<a href="'.url('admin/user/'.$user->id.'/1/approve').'" class="btn btn-info btn-sm mr-2" onclick="return confirmAlert()">Approve</a>';
                elseif($user->active == 3)
                    $nestedData['options'] .= '<a href="'.url('admin/user/'.$user->id.'/1/approve').'" class="btn btn-info btn-sm mr-2" onclick="return confirmAlert()">Re-Approve</a>';
                else
                    $nestedData['options'] .= '<a href="'.url('admin/user/'.$user->id.'/3/approve').'" class="btn btn-danger btn-sm mr-2" onclick="return confirmAlert()">Block</a>';
                $nestedData['options'] .= '<a href="'.url('admin/user/'.$user->id.'/delete').'" class="btn btn-danger btn-sm" onclick="return confirmAlert()">Delete</a>';
                $data[] = $nestedData;
            }
        }
        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );

        return response()->json($json_data);
    }

    public function approveUser($id, $status)
    {
        $user = User::findOrFail($id);
        if($status == 1)
            $user->active = 1;
        else
            $user->active = 3;
        $user->save();
        return redirect()->to('admin');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('pages.edit-user', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            "name" => 'required|string',
            "email" => 'required|email',
        ]);
        $update_data = [
            'name' => $request->name,
            'email' => $request->email,
        ];
        if(!empty($request->password)){
            $update_data['active'] = 2;
            $update_data['password'] = Hash::make($request->password);
        }
        User::where('id', $id)->update($update_data);
        return redirect()->to('admin');
    }
    public function delete($id){
        User::destroy($id);
        return redirect()->to('admin');
    }
}
