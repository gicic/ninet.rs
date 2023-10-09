<?php

namespace App\Models;

use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Customer extends Model
{

    use MustVerifyEmail, Notifiable;

    protected $hidden = ['password', 'rememberToken'];

    protected $fillable = ['email', 'status_id'];

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    public function customerStatus()
    {
        return $this->belongsTo(CustomerStatus::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function order()
    {
        return $this->hasMany(Order::class);
    }


    public function activate()
    {
        $activeStatus = CustomerStatus::where('code', 'active')->first();
        $this->customer_status_id = $activeStatus->id;
        return $this->save();
    }

    public function deactivate()
    {
        $inactiveStatus = CustomerStatus::where('code', 'inactive')->first();
        $this->customer_status_id = $inactiveStatus->id;
        return $this->save();
    }

    public function setCustomerCode()
    {
        $customer = Customer::whereNotNull('customer_code')->orderBy('id', 'desc')->first();

        if(!empty($customer->customer_code)) {
            $customerCode = (int)$customer->customer_code + 1;
            while(Customer::where('customer_code', $customerCode)->first() !== null) {
                $customerCode++;
            }
        } else {
            $customerCode = '1111';
        }

        $this->customer_code = $customerCode;
        return $this;
    }

    /**
     * Customer validator
     *
     * @param $data
     * @return \Illuminate\Validation\Validator
     */
    public function validator($data)
    {
        $v = \Validator::make($data, [
            'email' => 'required|email|unique:customers|unique:contacts',
        ]);

        return $v;
    }

    public function getMainContact()
    {
        return $this->contacts()->whereHas('contactType', function ($query) {
            $query->where('code', 'primary');
        })->first();
    }
}
