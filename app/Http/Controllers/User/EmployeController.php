<?php

namespace App\Http\Controllers\User;

use App\Employe;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class EmployeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employes = Employe::all();
        return view('backend.user.cards.index',compact('employes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.user.cards.create');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function upload()
    {
        return view('backend.user.cards.upload');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function storeCsv(Request $request)
    {
        $rules = [
            'csv_file' => 'required|file'
        ];
        $this->validate($request,$rules);
        
        $records = $this->parseImport($request);

        foreach ($records as $record) {
            $employe = new Employe;
            $employe->user_id       = auth()->Id();
            $employe->name          = $record[0];
            $employe->designation   = $record[1];
            $employe->phone         = $record[2];
            $employe->email         = $record[3];
            $employe->address       = $record[4];
            $employe->save();
        }
        session()->flash('alert-success','CSV Uploaded.');
        return redirect( route('employe.index') );
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name'          => 'required',
            'email'         => 'required|email',
            'phone'         => 'required',
            'designation'   => 'required',
            'address'       => 'required',
            'image'         => 'required|image',
        ];
        $this->validate($request,$rules);

        $filextention = $request->file('image')->getClientOriginalExtension();
        $filename = md5(microtime()).'.'.$filextention;
        $userDir = md5(auth()->id());

        $request->file('image')->storeAs($userDir,$filename);

        $data           = $request->all();
        $data['image']  = $filename;
        $data['user_id']= auth()->Id();

        $retult= Employe::create(
            $data
        );
        session()->flash('alert-success','Record Saved');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Employe  $employe
     * @return \Illuminate\Http\Response
     */
    public function show(Employe $employe)
    {
        //
    }

    /**
     * Save Image of user
     */
    public function saveImage(Request $request,$id){
        $emp = Employe::find($id);
        $rules = [
            'image'         => 'required|image',
        ];
        $this->validate($request,$rules);

        $filextention = $request->file('image')->getClientOriginalExtension();
        $filename = md5(microtime()).'.'.$filextention;
        $userDir = md5(auth()->id());

        $request->file('image')->storeAs($userDir,$filename);

        $emp->image = $filename;
        $emp->save();
        session()->flash('alert-success','Image Saved');
        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Employe  $employe
     * @return \Illuminate\Http\Response
     */
    public function edit(Employe $employe)
    {
        return view('backend.user.cards.edit',compact('employe'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Employe  $employe
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employe $employe)
    {
        $rules = [
            'name'          => 'required',
            'email'         => 'required|email',
            'phone'         => 'required',
            'designation'   => 'required',
            'address'       => 'required',
            'image'         => 'required_without:old_image|image',
        ];
        $this->validate($request,$rules);

        $data           = $request->all();
        $data['user_id']= auth()->Id();

        if ($request->has('image')){
            $filextention = $request->file('image')->getClientOriginalExtension();
            $filename = md5(microtime()).'.'.$filextention;
            $userDir = md5(auth()->id());
            $request->file('image')->storeAs($userDir,$filename);

            $data['image']  = $filename;
        }

        $retult= $employe->update(
            $data
        );
        session()->flash('alert-success','Record Updated');
        return redirect( route('employe.index') );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Employe  $employe
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employe $employe)
    {
        $employe->delete();
        session()->flash('alert-success','Record deleted');
        return back();
    }


    public function generateCards(){
        $employes = Employe::where('user_id',auth()->Id())->get();
        return \View::make('backend.user.cards.viewcards',compact('employes'));
    }

    public function generateCard($id){
        $employe = Employe::find($id);
        return \View::make('backend.user.cards.showcard',compact('employe'));
    }

    public function export(){
        $collection = Employe::where('user_id',auth()->Id())->get();
        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=file.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );
    
        $callback = function() use ($collection)
        {
            $file = fopen('php://output', 'w');
    
            foreach($collection as $row) {
                fputcsv($file,[
                    $row->name,
                    $row->designation,
                    $row->phone,
                    $row->email,
                    $row->address
                ]);
            }
            fclose($file);
        };
        return Response::stream($callback, 200, $headers);
    }
    private function parseImport(Request $request)
    {
        $path = $request->file('csv_file')->getRealPath();
        $data = array_map('str_getcsv', file($path));
        return $data;
    }
}
