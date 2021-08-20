<?php
class PrivateMessagesController extends BaseController
{
    public function __construct()
    {
        $this->beforeFilter('csrf', array('on' => 'post'));
    }

    public function index()
    {
        $messages = Messages::where('to', '=', Auth::user()->id)->get();
        return View::make($this->layout.'.messages.index', compact('messages'));
    }

    public function view($id)
    {
        if(!$id)
        {
            Session::put('msg',array('t'=>'danger','m'=>'You need to specify the ID of a message to view.'));
            return Redirect::route('messages');
        }
        $Message = Messages::where('id', $id)->get();
        if(count($Message) == 0)
        {
            Session::put('msg', array('t'=>'danger','m'=>'A message with that ID does not exist.'));
            return Redirect::route('messages');
        }
        if($Message[0]->to !== Auth::user()->id)
        {
            Session::put('msg', array('t'=>'danger','m'=>'You can not view messages that have not been sent to you.'));
            return Redirect::route('messages');
        }
        return View::make($this->layout.'.messages.view', ['message' => $Message[0]]);
    }

    public function compose($id = null)
    {
        $append_data = array();
        if($id != null)
        {
            $append_data['to'] = $id;
        }
        return View::make($this->layout.'.messages.compose', compact('append_data'));
    }

    public function loadInvViewer()
    {
        return View::make($this->layout.'.messages.includes.inv-view');
    }

    public function loadPreview()
    {
        $data = Input::all();
        $author = User::find($data['to']);
        $message = array(
            'to' => $data['to'],
            'to_author' => $author,
            'subject' => $data['subject'],
            'message'  => Purifier::clean($data['message']),
            'attachments' => $data['attachments'],
            'created_at' => Carbon\Carbon::now()
        );
        return View::make($this->layout.'.messages.includes.preview', ['message' => $message]);
    }

    public function sendMessage()
    {
        $data = Input::all();
        if($data['to'] == Auth::user()->id)
        {
            Session::put('msg', array('t'=>'danger','m'=>'Oof! You can\'t send messages to yourself!'));
            return json_encode(['t'=>'error']);
        }
        $findTo = User::find($data['to']);
        if(!$findTo)
        {
            Session::put('msg', array('t'=>'danger','m'=>'It doesn\'t seem as though a user with that ID exists!'));
            return json_encode(['t'=>'error']);
        }
        $data['subject'] = (isset($data['subject'])) ? $data['subject'] : 'Untitled';
        $data['message'] = Purifier::clean($data['message']);
        if($data['message'] == '')
        {
            Session::put('msg', array('t'=>'danger','m'=>'You need to enter a message!'));
            return json_encode(['t'=>'error']);
        }
        $errors = [];
        $message = Messages::create(['to' => $data['to'], 'from' => Auth::user()->id, 'subject' => $data['subject'], 'message' => $data['message']]);

        if(isset($data['attachments']))
        {
            foreach($data['attachments'] as $attachment)
            {
                switch($attachment['type'])
                {
                    case 'currency_silver':
                        if(Auth::user()->silver < $attachment['quantity'])
                        {
                            $errors[] = 'The attached amount of silver shils exceeds the amount you actually have. They will not be added.';
                            $attachment['errored'] = true;
                        }else{
                            Auth::user()->takeCurrency('silver', $attachment['quantity']);
                        }
                        break;
                    case 'currency_gold':
                        if(Auth::user()->gold < $attachment['quantity'])
                        {
                            $errors[] = 'The attached amount of gold shils exceeds the amount you actually have. They will not be added.';
                            $attachment['errored'] = true;
                        }else{
                            Auth::user()->takeCurrency('gold', $attachment['quantity']);
                        }
                        break;
                    case 'item':
                        if(!Auth::user()->hasItem($attachment['object_id'], 1))
                        {
                            $item = Items::find($attachment['object_id']);
                            $errors[] = 'It does not appear you have the item \''.$item->name.'\'. It will not be added.';
                            $attachment['errored'] = true;
                        }else{
                            Auth::user()->takeItem($attachment['object_id'], 1);
                        }
                        break;
                }
                if(!isset($attachment['errored']))
                {
                    $obj_id = (isset($attachment['object_id'])) ? $attachment['object_id'] : 0;
                    $quantity = (isset($attachment['quantity'])) ? $attachment['quantity'] : 1;
                    MessageAttachments::create(['message_id'=>$message->id,'type'=>$attachment['type'],'object_id' => $obj_id, 'quantity' => $quantity]);
                }
            }
        }
        if($message)
        {
            if(count($errors) > 0)
            {
                Session::put('msg', array('t'=>'warning','m'=>'Your message has been sent, but with errors.','e'=>$errors));
            }else{
                Session::put('msg', array('t'=>'success','m'=>'Your message has been sent.'));
            }
            return json_encode(['t'=>'success']);
        }else{
            Session::put('msg', array('t'=>'danger','m'=>'An error occurred and we could not send your message. Please contact our staff.'));
            return json_encode(['t'=>'error']);
        }
    }

