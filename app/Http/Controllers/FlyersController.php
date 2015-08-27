<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Http\Requests\FlyerRequest;
use App\Http\Controllers\Controller;
use App\Flyer;
use App\Photo;

class FlyersController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['show']]);
        
        parent::__construct();
    }

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
        return view('flyers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  FlyerRequest  $request
     * @return Response
     */
    public function store(FlyerRequest $request)
    {
        // persist the flyer
        Flyer::create($request->all());

        // flash messaging
        flash('Success!', 'Your flyer has been created!');

        return redirect()->back(); // temporary
    }

    /**
     * Display the specified resource.
     *
     * @return Response
     */
    public function show($zip, $street)
    {
        $flyer = Flyer::locatedAt($zip, $street);
    
        return view ('flyers.show', compact('flyer'));
    }

    public function addPhoto($zip, $street, Request $request)
    {
        $this->validate($request, [
            'photo' => 'required|mimes:jpg,jpeg,png,bmp'
        ]);

        $flyer = Flyer::locatedAt($zip, $street);

        if ($flyer->user_id !== \Auth::id()) {
            if ($request->ajax()) {
                return response(['message' => 'No way.'], 403);
            }

            flash('No way');

            return redirect('/');
        }

        $photo = $this->makePhoto($request->file('photo'));

        Flyer::locatedAt($zip, $street)->addPhoto($photo);
    }

    protected function makePhoto(UploadedFile $file)
    {
        return Photo::named($file->getClientOriginalName())
            ->move($file);           
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
}
