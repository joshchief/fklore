<?php

class ForumsController extends BaseController {
    
    public function __construct()
	{
		$this->beforeFilter('csrf', array('on' => 'post'));
	}
    
	public function getIndex()
	{
		$categories = ForumCategories::orderBy('id', 'asc')->get();

		$data['categories'] = $categories;

		return View::make($this->layout.'.forums.index', $data);
	}
	
	public function getView($id)
	{
	    $forum = ForumCategories::find($id);
	    
	    $data['forum'] = $forum;
	    
	    $data['threads'] = $forum->threads()->paginate(25);

		return View::make($this->layout.'.forums.view', $data);
	}
	
	public function getThread($id)
	{
	    $thread = ForumThreads::find($id);
	    
	    $data['thread'] = $thread;
	    
	    $replies = $thread->replies()->orderBy('id', 'asc')->paginate(15);
	    
	    $data['replies'] = $replies;
	    
	    $categories = ForumCategories::where('id', '!=', $thread->forum_id)->get();
	    
	    $data['categories'] = $categories;

		return View::make($this->layout.'.forums.thread', $data);
	}
	
	public function postThread($id)
	{
	    $thread = ForumThreads::find($id);
	    
	    // Check if closed
	    if($thread->status == 2)
	    {
	        // redirect
	        return Redirect::to('/forums/thread/'.$thread->id);
	    }
	    
	   // Set form rules
		$rules = array(
			'reply' 		=> 'required',
		);

		// Set form error messages
		$messages = array(
			   'reply.required'     	=> 'Please enter text for your reply!',
		);
			
		// Send input through validator
		$validator = Validator::make(Input::all(), $rules, $messages);

		// Array that will hold our error messages
		$msgArray = array();

				// If validation fails give error messages
		if($validator->fails())
		{
			// Get our error messages
			$messages = $validator->messages();
			
			if($messages->has('reply'))
			{
				// Add first issue to our $msgArray
				$msgArray['reply'] = $messages->first('reply');
			}


			// Redirect back
			return Redirect::to('/forums/thread/'.$thread->id)
					->with('postErrors', $msgArray)
					->withInput();
		}
		else
		{
		    $replyText = Purifier::clean(Input::get('reply'));
            
            // Create reply
            $reply = new ForumReplies;
            $reply->forum_id = $thread->forum_id;
            $reply->thread_id = $thread->id;
            $reply->user_id = Auth::user()->id;
            $reply->reply = $replyText;
            $reply->save();
            
			$thread->last_post = $reply->id;
			$thread->save();
			
			$forum = ForumCategories::find($thread->forum_id);
			$forum->last_post = $thread->id;
			$forum->save();

            // redirect
			return Redirect::to('/forums/thread/'.$thread->id);
		}
	}
	
	public function getStickThread($id)
	{
	    $thread = ForumThreads::find($id);
	    
	    // see if user is staff
	    if(!Auth::user()->roles()['admin'])
	    {
	        // redirect
			return Redirect::to('/forums/thread/'.$thread->id);
	    }
	    
	    if($thread->status != 1)
	    {
	        $thread->status = 1;
	    }
	    else
	    {
	        $thread->status = 0;
	    }
	    
	    $thread->save();
	    
	    // redirect
		return Redirect::to('/forums/thread/'.$thread->id);
	}
	
	public function getLockThread($id)
	{
	    $thread = ForumThreads::find($id);
	    
	    // see if user is staff
	    if(!Auth::user()->roles()['admin'])
	    {
	        // redirect
			return Redirect::to('/forums/thread/'.$thread->id);
	    }
	    
	    if($thread->status != 2)
	    {
	        $thread->status = 2;
	    }
	    else
	    {
	        $thread->status = 0;
	    }
	    
	    $thread->save();
	    
	    // redirect
		return Redirect::to('/forums/thread/'.$thread->id);
	}
	
