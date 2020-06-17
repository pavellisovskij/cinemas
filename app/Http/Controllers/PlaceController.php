<?php

namespace App\Http\Controllers;

use App\Option_place;
use App\Place;
use Illuminate\Http\Request;
use App\Sidemenu;

class PlaceController extends Controller
{
    public $places;

    public function __construct()
    {
//        $this->places = Place::all();
        \Illuminate\Support\Facades\View::share('items', Sidemenu::where(['role' => 'admin'])->get());
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $places = Place::all();
        return view('place.index', ['places' => $places]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('place.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        $place = new Place();
//        $place->name    = $request->namePlace;
//        $place->amount  = $request->amount;
//        $place->save();
//        return response(['place' => json_encode($place)], 200);
        $place = new Place();
        $place->name    = $request->namePlace;
        $place->amount  = $request->amount;

        if ($place->save()) {
            $optionsId = $request->options;//json_decode($request->options);
            for ($i = 0; $i < count($optionsId); $i++) {
                $relation = new Option_place();
                $relation->option_id = $optionsId[$i];
                $relation->place_id  = $place->id;
                if (!$relation->save()) {
                    $message = 'error';
                    return response(['message' => $message], 400);
                }
            }
        }
        //dd($place);
        $message = 'ok';
        return response(['message' => $message], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Place::destroy($id);
        $place_option_relation = Option_place::where('place_id', $id)->delete();
        return redirect()->route('place.index');
    }
}
