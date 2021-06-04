<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Model\Dp;
use Validator;

class DpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dp = Dp::select("dp.*")->get()->toArray();

        return response()->json($dp);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'dp' => 'required'
        ]);
        if ($validator->fails()){
            return response()->json([
                'ok' => false,
                'error' => $validator->messages(),
            ]);
        }
        try{
            Dp::create($input);
            return response()->json([
                "ok" => true,
                "message" => "dp plan is successfully added",
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                "ok" => false,
                "error" => $ex->getMessage(),
            ]);
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
        $dp = dp::select("dp.*")
            ->where("dp.id", $id)
            ->first();
        return  response()->json([
            "ok" => true,
            "data" => $dp,
        ]);
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
        $input = $request->all();
        $validator = Validator::make($input, [
            'dp' => 'required',
        ]);
        if ($validator->fails()){
            return response()->json([
                'ok' => false,
                'error' => $validator->messages(),
            ]);
        }
        try {
            $dp = dp::find($id);
            if ($dp == false) {
                return response()->json([
                    "ok" => false,
                    "error" => "No data is found",
                ]);
            }
            $dp->update($input);
            return response()->json([
                "ok" => true,
                "message" => "successfully modified"
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                "ok" => false,
                "error" => $ex->getMessage(),
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $dp = Dp::find($id);
            if ($dp == false) {
                return  response()->json([
                    "ok" => false,
                    "error" => "No data is found",
                ]);
            }
            $dp->delete([

            ]);
            return response()->json([
                "ok" => true,
                "message" => "successfully modified",
            ]);
        }catch (\Exception $ex) {
            return response()->json([
                "ok" => false,
                "error" => $ex->getMessage(),
            ]);
        }
    }
}
