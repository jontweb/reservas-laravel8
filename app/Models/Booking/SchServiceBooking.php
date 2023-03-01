<?php

namespace App\Models\Booking;

use App\Models\Customer\CmnCustomer;
use App\Models\Employee\SchEmployee;
use App\Models\Services\SchServices;
use App\Models\Settings\CmnBranch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Payment\CmnPaymentInfo;

class SchServiceBooking extends Model
{
    protected $fillable = [
        'id',
        'cmn_branch_id',
        'cmn_customer_id',
        'sch_employee_id',
        'date',
        'start_time',
        'end_time',
        'sch_service_id',
        'status',
        'service_amount',
        'paid_amount',
        'payment_status',
        'cmn_payment_type_id',
        'canceled_paid_amount',
        'cancel_paid_status',
        'cancel_cmn_payment_type_id',
        'created_by',
        'updated_by'
    ];

    public function branch()
    {
        return $this->belongsTo(CmnBranch::class);
    }
    public function customer()
    {
        return $this->belongsTo(CmnCustomer::class);
    }
    public function employee()
    {
        return $this->belongsTo(SchEmployee::class);
    }
    public function service()
    {
        return $this->belongsTo(SchServices::class);
    }

    public function payments()
    {
        return $this->morphMany(CmnPaymentInfo::class, "paymentable");
    }
    public function scopeUserWiseServiceBooking($query)
    {
        $employeeId = auth()->user()->sch_employee_id;
        if ($employeeId != null)
            return $query->where('sch_employee_id', $employeeId);
        return $query;
    }
    
}
