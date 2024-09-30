<?php

namespace App\Http\Controllers\Admin\Widgets;

use App\Models\ProductLine;
use App\Models\Widgets\ProductWidget;
use Illuminate\Http\Request;

class ProductWidgetController extends BaseWidgetController
{
    protected function getWidgetModel()
    {
        return ProductWidget::class;
    }

    protected function getWidgetEditViewName(): string
    {
        return 'admin.forms.productWidgetEditForm';
    }

    protected function getWidgetIndexViewName(): string
    {
        return 'admin.widget.allProductWidgets';
    }

    protected function getRelatedModels(): array
    {
        return ['allProductLines' => ProductLine::all()];
    }

    protected function syncModelsToWidget(Request $request, $widget): void
    {
        if ($request->has('products')) {
            $widget->products()->sync($request->products);
            $widget->save();
        }
    }

    protected function getRedirectRouteName(): string
    {
        return 'productWidget.all';
    }
}
