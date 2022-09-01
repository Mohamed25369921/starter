<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CrudController extends Controller
{
    public function getOffers(){
       return Offer::get();
    }

    public function create(){
        return view('offers.create');
    }

    public function store(Request $request){
        //validation
        $rules = $this->getRules();
        $messages = $this->getMessages();
        $validator = Validator::make($request->all(),$rules,$messages);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInputs($request->all());
        }
        //insert in DB
        Offer::create([
            'name' => $request->name,
            'price' => $request->price,
            'details' => $request->details
        ]);
        return redirect()->back()->with(['success' => 'تم اضافة العرض بنجاح']);
    }

    public function getMessages(){
       return $messages = [
            'name.required' => __('messages.offer name required'),
            'name.unique' => __('messages.offer name unique'),
            'price.required' => __('messages.offer price required'),
            'price.numeric' => __('messages.offer price numeric'),
            'details.required' => __('messages.offer details required'),
        ];
    }
    public function getRules(){
       return $rules =[
            'name'=>'required|max:100|unique:offers,name',
            'price' => 'required|numeric',
            'details' => 'required'
        ];
    }

    
}