<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ViewDataScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        if(Auth::user()->view_data == '2'){
            return $builder->whereIn($model['table'].'.input_by', function ($queryIn) {
                    $queryIn->select('id')
                        ->from('users')
                        ->where('satuan_kerja_id', Auth::user()->satuan_kerja_id);
                });
        }else if(Auth::user()->view_data == '3'){
            return $builder->whereIn($model['table'].'.input_by', function ($queryIn) {
                    $queryIn->select('id')
                        ->from('users')
                        ->where('sub_satuan_kerja_id', Auth::user()->sub_satuan_kerja_id);
                });
        }else if(Auth::user()->view_data == '4'){
            return $builder->whereIn($model['table'].'.input_by', function ($queryIn) {
                    $queryIn->select('id')
                        ->from('users')
                        ->where('id', Auth::user()->id);
                });
        }
    }
}
