<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    const STATUS_LEAVE = 'leave';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    /*protected $fillable = [
        'options->enabled',
        'id',
        'name',
        'username',
        'email',
        'password',
        'position_id',
        'cadre_id',
        'signature',
        'email_verified_at',
        'status',
    ];*/

    protected $guarded = [];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
//    protected $hidden = [
//        'password',
//        'remember_token',
//    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
//    public $timestamps = 'U';

    protected $casts = [
        'email_verified_at' => 'datetime',
//	    'created_at' => 'datetime:Y-m-Y h:i:s',
//	    'updated_at' => 'datetime:Y-m-Y h:i:s'
    ];



    public function memosRaw()
    {
        $id = $this->id;
        $memos = Memo::whereRaw("(memos.raise_by=$id OR memos.raised_for=$id OR FIND_IN_SET('$id',memos.copy) > 0 OR $id IN (SELECT from_user FROM minutes WHERE memo_id=memos.id) OR $id IN (SELECT to_user FROM minutes WHERE memo_id=memos.id)) ");
        return $memos;
    }

	public function memo()
	{
		return $this->memosRaw()->whereRaw("memos.status = 'open'")->orderBy('id', 'desc');
	}

    public function memos()
    {
        return $this->memo()->get();
    }

    public function twoHoursMemos()
    {
        $id = $this->id;
//        $memos = $this->memosRaw()->whereRaw('memos.created_at >= DATE_SUB(NOW(),INTERVAL 2 HOUR)');
        $memos = $this->memosRaw()->select('memos.*')->whereRaw("(memos.status = 'open' AND minutes.id = (SELECT max(id) FROM minutes WHERE minutes.memo_id=memos.id) AND minutes.to_user = $id) AND memos.updated_at >= DATE_SUB(NOW(),INTERVAL 2 HOUR)")->join('minutes', 'minutes.memo_id', '=', 'memos.id');
        return $memos->orderBy('id', 'desc');
    }

    public function twoDaysMemos()
    {
        $id = $this->id;
//        $memos = $this->memosRaw()->whereRaw('memos.created_at >= ( CURDATE() - INTERVAL 2 DAY )');
        $memos = $this->memosRaw()->select('memos.*')->whereRaw("(memos.status = 'open' AND minutes.id = (SELECT max(id) FROM minutes WHERE minutes.memo_id=memos.id) AND minutes.to_user = $id) AND  memos.updated_at >= ( CURDATE() - INTERVAL 2 DAY )")->join('minutes', 'minutes.memo_id', '=', 'memos.id');
        return $memos->orderBy('id', 'desc');
    }

    public function oneWeekMemos()
    {
        $id = $this->id;
//        $memos = $this->memosRaw()->whereRaw('(memos.created_at >= curdate() - INTERVAL DAYOFWEEK(curdate())+6 DAY AND memos.created_at < curdate() - INTERVAL DAYOFWEEK(curdate())-1 DAY)');
        $memos = $this->memosRaw()->select('memos.*')->whereRaw("(memos.status = 'open' AND minutes.id = (SELECT max(id) FROM minutes WHERE minutes.memo_id=memos.id) AND minutes.to_user = $id) AND  memos.updated_at < ( NOW() - INTERVAL 1 WEEK )")->join('minutes', 'minutes.memo_id', '=', 'memos.id');
        return $memos->orderBy('id', 'desc');
    }

    //all users
    public function memosAll()
    {
        return Memo::whereRaw("memos.status = 'open'");
//        return $memos;
    }

    public function twoHoursMemosAll()
    {
        $memos = $this->memosAll()->whereRaw("memos.updated_at >= DATE_SUB(NOW(),INTERVAL 2 HOUR)");
        return $memos->orderBy('id', 'desc');
    }

    public function twoDaysMemosAll()
    {
        $memos = $this->memosAll()->whereRaw("memos.updated_at >= ( CURDATE() - INTERVAL 2 DAY )");
        return $memos->orderBy('id', 'desc');
    }

    public function oneWeekMemosAll()
    {
        $memos = $this->memosAll()->whereRaw("(memos.created_at >= curdate() - INTERVAL DAYOFWEEK(curdate())+6 DAY AND memos.created_at < curdate() - INTERVAL DAYOFWEEK(curdate())-1 DAY)");
        return $memos->orderBy('id', 'desc');
    }

    /*public function details()
    {
        return UserDetail::where(["user_id" => $this->id])->first();
    }*/

    public function details(){
        return $this->hasMany(UserDetail::class, 'user_id')->first();
    }

    public function fullName()
    {
        $user = $this->details();
        if (!$user) return "";
        $atc = $user->personnel_number ? '(' . $user->personnel_number . ')' : "";
        return ($user->surname ? strtoupper($user->surname) . ", " : "") . $user->first_name . " " . $user->other_names . $atc;
    }

    public function department()
    {
        return Department::find($this->details()->department_id);
    }

    public function branch()
    {
//        return $this->belongsTo(Branch::class, 'branch_id');
        return Branch::find($this->details()->branch_id);
    }

    public function position()
    {
        return Position::find($this->position_id);
    }

    public function referenceCode()
    {
        $act = $this->details()->personnel_number;
        if ($act == "")
            $act = $this->department()->code ?? 'CODE';
//        $department = $this->department()->code ?? 'CODE';
        $branch = $this->branch()->code ?? 'CODE';
//        $position = $this->position()?$this->position()->code:"CODE";
        return $branch . '/' . $act;
    }

    public function memoCount()
    {
        return [
            "raised" => Memo::where(['raise_by' => $this->id])->count(),
            "received" => Memo::where(['raised_for' => $this->id])->count(),
            "copied" => Minute::whereRaw("FIND_IN_SET('$this->id',copy)")->count(),
        ];
    }

    public function colleagues()
    {
        return User::whereIn('id', UserDetail::where('department_id', '=', $this->details()->department_id)
            ->where("user_id", "!=", $this->id)->limit(3)
            ->pluck('user_id'))->get();
    }

    public function saveDetails($data)
    {

    	return $data;
        $datum = (object)$data;
        $dt = UserDetail::where(["user_id" => $this->id])->first();
        if (!$dt) {
            $dt = new UserDetail();
            $dt->id = newId();
            $dt->user_id = $this->id;
        }
        $dt->surname = $datum->surname;
        $dt->first_name = $datum->first_name;
        $dt->other_names = $datum->other_names;
        $dt->gender = $datum->gender;
        $dt->department_id = $datum->department_id;
        $dt->branch_id = $datum->branch_id;
        $dt->personnel_number = $datum->personnel_number;
        $dt->contact_address = $datum->contact_address;
        $dt->phone = $datum->phone;
        $dt->status = 'active';
        $dt->marital_status = $datum->marital_status;

        return $dt->save();
    }

    public function canAccess($permission)
    {
        $permissionObj = Permission::where(["name" => $permission])->first();
        if (!$permissionObj) return false;

        $roles = RoleUser::where(['user_id' => $this->id])->pluck('role_id');
        $access = PermissionRole::where("permission_id", "=", $permissionObj->id)->whereIn('role_id', $roles)->get();
        // return count($access);
        return count($access);
    }

    public function hasRole($role_id)
    {
        return RoleUser::where(["role_id" => $role_id, "user_id" => $this->id])->first();
    }

    public function signature()
    {
        $signatureObj = User::where('id', $this->id)->first();
        if ($signatureObj) {
            return json_decode($signatureObj->signature);
        }
        return null;
    }

    public function myForms()
    {

    }

    public function activeLevel(){
        return PayrollUser::where(['status'=> 1, 'user_id'=>$this->id])->orderBy('id','desc')->first();
    }



    public function payslipYear(){
        return PayrollPayslip::select(DB::raw("YEAR(date) as year"))->distinct()->orderBy('year', 'desc')->pluck('year');
//        return PayrollPayslip::where('payroll_user_id', $this->id)->select('date')->distinct()->orderBy('date', 'desc')->get();
    }

    public function payslipMonth($year){
        return PayrollPayslip::where('payroll_user_id',$this->id)->where('date','like','%'.$year.'%')->select('date')->distinct()->orderBy('date', 'desc')->get();
    }

    public function grossSalary($month){

    }
    public function totalDeduction($month){

    }
    public function netSalary($month){

    }
    public function totalSalary($month){

    }

    public function monthlySalary(){

    }

    public function accountNumber(){

    }
}
