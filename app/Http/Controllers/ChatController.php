<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Chat;
use App\Engineer;
use Mail;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return Chat::all();
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

        //We need to set the Engineer as unavailable
        $e = Engineer::find($request["engineer_id"]);
        $e->available = 0;
        $e->save();

        $post_data = $request->all();

        if ($post_data["engineer_email"]) {

          //Send e-mail to responsible engineer
            $mail = Mail::raw("You have receixed a new chat request, please check the tool now!", function ($message) use ($post_data) {
              $message->from('saplabsla@gmail.com', 'RTS Tool');
              $message->to($post_data["engineer_email"])->subject('New RTS request!');
            });
        }

        return Chat::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response'
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
        $c = Chat::findOrNew($id);

        $input = $request->all();

        $c->fill($input)->save();

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
}
