<?php

namespace App\Http\Controllers;

use App\Film_hall;
use App\Hall;
use App\Sidemenu;
use App\Film;
use Illuminate\Http\Request;

class FilmController extends Controller
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
        return view('film.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('film.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $film = Film::where([
            'name' => $request->name,
            'year' => $request->year
        ])->first();
//        dd($film);
        if ($film != null) {
            return redirect()->route('film.create')->with('film_exists', 'Такой фильм уже существует!')->withInput();
        }
        else {
            $film = new Film();
            $film->name         = $request->name;
            $film->year         = $request->year;
            $film->description  = $request->description;
            $film->start        = $request->start;
            $film->end          = $request->end;
            $film->duration     = $request->duration;
            //$film->box_office   = $request->
            $film->poster       = $request->file('poster')->store('uploads/posters', 'public');
            $film->price        = $request->price;
            if ($request->trailer) {
                $film->trailer  = $request->trailer;
            }

            if ($film->save()) {
                return redirect()->route('film.show', ['film' => $film->id]);
            }
            else {
                return redirect()->back()->withInput()->with('error', 'Что-то пошло не так.');
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $film = Film::find($id);

        //dd($film->box_office);
        return view('film.show', compact('film'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $film = Film::find($id);

        return view('film.edit', compact('film'));
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
        //
    }

    public function setFilmsToHalls(Request $request)
    {
        foreach ($request->ids as $hall_id) {
            $film_hall = Film_hall::where([
                'film_id' => $request->film_id,
                'hall_id' => $hall_id
            ])->first();

            if (empty($film_hall)) {
                $film_hall = new Film_hall();
                $film_hall->film_id = $request->film_id;
                $film_hall->hall_id = $hall_id;
                $film_hall->save();
            }
        }
        return response([
//            'type'    => 'success',
            'message' => 'Фильм добавлен в выбранные кинозалы.',
        ], 200);
    }

    public function getFilms($hall) {
        $films = Hall::find($hall)->films()->where('end', '>', date('Y-m-d'))->get();
        if (count($films) != 0) {
            return response([
                'films' => json_encode($films),
            ], 200);
        }
        else return response(['word' => 'bad'], 404);
    }

    public function getFilm($name, $year) {
        $film = Film::where([
            'name' => $name,
            'year' => $year
        ])->first();
        return response([
            'film' => $film
        ], 200);
    }
}
