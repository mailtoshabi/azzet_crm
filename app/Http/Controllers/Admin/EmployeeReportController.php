<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Utilities\Utility;
use App\Models\Employee;
use App\Models\EmployeeReport;
use App\Models\TaxSlab;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeReportController extends Controller
{
    public function index() {
        $status = request('status');
        $count_pending = EmployeeReport::whereDate('reported_at', Carbon::today())
        ->join('employees','employee_reports.employee_id','=','employees.id');
        if(request()->has('employee_id')) {
            $count_pending = $count_pending->where('employees.id',request('employee_id'));
        }
        $count_pending = $count_pending->where('employees.branch_id',default_branch()->id)->distinct()->count();

        $count_new = $count_pending<99? $count_pending:'99+';
        $status = isset($status)? decrypt(request('status')) : ($count_pending==0?0:1);

        $employee_reports = EmployeeReport::orderBy('employee_reports.id','desc')
            ->join('employees','employee_reports.employee_id','=','employees.id')
            ->where('employees.branch_id',default_branch()->id)
            ->select('estimates.*');
        if($status==Utility::ITEM_ACTIVE) {
            $employee_reports = $employee_reports
            ->whereDate('reported_at', Carbon::today());

        }else {
            $employee_reports = $employee_reports
            ->whereDate('reported_at', '!=', Carbon::today());
        }
        if(request()->has('employee_id')) {
            $employee_reports = $employee_reports->where('employees.id',request('employee_id'));
        }
        $employee_reports = $employee_reports->select('employee_reports.*')->distinct()->paginate(Utility::PAGINATE_COUNT);


        $employees = Employee::where('status',Utility::ITEM_ACTIVE)->where('branch_id',default_branch()->id)->get();
        return view('admin.employee_reports.index',compact('employee_reports','status','count_new','employees'));
    }

    // public function create() {
    //     return view('admin.employee.employee_reports.add');
    // }

    // public function store () {
    //     $validated = request()->validate([
    //         'reported_at' => 'required',
    //         'description' => 'required',
    //     ]);
    //     $input = request()->only(['reported_at','description']);
    //     $input['employee_id'] = Auth::guard('employee')->id();
    //     $employee_report = EmployeeReport::create($input);
    //     return redirect()->route('employee.employee_reports.index')->with(['success'=>'New Report Added Successfully']);
    // }

    // public function edit($id) {
    //     $employee_report = EmployeeReport::findOrFail(decrypt($id));
    //     if($employee_report->reported_at==Carbon::today()) {
    //         return view('admin.employee.employee_reports.add',compact('employee_report'));
    //     }else {
    //         abort(403);
    //     }
    // }

    // public function update () {
    //     $id = decrypt(request('employee_report_id'));
    //     $employee_report = EmployeeReport::find($id);
    //     //return EmployeeReport::DIR_PUBLIC . $employee_report->image;
    //     $validated = request()->validate([
    //         'reported_at' => 'required',
    //         'description' => 'required',
    //     ]);
    //     $input = request()->only(['reported_at','description']);
    //     $employee_report->update($input);
    //     return redirect()->route('employee.employee_reports.index')->with(['success'=>'Report Updated Successfully']);
    // }

    // public function destroy($id) {
    //     $employee_report = EmployeeReport::find(decrypt($id));
    //     $employee_report->delete();
    //     return redirect()->route('employee.employee_reports.index')->with(['success'=>'EmployeeReport Deleted Successfully']);
    // }

    // public function changeStatus($id) {
    //     $employee_report = EmployeeReport::find(decrypt($id));
    //     $currentStatus = $employee_report->status;
    //     $status = $currentStatus ? 0 : 1;
    //     $employee_report->update(['status'=>$status]);
    //     return redirect()->route('employee.employee_reports.index')->with(['success'=>'Status changed Successfully']);
    // }
}