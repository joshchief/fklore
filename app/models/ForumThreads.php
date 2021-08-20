<?php

class ForumThreads extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'forum_threads';
	
	public function forum() {
        return $this->belongsTo('ForumCategories', 'forum_id'); 
    }
    
    public function replies() {
        return $this->hasMany('ForumReplies', 'thread_id'); 
    }
    
    public function user() {
        return $this->hasOne('User', 'id', 'user_id'); 
    }
    
    public function lastPost() {
        return $this->hasOne('ForumReplies', 'id', 'last_post'); 
    }
}
