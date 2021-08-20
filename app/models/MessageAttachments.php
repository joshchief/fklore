<?php
class MessageAttachments extends Eloquent
{
    protected $table = 'message_attachments';
    protected $fillable = ['message_id', 'type', 'detached', 'object_id', 'quantity'];

    public function message()
    {
        return $this->hasOne('Messages', 'id','message_id');
    }
    public function item()
    {
        if($this->type == 'item')
        {
            return $this->hasOne('Items','id','object_id');
        }
        return false;
    }
}