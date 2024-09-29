<?php

namespace App\Http\Controllers\Admin\Widgets;

use App\Http\Controllers\Controller;
use App\Models\Blog\Comment;
use App\Models\Blog\Post;
use App\Models\Widgets\CommentWidget;
use App\Models\Widgets\PostWidget;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;


class BlogWidgetController extends Controller
{

    /**
     * Retrieves all PostWidget and CommentWidget instances.
     *
     * @return View
     */
    public function index(): View
    {
        $content = [

            'postWidgets'    => PostWidget::all(),
            'commentWidgets' => CommentWidget::all(),

        ];

        return view(view: 'admin.widget.allBlogWidgets', data: $content);
    }

    /**
     * Edit Form of a specific PostWidget instance.
     *
     * Retrieves the specified post widget by ID to populate the edit form.
     *
     * @param int $widget_id The ID of the post widget to edit.
     * @return View The view for editing the post widget.
     */
    public function editPostWidget(int $widget_id): View
    {
        $content = [
            'allPosts'   => Post::all(),
            'postWidget' => PostWidget::find($widget_id),
        ];

        return view(view: 'admin.forms.postWidgetEditForm', data: $content);
    }

    /**
     * Updates a specific PostWidget instance based on the provided request and widget ID.
     *
     * @param Request $request The request containing the updated post widget data
     * @param int $widget_id The ID of the post widget to be updated
     * @return RedirectResponse A redirect response after updating the post widget
     */
    public function updatePostWidget(Request $request, int $widget_id): RedirectResponse
    {
        $postWidget = PostWidget::find($widget_id);

        $credentials = $this->getCredentialsFromRequest($request);
        $postWidget->update($credentials);

        $this->syncPostsToWidget($request, $postWidget);

        return $this->redirectBack();
    }

    /**
     * Edit Form of a specific CommentWidget instance.
     *
     * Retrieves the specified comment widget by ID to populate the edit form.
     *
     * @param int $widget_id The ID of the comment widget to edit.
     * @return View The view for editing the comment widget with the fetched data.
     */
    public function editCommentWidget(int $widget_id): View
    {
        $content = [
            'allComments'   => Comment::all(),
            'commentWidget' => CommentWidget::find($widget_id),
        ];

        return view(view: 'admin.forms.commentWidgetEditForm', data: $content);
    }

    /**
     * Updates a a specific CommentWidget instance based on the provided request and widget ID.
     *
     * @param Request $request The request containing the updated information
     * @param int $widget_id The ID of the comment widget to update
     * @return RedirectResponse A redirection response after updating the comment widget
     */
    public function updateCommentWidget(Request $request, int $widget_id): RedirectResponse
    {
        $commentWidget = CommentWidget::find($widget_id);

        $credentials = $this->getCredentialsFromRequest($request);
        $commentWidget->update($credentials);

        $this->syncCommentsToWidget($request, $commentWidget);

        return $this->redirectBack();
    }

    /**
     * Gets credentials from the request data.
     *
     * Prepares the necessarily credentials from the request data for updating
     * a PostWidget or a CommentWidget instance.
     *
     * @param Request $request The request object containing the data.
     * @return array The credentials extracted from the request.
     */
    private function getCredentialsFromRequest(Request $request): array
    {
        return [
            'title'     => $request->title,
            'is_active' => $request->is_active == "on" ? true : false,
        ];
    }

    /**
     * Syncs Post instances to a specific PostWidget.
     *
     * First checks if there is posts in the request data, then syncs them
     * to the given PostWidget instance.
     *
     * @param Request $request The HTTP request containing the posts data.
     * @param PostWidget $postWidget The PostWidget to sync the posts to.
     * @return void
     */
    private function syncPostsToWidget(
        Request $request, PostWidget $postWidget
    ): void
    {
        if ($request->has('posts'))
        {
            $postWidget->posts()->sync($request->posts);
            $postWidget->save();
        }
    }

    /**
     * Syncs Comment instances to a specific CommentWidget.
     *
     * First checks if there is comments in the request data, then syncs them
     * to the given CommentWidget instance.
     *
     * @param Request $request The HTTP request containing the data.
     * @param CommentWidget $commentWidget The comment widget to sync comments with.
     * @return void
     */
    private function syncCommentsToWidget(
        Request $request, CommentWidget $commentWidget
    ): void
    {
        if ($request->has('comments'))
        {
            $commentWidget->comments()->sync($request->comments);
            $commentWidget->save();
        }
    }

    /**
     * Redirects back to the widget management page after updating a widget.
     *
     * @return RedirectResponse
     */
    private function redirectBack(): RedirectResponse
    {
        return redirect('/admin-panel/widget-management/blog-widgets')
        ->with('success', 'Widget Updated.');
    }
}
