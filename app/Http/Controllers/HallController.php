<?php

namespace App\Http\Controllers;

use App\Cinema;
use App\Film;
use App\Hall;
use App\Option;
use App\Place;
use App\Session;
use Illuminate\Http\Request;
use App\Sidemenu;
use Illuminate\Support\Facades\Route;

class HallController extends Controller
{
    public $cinema;

    public function __construct()
    {
        $this->cinema = Cinema::where('id', Route::current()->parameter('cinema'))->first();

        \Illuminate\Support\Facades\View::share('items', Sidemenu::where(['role' => 'admin'])->get());
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $places = Place::all();
        return view('hall.create', [
            'cinema_name'   => $this->cinema->name,
            'cinema_id'     => $this->cinema->id,
            'places'        => json_encode($places)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $hall_seats = json_decode($request->hall);
        $seats = 0;
        foreach ($hall_seats as $row) {
            foreach ($row as $place) {
                $place != false ? $seats++ : $seats + 0;
            }
        }

        $hall = new Hall();
        $hall->name      = $request->name;
        $hall->map       = $request->hall;
        $hall->seats     = $seats;
        $hall->cinema_id = $this->cinema->id;

        if ($hall->save()) {
            return response([
                'type'    => 'success',
                'message' => 'Добавлен ' . $hall->name . ' в список залов кинотеатра ' . $this->cinema->name,
                'id'      => $hall->id
            ], 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($cinema_id, $hall_id)
    {
        $hall = Hall::find($hall_id);

        $films = $hall->films()->with('sessions')->get();

        return view('hall.show', [
            'hall'   => $hall,
            'cinema' => $this->cinema,
            'films'  => $films
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($cinema_id, $hall_id)
    {
        $hall = Hall::find($hall_id);

        return view('hall.edit', [
            'hall'   => $hall,
            'cinema' => $this->cinema
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $cinema_id, $hall_id)
    {
        $hall = Hall::find($hall_id);

        $hall->status = $request->status;

        if($hall->save()) {
            return redirect()->route('hall.show',[
                'cinema' => $cinema_id,
                'hall'   => $hall_id
            ])->with('success', 'Статус зала изменен.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($cinema_id, $hall_id)
    {
        $hall = Hall::find($hall_id);

        if($hall->delete()) {
            return redirect()->route('cinema.show',[
                'cinema' => $cinema_id,
            ])->with('success-hall-deleting', 'Зала упешно удален.');
        }
    }
}
