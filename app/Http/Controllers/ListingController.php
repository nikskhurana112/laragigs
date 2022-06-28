<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;

class ListingController extends Controller
{
    //Get and show all listings
    public function index(Request $request)
    {
        return view('listings.index', [
            'listings' => Listing::latest()->filter(['tag' => $request->tag, 'search' => $request->search])->paginate(2)
        ]);
    }
    //Show single listing
    public function show(Listing $listing)
    {

        //$listing = Listing::find($listing);
        if ($listing) {
            return view('listings.show', [
                'listing' => $listing
            ]);
        } else {
            abort('404');
        }
    }

    //create form
    public function create()
    {
        return view('listings.create');
    }

    //store listing data
    public function store(Request $request)
    {
        $formFields = $request->validate(
            [
                'title' => 'required',
                'company' => 'required | unique:listings,company',
                'location' => 'required',
                'website' => 'required',
                'email' => 'required | email',
                'tags' => 'required',
                'description' => 'required'
            ]
        );
        if ($request->hasFile('logo')) {
            $formFields['logo'] =  $request->file('logo')->store('logos', 'public');
        }

        $formFields['user_id'] = auth()->id();

        Listing::create($formFields);
        return redirect('/')->with('message', 'Listing created successfully');
    }
    //show edit form
    public function edit(Listing $listing)
    {
        if ($listing->user_id != auth()->id()) {
            abort(403, 'Unauthorized action');
        }
        return view('listings.edit', ['listing' => $listing]);
    }
    public function update(Listing $listing, Request $request)
    {

        $formFields = $request->validate(
            [
                'title' => 'required',
                'company' => 'required',
                'location' => 'required',
                'website' => 'required',
                'email' => 'required | email',
                'tags' => 'required',
                'description' => 'required'
            ]
        );
        if ($request->hasFile('logo')) {
            $formFields['logo'] =  $request->file('logo')->store('logos', 'public');
        }

        $listing->update($formFields);
        return redirect()->back()->with('message', 'Listing updated successfully');
    }
    public function destroy(Listing $listing)
    {
        if ($listing->user_id != auth()->id()) {
            abort(403, 'Unauthorized action');
        }
        $listing->delete();
        return redirect()->back()->with('message', 'Listing deleted successfully');
    }
    public function manage()
    {
        return view('listings.manage', ['listings' => auth()->user()->listings()->get()]);
    }
}
