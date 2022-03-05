<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
   @property bigint $item_id item id
@property enum $type type
@property varchar $amount amount
@property int $level level
@property int $step step
@property timestamp $created_at created at
@property timestamp $updated_at updated at
   
 */
class PayrollSalaryStructure extends Model 
{
    const TYPE_EARNING='Earning';

const TYPE_DEDUCTION='Deduction';

    /**
    * Database table name
    */
    protected $table = 'payroll_salary_structures';

    /**
    * Mass assignable columns
    */
    protected $fillable=['item_id',
'type',
'amount',
'level',
'step'];

    /**
    * Date time columns.
    */
    protected $dates=[];




}