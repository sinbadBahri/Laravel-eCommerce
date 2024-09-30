<?php

namespace App\Support\Attribute;

use App\Models\AttributeValue;
use App\Models\ProductLine;
use Illuminate\Support\Collection;


class ProductAttributeService
{
    public function getRelatedAttributes(int $productLineId)
    {
        $productType = $this->getProductTypeFromProductLine($productLineId);

        return $productType->attributes;
    }
    /**
     * Update or create attribute values for a product line.
     */
    public function updateAttributeValuesForProductLine(ProductLine $productLine, Collection $attributes): void
    {
        foreach ($attributes as $attributeId => $value) {
            if ($value === '-no value-') {
                // Skip attributes marked as no value
                continue;
            }

            $this->updateOrCreateAttributeValue($attributeId, $value, $productLine);
        }
    }

    /**
     * Update an existing AttributeValue or create a new one and attach it to the ProductLine.
     */
    private function updateOrCreateAttributeValue(int $attributeId, string $value, ProductLine $productLine): void
    {
        $attributeValue = $this->findAttributeValueForProductLine($attributeId, $productLine);

        if ($attributeValue) {
            $this->updateExistingAttributeValue($attributeValue, $value);
        } else {
            $this->createAndAttachNewAttributeValue($attributeId, $value, $productLine);
        }
    }

    /**
     * Find the AttributeValue for a given ProductLine and attribute.
     */
    private function findAttributeValueForProductLine(int $attributeId, ProductLine $productLine): ?AttributeValue
    {
        return AttributeValue::where('attribute_id', $attributeId)
            ->whereHas('productLines', function ($query) use ($productLine) {
                $query->where('product_line_id', $productLine->id);
            })->first();
    }

    /**
     * Update the existing AttributeValue with a new value.
     */
    private function updateExistingAttributeValue(AttributeValue $attributeValue, string $value): void
    {
        $attributeValue->update(['value' => $value]);
    }

    /**
     * Create a new AttributeValue and attach it to the ProductLine.
     */
    private function createAndAttachNewAttributeValue(int $attributeId, string $value, ProductLine $productLine): void
    {
        $newAttributeValue = AttributeValue::create([
            'attribute_id' => $attributeId,
            'value' => $value,
        ]);

        $productLine->attributeValues()->attach($newAttributeValue->id);
    }

    private function getProductTypeFromProductLine(int $productLineId)
    {
        $productLine = $this->getProductLine($productLineId);
        return $productLine->getProductType();
    }

    private function getProductLine(int $productLineId): ProductLine
    {
        return ProductLine::findOrFail($productLineId);
    }
}
