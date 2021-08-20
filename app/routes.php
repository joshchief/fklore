<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    // return what you want
});


Route::pattern('id', '[0-9]+');
Route::pattern('object', '[a-zA-Z]+');

// PAYMENTS -----------------------------------------------------------
Route::get('payments/success', 'PaypalPaymentController@getSuccess');
Route::get('payments/fails', 'PaypalPaymentController@getFails');
Route::resource('payments', 'PaypalPaymentController');

Route::controller('forums', 'ForumsController');

Route::post('/demo-generate', 'IndexController@postDemoGenerate');
Route::post('/demo-clothes', 'IndexController@postDemoClothes');
Route::get('/demo', 'IndexController@getDemo');

Route::post('/wardrobe-generate', 'WardrobeController@postGenerate');
Route::post('/wardrobe-clothes', 'WardrobeController@postClothes');
Route::controller('/wardrobe', 'WardrobeController');

Route::post('/char-change', 'IndexController@postCharChange');

Route::get('/faq', 'IndexController@getCredits');
Route::get('/staff', 'IndexController@getCredits');
Route::get('/credits', 'IndexController@getCredits');
Route::get('/town', 'IndexController@getTown');
Route::get('/tos', 'IndexController@getTos');
Route::post('/create/complete', 'IndexController@postCreateComplete');
Route::post('/create/confirm', 'IndexController@postCreateConfirm');
Route::post('/create/elemental', 'IndexController@postCreateFinal');
Route::post('/create-generate', 'IndexController@postCreateGenerate');
Route::post('/create/customize/{species}', 'IndexController@postCreateNext');
Route::get('/create/customize/{species}', 'IndexController@getCreateNext');
Route::get('/create', 'IndexController@getCreate');

Route::get('/', 'IndexController@getIndex');
Route::get('/news', 'IndexController@getNews');

Route::controller('craviary', 'CraviaryController');

// Maybe(tm) separate for other people browsing?
Route::group(array('prefix'=>'home'), function(){
    // do some neat stuff soon(tm)
});

Route::group(array('prefix'=>'user/home'), function(){
    Route::get('/', ['as'=>'user.home','uses'=>'UserHomeController@index']);
});

Route::group(array('prefix' => 'user/messages'), function(){
    Route::get('/',['as'=>'messages', 'uses'=>'PrivateMessagesController@index']);
    Route::get('/{id}', ['as'=> 'messages.view', 'uses' => 'PrivateMessagesController@view']);
    Route::get('/compose', ['as'=>'messages.compose', 'uses' => 'PrivateMessagesController@compose']);
    Route::get('/compose/{id}', ['as'=>'messages.compose.withid', 'uses' => 'PrivateMessagesController@compose']);
    Route::get('/compose/invviewer', ['as'=>'messages.compose.invviewer', 'uses'=>'PrivateMessagesController@loadInvViewer']);
    Route::get('/detach/{id}', ['as'=>'messages.detach', 'uses'=>'PrivateMessagesController@detachItem']);
    Route::post('/compose', ['as'=>'messages.compose.post', 'uses'=>'PrivateMessagesController@sendMessage']);
    Route::post('/compose/preview', ['as'=>'messages.compose.preview', 'uses'=>'PrivateMessagesController@loadPreview']);
    Route::post('/reply', ['as'=>'messages.reply','uses'=>'PrivateMessagesController@sendReply']);
    Route::post('/delete', ['as' => 'messages.delete','uses'=>'PrivateMessagesController@deleteMsgs']);
});

Route::controller('user', 'UserController');

Route::controller('character', 'CharacterController');

Route::controller('shop/{id}', 'ShopsController');
Route::get('shop/{id}/buy/{item}', 'ShopsController@getBuy');
Route::get('shop/premium', 'ShopsController@getPremium');

// Admin Dashboard
Route::controller('admin/', 'AdminController');

