<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
   @property varchar $name name
@property timestamp $created_at created at
@property timestamp $updated_at updated at
@property \Illuminate\Database\Eloquent\Collection $department hasMany

 */
class Branch extends Model
{

    /**
    * Database table name
    */
    protected $table = 'branches';

    /**
    * Mass assignable columns
    */
    /*protected $fillable=['name', 'code'];*/
    protected $guarded = [];

    /**
    * Date time columns.
    */
    protected $dates=[];

    /**
    * departments
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function departments()
    {
        return $this->hasMany(Department::class,'branch_id');
    }


    public function hasMembers()
    {
        return count($this->departments()->get());
    }


    public function hr_mapping(){
        return $this->hasMany(HrTaskMapping::class, 'branch_id');
    }

    public function staff(){
        return $this->hasMany(UserDetail::class, 'branch_id')->join('users', 'users.id', '=', 'user_details.user_id')->where('users.status', 'active');
    }


}
