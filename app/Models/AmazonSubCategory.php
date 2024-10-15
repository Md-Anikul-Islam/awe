<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AmazonSubCategory extends Model
{
    use HasFactory;
    protected $fillable = [
        'amazon_category_id',
        'name',
        'referral_fee',
        'size_tier_type',
        'shipping_weight',
        'fba_fee',
        'status',
    ];

    public function amazonCategory()
    {
        return $this->belongsTo(AmazonCategory::class);
    }
}
