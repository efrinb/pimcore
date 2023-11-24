<?php

namespace AdminConfBundle\Command;

use Carbon\Carbon;
use League\Csv\Reader;
use Pimcore\Model\Asset;
use Pimcore\Model\DataObject;
use Pimcore\Model\DataObject\ClassDefinition\Data\ManyToOneRelation;
use Pimcore\Model\DataObject\Csvclass;
use Symfony\Component\Console\Command\Command;
use Pimcore\Model\Element\ValidationException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Pimcore\Model\DataObject\ClassDefinition\Data\Input;

class ImportCsv extends Command
{
    protected static $defaultName = 'app:create-dataObject';

    protected function configure(): void
    {
        $this->setDescription('Create or update product objects from a CSV file');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $csvPath = 'bundles/AdminConfBundle/public/csv/product.csv';
        $processedProducts = [];
        $parentCategory = DataObject::getById(1);

        if (!$parentCategory) {
            $output->writeln('Parent product category not found.');
            return Command::FAILURE;
        }

        try {
            $csv = Reader::createFromPath($csvPath)->setHeaderOffset(0);
        } catch (\Exception $e) {
            $output->writeln('An error occurred: ' . $e->getMessage());
            return Command::FAILURE;
        }

        foreach ($csv->getRecords() as $record) {
            try {
                $productObject = Csvclass::getByPath('/' . $record['key']) ?? new Csvclass();
                $productObject->setKey($record['key']);
                $productObject->setParent($parentCategory);

                foreach ($record as $fieldType => $fieldValue) {
                    if ($fieldType === 'key') {
                        continue;
                    }
                    $data = $this->handleField($fieldType, $fieldValue, $productObject, $output);
                    $productObject->setValues($data);
                }

                $productObject->save();
                $processedProducts[] = $productObject->getKey();
            } catch (\Exception $e) {
                $output->writeln("Error processing product '{$record['key']}': " . $e->getMessage());
            }
        }

        $this->outputProcessedProducts($processedProducts, $output);

        return Command::SUCCESS;
    }

/*    private function handleField(string $fieldType, $fieldValue, Csvclass $productObject, OutputInterface $output): array
    {
        $data = [];
        try {
            $fieldDefinition = $productObject->getClass()->getFieldDefinition($fieldType);

            if ($fieldDefinition instanceof Input) {

                $data[$fieldType] = $this->handleInputField($fieldValue);

            } elseif ($fieldDefinition instanceof DataObject\ClassDefinition\Data\Textarea) {

                $data[$fieldType] = $this->handleTextareaField($fieldValue);

            } elseif ($fieldDefinition instanceof DataObject\ClassDefinition\Data\Wysiwyg) {

                $data[$fieldType] = $this->handleWysiwygField($fieldValue);

            } elseif ($fieldDefinition instanceof DataObject\ClassDefinition\Data\Numeric) {

                $data[$fieldType] = $this->handleNumericField($fieldValue);

            } elseif ($fieldDefinition instanceof DataObject\ClassDefinition\Data\manyToOneRelation) {

                $data[$fieldType] = $this->handleManyToOneRelation($fieldValue);

            } elseif ($fieldDefinition instanceof DataObject\ClassDefinition\Data\country) {

                $data[$fieldType] = $this->handleCountryField($fieldValue);

            } elseif ($fieldDefinition instanceof DataObject\ClassDefinition\Data\date) {

                $data[$fieldType] = $this->handleDateField($fieldValue);

            } elseif ($fieldDefinition instanceof DataObject\ClassDefinition\Data\Select) {

                $data[$fieldType] = $this->handleSelectField($fieldValue);

            } elseif ($fieldDefinition instanceof DataObject\ClassDefinition\Data\MultiSelect) {

                $data[$fieldType] = $this->handleMultiSelectField($fieldValue);

            } elseif ($fieldDefinition instanceof DataObject\ClassDefinition\Data\BooleanSelect) {
                $data[$fieldType] = $this->handleBooleanSelectField($fieldValue);

            } elseif ($fieldDefinition instanceof DataObject\ClassDefinition\Data\Image) {

                $data[$fieldType] = $this->handleImageField($fieldValue);

            } elseif ($fieldDefinition instanceof DataObject\ClassDefinition\Data\ImageGallery) {

                $data[$fieldType] = $this->handleImageGalleryField($fieldValue);
            }

        }catch (\Exception $e){
            $output->writeln("Error handling field '{$fieldType}': " . $e->getMessage());
        }
        return $data;
    }*/


