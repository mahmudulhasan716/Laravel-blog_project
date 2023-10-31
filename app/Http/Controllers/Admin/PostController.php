<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Post;
use Intervention\Image\Facades\Image;



class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $category = Category::all();
        $obj_post = new Post();
        $posts = $obj_post->join('categories', 'categories.id', '=', 'posts.category_id')
            ->select('posts.*', 'categories.name as category_name')
            ->orderBy('posts.id', 'desc')
            ->get();

        return view('admin.post', compact('category', 'posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'category_id' => 'required'
        ]);

        $data = [
            'title' => $request->title,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'status' => $request->status
        ];


        if ($request->hasFile('thumbail')) {
            $file = $request->file('thumbail');
            $extention = $file->getClientOriginalExtension();
            $fileName = time() . '.' . $extention;


            //resize image
            $thumbnil = Image::make($file);
            $thumbnil->resize(600, 400, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            $thumbnil->save(public_path('post_thumbnil/' . $fileName));

            //$file->move(public_path('post_thumbnil'), $fileName);
            $data['thumbail'] = $fileName;
        };

        Post::create($data);

        return redirect()->back()->with('success', 'Post Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'category_id' => 'required'
        ]);

        $data = [
            'title' => $request->title,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'status' => $request->status
        ];


        if ($request->hasFile('thumbail')) {

            if (isset($request->old_thumbail)) {
                //File::delete(public_path('post_thumbnil/' . $request->old_thumbail));
                unlink(public_path('post_thumbnil/' . $request->old_thumbail));
            }
            $file = $request->file('thumbail');
            $extention = $file->getClientOriginalExtension();
            $fileName = time() . '.' . $extention;
            $file->move(public_path('post_thumbnil'), $fileName);
            $data['thumbail'] = $fileName;
        };

        Post::where('id', $id)->update($data);

        return redirect()->back()->with('success', 'Post updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::find($id);

        if (isset($post->thumbail)) {
            unlink(public_path('post_thumbnil/' . $post->thumbail));
        };

        $post->delete();

        return redirect()->back()->with('success', 'Post deleted Successfully');
    }
}
