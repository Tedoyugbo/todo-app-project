<?php

namespace App\Http\Livewire;

use App\Models\Tag;
use App\Models\Post;
use Livewire\Component;
use App\Models\Category;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Home extends Component
{
    use WithPagination;
    use WithFileUploads;

    protected $paginationTheme = 'bootstrap';

    protected $posts, $tags, $categories;

    public $title, $body, $category_id, $tag_ids, $image, $post_id;
    public $error;
    //set form validation rules

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->tags = Tag::all();
        $this->categories = Category::all();
    }

    public function render()
    {
        $search = $this->search;
        return view('livewire.home',[
            'tags' => $this->tags,
            'categories' => $this->categories,
            'main_post' => Post::inRandomOrder()->first(),
            'posts' => Post::where('title', 'like', '%'.$search.'%')
                ->orWhere('body', 'like', '%'.$search.'%')
                ->whereHas('category', function($q) use($search) {
                    $q->where('name',$search);
                })
                ->whereHas('tags', function($q) use($search) {
                    $q->where('name',$search);
                })
                ->orderBy('id','DESC')->paginate(5),
            'featured_posts' => Post::inRandomOrder()->take(2)->get(),
        ]);
    }

    public function goToPosts()
    {
        return redirect(route('posts.index'));
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    private function resetInputFields(){
        $this->title = '';
        $this->body = '';
        $this->category_id = '';
        $this->tags = [];
        $this->image = '';
    }


    public function store()
    {
        $this->validate([
            'title' => 'required',
            'body' => 'required',
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:1024',
            'category_id' => 'required',
        ]);

        $image_name  =  $this->image->getClientOriginalName();
        $this->image->storeAs('public/photos',$image_name);

        $post = new Post();
        $post->title = $this->title;
        $post->slug = Str::slug($this->title);
        $post->body = $this->body;
        $post->category_id = $this->category_id;
        $post->user_id = auth()->user()->id;
        $post->image = $image_name;
        $post->save();

        if ($this->tag_ids) {
            $post->tags()->attach($this->tag_ids);
        }

        if($post){
            //flash success message
            session()->flash('success','You Successfully Created a Post');
            //if user successfully created redirect to login page
            return redirect(route('admin.posts'));
        }

        $this->resetInputFields();
        $this->dispatchBrowserEvent('close-modal');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        if ($post) {
            $this->post_id =  $post->id;
            $this->title = $post->title;
            $this->body = $post->body;
            $this->category_id = $post->category_id;
            $this->tags = $post->tags;
            $this->image = $post->media->url;
        }else{
            redirect()->to('/admin/posts');
        }
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function cancel()
    {
        $this->resetInputFields();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function update()
    {
        //set form validation rules
        $this->validate([
            'title' => 'required|min:3',
            'body' => 'required|min:3',
        ]);

        $post = Post::find($this->post_id);
        $post->update([
            'title' => $this->title,
            'body' => $this->body
        ]);

        session()->flash('message', 'Post Updated Successfully.');
        $this->resetInputFields();
        $this->dispatchBrowserEvent('close-modal');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function delete()
    {
        Post::find($this->post_id)->delete();
        session()->flash('message', 'Post Deleted Successfully.');
    }
}
