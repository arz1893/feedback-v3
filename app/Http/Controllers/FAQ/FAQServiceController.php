<?php

namespace App\Http\Controllers\FAQ;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FAQServiceController extends Controller
{
    function index() {
        return view('faq.service.faq_service_index');
    }
}
