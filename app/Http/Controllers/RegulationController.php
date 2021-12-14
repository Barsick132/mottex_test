<?php

namespace App\Http\Controllers;

use App\Http\Constants\RequestStatuses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegulationController extends Controller
{
    public function index()
    {
        return view('regulations.index');
    }


    public function create()
    {
        return view('regulations.create');
    }


    public function store(Request $request)
    {
        $rules = [
            'file' => 'required|file|max:10240|mimes:xml'
        ];

        $validateData = $this->validate($request, $rules);

        $rss = simplexml_load_file($validateData['file']);
        $array = json_decode(json_encode($rss),TRUE);
//dd($array['channel']['item']);
        $rss_validator = Validator::make($array, [
            'channel' => 'required|array',
            'channel.item' => 'required|array',
            'channel.item.*.link' => 'required|string',
            'channel.item.*.author' => 'required|string',
            'channel.item.*.title' => 'required|string',
            'channel.item.*.description' => 'required|string',
            'channel.item.*.guid' => 'required|string'
        ])->validate();
//        if ($rss_validator->fails()) {
//            dd($rss_validator);
//        }

        // Retrieve the validated input...
//        $validated = $rss_validator->validated();
//        dd($validated);

        return redirect()->route('regulations.create');
    }
}
