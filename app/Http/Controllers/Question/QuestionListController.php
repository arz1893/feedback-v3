<?php

namespace App\Http\Controllers\Question;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class QuestionListController extends Controller
{
    public function index() {
        return view('question.list.question_list_index');
    }
}
