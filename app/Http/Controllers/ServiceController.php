<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Image;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = Service::with('image')->get();

        return view('adminpanel.service.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('adminpanel.service.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'file' => 'required|image',
            'content' => 'required',
        ], [
            'file.image' => 'The uploaded file must be an image of jpg,jpeg or png format.',
        ]);


        $service = new Service();
        $service->title = $request->title;
        $service->content = $request->content;
        $service->save();
        
        
        // if ($request->hasfile('images')) {
        //     foreach ($request->file('images') as $key => $file) {
        //         $name = $key . '-' . time() . '.' . $file->extension();
        //         $file->move(public_path('image/service_images/'), $name);
        //         $location = 'image/service_images/' . $name;
        //         $extension = explode('.' ,$name);

        //         $image = new Image();
        //         $image->url = $location;
        //         $image->type = $extension[1];
        //         $image->parentable_id = $university->id;
        //         $image->parentable_type = University::class;
        //         $image->save();
        //     }
        // }   

        if ($request->hasfile('file')) {
            $file = $request->file('file');
            $name = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('image/service_images/'), $name);
            $location = 'image/service_images/' . $name;
            
            $extension = $file->getClientOriginalExtension();
        
            $image = new Image();
            $image->url = $location;
            $image->type = $extension;
            $image->parentable_id = $service->id;
            $image->parentable_type = Service::class;
            $image->save();
        }

        return back()->with('success', 'Service created successfully.');
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function show(Service $service)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function edit(Service $service)
    {
        $service->load('image');
        return view('adminpanel.service.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Service $service)
    {
        $request->validate([
            'title' => 'required',
            'file' => 'nullable|image|mimes:jpeg,jpg,png', // Adding mimes validation for specific formats
            'content' => 'required',
        ], [
            'file.image' => 'The uploaded file must be an image of jpg, jpeg, or png format.',
        ]);


        $service->title = $request->title;
        $service->content = $request->content;
        $service->save();

        if ($request->hasfile('file')) {
            $file = $request->file('file');
            $name = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('image/service_images/'), $name);
            $location = 'image/service_images/' . $name;
            
            $extension = $file->getClientOriginalExtension();
        
            $image = new Image();
            $image->url = $location;
            $image->type = $extension;
            $image->parentable_id = $service->id;
            $image->parentable_type = Service::class;
            $image->save();
        }

        return back()->with('success', 'Service updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service)
    {

        $service->delete();
        return back()->with('success', 'Service deleted successfully.');

    }
}
