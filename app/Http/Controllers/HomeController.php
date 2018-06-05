<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Product;
use App\Service;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $totalProduct = count(Product::where('tenantId', Auth::user()->tenantId)->get());
        $totalService = count(Service::where('tenantId', Auth::user()->tenantId)->get());
        $totalTag = count(Tag::where('recOwner', Auth::user()->tenantId)->get());
        $totalCustomer = count(Customer::where('tenantId', Auth::user()->tenantId)->get());
        Cookie::queue('company_email', Auth::user()->tenant->email);
        return view('home', compact('totalProduct', 'totalService', 'totalTag', 'totalCustomer'));
    }
}
