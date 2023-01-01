<?php

namespace App\Http\Controllers;
 
use Illuminate\Http\Request;

use Validator;
use Response;
use Redirect;
use App\Models\{category, subcategory};

class DropdownController extends Controller
{
    public function index()
    {
        $data['countries'] = Country::get(["name", "id"]);
        return view('welcome', $data);
    }

    public function fetchState(Request $request)
    {
        $data['subcategories'] = subcategory::where("catid",$request->country_id)->get(["title", "id"]);
        return response()->json($data);
    }

    public function fetchCity(Request $request)
    {
        $data['cities'] = City::where("state_id",$request->state_id)->get(["name", "id"]);
        return response()->json($data);
    }
}