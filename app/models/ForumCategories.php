<?php

class ForumCategories extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'forum_categories';
	
	public function threads() {
        return $this->hasMany('ForumThreads', 'forum_id')->where('status', '!=', 2)->orderBy('status', 'desc')->orderBy('updated_at', 'desc'); 
    }

    public function replies() {
        return $this->hasMany('ForumReplies', 'forum_id'); 
    }
    
    public function lastPost() {
        return $this->hasOne('ForumThreads', 'id', 'last_post'); 
    }
}
