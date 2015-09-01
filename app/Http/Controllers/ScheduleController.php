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
        ->where('component', 'LIKE', 'MM%')
          ->orderBy('date')
          ->get();
      return $list;
    }

    public function getSRM() {
      $list = DB::table('schedules as s')
        ->join('engineers as e', 's.engineer_id', '=', 'e.id')
        ->join('engineer_areas as ea', 'e.id', '=', 'ea.engineer_id')
        ->join('areas as a', 'ea.area_id', '=', 'a.id')
        ->where('component', 'LIKE', 'SRM%')
          ->orderBy('date')
          ->get();
      return $list;
    }
}
