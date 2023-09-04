<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Technology;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Exists;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts =Post::paginate(15);
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()

    {
        $types = Type::all();
        $technologies = Technology::all();
        return view('admin.posts.create', compact('technologies' , 'types'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $img_path = Storage::put('uploads', $request['image']);
        $data = $request->validate([
            'title' => ['required', 'unique:posts' , 'max:255'],
            'content' => ['required', 'min:10' ],
            'type_id' => ['required','exists:types,id'],
            'technologies' => ['exists:technologies,id'],
            
        ]);

        $data['image'] = $img_path;    
        $newPost = Post::create($data);
        $newPost->slug = Str::of("$newPost->id " .  $data['title'])->slug('-');
        $newPost->save();

        if ($request->has('technologies')){
            $newPost->technologies()->sync($request->technologies);
        }

        return redirect()->route('admin.posts.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {

        return view('admin.posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,Post $post)
    {
        $data = $request->validate([
            'title' => ['required' , 'max:255', Rule::unique('posts')->ignore($post->id)],
            'content' => ['required', 'min:10' ],
            'image' => ['url:https'],
        ]);

        $data['slug'] = Str::of($data['title'])->slug('-');

        $post->update($data);

        return redirect()->route('admin.posts.show',compact('post'));
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('admin.posts.index');
    }

    public function deletedIndex(){

        $posts = Post::onlyTrashed()->paginate(10);
        return view('admin.posts.deleteIndex' , compact('posts'));
    }

    public function restore($slug){
        $post = Post::withTrashed()->findOrFail($slug);
        
        $post-> restore();

        return redirect()->route('admin.posts.show', $post);
    }

    public function obliterate($slug){
        $post = Post::withTrashed()->findorFail($slug);
        $post->forceDelete();
        return redirect()->route('admin.posts.index');
    }
}
