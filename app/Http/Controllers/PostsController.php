<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePost;
use App\Models\BlogPost;

use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;


class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')
            ->only(['create', 'store', 'edit', 'update', 'destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|Response
     */
    public function index()
    {
        $mostCommented = Cache::remember('blog-post-commented', 60,function (){
            return BlogPost::mostCommented()->take(5)->get();
        });

        $mostActive = Cache::remember('users-most-active',60,function (){
            return User::withMostBlogPosts()->take(5)->get();
        });

        $mostActiveLastMonth = Cache::remember('users-most-active-last-month', 60,function (){
            return User::withMostBlogPostsLastMonth()->take(5)->get();
        });

        return view('posts.index',
            [
                'posts' => BlogPost::latest()->withCount('comments')->with('user')->get(),
                'mostCommented' => $mostCommented,
                'mostActive'=> $mostActive,
                'mostActiveLastMonth'=> $mostActiveLastMonth,
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View|Response
     */
    public function create()
    {
//        $this->authorize('posts.create');
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(StorePost $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = $request->user()->id;
        $post = BlogPost::create($validated);


//        $post = new BlogPost();
//        $post->title = $validated['title'];
//        $post->content = $validated['content'];
//        $post->save();


        $request->session()->flash('status', 'The blog post was created!');
        return redirect()->route('posts.show', ['post' => $post->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View|Response
     */
    public function show($id)
    {
//        abort_if(!isset($this->posts[$id]), 404);
        /**
         * zwrócenie blogpost z komentarzami w kolejności created_at. wykorzystanie local scope
         */
//        return view('posts.show', [
//            'post' => BlogPost::with(['comments'=> function($query){
//                return $query->latest();
//            }])->findOrFail($id)]);

        $blogPost = Cache::remember('blog-post-{$id}',60,function () use ($id){
            return BlogPost::with('comments')->findOrFail($id);
        });

        $sessionId = session()->getId();
        $counterKey = 'blog-post-{$id}-counter';
        $usersKey = 'blog-post-{$id}-users';

        $users = Cache::get($usersKey, []);
        $usersUpdate = [];
        $difference = 0;
        $now = now();

        foreach ($users as $session => $lastVisit){
            if ($now->diffInMinutes($lastVisit)>=1){
                $difference--;
            }else{
                $usersUpdate[$session] = $lastVisit;
            }
        }

        if(!array_key_exists($sessionId, $users)
            || $now->diffInMinutes($users[$sessionId])>=1
        ){
            $difference++;
        }

        $usersUpdate[$sessionId] = $now;
        Cache::forever($usersKey, $usersUpdate);

        if (!Cache::has($counterKey)){
            Cache::forever($counterKey,1);
        }else{
            Cache::increment($counterKey, $difference);
        }

        $counter = Cache::get($counterKey);

        return view('posts.show', [
            'post' => $blogPost,
            'counter'=>$counter,
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View|Response
     */
    public function edit($id)
    {

        $post = BlogPost::findorfail($id);
//        if (Gate::denies('update-post', $post){
//            abort(403, "You can't update this blog post!")
//        });
        $this->authorize($post);// <- zamiast Gate::denies

        return view('posts.edit', ['post' => BlogPost::findOrFail($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse|Response
     */
    public function update(StorePost $request, $id)
    {

        $post = BlogPost::findorfail($id);

//        if (Gate::denies('update-post', $post){
//            abort(403, "You can't update this blog post!")
//        });

        $this->authorize($post); // <- zamiast Gate::denies


        $validated = $request->validated();
        $post->fill($validated);
        $post->save();

        $request->session()->flash('status', 'Blog post was updated!');

        return redirect()->route('posts.show', ['post' => $post->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse|Response
     */
    public function destroy($id)
    {
        $post = BlogPost::findOrFail($id);

//        if (Gate::denies('delete-post', $post){
//        abort(403, "You can't delete this blog post!")
//        }) ;
        $this->authorize($post);// <- zamiast Gate::denies

        $post->delete();

        session()->flash('status', 'Blog post was deleted!');

        return redirect()->route('posts.index');
    }
}