Route::group(array('prefix'=>'admin/crafting'), function(){
    Route::get('/', ['as'=>'admin.crafting','uses'=>'AdminCraftingController@index']);
    Route::get('/room/{id}', ['as'=>'admin.crafting.room', 'uses'=>'AdminCraftingController@room']);
    Route::get('/appliance/{id}', ['as'=>'admin.crafting.appliance', 'uses'=>'AdminCraftingController@appliance']);
    Route::get('/add/{object}', ['as'=>'admin.crafting.addobject','uses'=>'AdminCraftingController@addObject']);
    Route::post('/delete/{id}', ['as'=>'admin.crafting.delete', 'uses'=>'AdminCraftingController@deleteObject']);
    Route::post('/add/{object}', ['as'=>'admin.crafting.postadd','uses'=>'AdminCraftingController@postAddObject']);
    Route::get('/itemList', ['as'=>'admin.crafting.getitemlist', 'uses'=>'AdminCraftingController@itemList']);
});

Route::group(
    array('prefix' => 'admin/user'), 
    function() 
    {
		// Admin user controller
		Route::controller('/', 'AdminUserController');

		// Admin user controller (delete user)
		Route::get('delete/{id}', 'AdminUserController@getDelete');

		// Admin user controller (enable user)
		Route::get('enable/{id}', 'AdminUserController@getEnable');

		// Admin user controller (disable user)
		Route::get('disable/{id}', 'AdminUserController@getDisable');

		// Admin user controller (edit user)
		Route::get('edit/{id}', 'AdminUserController@getEdit');

		// Admin user controller (delete role)
		Route::get('roles-delete/{id}', 'AdminUserController@getRolesDelete');

		// Admin user controller (edit role)
		Route::get('roles-edit/{id}', 'AdminUserController@getRolesEdit');
    }
);

Route::group(
    array('prefix' => 'admin/items'), 
    function() 
    {
		// Admin item controller
		Route::controller('/', 'AdminItemController');
		
		// Admin item delete
		Route::get('delete/{id}', 'AdminItemController@getDelete');

		// Admin item edit
		Route::get('edit/{id}', 'AdminItemController@getEdit');
        
        // Admin item category delete
		Route::get('category-delete/{id}', 'AdminItemController@getCategoryDelete');

		// Admin item category edit
		Route::get('category-edit/{id}', 'AdminItemController@getCategoryEdit');
    }
);

Route::group(
    array('prefix' => 'admin/forums'), 
    function() 
    {
		// Admin forum category controller
		Route::controller('/', 'AdminForumsController');
		
		// Admin forum category delete
		Route::get('delete/{id}', 'AdminForumsController@getDelete');

		// Admin forum category edit
		Route::get('edit/{id}', 'AdminForumsController@getEdit');
    }
);

Route::group(
    array('prefix' => 'admin/promo-codes'), 
    function() 
    {
		// Admin promo codes controller
		Route::controller('/', 'AdminPromoController');

		// Admin promo codes controller (delete)
		Route::get('delete/{id}', 'AdminPromoController@getDelete');

		// Admin promo codes controller (edit)
		Route::get('edit/{id}', 'AdminPromoController@getEdit');
    }
);

Route::group(
    array('prefix' => 'admin/beta-codes'), 
    function() 
    {
		// Admin beta codes controller
		Route::controller('/', 'AdminCodesController');

		// Admin beta codes controller (delete)
		Route::get('delete/{id}', 'AdminCodesController@getDelete');

		// Admin beta codes controller (edit)
		Route::get('edit/{id}', 'AdminCodesController@getEdit');
    }
);

Route::group(
    array('prefix' => 'admin/craviary'), 
    function() 
    {
		// Admin craviary controller
		Route::controller('/', 'AdminCraviaryController');

		// Admin craviary controller (delete)
		Route::get('delete/{id}', 'AdminCraviaryController@getDelete');

		// Admin craviary controller (edit)
		Route::get('edit/{id}', 'AdminCraviaryController@getEdit');
    }
);

