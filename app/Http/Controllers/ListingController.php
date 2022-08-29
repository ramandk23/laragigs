<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


class ListingController extends Controller
{
    //fetch and show all listings
    public function index()
    {

                     /* dd(request('tag')); dd is dump and die function, here this function will dump the page request variables*/
        return view('listings.index',[
            //'listings' => Listing::all()
           // 'listings' => Listing::latest()->filter(request(['tag', 'search']))->get()
           'listings' => Listing::latest()->filter(request(['tag', 'search']))->paginate(6)

    ]);
    }

    //Fetch and Show Single Listings
    public function show(Listing $listing)
    {
        return view('listings.show',[
            'listing' => $listing
        ]);
    }

    //Show Create Form
    public function create()
    {
        return view('listings.create');
    }


    public function store(Request $request)
    {
        //dd($request->file('logo'));
        $formFields = $request->validate([
            'title' => 'required',
            'company' => 'required',
            'location' => 'required',
            'website' => 'required',
            'email' => ['required','email'],
            'tags' => 'required',
            'description' => 'required'
        ]);

        if($request->hasFile('logo'))
        {
            $formFields['logo']= $request->file('logo')->store('logos','public');
        }

        $formFields['user_id'] = auth()->id();

        Listing::create($formFields);

        return(redirect("/")->with('message','Listing Created Successfully'));
    }

    public function edit(Listing $listing)
    {

        return view('listings.edit', ['listing' => $listing]);
    }

    public function update(Request $request , Listing $listing)
    {
        // Check if User is owner of the llisting he is editing
        if($listing->user_id != auth()->id())
        {
            abort(403, 'Unauthorized Actions');
        }

        $formFields = $request->validate([
            'title' => 'required',
            'company' => 'required',
            'location' => 'required',
            'website' => 'required',
            'email' => ['required','email'],
            'tags' => 'required',
            'description' => 'required'
        ]);

        if($request->hasFile('logo'))
        {
            $formFields['logo']= $request->file('logo')->store('logos','public');
        }
        //dd($formFields);
        $listing->update($formFields);

        return back()->with('message','Listing Updates Successfully');
    }

    public function destroy(Listing $listing)
    {
        // Check if User is owner of the llisting he is editing
        if($listing->user_id != auth()->id())
        {
            abort(403, 'Unauthorized Actions');
        }

        $listing->delete();
        return redirect('/')->with('message','Listing Deleted Successfully');
    }

    public function manage()
    {
        return view('listings.manage' , ['listings' => auth()->user()->listings()->get() ]);

    }
}
