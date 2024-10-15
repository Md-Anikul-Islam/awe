<?php

namespace App\Http\Controllers;

use App\Models\AmazonCategory;
use App\Models\AmazonSubCategory;
use Illuminate\Http\Request;

class CalculationController extends Controller
{
    public function index()
    {
        $amazonCategory =  AmazonCategory::latest()->get();
        return view('calculation',compact('amazonCategory'));
    }

    public function getAmazonSubCategories($id)
    {
        $amazonSubCategory = AmazonSubCategory::where('amazon_category_id', $id)->get();
        return response()->json($amazonSubCategory);
    }

    public function calculationResult(Request $request)
    {
        // Retrieve the incoming request data
        $data = $request->all();

        // Extract data from the request
        $retailPrice = $data['retail_price'];
        $costPrice = $data['cost_price'];
        $length = $data['length'];
        $width = $data['width'];
        $height = $data['height'];
        $weight = $data['weight'];

        // Fetch the subcategory to get referral fees and FBA fees
        $subCategory = AmazonSubCategory::find($data['amazon_sub_category_id']);
        // Calculate the referral fee (percentage of retail price)
        $referralFee = $retailPrice * ($subCategory->referral_fee / 100);

        // Fetch the FBA fulfillment fee from the subcategory model
        $fulfillmentFee = $subCategory->fba_fee;

        // Total Amazon fees
        $totalAmazonFees = $referralFee + $fulfillmentFee;

        // Gross Profit
        $grossProfit = $retailPrice - $costPrice - $totalAmazonFees;


        // Net Profit (same as gross profit unless there are other deductions)
        $netProfit = $grossProfit;

        // Net Margin (percentage)
        $netMargin = ($netProfit / $retailPrice) * 100;

        // Return or output the results
        return response()->json([
            'referral_fee' => $referralFee,
            'fulfillment_fee' => $fulfillmentFee,
            'total_amazon_fees' => $totalAmazonFees,
            'gross_profit' => $grossProfit,
            'net_profit' => $netProfit,
            'net_margin' => $netMargin,
        ]);
    }

}
