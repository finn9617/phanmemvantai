<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use DateTime;
use Response;

class MapController extends Controller
{
    public function index()
    {
        return view('api.index');
    }

    public function create()
    {
        $car = DB::table('tbl_location')
        ->whereIn('id', function ($query) {
            $query->select(DB::raw('max(id)'))
                ->from('tbl_location')
                ->groupby('car_id');
        })
        ->get();

        return $car;
    }

    public function createManyCar($id)
    {
        $car = DB::table('tbl_location')
        ->whereIn('id', function ($query) {
            $query->select(DB::raw('max(id)'))
                ->from('tbl_location')
                ->groupby('car_id');
        })
        ->where('car_id', '=', $id)
        ->get();

        return $car;
    }

    public function HistoryCar(Request $rq)
    {
        $car = DB::table('tbl_location')
        ->where('car_id', $rq->car_id)
        ->whereBetween('created_at', array($timeStart, $timeEnd))->skip($rq->id)->take(4)->get();

        return $car;
    }

    public function getInfo(Request $request)
    {
        $id = $request->id;
        $car = DB::table('tbl_car')->where('car_id', $id)->first();
        $car_num = $car->car_num;

        $timefm = new DateTime();

        $timeStart = $request->dateStart;
        $timeStart = $timefm->createFromFormat('d-m-Y H', $timeStart);
        $timeStart = $timeStart->format('Y-m-d H:00:00');

        $timeEnd = $request->dateEnd;
        $timeEnd = $timefm->createFromFormat('d-m-Y H', $timeEnd);
        $timeEnd = $timeEnd->format('Y-m-d H:00:00');

        $local = DB::table('tbl_location')
        ->where('car_id', $id)
        ->whereBetween('created_at', array($timeStart, $timeEnd))->orderby('created_at', 'DESC')
            ->get()->toArray();

        return Response::json(['array' => $local, 'carnum' => $car_num]);
    }

    public function getInfo1(Request $request)
    {
        $id = $request->id;
        $car = DB::table('tbl_car')->where('car_id', $id)->first();
        $car_num = $car->car_num;

        $timefm = new DateTime();

        $timeStart = $request->dateStart;
        $timeStart = $timefm->createFromFormat('d-m-Y H', $timeStart);
        $timeStart = $timeStart->format('Y-m-d H:00:00');

        $timeEnd = $request->dateEnd;
        $timeEnd = $timefm->createFromFormat('d-m-Y H', $timeEnd);
        $timeEnd = $timeEnd->format('Y-m-d H:00:00');

        $local = DB::table('tbl_location')
        ->where('car_id', $id)
        ->whereBetween('created_at', array($timeStart, $timeEnd))->skip($request->iddata)->take(25)
            ->get()->toArray();

        $dem = DB::table('tbl_location')
            ->where('car_id', $id)
            ->whereBetween('created_at', array($timeStart, $timeEnd))->count();

        return Response::json(['array' => $local, 'carnum' => $car_num, 'count' => $dem]);
    }
}
