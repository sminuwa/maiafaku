<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
   @property varchar $item item
@property enum $type type
@property decimal $amount amount
@property date $date date
@property bigint $user_id user id
@property timestamp $created_at created at
@property timestamp $updated_at updated at
   
 */
class PayrollPayslip extends Model 
{
    const TYPE_EARNING='Earning';

const TYPE_DEDUCTION='Deduction';

    /**
    * Database table name
    */
    protected $table = 'payroll_payslips';

    /**
    * Mass assignable columns
    */
    protected $fillable=['item',
'type',
'amount',
'date',
'user_id'];

    /**
    * Date time columns.
    */
    protected $dates=['date'];




}