<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function brands(){
        $brands = Brand::orderBy('id','DESC')->paginate(10);
        return view('admin.brands', compact('brands'));
    }

    public function add_brand()
    {
        return view('admin.brand-add');
    }

    public function brand_store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:brands,slug',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        $brand = new Brand();
        $brand->name = $request->name;
        $brand->slug = Str::slug($request->slug);
        
        $image = $request->file('image');
        $file_extension = $request->file('image')->extension();
        $file_name = Carbon::now()->timestamp . '.' . $file_extension;
        
        $this->GenerateBrandThumbailsImage($image, $file_name);
        
        $brand->image = $file_name;
        $brand->save();

        return redirect()->route('admin.brands')->with('success', 'Brand added successfully.');
    }

    public function GenerateBrandThumbailsImage($image, $imageName)
    {
        $destinationPath = public_path('uploads/brands/');
        
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }
        
        $manager = new ImageManager(new Driver());
        
        $img = $manager->read($image->getRealPath());
        $img->resize(124, 124, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        
        $img->save($destinationPath . $imageName);
    }
}