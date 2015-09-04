<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Schedule;
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
        $s = [];
        $s[] = Schedule::find($id);

        $newObj = [];

            if ($s) {
                foreach ($s as $i => $obj) {

                    if (!$this->isPast($obj->date)) {
                        $newObj[$i] = $obj->date;
                        $obj->onTime = $this->isOnTime($obj->date, $obj->start, $obj->end);
                        $newObj[$i] = $obj;
                    }
                }
                $newObj = $newObj[0];
            } else {
                $newObj = [
                    "no_entries" => true
                ];
            }

            return $newObj;
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
            ->select('s.id', 'e.id as engineer_id', 'a.id as area_id', 's.date', 'e.name as engineer', 'e.email as engineer_email', 'e.available', 's.date', 's.start', 's.end', 'a.name as area', 'a.component')
            ->where('component', 'LIKE', 'MM%')
            ->orderBy('date')
            ->get();

            $newObj = [];

            if ($list) {
                foreach ($list as $i => $obj) {

                    if (!$this->isPast($obj->date)) {
                        $newObj[$obj->date]['date'] = $obj->date;
                        $obj->onTime = $this->isOnTime($obj->date, $obj->start, $obj->end);
                        $newObj[$obj->date]['data'][] = $obj;
                    }
                }
            } else {
                $newObj = [
                    "no_entries" => true
                ];
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

        if ($list) {
            foreach ($list as $i => $obj) {

                if (!$this->isPast($obj->date)) {
                    $newObj[$obj->date]['date'] = $obj->date;
                    $obj->onTime = $this->isOnTime($obj->date, $obj->start, $obj->end);
                    $newObj[$obj->date]['data'][] = $obj;
                }
            }
        } else {
            $newObj = [
                "no_entries" => true
            ];
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

    public function isPast($date) {

      $isPast = false;

      $date = explode("-", $date);

      $tz_string = "America/Sao_Paulo";
      $tz_object = new \DateTimeZone($tz_string);

      $date_start = new \DateTime();
      $date_start->setTimezone($tz_object);
      $date_start->setDate($date[0], $date[1], $date[2]);

      $now = new \DateTime("now");
      $now->setTimezone($tz_object);

      if ($date_start <= $now && $date_start->format('Y-m-d') != $now->format('Y-m-d') ) {
        $isPast = true;
      }

      return $isPast;
    }

}
