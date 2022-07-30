<?php

namespace App\Http\Controllers\Admin;

use App\Models\Slider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Http\Requests\SliderFormRequest;

class SliderController extends Controller
{
    public function index(){
        $sliders = Slider::all();
        return view('admin.slider.index',\compact('sliders'));
    }

    public function create(){
        return view('admin.slider.create');
    }

    public function store(SliderFormRequest $request){

        $validatedData = $request->validated();

        if($request->hasFile('image')){
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $fileName = time().'.'.$ext;
            $file->move('uploads/slider/',$fileName);
            $validatedData['image'] = "uploads/slider/$fileName";
        }

        $validatedData['status'] = $request->status == true ? '1' : '0';

        Slider::create([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'image' => $validatedData['image'],
            'status' => $validatedData['status'],
        ]);

        return redirect('admin/sliders')->with('msg','Slider created successfully');
    }

    public function edit(Slider $slider){
        return view('admin.slider.edit',\compact('slider'));
    }

    public function update(SliderFormRequest $request,Slider $slider){
        $validatedData = $request->validated();

        if($request->hasFile('image')){

            $destination = $slider->image;

            if(File::exists($destination)){
                File::delete($destination);
            }

            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $fileName = time().'.'.$ext;
            $file->move('uploads/slider/',$fileName);
            $validatedData['image'] = "uploads/slider/$fileName";
        }

        $validatedData['status'] = $request->status == true ? '1' : '0';

        $slider->update([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'image' => $validatedData['image'] ?? $slider->image,
            'status' => $validatedData['status'],
        ]);

        return redirect('admin/sliders')->with('msg','Slider updated successfully');
    }

    public function destroy(Slider $slider){
        $destination = $slider->image;

        if(File::exists($destination)){
            File::delete($destination);
        }

        $slider->delete();

        return redirect('admin/sliders')->with('msg','Slider deleted successfully');
    }
}