Route::group(
    array('prefix' => 'admin/bloodlines'), 
    function() 
    {
		// Admin bloodlines controller
		Route::controller('/', 'AdminBloodlinesController');

		// Admin bloodlines controller (delete)
		Route::get('delete/{id}', 'AdminBloodlinesController@getDelete');

		// Admin bloodlines controller (edit)
		Route::get('edit/{id}', 'AdminBloodlinesController@getEdit');
    }
);

Route::group(
    array('prefix' => 'admin/colors'), 
    function() 
    {
		// Admin Colors controller
		Route::controller('/', 'AdminColorsController');

		// Admin Colors controller (delete Colors)
		Route::get('delete/{id}', 'AdminColorsController@getDelete');

		// Admin Colors controller (edit Colors)
		Route::get('edit/{id}', 'AdminColorsController@getEdit');
    }
);

Route::group(
    array('prefix' => 'admin/species'), 
    function() 
    {
		// Admin species controller
		Route::controller('/', 'AdminSpeciesController');

		// Admin species controller (delete species)
		Route::get('delete/{id}', 'AdminSpeciesController@getDelete');

		// Admin species controller (edit species)
		Route::get('edit/{id}', 'AdminSpeciesController@getEdit');
    }
);

Route::group(
    array('prefix' => 'admin/shops'), 
    function() 
    {
        // Admin shop greetings
		Route::get('greetings/{id}', 'AdminShopsController@getGreetingIndex');
		
		// Admin shop greetings add
		Route::get('greetings-add/{id}', 'AdminShopsController@getGreetingNew');
		Route::post('greetings-add/{id}', 'AdminShopsController@postGreetingNew');
        
        // Admin shop greetings delete
		Route::get('greetings-delete/{id}', 'AdminShopsController@getGreetingDelete');

		// Admin shop greetings edit
		Route::get('greetings-edit/{id}', 'AdminShopsController@getGreetingEdit');
		Route::post('greetings-edit/{id}', 'AdminShopsController@postGreetingEdit');
		
		// Admin shop items
		Route::get('items/{id}', 'AdminShopsController@getItemsIndex');
		
		// Admin shop items add
		Route::get('items-add/{id}', 'AdminShopsController@getItemsNew');
        Route::post('items-add/{id}', 'AdminShopsController@postItemsNew');
        
        // Admin shop items delete
		Route::get('items-delete/{id}', 'AdminShopsController@getItemsDelete');

		// Admin shop items edit
		Route::get('items-edit/{id}', 'AdminShopsController@getItemsEdit');
		Route::post('items-edit/{id}', 'AdminShopsController@postItemsEdit');
		
		// Admin shop controller
		Route::controller('/', 'AdminShopsController');
		
		// Admin shop delete
		Route::get('delete/{id}', 'AdminShopsController@getDelete');

		// Admin shop edit
		Route::get('edit/{id}', 'AdminShopsController@getEdit');
    }
);

Route::group(
    array('prefix' => 'admin/npcs'), 
    function() 
    {
        // Admin npc bonds
		Route::get('bond-text/{id}', 'AdminNpcController@getBondIndex');
		
		// Admin npc bond add
		Route::get('bond-add/{id}', 'AdminNpcController@getBondNew');
        Route::post('bond-add/{id}', 'AdminNpcController@postBondNew');
        
        // Admin npc bond delete
		Route::get('bond-delete/{id}', 'AdminNpcController@getBondDelete');

		// Admin npc bond edit
		Route::get('bond-edit/{id}', 'AdminNpcController@getBondEdit');
        Route::post('bond-edit/{id}', 'AdminNpcController@postBondEdit');
        
		// Admin npc controller
		Route::controller('/', 'AdminNpcController');
		
		// Admin npc delete
		Route::get('delete/{id}', 'AdminNpcController@getDelete');

		// Admin npc edit
		Route::get('edit/{id}', 'AdminNpcController@getEdit');
		
    }
);

// Admin Clothing upload
Route::controller('admin/clothing', 'AdminClothingController');