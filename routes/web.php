<?php

use App\Models\Listing;
use Hamcrest\Type\IsNumeric;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ListingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/*
// Common Resource Routes:
// index - Show all listings
// show - Show single listing
// create - Show form to create new listing
// store - Store new listing
// edit - Show form to edit listing
// update - Update listing
// destroy - Delete listing
*/

// Fetch all listings
Route::get('/', [ListingController::class, 'index' ]);

//Update Listing
Route::put('listings/{listing}' , [ListingController::class, 'update'])->middleware('auth');

//Delete Listing
Route::delete('listings/{listing}' , [ListingController::class, 'destroy'])->middleware('auth');

//Show Create Listing
Route::get('/listings/create', [ListingController::class , 'create'])->middleware('auth');

//Show Edit Listing Form
Route::get('/listings/{listing}/edit', [ListingController::class , 'edit'])->middleware('auth');

//Post Listing, Store listing data through Controller
Route::post('/listings/', [ListingController::class , 'store'])->middleware('auth');

//Manage Listings
Route::get('/listings/manage', [ListingController::class , 'manage'])->middleware('auth');

//Fetch Single Listing , through Controller
Route::get('/listings/{listing}', [ListingController::class , 'show']);


/* USERS */

//Create User
Route::get('/register', [UserController::class , 'create'])->middleware('guest');

// Create New User
Route::post('/users', [UserController::class, 'store']);

// Log User Out
Route::post('/logout',[UserController::class, 'logout'])->middleware('auth');

//Login Use
Route::get('/login', [UserController::class, 'login'])->name('login')->middleware('guest');

//Login Authenticate
Route::post('users/authenticate', [UserController::class, 'authenticate']);







/*
Same a sabove function but standard way of coding
Route::get('/listings/{id}',function($id){

    $listing = Listing::find($id);
    if($listing)
    {
        return view('listing',[
            'listing' => $listing
        ]);
    }
    else
    {
        abort('404');
    }

});*/

/* Try code for Api, can be accessed from URL like : /api/posts */

Route::get('/hello', function (){
return response('<h1>Hello Raman, Welcome to your Project , All the Best!</h1>',200)
                    ->header('Content-Type','text/plain')
                    ->header('foo','bar');
});

Route::get('/post/{id}',function($id)
{

    return response('You Posted '.$id.' in the URL');
})->where('id' , '[0-9]+');


Route::get('/search',function(Request $request){
return($request->name.' lives in '.$request->city);

});
/** End Try Code */
