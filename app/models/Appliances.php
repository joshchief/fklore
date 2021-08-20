<?php
class Appliances extends Eloquent
{
    protected $table = 'crafting_appliances';
    protected $fillable = ['name','room'];

    public function recipes()
    {
        return $this->hasMany('Recipes','appliance','id');
    }

    public function room()
    {
        return $this->hasOne('Rooms','id','room');
    }
}