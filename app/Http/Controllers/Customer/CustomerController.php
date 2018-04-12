<?php

namespace App\Http\Controllers\Customer;

use App\Customer;
use App\Http\Resources\Customer\CustomerCollection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Customer\Customer as CustomerResource;
use Webpatser\Uuid\Uuid;

class CustomerController extends Controller
{
    public function index() {

    }

    /* API Section */

    public function addCustomer(Request $request) {
        $id = Uuid::generate(4);

        $customer = Customer::create([
            'systemId' => $id,
            'name' => $request->customer['name'],
            'address' => $request->customer['address'],
            'city' => $request->customer['city'],
            'email' => $request->customer['email'],
            'gender' => $request->customer['gender'],
            'phone' => $request->customer['phone'],
            'birthdate' => date('Y-m-d', strtotime($request->customer['birthdate'])),
            'memo' => $request->customer['memo'],
            'tenantId' => $request->tenantId
        ]);
        return ['systemId' => utf8_encode($customer->systemId), 'name' => utf8_decode($customer->name)];
    }

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
