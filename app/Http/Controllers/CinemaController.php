<?php

namespace App\Http\Controllers;

use App\Address;
use App\Session;
use App\Sidemenu;
use App\Cinema;
use Illuminate\Http\Request;

class CinemaController extends Controller
{
    public function __construct()
    {
        \Illuminate\Support\Facades\View::share('items', Sidemenu::where(['role' => 'admin'])->get());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$sessions = Session::where('film_id', $);
        $cinemas = Cinema::with(['address', 'hall'])->get();
        return view('cinema.index', compact('cinemas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cinema.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cinema = Cinema::create($request->all());
        $cinema->address()->create($request->only(['longitude', 'latitude', 'street', 'phone', 'city', 'country']));
//        $cinema  = new Cinema();
//        $cinema->name           = $request->name;
//        $cinema->description    = $request->description;
//        $cinema->save();
//
//        $address = new Address();
//        $address->cinema_id = $cinema->id;
//        $address->longitude = $request->longitude;
//        $address->latitude  = $request->latitude;
//        $address->country   = $request->country;
//        $address->city      = $request->city;
//        $address->street    = $request->street;
//        $address->phone     = $request->phone;
//        $address->save();

        return redirect()->route('cinema.create');
            //->with('error', 'Что-то пошло не так при добавлении нового кинотеатра.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cinema = Cinema::where('id', $id)->with('address')->first();
        return view('cinema.show', compact('cinema'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cinema = Cinema::where('id', $id)->with('address')->first();
        return view('cinema.edit', compact('cinema'));
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
        $cinema = Cinema::where('id', $id)
            ->update([
                'name'          => $request->name,
                'description'   => $request->description
            ]);
        $address = Address::where('cinema_id', $id)
            ->update([
                'longitude' => $request->longitude,
                'latitude'  => $request->latitude,
                'country'   => $request->country,
                'city'      => $request->city,
                'street'    => $request->street,
                'phone'     => $request->phone
            ]);

        if ($cinema == 1 || $address == 1) {
            return redirect()->route('cinema.edit', $id)->with('success', 'Данные о кинотеатре "' . $request->name . '" обновлены.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cinema = Cinema::where('id', $id)->first();

        if ($cinema->address->delete() && $cinema->delete()) {
            return redirect()->route('cinema.index')->with('success', 'Данные о кинотеатре "' . $cinema->name . '" удалены успешно.');
        }
        else {
            return redirect()->route('cinema.index')->with('error', 'При удалении кинотеатра "' . $cinema->name . '" произошла ошибка!');
        }
    }

    public function getCinemas() {
        $cinemas = Cinema::with(['hall:id,name,seats,status,cinema_id', 'address:cinema_id,id,country,city'])->get();
        return response(['cinemas' => json_encode($cinemas)], 200);
    }
}
