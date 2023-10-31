<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use App\Models\ContactMessage;
use App\Models\postcomment;
use App\Models\Question;
use App\Models\QuestionAnswer;
use App\Models\QuestionAnswerLike;

class UserController extends Controller
{
    public function index()
    {
        $post_obj = new Post;

        $posts = $post_obj->join('categories', 'categories.id', '=', 'posts.id')
            ->select('posts.*', 'categories.name as category_name')
            ->where('posts.status', 1)
            ->orderby('posts.id', 'desc')
            ->paginate(5);

        $recent_posts = $post_obj->join('categories', 'categories.id', '=', 'posts.id')
            ->select('posts.*', 'categories.name as category_name')
            ->where('posts.status', 1)
            ->orderby('posts.id', 'desc')
            ->limit(3)
            ->get();

        $categories = Category::all();

        Post::all()->where('status', 1)->sortByDesc('created_at');

        return view('user.index', compact('posts', 'categories', 'recent_posts'));
    }


    public function single_post_view($id)
    {
        $post_obj = new Post;

        $posts = $post_obj->join('categories', 'categories.id', '=', 'posts.id')
            ->select('posts.*', 'categories.name as category_name')
            ->where('posts.id', $id)
            ->first();

        $comments_obj = new postcomment();

        $comments = $comments_obj->join('users', 'users.id', '=', 'postcomments.id')
            ->select('postcomments.*', 'users.name as user_name', 'users.photo as user_image')
            ->where('postcomments.post_id', $id)
            ->paginate(3);


        //$comments = PostComment::where('post_id', $id)->get();
        return view('user.single_post_view', compact('posts', 'comments'));
    }

    public function filter_by_category($id)
    {

        $post_obj = new Post;

        $Filter_posts = $post_obj->join('categories', 'categories.id', '=', 'posts.id')
            ->select('posts.*', 'categories.name as category_name')
            ->where('posts.status', 1)
            ->where('posts.category_id', $id)
            ->paginate(5);


        $recent_posts = $post_obj->join('categories', 'categories.id', '=', 'posts.id')
            ->select('posts.*', 'categories.name as category_name')
            ->where('posts.status', 1)
            ->orderby('posts.id', 'desc')
            ->limit(3)
            ->get();

        $categories = Category::all();


        return view('user.filter_by_category', compact('recent_posts', 'Filter_posts', 'categories'));
    }

    public function comment_store(Request $request, $id)
    {
        $data = [
            'post_id' => $id,
            'user_id' => auth()->user()->id,
            'comment' => $request->comment,
        ];

        postcomment::create($data);
        $notify = ['message' => 'comment Add Successfully', 'alert-type' => 'success'];
        return redirect()->back()->with($notify);
    }


    public function questions()
    {
        $Question_obj = new question;

        $questions = $Question_obj->join('categories', 'categories.id', '=', 'questions.id')
            ->join('users', 'users.id', '=', 'questions.user_id')
            ->select('questions.*', 'categories.name as category_name', 'users.name as user_name', 'users.photo as user_photo')
            ->orderBy('questions.id', 'desc')
            ->paginate(5);



        $post_obj = new Post;

        $recent_posts = $post_obj->join('categories', 'categories.id', '=', 'posts.id')
            ->select('posts.*', 'categories.name as category_name')
            ->where('posts.status', 1)
            ->orderby('posts.id', 'desc')
            ->limit(3)
            ->get();


        $categories = Category::all();
        return view('user.question', compact('categories', 'questions', 'recent_posts'));
    }


    public function questions_store(Request $request)
    {

        $request->validate([
            'catergory_id' => 'required',
            'question' => 'required'
        ]);

        $data = [
            'user_id' => auth()->user()->id,
            'catergory_id' => $request->catergory_id,
            'question' => $request->question,
        ];

        Question::create($data);

        return redirect()->back();
    }

    public function questions_delete($id)
    {
        Question::find($id)->delete();

        $notify = ['message' => 'Question delete Successfully', 'alert-type' => 'success'];
        return redirect()->back()->with($notify);
    }


    public function questions_answer($id)
    {

        $Question_obj = new question;

        $question = $Question_obj->join('categories', 'categories.id', '=', 'questions.id')
            ->join('users', 'users.id', '=', 'questions.user_id')
            ->select('questions.*', 'categories.name as category_name', 'users.name as user_name', 'users.photo as user_photo')
            ->where('questions.id', $id)
            ->first();

        $answer_obj = new QuestionAnswer;

        $answers = $answer_obj->join('users', 'users.id', '=', 'question_answers.user_id')
            ->select('question_answers.*', 'users.name as user_name', 'users.photo as user_photo')
            ->where('question_answers.question_id', $id)
            ->get();


        return view('user.question_answers', compact('question', 'answers'));
    }

    public function questions_answer_store(Request $request, $id)
    {
        $data = [
            'question_id'       => $id,
            'user_id'           => auth()->user()->id,
            'question_answer'   => $request->answer,
        ];

        QuestionAnswer::create($data);

        $notify = ['message' => 'Answer Added  Successfully', 'alert-type' => 'success'];
        return redirect()->back()->with($notify);
    }

    public function answer_delete($id)
    {
        QuestionAnswer::find($id)->delete();

        $notify = ['message' => 'Answer delete Successfully', 'alert-type' => 'success'];
        return redirect()->back()->with($notify);
    }

    public function answer_like($id)
    {
        $data = [
            'answer_id' => $id,
            'user_id' => auth()->user()->id
        ];

        QuestionAnswerLike::create($data);

        return redirect()->back();
    }

    public function answer_unlike($id)
    {
        QuestionAnswerLike::where('answer_id', $id)->where('user_id', auth()->user()->id)->delete();
        return redirect()->back();
    }

    public function contact()
    {
        $categories = Category::all();
        return view('user.contact', compact('categories'));
    }

    public function contact_store(request $request)
    {
        $data = [
            'user_id' => auth()->user()->id,
            'subject' => $request->subject,
            'message' => $request->message
        ];

        ContactMessage::create($data);

        $notify = ['message' => 'message send success', 'alert-type' => 'success'];

        return redirect()->back()->with($notify);
    }

    public function about()
    {
        return view('user.about');
    }
}
