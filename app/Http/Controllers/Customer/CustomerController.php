<?php

namespace App\Http\Controllers\Customer;

use App\Customer;
use App\Http\Resources\Customer\CustomerCollection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Customer\Customer as CustomerResource;

class CustomerController extends Controller
{
    public function index() {

    }

    /* API Section */
    public function getAllCustomer($tenant_id) {
        $customers = Customer::where('tenantId', $tenant_id)->orderBy('name')->get();
        return new CustomerCollection($customers);
    }

    public function generateSelectCustomer($tenant_id) {
        $selectOption = array();
        $customers = Customer::where('tenantId', $tenant_id)->orderBy('name')->get();

        foreach ($customers as $customer) {
            array_push($selectOption, ['systemId' => $customer->systemId, 'name' => $customer->name]);
        }
        return $selectOption;
    }
}