	public function getDeleteThread($id)
	{
	    $thread = ForumThreads::find($id);
	    $thread->delete();
	    
	    // see if user is staff
	    if(!Auth::user()->roles()['admin'])
	    {
	        // redirect
			return Redirect::to('/forums/thread/'.$id);
	    }
	    
	    $forum = ForumCategories::where('last_post', '=', $id)->first();
	    
	    if($forum->threads()->count() > 0)
	    {
	        $lastReply = ForumThreads::where('forum_id', '=', $forum->id)->orderBy('created_at', 'desc')->first();
	        
	        $forum->last_post = $lastReply->id;
	        $forum->save();
	    }
	    else
	    {
	        $forum->last_post = 0;
	        $forum->save();
	    }
	    
	    $replies = ForumReplies::where('thread_id', '=', $id)->delete();
	    
	    // redirect
		return Redirect::to('/forums/view/'.$forum->id);
	}
	
	public function postMoveThread($id)
	{
	    $thread = ForumThreads::find($id);
	    
	    // see if user is staff
	    if(!Auth::user()->roles()['admin'])
	    {
	        // redirect
			return Redirect::to('/forums/thread/'.$thread->id);
	    }
	    
	    $thread->forum_id = Input::get('category');
	    $thread->save();
	    
	    foreach($thread->replies AS $reply)
	    {
	        $reply->forum_id = Input::get('category');
	        $reply->save();
	    }
	    
	    $forum = ForumCategories::where('last_post', '=', $thread->id)->first();
	    
	    if($forum->threads()->count() > 0)
	    {
	        $lastReply = ForumThreads::where('forum_id', '=', $forum->id)->orderBy('created_at', 'desc')->first();
	        
	        $forum->last_post = $lastReply->id;
	        $forum->save();
	    }
	    else
	    {
	        $forum->last_post = 0;
	        $forum->save();
	    }
	    
	    $newForum = ForumCategories::where('id', '=', $thread->forum_id)->first();
	    $newForum->last_post = $thread->id;
	    $newForum->save();
	    
	    // redirect
		return Redirect::to('/forums/thread/'.$thread->id);
	}
	
	public function getEditThread($id)
	{
	    $thread = ForumThreads::find($id);
	    
	    // see if user owns threaf or is staff
	    if($thread->user_id != Auth::user()->id && !Auth::user()->roles()['admin'])
	    {
	        // redirect
			return Redirect::to('/forums/thread/'.$thread->id);
	    }
	    
	    $data['thread'] = $thread;

		return View::make($this->layout.'.forums.edit_thread', $data);
	}
	
	public function postEditThread($id)
	{
	    $thread = ForumThreads::find($id);
	    
	    // see if user owns thread or is staff
	    if($thread->user_id != Auth::user()->id && !Auth::user()->roles()['admin'])
	    {
	        // redirect
			return Redirect::to('/forums/thread/'.$thread->id);
	    }
	    
	    // Set form rules
		$rules = array(
			'title' 		=> 'required',
			'reply' 		=> 'required',
		);

		// Set form error messages
		$messages = array(
			   'title.required'     	=> 'Please enter a title for your thread!',
			   'reply.required'     	=> 'Please enter text for your post!',
		);
			
		// Send input through validator
		$validator = Validator::make(Input::all(), $rules, $messages);

		// Array that will hold our error messages
		$msgArray = array();

				// If validation fails give error messages
		if($validator->fails())
		{
			// Get our error messages
			$messages = $validator->messages();

			// See if there are any errors
			if($messages->has('title'))
			{
				// Add first issue to our $msgArray
				$msgArray['title'] = $messages->first('title');
			}
			
			if($messages->has('reply'))
			{
				// Add first issue to our $msgArray
				$msgArray['reply'] = $messages->first('reply');
			}


			// Redirect back
			return Redirect::to('/forums/edit-thread/'.$thread->id)
					->with('postErrors', $msgArray)
					->withInput();
		}
		else
		{
		    $title = Purifier::clean(Input::get('title'));
		    $reply = Purifier::clean(Input::get('reply'));
            
			$thread->title = $title;
			$thread->reply = $reply;
			$thread->save();
			
            // redirect
			return Redirect::to('/forums/thread/'.$thread->id);
		}
	}
	
