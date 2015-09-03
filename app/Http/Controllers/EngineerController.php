<?php

namespace App\Http\Controllers;

use App\Schedule;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Engineer;
use App\EngineerArea;
use DB;

class EngineerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return Engineer::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        return Engineer::create($request->all());
    }

    public function getIdByIuser($iuser) {
        $engineer = Engineer::where('iuser', $iuser)->first();

        return $engineer;
    }

    public function storeArea(Request $request, $engineer_id)
    {
        //First we need to remove all the assigned areas, I will do a foreach just to make sure which is the engineer
        $objEngineer = Engineer::find($engineer_id);
        $objEngineer->areas()->detach();

        foreach ($request->all() as $newObj) {
            EngineerArea::create($newObj);
        }

        return [
            "success" => true
        ];
    }

    public function storeSchedule(Request $request, $engineer_id)
    {
        //First we need to remove all the schedules
        //$objEngineer = Engineer::find($engineer_id);

        Schedule::where('engineer_id', $engineer_id)->delete();


        foreach ($request->all() as $newObj) {
            Schedule::create($newObj);
        }

        return [
            "success" => true
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        return Engineer::findOrNew($id);
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
        $e = Engineer::findOrNew($id);

        $input = $request->all();

        $e->fill($input)->save();

        return [
            "success" => true
        ];
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

    public function areasLeft ($engineer_id) {

        $list = DB::table('areas as a')
            ->leftJoin('engineer_areas as ea', function ($join) use ($engineer_id) {
                $join->on('ea.area_id', '=', 'a.id')
                    ->on('ea.engineer_id', '=',  DB::raw($engineer_id));
            })

            ->leftJoin('engineers as e', 'ea.engineer_id', '=', 'e.id')

            ->select('a.id as area_id', 'a.name as area', 'a.component', 'e.iuser', DB::raw('IF (e.iuser IS NOT NULL, true, NULL) AS assigned'))
            ->orderBy('area', 'asc')
            ->get();

        return $list;
    }

    public function schedule($id)
    {
        return Engineer::findOrNew($id)->schedule;
    }

    public function chat($engineer_id) {
        return Engineer::find($engineer_id)->chat;
    }

    public function openChat($engineer_id) {
        return Engineer::find($engineer_id)->openChat;
    }

    public function closedChat($engineer_id) {
        return Engineer::find($engineer_id)->closedChat;
    }
}
