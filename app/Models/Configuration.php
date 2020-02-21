<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Configuration
 * @package App\Models
 * @version February 21, 2020, 9:37 am UTC
 *
 * @property string config_description
 * @property string config_value
 * @property string|\Carbon\Carbon modified_at
 */
class Configuration extends Model
{
    use SoftDeletes;

    public $table = 'configuration';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'config_description',
        'config_value',
        'modified_at'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'config_description' => 'string',
        'config_value' => 'string',
        'modified_at' => 'datetime'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'config_description' => 'required',
        'config_value' => 'required',
        'created_at' => 'required',
        'modified_at' => 'required',
        'deleted_at' => 'required'
    ];

    
}
