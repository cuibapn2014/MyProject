<?php

namespace App\Http\Controllers\Admin;

use App\Events\TaskEvent;
use App\Http\Controllers\Controller;
use App\Models\Assign;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    //
    public function index()
    {
        if (!in_array(auth()->user()->role->alias,array('CEO', 'ADMIN'))) return redirect()->route('admin.task.user.index');
        return view('admin.manage.task.task', ['tasks' => Task::orderByDesc('created_at')->paginate(25)]);
    }

    public function getByUser()
    {
        if (Auth::user()->role->alias == 'CUSTOMER') return abort(401);
        $id = Auth::user()->id;

        // return view('admin.manage.task.ListTask');
        return Assign::where('id_NguoiNhan', $id)->with(['task', 'task.user'])->get();
    }

    public function getListTask()
    {
        $id = Auth::user()->id;
        Assign::where('id_NguoiNhan', $id)->update([
            'TrangThai' => 1
        ]);

        return view('admin.manage.task.ListTask');
    }

    public function create()
    {
        $this->middleware('admin');
        $user =  User::where('id', '!=', auth()->user()->id)->whereNotIn('id_role', [3, 4])->get();
        return view('admin.manage.task.createTask', ['users' => $user]);
    }

    public function store(Request $req)
    {
        $this->middleware('admin');
        $this->validate(
            $req,
            [
                'title' => 'required',
                'detail' => 'required',
                'duration' => 'required',
                'users.0' => 'required',
            ],
            [
                'title.required' => 'Bạn chưa nhập tiêu đề',
                'detail.requried' => 'Bạn chưa nhập chi tiết công việc',
                'duration.required' => 'Bạn chưa chọn ngày hoàn thành công việc',
                'users.0.required' => 'Bạn chưa chọn nhân viên làm công việc này',
            ]
        );

        $task = Task::create([
            'id_nguoi_giao' => Auth::user()->id,
            'tieu_de' => $req->title,
            'chi_tiet' => $req->detail,
            'ngay_hoan_thanh' => $req->duration
        ]);

        foreach ($req->users as $user) {
            $assign = Assign::create([
                'id_NguoiNhan' => $user,
                'id_CongViec' => $task->id
            ]);
            broadcast(new TaskEvent($assign->load(['task', 'task.user'])))->toOthers();
        }


        return redirect()->route('admin.task.index')->with('success', 'Thêm công việc thành công');
    }

    public function edit($id)
    {
        $this->middleware('admin');
        $task = Task::findOrFail($id);
        $this->authorize('update', $task);
        return view('admin.manage.task.editTask', [
            'users' => User::where('id', '!=', auth()->user()->id)->get(),
            'task' => $task
        ]);
    }

    public function update(Request $req, $id)
    {
        $this->middleware('admin');
        $this->validate(
            $req,
            [
                'title' => 'required',
                'detail' => 'required',
                'duration' => 'required',
                'users.0' => 'required',
            ],
            [
                'title.required' => 'Bạn chưa nhập tiêu đề',
                'detail.requried' => 'Bạn chưa nhập chi tiết công việc',
                'duration.required' => 'Bạn chưa chọn ngày hoàn thành công việc',
                'users.0.required' => 'Bạn chưa chọn nhân viên làm công việc này',
            ]
        );

        $task = Task::findOrFail($id);

        $this->authorize('update', $task);

        $task->update([
            'tieu_de' => $req->title,
            'chi_tiet' => $req->detail,
            'ngay_hoan_thanh' => $req->duration
        ]);

        foreach ($req->users as $user) {
            Assign::create([
                'id_NguoiNhan' => $user,
                'id_CongViec' => $task->id
            ]);
        }

        return redirect()->route('admin.task.index')->with('success', 'Cập nhật công việc thành công');
    }

    public function removeUser($id)
    {
        $this->middleware('admin');
        Assign::findOrFail($id)->delete();
        return back()->with('success', 'Đã gỡ');
    }

    public function delete($id)
    {
        Assign::where('id_CongViec', $id)->delete();
        Task::findOrFail($id)->delete();
        return back()->with('success', 'Đã xóa');
    }
}
