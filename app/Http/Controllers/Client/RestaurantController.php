<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Models\Menu;
use App\Models\Product;
use App\Models\City;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Carbon\Carbon;
use App\Models\Gllery;

class RestaurantController extends Controller
{
    public function AllMenu(){
        $id = Auth::guard('client')->id();
        $menu = Menu::where('client_id',$id)->orderBy('id','desc')->get();
        return view('client.backend.menu.all_menu', compact('menu'));
    }
    // End Method

    public function AddMenu(){

        return view('client.backend.menu.add_menu');
    }
    // End Method

    public function StoreMenu(Request $request){

        if ($request->file('image')) {
            $image = $request->file('image');
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            $img = $manager->read($image);
            $img->resize(300,300)->save(public_path('upload/menu/'.$name_gen));
            $save_url = 'upload/menu/'.$name_gen;

            Menu::create([
                'menu_name' => $request->menu_name,
                'client_id' => Auth::guard('client')->id(),
                'image' => $save_url,
            ]);
        }

        $notification = array(
            'message' => 'Menu Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.menu')->with($notification);

    }
    // End Method

    public function EditMenu($id){
        $menu = Menu::find($id);
        return view('client.backend.menu.edit_menu', compact('menu'));
    }
     // End Method

     public function UpdateMenu(Request $request){

        $menu_id = $request->id;

        if ($request->file('image')) {
            $image = $request->file('image');
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            $img = $manager->read($image);
            $img->resize(300,300)->save(public_path('upload/menu/'.$name_gen));
            $save_url = 'upload/menu/'.$name_gen;

            Menu::find($menu_id)->update([
                'menu_name' => $request->menu_name,
                'image' => $save_url,
            ]);
            $notification = array(
                'message' => 'Menu Updated Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('all.menu')->with($notification);

        } else {

            Menu::find($menu_id)->update([
                'menu_name' => $request->menu_name,
            ]);
            $notification = array(
                'message' => 'Menu Updated Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('all.menu')->with($notification);

        }

    }
    // End Method
    public function DeleteMenu($id){
        $item = Menu::find($id);
        $img = $item->image;
        unlink($img);

        Menu::find($id)->delete();

        $notification = array(
            'message' => 'Menu Delete Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    }
    // End Method

    // ===== PRODUCT METHODS =====

    public function AllProduct() {
        $id = Auth::guard('client')->id();
        $product = Product::where('client_id', $id)->orderBy('id','desc')->get();
        return view('client.backend.product.all_product', compact('product'));
    }

    public function AddProduct() {
        $cid = Auth::guard('client')->id();
        $category = Category::latest()->get();
        $city = City::latest()->get();
        $menu = Menu::where('client_id', $cid)->latest()->get();
        return view('client.backend.product.add_product', compact('category','city','menu'));
    }

    public function StoreProduct(Request $request) {
        $pcode = IdGenerator::generate(['table' => 'products','field' => 'code', 'length' => 5, 'prefix' => 'PC']);
        $save_url = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            $img = $manager->read($image);
            $img->resize(300,300)->save(public_path('upload/product/'.$name_gen));
            $save_url = 'upload/product/'.$name_gen;
        }

        Product::create([
    'name' => $request->name,
    'slug' => strtolower(str_replace(' ','-',$request->name)),
    'category_id' => $request->category_id,
    'city_id' => $request->city_id,
    'menu_id' => $request->menu_id,
    'code' => $pcode,
    'qty' => $request->qty,
    'size' => $request->size,
    'price' => preg_replace('/[^0-9]/', '', $request->price), // jadi angka
    'discount_price' => preg_replace('/[^0-9]/', '', $request->discount_price ?? 0),
    'client_id' => Auth::guard('client')->id(),
    'most_populer' => $request->most_populer ?? 0,
    'best_seller' => $request->best_seller ?? 0,
    'status' => 1,
    'created_at' => Carbon::now(),
    'image' => $save_url,
]);


        return redirect()->route('all.product')->with([
            'message' => 'Product Inserted Successfully',
            'alert-type' => 'success'
        ]);
    }

    public function EditProduct($id) {
        $cid = Auth::guard('client')->id();
        $category = Category::latest()->get();
        $city = City::latest()->get();
        $menu = Menu::where('client_id',$cid)->latest()->get();
        $product = Product::find($id);

        if (!$product) {
            return redirect()->back()->with([
                'message' => 'Product not found!',
                'alert-type' => 'error'
            ]);
        }

        return view('client.backend.product.edit_product', compact('category','city','menu','product'));
    }

    public function UpdateProduct(Request $request) {
        $pro_id = $request->id;
        $product = Product::find($pro_id);

        if (!$product) {
            return redirect()->back()->with([
                'message' => 'Product not found!',
                'alert-type' => 'error'
            ]);
        }

        $save_url = $product->image; // default pakai image lama

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            $img = $manager->read($image);
            $img->resize(300,300)->save(public_path('upload/product/'.$name_gen));
            $save_url = 'upload/product/'.$name_gen;

            // hapus gambar lama jika ada
            if ($product->image && file_exists(public_path($product->image))) {
                unlink(public_path($product->image));
            }
        }

        $product->update([
            'name' => $request->name,
            'slug' => strtolower(str_replace(' ', '-', $request->name)),
            'category_id' => $request->category_id,
            'city_id' => $request->city_id,
            'menu_id' => $request->menu_id,
            'qty' => $request->qty,
            'size' => $request->size,
            'price' => preg_replace('/[^0-9]/', '', $request->price),
            'discount_price' => preg_replace('/[^0-9]/', '', $request->discount_price ?? 0),
            'best_seller' => $request->best_seller ?? 0,
            'image' => $save_url,
            'updated_at' => Carbon::now(),
        ]);

        return redirect()->route('all.product')->with([
            'message' => 'Product Updated Successfully',
            'alert-type' => 'success'
        ]);
    }

    public function DeleteProduct($id) {
        $product = Product::find($id);

        if ($product) {
            if ($product->image && file_exists(public_path($product->image))) {
                unlink(public_path($product->image));
            }
            $product->delete();
        }

        return redirect()->back()->with([
            'message' => 'Product Deleted Successfully',
            'alert-type' => 'success'
        ]);
    }

    // ===== END PRODUCT =====



    public function ChangeStatus(Request $request){
        $product = Product::find($request->product_id);
        $product->status = $request->status;
        $product->save();
        return response()->json(['success' => 'Status Change Successfully']);
    }
     // End Method

     /////////// All Gallery Method Start

     public function AllGallery(){
        $cid = Auth::guard('client')->id();
        $gallery = Gllery::where('client_id',$cid)->latest()->get();
        return view('client.backend.gallery.all_gallery', compact('gallery'));
    }
    // End Method

    public function AddGallery(){
        return view('client.backend.gallery.add_gallery' );
    }
    // End Method

    public function StoreGallery(Request $request){

        $images = $request->file('gallery_img');

        foreach ($images as $gimg) {

            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()).'.'.$gimg->getClientOriginalExtension();
            $img = $manager->read($gimg);
            $img->resize(800,800)->save(public_path('upload/gallery/'.$name_gen));
            $save_url = 'upload/gallery/'.$name_gen;

            Gllery::insert([
                'client_id' => Auth::guard('client')->id(),
                'gallery_img' => $save_url,
            ]);
        } // end foreach

        $notification = array(
            'message' => 'Gallery Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.gallery')->with($notification);

    }
     // End Method

     public function EditGallery($id){
        $gallery = Gllery::find($id);
        return view('client.backend.gallery.edit_gallery',compact('gallery'));
     }
     // End Method

     public function UpdateGallery(Request $request){

        $gallery_id = $request->id;

        if ($request->hasFile('gallery_img')) {
            $image = $request->file('gallery_img');
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            $img = $manager->read($image);
            $img->resize(800,800)->save(public_path('upload/gallery/'.$name_gen));
            $save_url = 'upload/gallery/'.$name_gen;

            $gallery = Gllery::find($gallery_id);
            if ($gallery->gallery_img) {
                $img = $gallery->gallery_img;
                unlink($img);
            }

            $gallery->update([
                'gallery_img' => $save_url,
            ]);

            $notification = array(
                'message' => 'Menu Updated Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('all.gallery')->with($notification);

        } else {

            $notification = array(
                'message' => 'No Image Selected for Update',
                'alert-type' => 'warning'
            );

            return redirect()->back()->with($notification);
        }
    }
    // End Method

    public function DeleteGallery($id){
        $item = Gllery::find($id);
        $img = $item->gallery_img;
        unlink($img);

        Gllery::find($id)->delete();

        $notification = array(
            'message' => 'Gallery Delete Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    }
    // End Method
}
