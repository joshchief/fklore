<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class RestockShop extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'shops:restock';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Restock NPC Shops.';

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
		sleep(mt_rand(1, 600));

		$shops = Shops::all();

		// Cycle through each shop
		foreach($shops AS $shop)
		{
			// 1 in 20 chace of restock
			$restock = mt_rand(1, 3);

			// Restock shop
			if($restock == 1)
			{
				// Get shop item list
				$itemList = $shop->items;

				// Cycle through each item
				foreach($itemList AS $item)
				{
					// Set restock chace from database
					$stockIt = mt_rand(1, $item->frequency);

					// Stock item in shop
					if($stockIt == 1)
					{
						// See if item is already in stock
						$stocked = $shop->stock()->where('item_id', '=', $item->item_id)->count();

						if($stocked)
						{
							$stocked = $shop->stock()->where('item_id', '=', $item->item_id)->first();

							if($stocked->qty < 20)
							{
								// Get new qty
								$randQty = mt_rand(1, $item->max_qty);
								$newQty = (($stocked->qty + $randQty) > 20) ? 20 : ($stocked->qty + $randQty);

								// Update Stock
								$stocked->qty = $newQty;
								$stocked->save();
							}
						}
						elseif(!$stocked)
						{
							// Stock item
							$stockItem = new ShopStock;
							$stockItem->shop_id = $shop->id;
							$stockItem->item_id = $item->item_id;
							$stockItem->qty = mt_rand(1, $item->max_qty);
							$stockItem->save();
						}
					}
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
