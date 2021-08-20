<?php
class UserHomeController extends BaseController
{
    public function __construct()
    {
        $this->beforeFilter('admin');
        $this->beforeFilter('csrf', array('on' => 'post'));
    }

    public function index()
    {
        return View::make($this->layout.'.homes.users.index');
    }
}