<?php

namespace App\Http\Controllers\Admin\Widgets;

use App\Models\Category;
use App\Models\Widgets\CategoryWidget;
use Illuminate\Http\Request;

class CategoryWidgetController extends BaseWidgetController
{
    protected function getWidgetModel()
    {
        return CategoryWidget::class;
    }

    protected function getWidgetEditViewName(): string
    {
        return 'admin.forms.categoryWidgetEditForm';
    }

    protected function getWidgetIndexViewName(): string
    {
        return 'admin.widget.allCategoryWidgets';
    }

    protected function getRelatedModels(): array
    {
        return ['allCategories' => Category::all()];
    }

    protected function syncModelsToWidget(Request $request, $widget): void
    {
        if ($request->has('categories')) {
            $widget->categories()->sync($request->categories);
            $widget->save();
        }
    }

    protected function getRedirectRouteName(): string
    {
        return 'categoryWidget.all';
    }
}
