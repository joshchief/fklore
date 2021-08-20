<?php
class Rooms extends Eloquent
{
    protected $table = 'crafting_rooms';
    protected $fillable = ['name'];

    public function appliances()
    {
        return $this->hasMany('Appliances','room','id');
    }

    public function recipes()
    {
        return $this->hasMany('Recipes','room','id');
    }
}