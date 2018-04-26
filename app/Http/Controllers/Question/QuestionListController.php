<?php

namespace App\Http\Controllers\Question;

use App\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class QuestionListController extends Controller
{
    public function index() {
        return view('question.list.question_list_index');
    }

    public function edit($question_id) {
        $question = Question::findOrFail($question_id);
        return view('question.list.question_list_edit', compact('question'));
    }
}
