<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\AmazonCategory;
use App\Models\AmazonSubCategory;
use Illuminate\Http\Request;
use Yoeunes\Toastr\Facades\Toastr;

class AmazonSubCategoryController extends Controller
{
    public function index()
    {
        $amazonCategory =  AmazonCategory::get();
        $amazonSubCategory = AmazonSubCategory::with('amazonCategory')->latest()->get();
        return view('admin.amazonSubCategory.index',compact('amazonCategory','amazonSubCategory'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'amazon_category_id' => 'required',
                'name' => 'required',
                'referral_fee' => 'required',
                'size_tier_type' => 'required',
                'shipping_weight' => 'required',
                'fba_fee' => 'required',
            ]);
            $amazonSubCategory = new AmazonSubCategory();
            $amazonSubCategory->amazon_category_id = $request->amazon_category_id;
            $amazonSubCategory->name = $request->name;
            $amazonSubCategory->referral_fee = $request->referral_fee;
            $amazonSubCategory->size_tier_type = $request->size_tier_type;
            $amazonSubCategory->shipping_weight = $request->shipping_weight;
            $amazonSubCategory->fba_fee = $request->fba_fee;
            $amazonSubCategory->save();
            Toastr::success('Amazon Sub Category Added Successfully', 'Success');
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
                'amazon_category_id' => 'required',
                'name' => 'required',
                'referral_fee' => 'required',
                'size_tier_type' => 'required',
                'shipping_weight' => 'required',
                'fba_fee' => 'required',
                'status' => 'required',
            ]);
            $amazonSubCategory = AmazonSubCategory::find($id);
            $amazonSubCategory->amazon_category_id = $request->amazon_category_id;
            $amazonSubCategory->name = $request->name;
            $amazonSubCategory->referral_fee = $request->referral_fee;
            $amazonSubCategory->size_tier_type = $request->size_tier_type;
            $amazonSubCategory->shipping_weight = $request->shipping_weight;
            $amazonSubCategory->fba_fee = $request->fba_fee;
            $amazonSubCategory->status = $request->status;
            $amazonSubCategory->save();
            Toastr::success('Amazon Sub Category Updated Successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $amazonSubCategory = AmazonSubCategory::find($id);
            $amazonSubCategory->delete();
            Toastr::success('Amazon Sub Category Deleted Successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
}
