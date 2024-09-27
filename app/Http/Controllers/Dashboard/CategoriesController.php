<?php
namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return view('dashboard.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parents = Category::all();
        $category = new Category();
        return view('dashboard.categories.create', compact('parents', 'category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // لو عاوز تتحكم في اسم الملف بنكتب storeAs(اسم الفولد اللي هخزن فيه + الاسم اللي هتتحكم في اسم الصورة )
         // Merge slug into the request data, using name to generate slug
    // Merge slug into the request data, using name to generate slug

    $request->validate( Category::rules());

    $request->merge([
        'slug' => Str::slug($request->post('name'))
    ]);

    $data = $request->except('image');
    $data['image'] = $this->uploadImage($request);

    // Create the category with mass assignment
    $category = Category::create($data);

    // Redirect with success message
    return redirect()->route('dashboard.categories.index')
    ->with('success', 'Category Created Successfully');
 }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::findOrFail($id);
        return view('dashboard.categories.show', compact('category'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {


        try {
            $category = Category::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('dashboard.categories.index')->with('info', 'Category Not Found');
        }

        // Get all categories except the one being edited and its potential child
        $parents = Category::where('id', '<>', $id)
        ->whereNull('parent_id')
        ->orwhere('parent_id', '<>', $id)
        ->get();

        return view('dashboard.categories.edit', compact('category', 'parents'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate(Category::rules($id));


        $category = Category::findOrFail($id);

        $old_image = $category->image;
        $data = $request->except('image');

        $data['image'] = $this->uploadImage($request);

        // Update the category with validated data
        $category->update($data);

        if($old_image && isset($data['image'])){
            Storage::disk('public')->delete($old_image);
        }

        return redirect()->route('dashboard.categories.index')
            ->with('success', 'Category Updated Successfully');
            //         $category = Category::findorFail($id);
//         $category->update($request->all());

//         return redirect()->route('dashboard.categories.index')
//         ->with('success', 'Category Updated Successfully');


//         // $category = new Category(); // يوجد فرق بينها وما بين اللي فيهاا find($id)  بيكون ساعتها $exists => false في هذه الحاله ام في حاله الا edit بتكوكن true
//         // $category->name=$request->name;
//         // $category->parent_id=$request->parent_id;
//         // $category->save();

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        if($category->image){
            Storage::disk('public')->delete($category->image);
        }
        // Check if category has children, handle or notify accordingly (optional)
        // e.g., Category::where('parent_id', $id)->update(['parent_id' => null]);


        return redirect()->route('dashboard.categories.index')
            ->with('error', 'Category Deleted Successfully');
    }


    protected function uploadImage(Request $request)
    {
        if(!$request->hasFile('image')){
            return;
        }

            $file= $request->file('image'); // uploadefile object

            $path = $file->store('uploads',[
                'disk' =>'public'
            ]);
            return $path;
        }
    }


// $file->getClientMimeType();
// $file->getSize();
// $file->getClientOriginalExtension();
// $file->getMimeType();






// code 222


// namespace App\Http\Controllers\Dashboard;

// use App\Http\Controllers\Controller;
// use App\Models\Category;
// use Illuminate\Http\Request;
// use Illuminate\Support\Str;

// class CategoriesController extends Controller

// {
//     /**
//      * Display a listing of the resource.
//      */
//     public function index()
//     {
//         $categories = Category::all();
//         return view('dashboard.categories.index', compact('categories'));
//     }

//     /**
//      * Show the form for creating a new resource.
//      */
//     public function create()
//     {
//         $parents = Category::all();
//         return view('dashboard.categories.create', compact('parents'));
//     }

//     /**
//      * Store a newly created resource in storage.
//      */
//     public function store(Request $request)
//     {
//         // Validate the request data
//         $validated = $request->validate([
//             'name' => 'required|string|max:255',
//             'description' => 'nullable|string',
//             'parent_id' => 'nullable|integer|exists:categories,id',
//         ]);

//         // Merge slug into the request data, using name to generate slug
//         $validated['slug'] = Str::slug($request->post('name'));

//         // Create the category with mass assignment
//         $category = Category::create($validated);

//         // Redirect with success message
//         return redirect()->route('dashboard.categories.index')->with('success', 'Category Created Successfully');
//     }

//     /**
//      * Display the specified resource.
//      */
//     public function show(string $id)
//     {
//     }

//     /**
//      * Show the form for editing the specified resource.
//      */
//     public function edit(string $id)
//     {
//         try{
//             $category = Category::findOrFail($id);
//         }catch(Exception $e){
//             return redirect()->route('dashboard.categories.index')->with('info', 'Category Not Found');
//         }
//         $parents = Category::where('id','<>',$id)->get();

//         return view('dashboard.categories.edit',compact('category','parents'));

//     }

//     /**
//      * Update the specified resource in storage.
//      */
//     public function update(Request $request, string $id)
//     {
//         $category = Category::findorFail($id);
//         $category->update($request->all());

//         return redirect()->route('dashboard.categories.index')
//         ->with('success', 'Category Updated Successfully');


//         // $category = new Category(); // يوجد فرق بينها وما بين اللي فيهاا find($id)  بيكون ساعتها $exists => false في هذه الحاله ام في حاله الا edit بتكوكن true
//         // $category->name=$request->name;
//         // $category->parent_id=$request->parent_id;
//         // $category->save();
//     }

//     /**
//      * Remove the specified resource from storage.
//      */
//     public function destroy(string $id)
//     {
//         // $category = Category::findorfail($id);
//         // $category->delete();

//         // Category::where('id', $id)->delete();
//         Category::destroy($id);

//             return redirect()->route('dashboard.categories.index')
//         ->with('error', 'Category Deleted Successfully');
//     }

// }



############################################################################################################################
############################################################################################################################
############################################################################################################################


// Code 111

// namespace App\Http\Controllers\Dashboard;

// use App\Http\Controllers\Controller;
// use App\Models\Category;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Redirect;
// use Illuminate\Support\Str;

// class CategoriesController extends Controller
// {
//     /**
//      * Display a listing of the resource.
//      */
//     public function index()
//     {
//         $categories = Category::all();
//         return view('dashboard.categories.index',compact('categories'));
//     }

//     /**
//      * Show the form for creating a new resource.
//      */
//     public function create()
//     {
//         $parents = Category::all();
//         return view('dashboard.categories.create',compact('parents'));
//     }

//     /**
//      * Store a newly created resource in storage.
//      */
//     public function store(Request $request)
//     {
//         $category = new Category();


//         // merage

//         $request->merge([
//             'slug' => Str::slug($request->post('slug'))
//         ]);
//         // mass Assignment
//         $category =Category::create($request->all()); // without writing  [ $category->save() ].

//         // $category = new Category($request->all());
//         // $category->name = $request->input('name');
//         // $category->description = $request->input('description');
//         // $category->parent_id = $request->input('parent_id');
//         // $category->save();

//         return redirect()->route('categories.index')->with('success', 'Category Created');
//     }

//     /**
//      * Display the specified resource.
//      */
//     public function show(string $id)
//     {
//         //
//     }

//     /**
//      * Show the form for editing the specified resource.
//      */
//     public function edit(string $id)
//     {
//         //
//     }

//     /**
//      * Update the specified resource in storage.
//      */
//     public function update(Request $request, string $id)
//     {
//         //
//     }

//     /**
//      * Remove the specified resource from storage.
//      */
//     public function destroy(string $id)
//     {
//         //
//     }
// }
