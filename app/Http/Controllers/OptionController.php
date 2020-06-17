<?php

namespace App\Http\Controllers;

use App\Option;
use Illuminate\Http\Request;

class OptionController extends Controller
{
    public function store(Request $request) {
        $option = new Option();
        $option->name = $request->name;
        $option->cost = $request->cost;

        if ($option->save()) {
            return response([
                'message'   => 'Опция добавлена.',
                'type'      => 'success',
                'option'    => json_encode($option)
            ],200);
        }
        else {
            return response([
                'message'   => 'Что-то пошло не так.',
                'type'      => 'danger',
            ],400);
        }
    }

    public function get() {
        $options = Option::all();

        return response(['options' => json_encode($options)], 200);
    }
}
