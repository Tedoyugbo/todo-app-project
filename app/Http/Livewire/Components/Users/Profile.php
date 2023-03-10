<?php

namespace App\Http\Livewire\Components\Users;

use Carbon\Carbon;
use App\Models\Tag;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Livewire\Component;
use App\Models\Category;
use Livewire\WithPagination;
use App\Repositories\MediaRepo;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;

class Profile extends Component
{
    use WithPagination;
    use WithFileUploads;
    protected $paginationTheme = 'bootstrap';

    //for user mod
    public $first_name, $last_name, $email, $password, $role_id, $role_name, $avatar, $newAvatar;

    //for post crud
    public $title, $body, $category_id, $image, $newImage, $post_id;
    public $tag_ids = [];
    public $new_tag_ids = [];

    //for comment crud
    public $content, $search, $comment_id;

    //Media Dependency Singleton
    protected MediaRepo $mediaRepo;

    // For Showing and Hiding Components
    public $showPosts,$showComments, $showNotifications;
    // Set  EditForm to show on default
    public $showEditForm = true;
    public $error;

    public function __construct()
    {
        $this->mediaRepo = new MediaRepo();
    }

    public function mount()
    {
        $this->first_name = auth()->user()->first_name;
        $this->last_name = auth()->user()->last_name;
        $this->email = auth()->user()->email;
        $this->role_id = auth()->user()->role_id;
        $this->role_name = auth()->user()->role->name;
        $this->newAvatar = auth()->user()->avatar->url;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    private function resetInputFields(){
        $this->first_name = auth()->user()->first_name;
        $this->last_name = auth()->user()->last_name;
        $this->email = auth()->user()->email;
        $this->role_id = auth()->user()->role_id;
        $this->role_name = auth()->user()->role->name;
        $this->newAvatar = auth()->user()->avatar->url;
        $this->avatar = '';
        $this->content = '';
    }

    public function render()
    {
        $user = User::find(Auth::id());
        return view('livewire.components.users.profile',[
            'user' => $user,
            'notifications' => $user->unreadNotifications()->paginate(5),
            'posts' => Post::where('user_id',$user->id)->orderBy('id','DESC')->paginate(5),
            'comments' => Comment::where('user_id',$user->id)->orderBy('id','DESC')->paginate(5),
            'categories' => Category::all(),
            'tags' => Tag::all()
        ]);
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
    private function resetShow(){
        $this->showPosts = false;
        $this->showComments = false;
        $this->showNotifications = false;
        $this->showEditForm = false;
    }

    public function markNotificationAsRead($id)
    {
        $user = User::find(Auth::id());
        foreach ($user->unreadNotifications as $notification) {
            if ($notification->id == $id) {
                $notification->markAsRead();
            }
        }
        session()->flash('message', 'Marked Notification as read Successfully.');
        $this->dispatchBrowserEvent('toast-message', ['message' => 'Marked Notification as read Successfully.']);
    }

    public function showPostsComponent()
    {
        $this->resetShow();
        $this->showPosts = true;
    }

    public function showCommentsComponent()
    {
        $this->resetShow();
        $this->showComments = true;
    }

    public function showNotificationsComponent()
    {
        $this->resetShow();
        $this->showNotifications = true;
    }

    public function showEditFormComponent()
    {
        $this->resetShow();
        $this->showEditForm = true;
    }

    public function deleteNotification($notification)
    {
        $notification->delete();
    }

    // Comments Region
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function editComment($id)
    {
        $comment = Comment::findOrFail($id);
        if ($comment) {
            $this->comment_id =  $comment->id;
            $this->content = $comment->content;
        }else{
            redirect()->to('/profile');
        }
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function updateComment()
    {
        //set form validation rules
        $this->validate([
            'content' => 'required|min:3'
        ]);

        $comment = Comment::find($this->comment_id);
        $comment->update([
            'content' => $this->content
        ]);

        $this->resetInputFields();
        $this->dispatchBrowserEvent('close-modal');
        $this->dispatchBrowserEvent('toast-success', ['message' => 'Comment Updated Successfully.']);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function deleteComment()
    {
        Comment::find($this->comment_id)->delete();
        $this->dispatchBrowserEvent('toast-success', ['message' => 'Comment Deleted Successfully.']);
    }

    //POST SECTION

    public function storePost()
    {
        $this->validate([
            'title' => 'required',
            'body' => 'required',
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:1024',
            'category_id' => 'required',
        ]);

        //Save Post
        $post = new Post();
        $post->title = $this->title;
        $post->slug = Str::slug($this->title);
        $post->body = $this->body;
        $post->category_id = $this->category_id;
        $post->user_id = auth()->user()->id;
        $post->save();

        //Save Media
        $this->mediaRepo->storePost($post, $this->image, 'image','post image', 'blog_app');

        if ($this->tag_ids) {
            $post->tags()->attach($this->tag_ids);
        }

        if($post){
            //flash success message
            $this->dispatchBrowserEvent('toast-success', ['message' => 'You Successfully Created a Post']);
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
    public function editPost($id)
    {
        $post = Post::findOrFail($id);
        if ($post) {
            $this->post_id =  $post->id;
            $this->title = $post->title;
            $this->body = $post->body;
            $this->category_id = $post->category_id;
            $this->tag_ids = $post->tags->pluck('id')->toArray();
            $this->new_tag_ids = $this->tag_ids;
            $this->newImage = $post->media->url ?? "";
        }else{
            redirect()->to('/admin/posts');
        }
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function updatePost()
    {
        //set form validation rules
        $this->validate([
            'title' => 'required|min:3',
            'body' => 'required|min:3',
            'image' => 'image|mimes:jpg,png,jpeg,gif,svg|max:1024',
            'category_id' => 'required'
        ]);


        $post = Post::find($this->post_id);
        $post->title = $this->title;
        $post->slug = Str::slug($this->title);
        $post->body = $this->body;
        $post->category_id = $this->category_id;

        $post->save();
        //Save Media
        if($this->image){
            $this->mediaRepo->storePost($post, $this->image, 'image','post image', 'blog_app');
        }


        if ($this->new_tag_ids) {
            $post->tags()->sync($this->new_tag_ids);
        }

        $this->resetInputFields();
        $this->dispatchBrowserEvent('close-modal');
        $this->dispatchBrowserEvent('toast-success', ['message' => 'You Successfully Updated a Post']);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function deletePost()
    {
        Post::find($this->post_id)->delete();
        $this->dispatchBrowserEvent('toast-success', ['message' => 'You Successfully Deleted a Post']);
    }

    //User Form
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function updateUser()
    {
        //set form validation rules
        $this->validate([
            'first_name' => 'required|min:3',
            'last_name' => 'required|min:3',
            'avatar' => 'image|mimes:jpg,png,jpeg,gif,svg|max:1024',
        ]);

        $user = User::find(auth()->user()->id);
        $user->first_name = $this->first_name;
        $user->last_name = $this->last_name;

        $user->save();
        //Save Media
        if($this->avatar){
            $this->mediaRepo->storeAvatar($user, $this->avatar, 'image','user avatar', 'blog_app');
            $this->dispatchBrowserEvent('toast-success', ['message' => "Avatar Uploaded Successfully."]);
        }

        //flash success message
        return redirect(route('profile'));
        $this->dispatchBrowserEvent('toast-success', ['message' => "Profile Updated Successfully."]);
    }
}
