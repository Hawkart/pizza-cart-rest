<?php

namespace App\Models;

use App\Acme\Helpers\MoneyHelper;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Product extends Model
{
    use Sluggable;

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'image',
        'description',
        'in_stock',
        'price',
        'currency'
    ];

    /**
     * @param $val
     * @return string|\Torann\Currency\Currency
     */
    public function getPriceAttribute($val)
    {
        $currency = MoneyHelper::getCurrentCurrency();
        $val = MoneyHelper::convertCentsToDollar($val);
        return currency($val, $this->currency,  $currency, false);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category() {
        return $this->belongsTo(Category::class);
    }

    /**
     * @param $query
     * @param $request
     * @return mixed
     */
    public function scopeSearch($query, $request)
    {
        if(!empty($request['id']))
        {
            if(is_array($request['id']))
                $query->whereIn('id', $request['id']);
            else
                $query->where('id', (int)$request['id']);
        }

        return $query;
    }
}
