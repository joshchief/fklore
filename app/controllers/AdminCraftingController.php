<?php
class AdminCraftingController extends BaseController
{
    public function __construct()
    {
        $this->beforeFilter('admin');
        $this->beforeFilter('csrf', array('on' => 'post'));
        ini_set('display_errors', '1');
        set_error_handler(null);
    }

    public function index()
    {
        $rooms = Rooms::get();
        return View::make($this->layout.'.crafting.admin.pages.index', compact('rooms'));
    }

    public function room($id = NULL)
    {
        if(is_null($id))
        {
            Session::put('msg', array('t'=>'danger','m'=>'You need to provide a room ID.'));
            return Redirect::route('admin.crafting');
        }
        $room = Rooms::where('id', $id)->get();
        if(count($room) == 0)
        {
            Session::put('msg', array('t'=>'danger','m'=>'You\'ve passed an invalid room ID.'));
            return Redirect::route('admin.crafting');
        }
        $appliances = Appliances::where('room', $id)->orderBy('id','ASC')->get();
        return View::make($this->layout.'.crafting.admin.pages.view_room', ['room'=> $room[0],'appliances'=>$appliances]);
    }

    public function viewObject($object = NULL)
    {

    }

    public function appliance($id = NULL)
    {
        if(is_null($id))
        {
            Session::put('msg', array('t'=>'danger','m'=>'You need to pass an appliance ID.'));
            return Redirect::route('admin.crafting');
        }
        $appliance = Appliances::where('id', $id)->orderBy('id','ASC')->get();
        if(count($appliance) == 0)
        {
            Session::put('msg', array('t'=>'danger','m'=>'You\'ve passed an invalid appliance ID.'));
            return Redirect::route('admin.crafting');
        }
        $recipes = $appliance[0]->recipes()->orderBy('id','ASC')->get();
        return View::make($this->layout.'.crafting.admin.pages.view_appliance', ['appliance' => $appliance[0], 'recipes' => $recipes]);
    }

    public function addObject($object = null)
    {
        switch($object)
        {
            default:
                if($object != 'room')
                {
                    Session::put('msg', array('t'=>'danger','m'=>'You need to specify what you would like to add.'));
                    return Redirect::route('admin.crafting');
                }
                break;
            case 'appliance':
                $send_data['rooms'] = Rooms::orderBy('id', 'ASC')->get();
                break;
            case 'recipe':
                $send_data['rooms'] = Rooms::orderBy('id', 'ASC')->get();
                $send_data['appliances'] = Appliances::orderBy('id','ASC')->get();
                break;
        }
        $data = (isset($send_data)) ? $send_data : [];
        return View::make($this->layout.'.crafting.admin.forms.add_'.$object, compact('data'));
    }

    public function deleteObject($id = NULL)
    {
        if(is_null($id))
        {
            Session::put('msg', array('t'=>'danger','m'=>'You need to pass an ID to check.'));
            return Redirect::route('admin.crafting');
        }
        $data = Input::all();
        if(is_null($data['type']))
        {
            Session::put('msg', array('t'=>'danger','m'=>'You need to pass a type of object to check.'));
            return Redirect::route('admin.crafting');
        }
        switch($data['type'])
        {
            default:
                Session::put('msg', array('t'=>'danger','m'=>'You\'ve passed an invalid type for checking.'));
                return Redirect::route('admin.crafting');
                break;
            case 'appliance':
                $object = Appliances::where('id', $id);
                break;
            case 'recipe':
                $object = Recipes::where('id', $id);
                break;
            case 'room':
                $object = Rooms::where('id', $id);
                break;
        }
        if(count($object->get()) == 0)
        {
            Session::put('msg', array('t'=>'danger','m'=>'You\'ve passed an invalid '.$data['type'].' ID.'));
            return Redirect::route('admin.crafting');
        }
        $is_deleted = $object->delete();
        if($is_deleted)
        {
            Session::put('msg', array('t'=>'success','m'=>'The '.$data['type'] .' with ID '.$id.' has been removed.'));
            return Redirect::route('admin.crafting');
        }else{
            Session::put('msg', array('t'=>'danger','m'=>'An error occurred while trying to delete the '.$data['type'].'. Please report this.'));
            return Redirect::route('admin.crafting');
        }
    }

    public function itemList()
    {
        $request = Input::all();
        if(isset($request['term']))
        {
            $item = Items::select('id','name','image')->where('name', 'LIKE', '%'.$request['term'].'%')->get()->toJSON();
            //return $item;
            return '{"results": '.$item.'}';
        }else{
            return '{"results": '.Items::select('id','name','image')->get()->toJSON().'}';
        }
    }
}