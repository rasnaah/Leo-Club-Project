<?php

namespace App\Http\Controllers;

use App\Http\ImageUpload;
use App\Models\Model\Events;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Str;
use Validator;

class EventsController extends Controller
{
    use ImageUpload;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $event = Events::select("event.*")->get()->toArray();

        return response()->json($event);
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
            'title' => 'required|string',
            'club' => 'required|string',
//            'bloodDonation' => ['required|boolean'],
            'date' => 'required|date',
            //'time' => 'required|time',
            'image' => 'required|mimes:jpeg,jpg,png,gig',
            'description' => 'required|string'
        ]);
        if ($validator->fails()){
            return response()->json([
                'ok' => false,
                'error' => $validator->messages(),
            ]);
        }
        /*        try{
                    Assistance::create($input);
                    return response()->json([
                        "ok" => true,
                        "message" => "new event is added successfully.",
                    ]);
                } catch (\Exception $ex) {
                    return response()->json([
                        "ok" => false,
                        "error" => $ex->getMessage(),
                    ]);
                }*/
        $event = new Events();

        if($request->has(0)){
            return 'No';
        }else{
            return 'Yes';
        };
        // Check if an image has been uploaded
        if ($request->has('image')) {
            // Get image file
            $image = $request->file('image');
            // Make a image name based on user name and current timestamp
            $name = Str::slug($request->input('name')).'_'.time();
            // Define folder path
            $folder = '/uploads/images/';
            // Make a file path where image will be stored [ folder path + file name + file extension]
            $filePath = $folder . $name. '.' . $image->getClientOriginalExtension();
            // Upload image
            $this->uploadOne($image, $folder, 'public', $name);
            // Set user profile image path in database to filePath

            $event->title = $request->title;
            $event->club = $request->club;
            $event->bloodDonation = $request->has('bloodDonation');
            $event->date = $request->date;
            $event->time = $request->time;
            $event->image = $filePath;
            $event->description = $request->description;
            //$event->user_id = $request->user_id;
            $event->save();
        }

        return  response()->json([
            "ok" => true,
            "data" => $event,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $event = Events::select("event.*")
            ->where("event.id", $id)
            ->first();
        return  response()->json([
            "ok" => true,
            "data" => $event,
        ]);

    }

    public function deleteImage($id){
        $userData=Events::findOrFail($id);
        $imageName=$userData->image;
        $deletePath=public_path('images/'.$imageName);
        if(file_exists($deletePath)){
            return unlink($deletePath);
        }
        return true;
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
            'title' => 'required|string',
            'club' => 'required|string',
            //'bloodDonation' => ['required'],
            'date' => 'required|date',
            'time' => 'required|time',
            'description' => 'required|string'
        ]);
        if ($validator->fails()){
            return response()->json([
                'ok' => false,
                'error' => $validator->messages(),
            ]);
        }
        if ($request->hasFile('image')){
            $image=$request->file('image');
            $ext=$image->getClientOriginalExtension();
            $imageName=Str::random(18).'.'.$ext;
            $uploadPath=public_path('images/');
            if($this->deleteImage($id) && $image->move($uploadPath,$imageName)){
                $data['images']=$imageName;
            }
        }
        try {
            $event = Events::find($id);
            if ($event == false) {
                return response()->json([
                    "ok" => false,
                    "error" => "No data is found",
                ]);
            }
            $event->update($input);
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
            $event = Events::find($id);
            if ($event == false) {
                return  response()->json([
                    "ok" => false,
                    "error" => "No data is found",
                ]);
            }
            $this->deleteImage($id);
            $event->delete([

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