	public function getEditReply($id)
	{
	    $reply = ForumReplies::find($id);
	    
	    // see if user owns reply or is staff
	    if($reply->user_id != Auth::user()->id && !Auth::user()->roles()['admin'])
	    {
	        // redirect
			return Redirect::to('/forums/thread/'.$reply->thread_id);
	    }
	    
	    $data['reply'] = $reply;

		return View::make($this->layout.'.forums.edit_reply', $data);
	}
	
	public function postEditReply($id)
	{
	    $reply = ForumReplies::find($id);
	    
	    // see if user owns reply or is staff
	    if($reply->user_id != Auth::user()->id && !Auth::user()->roles()['admin'])
	    {
	        // redirect
			return Redirect::to('/forums/thread/'.$reply->thread_id);
	    }
	    
	    // Set form rules
		$rules = array(
			'reply' 		=> 'required',
		);

		// Set form error messages
		$messages = array(
			   'reply.required'     	=> 'Please enter text for your post!',
		);
			
		// Send input through validator
		$validator = Validator::make(Input::all(), $rules, $messages);

		// Array that will hold our error messages
		$msgArray = array();

				// If validation fails give error messages
		if($validator->fails())
		{
			// Get our error messages
			$messages = $validator->messages();
			
			if($messages->has('reply'))
			{
				// Add first issue to our $msgArray
				$msgArray['reply'] = $messages->first('reply');
			}


			// Redirect back
			return Redirect::to('/forums/edit-reply/'.$reply->id)
					->with('postErrors', $msgArray)
					->withInput();
		}
		else
		{
		    $replyText = Purifier::clean(Input::get('reply'));
            
			$reply->reply = $replyText;
			$reply->save();
			
            // redirect
			return Redirect::to('/forums/thread/'.$reply->thread_id);
		}
	}
	
	public function getNewThread($id)
	{
	    $forum = ForumCategories::find($id);
	    
	    // Check if forum is staff only
	    if($forum->staff)
	    {
	        // See if user is staff
	        $roles = Auth::user()->roles();
	        
	        if(!$roles['admin'])
	        {
	            // redirect
			    return Redirect::to('/forums/view/'.$forum->id);
	        }
	    }
	    
	    $data['forum'] = $forum;

		return View::make($this->layout.'.forums.new_thread', $data);
	}
	
	public function postNewThread($id)
	{
	    $forum = ForumCategories::find($id);
	    
	    // Check if forum is staff only
	    if($forum->staff)
	    {
	        // See if user is staff
	        $roles = Auth::user()->roles();
	        
	        if(!$roles['admin'])
	        {
	            // redirect
			    return Redirect::to('/forums/view/'.$forum->id);
	        }
	    }
	    
	   // Set form rules
		$rules = array(
			'title' 		=> 'required',
			'reply' 		=> 'required',
		);

		// Set form error messages
		$messages = array(
			   'title.required'     	=> 'Please enter a title for your thread!',
			   'reply.required'     	=> 'Please enter text for your post!',
		);
			
		// Send input through validator
		$validator = Validator::make(Input::all(), $rules, $messages);

		// Array that will hold our error messages
		$msgArray = array();

				// If validation fails give error messages
		if($validator->fails())
		{
			// Get our error messages
			$messages = $validator->messages();

			// See if there are any errors
			if($messages->has('title'))
			{
				// Add first issue to our $msgArray
				$msgArray['title'] = $messages->first('title');
			}
			
			if($messages->has('reply'))
			{
				// Add first issue to our $msgArray
				$msgArray['reply'] = $messages->first('reply');
			}


			// Redirect back
			return Redirect::to('/forums/new-thread/'.$forum->id)
					->with('postErrors', $msgArray)
					->withInput();
		}
		else
		{
		    $title = Purifier::clean(Input::get('title'));
		    $reply = Purifier::clean(Input::get('reply'));
            
			$thread = new ForumThreads;
			$thread->forum_id = $forum->id;
			$thread->user_id = Auth::user()->id;
			$thread->title = $title;
			$thread->reply = $reply;
			$thread->save();
			
			$forum->last_post = $thread->id;
			$forum->save();

            // redirect
			return Redirect::to('/forums/thread/'.$thread->id);
		}
	}
}