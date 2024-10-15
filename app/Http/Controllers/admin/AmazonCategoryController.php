<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\AmazonCategory;
use Illuminate\Http\Request;
use Yoeunes\Toastr\Facades\Toastr;

class AmazonCategoryController extends Controller
{
    public function index()
    {
        $amazonCategory =  AmazonCategory::latest()->get();
        return view('admin.amazonCategory.index',compact('amazonCategory'));
    }
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
            ]);
            $amazonCategory = new AmazonCategory();
            $amazonCategory->name = $request->name;
            $amazonCategory->save();
            Toastr::success('Amazon Category Added Successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            // Handle the exception here
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required',
            ]);
            $amazonCategory = AmazonCategory::find($id);
            $amazonCategory->name = $request->name;
            $amazonCategory->save();
            Toastr::success('Amazon Category Updated Successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $amazonCategory = AmazonCategory::find($id);
            $amazonCategory->delete();
            Toastr::success('Amazon Category Deleted Successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
}
