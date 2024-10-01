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

    public function create()
    {
        $parents = Category::all();
        $category = new Category();
        return view('dashboard.categories.create', compact('parents', 'category'));
    }

    public function store(Request $request)
    {
        $request->validate(Category::rules(), [
            'name.required' => 'This field is required',
            'name.unique' => 'This word has already been taken',
            'description.required' => 'Description is required',
            'image.image' => 'The file must be an image',
        ]);

        $request->merge([
            'slug' => Str::slug($request->post('name'))
        ]);

        $data = $request->except('image');
        $data['image'] = $this->uploadImage($request);

        Category::create($data);

        return redirect()->route('dashboard.categories.index')
            ->with('success', 'Category Created Successfully');
    }

    public function show(string $id)
    {
        $category = Category::findOrFail($id);
        return view('dashboard.categories.show', compact('category'));
    }

    public function edit(string $id)
    {
        $category = Category::findOrFail($id);

        // Get all categories except the one being edited and its children
        $parents = Category::where('id', '<>', $id)
            ->where(function ($query) use ($id) {
                $query->whereNull('parent_id')
                    ->orWhere('parent_id', '<>', $id);
            })->get();

        return view('dashboard.categories.edit', compact('category', 'parents'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate(Category::rules($id));

        $category = Category::findOrFail($id);

        $old_image = $category->image;
        $data = $request->except('image');

        $new_image = $this->uploadImage($request);

        if ($new_image) {
            $data['image'] = $new_image;
        }

        $category->update($data);

        if ($old_image && $new_image) {
            Storage::disk('public')->delete($old_image);
        }

        return redirect()->route('dashboard.categories.index')
            ->with('success', 'Category Updated Successfully');
    }

    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);

        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        return redirect()->route('dashboard.categories.index')
            ->with('error', 'Category Deleted Successfully');
    }

    protected function uploadImage(Request $request): ?string
    {
        if (!$request->hasFile('image')) {
            return null;
        }

        $file = $request->file('image'); // UploadedFile object

        return $file->store('uploads', [
            'disk' => 'public'
        ]);
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
