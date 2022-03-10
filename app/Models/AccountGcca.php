<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
   @property varchar $prefix prefix
@property varchar $code code
@property varchar $description description
@property timestamp $created_at created at
@property timestamp $updated_at updated at
   
 */
class AccountGcca extends Model 
{
    
    /**
    * Database table name
    */
    protected $table = 'account_gccas';

    /**
    * Mass assignable columns
    */
    protected $fillable=['prefix',
'code',
'description'];

    /**
    * Date time columns.
    */
    protected $dates=[];




}