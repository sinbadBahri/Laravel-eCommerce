<?php

namespace App\Http\Controllers\Admin\Widgets;

use App\Models\Blog\Comment;
use App\Models\Widgets\CommentWidget;
use Illuminate\Http\Request;

class CommentWidgetController extends BaseWidgetController
{
    protected function getWidgetModel(): string
    {
        return CommentWidget::class;
    }

    protected function getWidgetEditViewName(): string
    {
        return 'admin.forms.commentWidgetEditForm';
    }

    protected function getWidgetIndexViewName(): string
    {
        return 'admin.widget.allCommentWidgets';
    }

    protected function getRelatedModels(): array
    {
        $comments = Comment::all();
        return compact('comments');
    }

    protected function syncModelsToWidget(Request $request, $widget): void
    {
        if ($request->has('comments')) {
            $widget->comments()->sync($request->comments);
            $widget->save();
        }
    }

    protected function getRedirectRouteName(): string
    {
        return 'commentWidget.all';
    }

}
