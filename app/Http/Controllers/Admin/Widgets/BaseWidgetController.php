<?php

namespace App\Http\Controllers\Admin\Widgets;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Base class for managing various widget controllers in the Admin-Panel.
 * This abstract class defines common methods for listing, editing, and updating widget instances.
 */
abstract class BaseWidgetController extends Controller
{
    /**
     * Gets the model class associated with the widget.
     * Each specific widget controller should implement this to return the correct model.
     *
     * @return string The widget model class name.
     */
    abstract protected function getWidgetModel();

    /**
     * Gets the name of the view for editing a widget.
     * Each specific widget controller should implement this to return the correct view.
     *
     * @return string The name of the edit view.
     */
    abstract protected function getWidgetEditViewName(): string;

    /**
     * Gets the name of the view for listing widgets.
     * Each specific widget controller should implement this to return the correct index view.
     *
     * @return string The name of the index view.
     */
    abstract protected function getWidgetIndexViewName(): string;

    /**
     * Gets the related models to be passed to the view during editing.
     * Each specific widget controller should implement this to return the related models.
     *
     * @return array An array of related models.
     */
    abstract protected function getRelatedModels(): array;

    /**
     * Synchronizes related models with the widget after it's updated.
     * Each specific widget controller should implement this to define how related models are synchronized.
     *
     * @param Request $request The HTTP request instance.
     * @param mixed $widget The widget instance being updated.
     */
    abstract protected function syncModelsToWidget(Request $request, $widget): void;

    /**
     * Gets the route name for redirecting after the widget is updated.
     * Each specific widget controller should implement this to return the correct route name.
     *
     * @return string The route name for redirection.
     */
    abstract protected function getRedirectRouteName(): string;

    /**
     * Displays a listing of all widget instances.
     *
     * @return View The view displaying the widget list.
     */
    public function index(): View
    {
        $widgets = $this->getWidgetModel()::all();
        return view($this->getWidgetIndexViewName(), compact('widgets'));
    }

    /**
     * Shows the form for editing a specific widget instance.
     *
     * @param int $widget_id The ID of the widget to edit.
     * @return View The view displaying the widget edit form.
     */
    public function edit(int $widget_id): View
    {
        $content = array_merge(
            $this->getRelatedModels(),
            ['widget' => $this->getWidgetModel()::find($widget_id)]
        );

        return view($this->getWidgetEditViewName(), $content);
    }

    /**
     * Updates the specified widget in storage.
     *
     * @param Request $request The HTTP request containing widget data.
     * @param int $widget_id The ID of the widget to update.
     * @return RedirectResponse A redirect response after updating the widget.
     */
    public function update(Request $request, int $widget_id): RedirectResponse
    {
        $widget = $this->getWidgetModel()::find($widget_id);

        $credentials = $this->getCredentialsFromRequest($request);
        $widget->update($credentials);

        $this->syncModelsToWidget($request, $widget);

        return $this->redirectBack();
    }

    /**
     * Extracts the relevant credentials from the request for updating the widget.
     *
     * Widget controllers cannot override this method.
     *
     * @param Request $request The HTTP request instance.
     * @return array The extracted credentials for updating the widget.
     */
    final protected function getCredentialsFromRequest(Request $request): array
    {
        return [
            'title'     => $request->title,
            'is_active' => $request->is_active == "on" ? true : false,
        ];
    }

    /**
     * Redirect back to the appropriate widget management page after updating the widget.
     * Uses the route name provided by the specific widget controller.
     *
     * Widget controllers cannot override this method.
     *
     * @return RedirectResponse A redirect response to the appropriate widget management page.
     */
    final protected function redirectBack(): RedirectResponse
    {
        return redirect()->route($this->getRedirectRouteName())
            ->with('success', 'Widget Updated.');
    }
}
