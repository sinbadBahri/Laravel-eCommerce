<?php

namespace App\Http\Controllers\Admin\Widgets;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Widgets\CategoryWidget;
use App\Models\Widgets\PostWidget;
use App\Models\Widgets\ProductWidget;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CategoryWidgetController extends Controller
{
    /**
     * Retrieves all CategoryWidget instances and displays them in the Admin-Panel.
     *
     * @return View The view displaying all category widgets.
     */
    public function index(): View
    {
        $categoryWidgets = CategoryWidget::all();

        return view(
            view: 'admin.widget.allCategoryWidgets',
            data: compact('categoryWidgets'),
        );
    }

    /**
     * Edit Form of a specific CategoryWidget instance.
     *
     * Retrieves the specified category widget by ID to populate the edit form.
     *
     * @param int $widget_id The ID of the category widget to edit.
     * @return View The view for editing the category widget with the fetched data.
     */
    public function edit(int $widget_id): View
    {
        $content = [
            'allCategories'  => Category::all(),
            'categoryWidget' => CategoryWidget::find($widget_id),
        ];

        return view(view: 'admin.forms.categoryWidgetEditForm', data: $content);
    }

    /**
     * Updates a a specific CategoryWidget instance based on the provided request and widget ID.
     *
     * @param Request $request The request containing the updated information
     * @param int $widget_id The ID of the category widget to update
     * @return RedirectResponse A redirection response after updating the category widget
     */
    public function update(Request $request, int $widget_id): RedirectResponse
    {
        $categoryWidget = CategoryWidget::find($widget_id);

        $credentials = $this->getCredentialsFromRequest($request);
        $categoryWidget->update($credentials);

        $this->syncCategoriesToWidget($request, $categoryWidget);

        return $this->redirectBack();
    }

    /**
     * Gets credentials from the request data.
     *
     * Prepares the necessarily credentials from the request data for updating
     * a PostWidget or a CategoryWidget instance.
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
    * Syncs Categpry instances to a specific CategoryWidget.
    *
    * First checks if there is categories in the request data, then syncs them
    * to the given PostWidget instance.
    *
    * @param Request $request The HTTP request containing the categories data.
    * @param CategoryWidget $categoryWidget The CategoryWidget to sync the categories to.
    * @return void
    */
   private function syncCategoriesToWidget(
       Request $request, CategoryWidget $categoryWidget
   ): void
   {
       if ($request->has('categories'))
       {
           $categoryWidget->categories()->sync($request->categories);
           $categoryWidget->save();
       }
   }

   /**
    * Redirects back to the widget management page after updating a widget.
    *
    * @return RedirectResponse
    */
   private function redirectBack(): RedirectResponse
   {
       return redirect('/admin-panel/widget-management/category-widgets')
       ->with('success', 'Widget Updated.');
   }
}
