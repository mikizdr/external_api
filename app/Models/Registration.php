<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Registration extends Model
{

    // /**
    //  * @var string
    //  */
    // public $payment_type = '';

    // /**
    //  * @var string
    //  */
    // protected $payment_product = 'subscription';
    
    // /**
    //  * @var int
    //  */
    // protected $payment_exceeded = 0;
    
    // /**
    //  * @var string
    //  */
    // protected $state = 'active';
    
    // /**
    //  * @var boolean
    //  */
    // protected $present = false;
    
    // /**
    //  * @var int
    //  */
    // protected $approver_id = 0;
    
    // /**
    //  * @var int
    //  */
    // protected $approval_date = null;
    
    // /**
    //  * @var int
    //  */
    // protected $is_migrated = 0;
    
    // /**
    //  * @var string
    //  */
    // protected $notes = "";
    

    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'activity_id',
        'activity_date',
        'payment_type',
        'payment_product',
        'payment_product_id',
        'payment_exceeded',
        'state',
        'creator_id',
        'creation_date',
        'present',
        'approver_id',
        'approval_date',
        'is_migrated',
        'notes',
    ];

    /**
     * @var boolean
     */
    public $timestamps = false;
}
