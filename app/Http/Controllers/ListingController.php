<?php

namespace App\Http\Controllers;

use App\Models\listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{
    // show all listing
    public function index(){
        return view('listings.index',[
            'listings'=>listing::latest()->filter(request(['tag','search']))->paginate(4)
        ]);
    }
    // show public listing

    public function show(listing $listing){
        return view('listings.show',[ 
            'listing'=>$listing
        ]);
             
    }
    public function create(){
        return view('listings.create');
    }
    // store listing data
    public function store(Request $request){
        $formFields = $request->validate([
            'title'=> 'required',
            'company'=>['required',Rule::unique('listings','company')],
            'location'=>['required'],
            'website'=>['required'],
            'email'=>['required','email'],
            'tags'=>['required'],
            'description'=>['required']
        ]);
        if($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }
        $formFields['user_id'] = auth()->id();
        
        Listing::create($formFields);
        return redirect('/')->with('message',"Listing  created successfully!");
    }

    public function edit(listing $listing){
        // dd($listing->title);
        return view('listings.edit',['listing'=>$listing]);
    }
    // store listing data
    public function update(Request $request , Listing $listing){
        // Make sure listing controller is owner
        if($listing->user_id != auth()->id()){
            abort(403,'Unauthorized Action');
        }
        $formFields = $request->validate([
            'title'=> 'required',
            'company'=>['required',Rule::unique('listings','company')],
            'location'=>['required'],
            'website'=>['required'],
            'email'=>['required','email'],
            'tags'=>['required'],
            'description'=>['required']
        ]);
        if($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }
        
        $listing->update($formFields);
        return back()->with('message',"Listing  Updated Successfully!");
    }
    public function destroy(listing $listing){
        // Make sure listing controller is owner
        if($listing->user_id != auth()->id()){
            abort(403,'Unauthorized Action');
        }
       $listing->delete();
       return redirect('/')->with('message','Listing Deleted Successfully');
    }
    // Manage Listing
    public function manage(){
        // dd(auth());
        return view('listings.manage',['listings'=>auth()->user()->listings()->get()]);
    }
}

