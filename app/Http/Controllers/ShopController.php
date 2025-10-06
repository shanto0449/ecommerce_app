<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $size = (int) $request->query('size', 12);
        if ($size <= 0) {
            $size = 12;
        }

        $o_column = "";
        $o_order = "";
        $order = (int) $request->query('order', -1);
    // raw brands parameter (could be string like "1,2" or array)
    $f_brands_param = $request->query('brands');
    $f_brands = $f_brands_param;
    $f_categories_param = $request->query('categories');
    $f_categories = $f_categories_param;
    $min_price = (float) $request->query('min_price', 1);
    $max_price = (float) $request->query('max_price', 5000);


        switch ($order) {
            case 1:
                $o_column = "created_at";
                $o_order = "DESC";
                break;
            case 2:
                $o_column = "created_at";
                $o_order = "ASC";
                break;
            case 3:
                $o_column = "sale_price";
                $o_order = "ASC";
                break;
            case 4:
                $o_column = "sale_price";
                $o_order = "DESC";
                break;
            default:
                $o_column = "";
                $o_order = "";
                break;
        }
        $brands = Brand::orderBy('name', 'ASC')->get();
        $categories = Category::orderBy('name', 'ASC')->get();  
        $query = Product::query();
        if ($f_brands) {
            if (is_string($f_brands)) {
                $f_brands = array_filter(array_map('trim', explode(',', $f_brands)));
            }
            if (is_array($f_brands) && count($f_brands) > 0) {
                $brandIds = array_filter(array_map('intval', $f_brands)); // keep numeric ids
                if (count($brandIds) > 0) {
                    $query->whereIn('brand_id', $brandIds);
                }
            }

        }
        if ($f_categories) {
            if (is_string($f_categories)) {
                $f_categories = array_filter(array_map('trim', explode(',', $f_categories)));
            }
            if (is_array($f_categories) && count($f_categories) > 0) {
                $categoryIds = array_filter(array_map('intval', $f_categories)); // keep numeric ids
                if (count($categoryIds) > 0) {
                    $query->whereIn('category_id', $categoryIds);
                }
            }
        }
        if ($min_price > 0) {
            $query->where('sale_price', '>=', $min_price);
        }
        if ($max_price > 0 && $max_price >= $min_price) {
            $query->where('sale_price', '<=', $max_price);
        }

        if ($o_column && $o_order) {
            $query->orderBy($o_column, $o_order);
        } else {
            $query->orderBy('id', 'DESC');
        }

        $products = $query->paginate($size)->withQueryString();

        // ensure view receives f_brands as a comma-separated string (safe for explode in blade)
        if (is_array($f_brands_param)) {
            $f_brands = implode(',', array_filter(array_map('trim', $f_brands_param)));
        } elseif (is_string($f_brands_param)) {
            $f_brands = $f_brands_param;
        } else {
            $f_brands = '';
        }

        return view('shop', compact('products', 'size', 'order', 'brands', 'f_brands', 'categories', 'f_categories', 'min_price', 'max_price'));
    }

    public function product_details($product_slug)
    {
        $product = Product::where('slug', $product_slug)->first();
        $rproducts = Product::where('slug', '<>', $product_slug)->take(8)->get();
        return view('details', compact('product', 'rproducts'));
    }
}
