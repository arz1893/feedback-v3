<?php

namespace App\Http\Controllers\Question;

use App\Http\Resources\Question\QuestionCollection;
use App\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Question\Question as QuestionResource;
use Webpatser\Uuid\Uuid;

class QuestionController extends Controller
{
    public function index() {
        return view('question.question_index');
    }

    /* API Section */
    public function getAllQuestion($tenant_id) {
        $questions = Question::where('tenantId', $tenant_id)->orderBy('created_at', 'desc')->paginate(15);
        return new QuestionCollection($questions);
    }

    public function getQuestion($question_id) {
        $question = Question::findOrFail($question_id);
        return new QuestionResource($question);
    }

    public function addQuestion(Request $request) {
        Question::create([
            'systemId' => Uuid::generate(4),
            'question' => $request->question['content'],
            'customerId' => $request->question['customer']['systemId'],
            'is_need_call' => $request->question['is_need_call'],
            'tenantId' => $request->tenantId,
            'syscreator' => $request->syscreator
        ]);
        return ['message' => 'success'];
    }

    public function updateQuestion(Request $request) {
        $question = Question::findOrFail($request->question['systemId']);
        $question->update([
            'question' => $request->question['question'],
            'customerId' => $request->question['customerId'],
            'sysupdater' => $request->user,
            'is_need_call' => $request->question['is_need_call']
        ]);
        return ['message' => 'success'];
    }
}