    public function sendReply()
    {
        $data = Input::all();
        $data['message'] = Purifier::clean($data['message']);
        if(!isset($data['msg_id']) || $data['msg_id'] == 0)
        {
            Session::put('msg', array('t'=>'danger','m'=>'No message ID was specified to reply to.'));
            return Redirect::route('messages');
        }
        $findMessage = Messages::find($data['msg_id']);
        if(!$findMessage)
        {
            Session::put('msg', array('t'=>'danger','m'=>'An invalid message ID was given to reply to.'));
            return Redirect::route('messages');
        }
        if($data['message'] == '')
        {
            Session::put('msg', array('t'=>'danger','m'=>'You need to enter a message.'));
            return Redirect::route('messages.view', ['id'=>$data['msg_id']]);
        }
        $subject = (stristr($findMessage->subject, 'Re:')) ? $findMessage->subject : 'Re: '.$findMessage->subject;
        $message = Messages::create(['to'=>$findMessage->from,'from'=>Auth::user()->id,'subject'=>$subject,'message' => $data['message']]);
        if($message)
        {
            Session::put('msg', array('t'=>'success','m'=>'Your reply has been sent.'));
            return Redirect::route('messages');
        }else{
            Session::put('msg', array('t'=>'danger','m'=>'Something went wrong trying to send your reply. Please file a bug report.'));
            return Redirect::route('messages.view', ['id'=>$data['msg_id']]);
        }
    }

    public function detachItem($id = null)
    {

        if($id == null || $id == 0)
        {
            Session::put('msg', array('t'=>'danger','m'=>'Need to specify an ID of an attachment.'));
            return Redirect::route('messages');
        }
        $findAttachment = MessageAttachments::find($id);
        if(!$findAttachment)
        {
            Session::put('msg', array('t'=>'danger','m'=>'Could not find an attachment with that ID!'));
            return Redirect::route('messages');
        }
        if($findAttachment->message->to != Auth::user()->id)
        {
            Session::put('msg', array('t'=>'danger','m'=>'That attachment does not belong to you!'));
            return Redirect::route('messages.view', ['id'=>$findAttachment->message->id]);
        }
        if($findAttachment->detached == 1)
        {
            Session::put('msg', array('t'=>'danger','m'=>'That item has already been detached'));
            return Redirect::route('messages.view', ['id'=>$findAttachment->message->id]);
        }
        $findAttachment->detached = 1;
        $findAttachment->save();
        switch($findAttachment->type)
        {
            case 'currency_gold':
                Auth::user()->giveCurrency('gold', $findAttachment['quantity']);
                break;
            case 'currency_silver':
                Auth::user()->giveCurrency('silver', $findAttachment['quantity']);
                break;
            case 'item':
                Auth::user()->giveItem($findAttachment['object_id'], 1);
                break;
        }
        $findAttachment->detached = 1;
        $findAttachment->save();
        Session::put('msg', array('t'=>'success','m'=>'Item detached!'));
        return Redirect::route('messages.view', ['id'=>$findAttachment->message->id]);
    }

    public function deleteMsgs()
    {
        $data = Input::all();
        $errors = array();
        if(is_array($data['delete']))
        {
            foreach($data['delete'] as $msg)
            {
                $check = Messages::where('id', $msg);
                if(count($check->get()) == 0)
                {
                    $errors[] = 'Message '.$msg.' not found.';
                    $msg = 0;
                }
                if($check->get()[0]->to != Auth::user()->id)
                {
                    $errors[] = 'Message '.$msg.' does not belong to you.';
                    $msg = 0;
                }
                if($msg != 0)
                {
                    $check->delete();
                }
            }
            if(count($errors) == 0)
            {
                Session::put('msg', array('t'=>'success','m'=>'The selected messages were deleted.'));
            }else{
                Session::put('msg', array('t'=>'warning','m'=>'The selected messages were deleted with errors.','e'=>$errors));
            }
            return Redirect::route('messages');
        }else{
            $check = Messages::where('id', $data['delete']);
            if(count($check->get()) == 0)
            {
                Session::put('msg', array('t'=>'danger','m'=>'The message with id '.$data['delete'].' could not be found.'));
                return Redirect::route('messages');
            }
            if($check->get()[0]->to != Auth::user()->id)
            {
                Session::put('msg', array('t'=>'danger','m'=>'The message with id '.$data['delete'].' does not belong to you.'));
                return Redirect::route('messages');
            }
            $check->delete();
            Session::put('msg', array('t'=>'success','m'=>'The message has been deleted.'));
            return Redirect::route('messages');
        }
        Session::put('msg', array('t'=>'danger','m'=>'No message IDs were specified for deletion.'));
        return Redirect::route('messages'); //
    }
}