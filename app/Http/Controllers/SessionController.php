<?php

namespace App\Http\Controllers;

use App\Cinema;
use App\Session;
use Illuminate\Http\Request;
use DateInterval;

class SessionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect()->route('session.create');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cinemas = Cinema::with('hall')->get();
        return view('session.create', compact('cinemas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $timeArr = $request->timearr;

        $startDate = new \DateTime($request->startdate);
        $endDate = new \DateTime($request->enddate);
        $interval = $startDate->diff($endDate);

        for ($i = 0; $i < $interval->d; $i++)
        {
            $date = $startDate->add(new DateInterval('P' . 1 . 'D'));
            for ($j = 0; $j < count($timeArr); $j++)
            {
                $session = new Session();
                $session->date = $date;
                $session->time = $timeArr[$j];
                $session->hall_id = $request->hallid;
                $session->film_id = $request->filmid;
                if (!$session->save()) {
                    return response([
                        'status' => false,
                        'message' => 'Что-то пошло не так'
                    ], 400);
                }
            }
        }
        return response([
            'status' => true,
            'message' => 'Сеансы созданы.'
        ], 200);


//        $timeArr = json_decode('"9:00","12:50","16:40","20:30","24:20"');
//        $startDate = new \DateTime('2020-05-25');
//        $endDate = new \DateTime('2020-06-14');
//        $interval = $startDate->diff($endDate);
//        dd($timeArr);
//        for ($i = 0; $i < $interval->d; $i++)
//        {
//            for ($j = 0; $j < count($timeArr); $j++)
//            {
//                $session = new Session();
//                $session->date = $startDate->add(DateInterval::createFromDateString('P' . $i . 'D'));
//                $session->time = $timeArr[$j];
//                $session->hall_id = 12;
//                $session->film_id = 54;
//                $session->save();
//            }
//        }
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
        //
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

    public function test() {
        $timeArr = ['aaa', 'bbb', 'ccc'];
        $startDate = new \DateTime('2020-05-25');
        $endDate = new \DateTime('2020-06-14');
        $interval = $startDate->diff($endDate);

        for ($i = 0; $i < $interval->d; $i++)
        {
            for ($j = 0; $j < count($timeArr); $j++)
            {
                $session = new Session();
                $session->date = $startDate->add(new DateInterval('P1D'));
                $session->time = $timeArr[$j];
                $session->hall_id = 12;
                $session->film_id = 54;
                dd($session);
                $session->save();
            }
        }
    }
}