    private function handleField(string $fieldType, $fieldValue, Csvclass $productObject, OutputInterface $output): array
    {
        $data = [];

        $fieldDefinition = $productObject->getClass()->getFieldDefinition($fieldType);

        switch (true) {
            case $fieldDefinition instanceof Input:
                $data[$fieldType] = $this->handleInputField($fieldValue);
                break;
            case $fieldDefinition instanceof DataObject\ClassDefinition\Data\Textarea:
                $data[$fieldType] = $this->handleTextareaField($fieldValue);
                break;
            case $fieldDefinition instanceof DataObject\ClassDefinition\Data\Wysiwyg:
                $data[$fieldType] = $this->handleWysiwygField($fieldValue);
                break;
            case $fieldDefinition instanceof DataObject\ClassDefinition\Data\Numeric:
                $data[$fieldType] = $this->handleNumericField($fieldValue);
                break;
            case $fieldDefinition instanceof DataObject\ClassDefinition\Data\manyToOneRelation:
                $data[$fieldType] = $this->handleManyToOneRelation($fieldValue);
                break;
            case $fieldDefinition instanceof DataObject\ClassDefinition\Data\country:
                $data[$fieldType] = $this->handleCountryField($fieldValue);
                break;
            case $fieldDefinition instanceof DataObject\ClassDefinition\Data\date:
                $data[$fieldType] = $this->handleDateField($fieldValue);
                break;
            case $fieldDefinition instanceof DataObject\ClassDefinition\Data\Select:
                $data[$fieldType] = $this->handleSelectField($fieldValue);
                break;
            case $fieldDefinition instanceof DataObject\ClassDefinition\Data\MultiSelect:
                $data[$fieldType] = $this->handleMultiSelectField($fieldValue);
                break;
            case $fieldDefinition instanceof DataObject\ClassDefinition\Data\ManyToManyObjectRelation:
                $data[$fieldType] = $this->handleManyToManyObjectRelation($fieldValue);
                break;
            case $fieldDefinition instanceof DataObject\ClassDefinition\Data\Image:
                $data[$fieldType] = $this->handleImageField($fieldValue);
                break;
            case $fieldDefinition instanceof DataObject\ClassDefinition\Data\Objectbricks:
                $data[$fieldType] = $this->handleBrick($fieldValue);
                break;
            default:
                $output->writeln("Unhandled field type: '{$fieldType}'");
        }

        return $data;
    }



    protected function handleInputField(string $fieldValue): string
    {
        return trim($fieldValue);
    }

    protected function handleTextareaField(string $fieldValue): string
    {
        return trim($fieldValue);
    }

    protected function handleWysiwygField(string $fieldValue): string
    {
        return trim($fieldValue);
    }

    protected function handleNumericField(string $fieldValue): string
    {
        return trim($fieldValue);
    }

    protected function handleDateField(string $fieldValue): ?\Carbon\Carbon
    {
        $fieldValue = trim($fieldValue);

        if (empty($fieldValue)) {
            return null;
        }

        // Assuming $fieldValue is a valid date format (modify as needed)
        $carbon = Carbon::createFromFormat("Y-m-d", $fieldValue);

        if (!$carbon instanceof Carbon) {
            throw new \Exception("Invalid date format given. It should be in the format 'Y-m-d' but given value is '$fieldValue'");
        }

        return $carbon;
    }


    protected function handleSelectField(string $fieldValue): string
    {
        return trim($fieldValue);
    }

    protected function handleMultiSelectField(string $fieldValue): array
    {
        // Assuming $fieldValue is a comma-separated string
        $elements = explode(",", $fieldValue);

        return array_map('trim', $elements);
    }

    protected function handleCountryField(string $fieldValue): string
    {
        $value = trim($fieldValue);
        return ucwords($value);
    }

    protected function handleImageField(string $fieldValue)
    {
        // Assuming $fieldValue is a valid image path (modify as needed)
        $asset = Asset::getByPath($fieldValue);

        if (!$asset instanceof Asset\Image) {
            throw new \Exception("No image found at the path '$fieldValue'");
        }

        return $asset;
    }

    private function handleManyToManyObjectRelation(string $fieldValue) {
        $value = trim($fieldValue);

        if (empty($value)) {
            return [];
        }

        $paths = explode(",", $value);
        $obejcts = [];

        foreach ($paths as $path) {
            $path = trim($path);
            $object = DataObject::getByPath($path);

            if (!$object instanceof DataObject\AbstractObject) {
                throw new ValidationException("No object found at the path='{$path}'");
            }

            $obejcts[] = $object;
        }

        return $obejcts;
    }

    private function handleManyToOneRelation(string $fieldValue) {
        $fieldValue = trim($fieldValue);

        if (empty($fieldValue)) {
            return [];
        }

        if (strpos($fieldValue, 'asset:') !== false) {
            throw new \Exception("Asset not supported. Currently only object is supported for 'ManyToOneRelation'");
        }

        if (strpos($fieldValue, 'document:') !== false) {
            throw new \Exception("Document not supported. Currently only object is supported for 'ManyToOneRelation'");
        }

        $path = $fieldValue;

        if (strpos($path, 'object:') !== false) {
            $path = str_replace("object:", "", $path);
        }

        $object = DataObject::getByPath($path);

        if (!$object instanceof DataObject\AbstractObject) {
            throw new ValidationException("No object found at the path='{$path}'");
        }

        return $object;
    }

    private function handleBrick(string $fieldValue)
    {
        $fieldValue = trim($fieldValue);
        var_dump($fieldValue);
    }

    private function outputProcessedProducts(array $processedProducts, OutputInterface $output): void
    {
        if (!empty($processedProducts)) {
            $count = count($processedProducts);
            $output->writeln("$count Products for '{$processedProducts[0]}' created or updated successfully.");
        } else {
            $output->writeln("No products were processed.");
        }
    }
}
