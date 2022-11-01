<?php

namespace App\Nova;

use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\FormData;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Category extends Resource
{
    public static $model = \App\Models\Category::class;

    public static $title = 'id';

    public static $search = [
        'id',
    ];

    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),

            Select::make('Type')
                ->options([
                    'TAG' => 'TAG',
                    'PRODUCT' => 'PRODUCT',
                ])
                ->displayUsingLabels()
                ->nullable(),

            Text::make('Name')->required(),

            Currency::make('Price')
                ->dependsOn('type',  fn (Currency $field, $r, FormData $data) => $field->visible = $data->get('type') === 'PRODUCT'),
        ];
    }
}
