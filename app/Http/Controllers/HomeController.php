<?php

namespace App\Http\Controllers;
use App\Models\Slide;
use App\Models\Category;
use App\Models\Product;
use App\Models\Contact;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $slides = Slide::where('status', '1')->get()->take(3);
        $categories = Category::orderBy('name')->get();
        $sproducts = Product::whereNotNull('sale_price')->where('sale_price', '<>','')->inRandomOrder()->take(8)->get();
        $fproducts = Product::where('featured', '1')->take(8)->get();
        return view('index', compact('slides', 'categories', 'sproducts', 'fproducts'));
    }

    public function contact()
    {
        return view('contact');
    }

    public function contact_store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|numeric|digits:10',
            'comment' => 'required|string',
        ]);
        $contact = new Contact();
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->phone = $request->phone;
        $contact->comment = $request->comment;
        $contact->save();
        // flash success message to session and redirect back so the message is available in the next view
        session()->flash('success', 'Thank you for contacting us! We will get back to you soon.');
        return redirect()->back();
    }
}
