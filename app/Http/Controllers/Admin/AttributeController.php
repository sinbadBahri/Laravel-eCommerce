<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

class AttributeController extends Controller
{

    public function index(): View
    {
        $attributes = Attribute::all();
        return view(view: 'admin.product.attributes', data: compact('attributes'));
    }

    /**
     * Stores a new Attribute instance with the provided request data.
     *
     * @param Request $request The request containing the attribute data.
     * @return JsonResponse JSON response indicating the success status & a message.
     */
    public function store(Request $request): JsonResponse
    {
        $this->makeOrUpdateAttribute(request: $request);

        return $this->respondWithSuccess("New Attribute Added");
    }

    /**
     * Validates the request data and creates or updates a Attribute instance.
     *
     * Note that this method could be called when either a Attribute instance is getting created or updated,
     * therefore when the $attribute_id is null probably the update method is calling this method.
     *
     * @param Request $request
     * @param int|null $attribute_id The ID of the Attribute to update, or null if creating a new Attribute.
     * @return Attribute The updated or newly created Attribute instance.
     */
    private function makeOrUpdateAttribute(Request $request, int $attribute_id = null): Attribute
    {
        $this->validateAttribute(request: $request);

        $attributeData = $this->prepareAttributeData(request: $request);

        $attribute = Attribute::updateOrCreate(
            ['id' => $attribute_id], $attributeData
        );

        return $attribute;
    }

    /**
     * Validates the Attribute request data.
     *
     * @param Request $request The HTTP request containing the attribute data.
     * @return void
     */
    private function validateAttribute(Request $request): void
    {
        $request->validate([

            'title'       => 'required|string|max:255',
            'description' => 'required|string|max:600',

        ]);
    }

    /**
     * Prepares the Attribute data for database storage.
     *
     * This method collects the validated request input and organizes it into an array ready for
     * storing in the database.
     *
     * @param Request $request The HTTP request containing the attribute data.
     * @return array An associative array of attribute data to be used for creating a record.
     */
    private function prepareAttributeData(Request $request): array
    {
        return [
            'title'       => $request->title,
            'description' => $request->description,
        ];
    }

    /**
     * Returns a JSON response indicating success.
     *
     * This method provides a uniform way to respond to successful operations.
     *
     * @param string $message  The error message to be included in the response.
     * @return JsonResponse A JSON response with a success message.
     */
    private function respondWithSuccess(string $message): JsonResponse
    {
        return response()->json(['success' => true, 'message' => $message]);
    }
}
