<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    public function getMM() {
      $list = DB::table('schedules as s')
        ->join('engineers as e', 's.engineer_id', '=', 'e.id')
        ->join('engineer_areas as ea', 'e.id', '=', 'ea.engineer_id')
        ->join('areas as a', 'ea.area_id', '=', 'a.id')
        ->select('e.id as engineer_id', 'a.id as area_id', 's.date', 'e.name as engineer', 'e.email as engineer_email', 'e.available', 's.date', 's.start', 's.end', 'a.name as area', 'a.component')
        ->where('component', 'LIKE', 'MM%')
          ->orderBy('date')
          ->get();

        $newObj = [];

        $current_date = null;
        foreach ($list as $i => $obj) {
          $newObj[$obj->date]['date'] = $obj->date;
          $obj->onTime = $this->isOnTime($obj->date, $obj->start, $obj->end);
          $newObj[$obj->date]['data'][] = $obj;
        }

        return $newObj;
    }

    public function getSRM() {
      $list = DB::table('schedules as s')
        ->join('engineers as e', 's.engineer_id', '=', 'e.id')
        ->join('engineer_areas as ea', 'e.id', '=', 'ea.engineer_id')
        ->join('areas as a', 'ea.area_id', '=', 'a.id')
        ->select('e.id as engineer_id', 'a.id as area_id', 's.date', 'e.name as engineer', 'e.email as engineer_email', 'e.available', 's.date', 's.start', 's.end', 'a.name as area', 'a.component')
        ->where('component', 'LIKE', 'SRM%')
          ->orderBy('date')
          ->get();

      $newObj = [];
      foreach ($list as $obj => $i) {
        $newObj[$i]->date = $list->date;
        //$newObj[$i]->data = $list;
      }

      return $newObj;
    }

    private function isOnTime($date, $time_start, $time_end) {

      $isOnTime = false;

      $date = explode("-", $date);
      $time_start = explode(":", $time_start);
      $time_end = explode(":", $time_end);

      $tz_string = "America/Sao_Paulo";
      $tz_object = new \DateTimeZone($tz_string);

      $date_start = new \DateTime();
      $date_start->setTimezone($tz_object);
      $date_start->setDate($date[0], $date[1], $date[2]);
      $date_start->setTime($time_start[0], $time_start[1], "00");

      $date_end = new \DateTime();
      $date_end->setTimezone($tz_object);
      $date_end->setDate($date[0], $date[1], $date[2]);
      $date_end->setTime($time_end[0], $time_end[1], "00");

      $now = new \DateTime("now");
      $now->setTimezone($tz_object);


      if ($date_start <= $now && $date_end >= $now) {
        $isOnTime = true;
      }

      return $isOnTime;
    }

}
