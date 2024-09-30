<?php

namespace App\Http\Controllers\Admin\Widgets;

use App\Models\Blog\Post;
use App\Models\Widgets\PostWidget;
use Illuminate\Http\Request;

class PostWidgetController extends BaseWidgetController
{
    protected function getWidgetModel(): string
    {
        return PostWidget::class;
    }

    protected function getWidgetEditViewName(): string
    {
        return 'admin.forms.postWidgetEditForm';
    }

    protected function getWidgetIndexViewName(): string
    {
        return 'admin.widget.allPostWidgets';
    }

    protected function getRelatedModels(): array
    {
        $posts = Post::all();
        return compact('posts');
    }

    protected function syncModelsToWidget(Request $request, $widget): void
    {
        $postIds = $request->input('posts', []);
        $widget->posts()->sync($postIds);
        $widget->save();
    }

    protected function getRedirectRouteName(): string
    {
        return 'postWidget.all';
    }
}
