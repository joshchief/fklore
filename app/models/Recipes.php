<?php
class Recipes extends Eloquent
{
    protected $table = 'crafting_recipes';
    protected $fillable = ['name','appliance','room','output_item','input_items'];

    public function result()
    {
        return $this->hasOne('Items','id','output_item');
    }

    public function appliance()
    {
        return $this->hasOne('Appliances','id','appliance');
    }

    public function room()
    {
        return $this->hasOne('Rooms','id','room');
    }

    //public function required_items()
    //{
        //
    //}
}