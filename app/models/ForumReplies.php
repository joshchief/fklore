<?php

class ForumReplies extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'forum_replies';
	
    public function user() {
        return $this->hasOne('User', 'id', 'user_id'); 
    }
    
    public function forum() {
        return $this->belongsTo('ForumCategories', 'forum_id'); 
    }
    
    public function thread() {
        return $this->belongsTo('ForumThreads', 'thread_id'); 
    }
}
