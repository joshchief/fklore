<?php
class Messages extends Eloquent
{
    protected $table = 'messages';
    protected $fillable = array('to','from','subject','message');
    
    public function attachments()
    {
        return $this->hasMany('MessageAttachments','message_id');
    }

    public function author()
    {
        return $this->hasOne('User','id','from');
    }
    
    public static function notify($to, $subject, $message, $notif = 0)
	{
		$notification = new Messages;
		$notification->to = $to;
		$notification->from = 0;
		$notification->subject = $subject;
		$notification->message = $message;
		$notification->notif = $notif;
		$notification->save();
	}
}