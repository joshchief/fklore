<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class DeleteAvatars extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'avatars:delete';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Delete queued avatars.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$count = UserCharacters::onlyTrashed()->count();
        
        if($count)
        {
            $avatars = UserCharacters::onlyTrashed()->get();
            
    		// Cycle through each avatar
    		foreach($avatars AS $avatar)
    		{
    			if(strtotime($avatar->deleted_at) <= strtotime("-72 Hours"))
    			{
    			    $avatar->forceDelete();
    			}
    		}
        }
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			array('example', InputArgument::REQUIRED, 'An example argument.'),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
		);
	}

}
