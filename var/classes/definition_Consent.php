<?php

/**
 * Inheritance: no
 * Variants: no
 *
 * Fields Summary:
 * - myconsent [consent]
 * - firstname [firstname]
 * - lastname [lastname]
 * - email [email]
 * - gender [gender]
 * - myrelation [manyToOneRelation]
 * - store [classificationstore]
 */

return \Pimcore\Model\DataObject\ClassDefinition::__set_state(array(
   'dao' => NULL,
   'id' => '5',
   'name' => 'Consent',
   'title' => '',
   'description' => '',
   'creationDate' => NULL,
   'modificationDate' => 1696875479,
   'userOwner' => 2,
   'userModification' => 2,
   'parentClass' => '',
   'implementsInterfaces' => '\\App\\Model\\Employee\\EmployeeDataInterfafce',
   'listingParentClass' => '',
   'useTraits' => '\\App\\Traits\\EmployeeDataTraits',
   'listingUseTraits' => '',
   'encryption' => false,
   'encryptedTables' => 
  array (
  ),
   'allowInherit' => false,
   'allowVariants' => false,
   'showVariants' => false,
   'layoutDefinitions' => 
  \Pimcore\Model\DataObject\ClassDefinition\Layout\Panel::__set_state(array(
     'name' => 'pimcore_root',
     'type' => NULL,
     'region' => NULL,
     'title' => NULL,
     'width' => 0,
     'height' => 0,
     'collapsible' => false,
     'collapsed' => false,
     'bodyStyle' => NULL,
     'datatype' => 'layout',
     'children' => 
    array (
      0 => 
      \Pimcore\Model\DataObject\ClassDefinition\Layout\Tabpanel::__set_state(array(
         'name' => 'Layout',
         'type' => NULL,
         'region' => NULL,
         'title' => '',
         'width' => '',
         'height' => '',
         'collapsible' => false,
         'collapsed' => false,
         'bodyStyle' => '',
         'datatype' => 'layout',
         'children' => 
        array (
          0 => 
          \Pimcore\Model\DataObject\ClassDefinition\Layout\Panel::__set_state(array(
             'name' => 'Layout',
             'type' => NULL,
             'region' => NULL,
             'title' => '',
             'width' => '',
             'height' => '',
             'collapsible' => false,
             'collapsed' => false,
             'bodyStyle' => '',
             'datatype' => 'layout',
             'children' => 
            array (
              0 => 
              \Pimcore\Model\DataObject\ClassDefinition\Data\Consent::__set_state(array(
                 'name' => 'myconsent',
                 'title' => 'Myconsent',
                 'tooltip' => '',
                 'mandatory' => false,
                 'noteditable' => false,
                 'index' => false,
                 'locked' => false,
                 'style' => '',
                 'permissions' => NULL,
                 'fieldtype' => '',
                 'relationType' => false,
                 'invisible' => false,
                 'visibleGridView' => false,
                 'visibleSearch' => false,
                 'blockedVarsForExport' => 
                array (
                ),
                 'defaultValue' => 0,
                 'width' => '',
              )),
              1 => 
              \Pimcore\Model\DataObject\ClassDefinition\Data\Firstname::__set_state(array(
                 'name' => 'firstname',
                 'title' => 'Firstname',
                 'tooltip' => '',
                 'mandatory' => false,
                 'noteditable' => false,
                 'index' => false,
                 'locked' => false,
                 'style' => '',
                 'permissions' => NULL,
                 'fieldtype' => '',
                 'relationType' => false,
                 'invisible' => false,
                 'visibleGridView' => false,
                 'visibleSearch' => false,
                 'blockedVarsForExport' => 
                array (
                ),
                 'defaultValue' => NULL,
                 'columnLength' => 190,
                 'regex' => '',
                 'regexFlags' => 
                array (
                ),
                 'unique' => false,
                 'showCharCount' => false,
                 'width' => '',
                 'defaultValueGenerator' => '',
              )),
              2 => 
              \Pimcore\Model\DataObject\ClassDefinition\Data\Lastname::__set_state(array(
                 'name' => 'lastname',
                 'title' => 'Lastname',
                 'tooltip' => '',
                 'mandatory' => false,
                 'noteditable' => false,
                 'index' => false,
                 'locked' => false,
                 'style' => '',
                 'permissions' => NULL,
                 'fieldtype' => '',
                 'relationType' => false,
                 'invisible' => false,
                 'visibleGridView' => false,
                 'visibleSearch' => false,
                 'blockedVarsForExport' => 
                array (
                ),
                 'defaultValue' => NULL,
                 'columnLength' => 190,
                 'regex' => '',
                 'regexFlags' => 
                array (
                ),
                 'unique' => false,
                 'showCharCount' => false,
                 'width' => '',
                 'defaultValueGenerator' => '',
              )),
              3 => 
              \Pimcore\Model\DataObject\ClassDefinition\Data\Email::__set_state(array(
                 'name' => 'email',
                 'title' => 'Email',
                 'tooltip' => '',
                 'mandatory' => false,
                 'noteditable' => false,
                 'index' => false,
                 'locked' => false,
                 'style' => '',
                 'permissions' => NULL,
                 'fieldtype' => '',
                 'relationType' => false,
                 'invisible' => false,
                 'visibleGridView' => false,
                 'visibleSearch' => false,
                 'blockedVarsForExport' => 
                array (
                ),
                 'defaultValue' => NULL,
                 'columnLength' => 190,
                 'regex' => '',
                 'regexFlags' => 
                array (
                ),
                 'unique' => false,
                 'showCharCount' => false,
                 'width' => '',
                 'defaultValueGenerator' => '',
              )),
              4 => 
              \Pimcore\Model\DataObject\ClassDefinition\Data\Gender::__set_state(array(
                 'name' => 'gender',
                 'title' => 'Gender',
                 'tooltip' => '',
                 'mandatory' => false,
                 'noteditable' => false,
                 'index' => false,
                 'locked' => false,
                 'style' => '',
                 'permissions' => NULL,
                 'fieldtype' => '',
                 'relationType' => false,
                 'invisible' => false,
                 'visibleGridView' => false,
                 'visibleSearch' => false,
                 'blockedVarsForExport' => 
                array (
                ),
                 'options' => NULL,
                 'defaultValue' => NULL,
                 'optionsProviderClass' => NULL,
                 'optionsProviderData' => NULL,
                 'columnLength' => 190,
                 'dynamicOptions' => false,
                 'defaultValueGenerator' => '',
                 'width' => NULL,
              )),
              5 => 
              \Pimcore\Model\DataObject\ClassDefinition\Data\ManyToOneRelation::__set_state(array(
                 'name' => 'myrelation',
                 'title' => 'Myrelation',
                 'tooltip' => '',
                 'mandatory' => false,
                 'noteditable' => false,
                 'index' => false,
                 'locked' => false,
                 'style' => '',
                 'permissions' => NULL,
                 'fieldtype' => '',
                 'relationType' => true,
                 'invisible' => false,
                 'visibleGridView' => false,
                 'visibleSearch' => false,
                 'blockedVarsForExport' => 
                array (
                ),
                 'classes' => 
                array (
                  0 => 
                  array (
                    'classes' => 'myblock',
                  ),
                ),
                 'displayMode' => 'grid',
                 'pathFormatterClass' => '',
                 'assetInlineDownloadAllowed' => false,
                 'assetUploadPath' => '',
                 'allowToClearRelation' => true,
                 'objectsAllowed' => true,
                 'assetsAllowed' => false,
                 'assetTypes' => 
                array (
                ),
                 'documentsAllowed' => false,
                 'documentTypes' => 
                array (
                ),
                 'width' => '',
              )),
              6 => 
              \Pimcore\Model\DataObject\ClassDefinition\Data\Classificationstore::__set_state(array(
                 'name' => 'store',
                 'title' => 'Store',
                 'tooltip' => '',
                 'mandatory' => false,
                 'noteditable' => false,
                 'index' => false,
                 'locked' => false,
                 'style' => '',
                 'permissions' => NULL,
                 'fieldtype' => '',
                 'relationType' => false,
                 'invisible' => false,
                 'visibleGridView' => false,
                 'visibleSearch' => false,
                 'blockedVarsForExport' => 
                array (
                ),
                 'children' => 
                array (
                ),
                 'labelWidth' => 0,
                 'localized' => false,
                 'storeId' => 1,
                 'hideEmptyData' => false,
                 'disallowAddRemove' => false,
                 'referencedFields' => 
                array (
                ),
                 'fieldDefinitionsCache' => NULL,
                 'allowedGroupIds' => 
                array (
                ),
                 'activeGroupDefinitions' => 
                array (
                ),
                 'maxItems' => NULL,
                 'height' => NULL,
                 'width' => NULL,
              )),
              7 => 
              \Pimcore\Model\DataObject\ClassDefinition\Layout\Iframe::__set_state(array(
                 'name' => 'iframe',
                 'type' => NULL,
                 'region' => NULL,
                 'title' => 'Myiframe',
                 'width' => 800,
                 'height' => 400,
                 'collapsible' => false,
                 'collapsed' => false,
                 'bodyStyle' => NULL,
                 'datatype' => 'layout',
                 'children' => 
                array (
                ),
                 'locked' => false,
                 'blockedVarsForExport' => 
                array (
                ),
                 'fieldtype' => 'iframe',
                 'iframeUrl' => '/iframe/summary',
                 'renderingData' => 'sample data',
              )),
              8 => 
              \Pimcore\Model\DataObject\ClassDefinition\Layout\Text::__set_state(array(
                 'name' => 'dynamictext',
                 'type' => NULL,
                 'region' => NULL,
                 'title' => 'Dynamic Text',
                 'width' => 800,
                 'height' => 400,
                 'collapsible' => false,
                 'collapsed' => false,
                 'bodyStyle' => '',
                 'datatype' => 'layout',
                 'children' => 
                array (
                ),
                 'locked' => false,
                 'blockedVarsForExport' => 
                array (
                ),
                 'fieldtype' => 'text',
                 'html' => '',
                 'renderingClass' => 'App\\Helpers\\CustomRenderer',
                 'renderingData' => 'Some Additional Data',
                 'border' => false,
              )),
            ),
             'locked' => false,
             'blockedVarsForExport' => 
            array (
            ),
             'fieldtype' => 'panel',
             'layout' => NULL,
             'border' => false,
             'icon' => '',
             'labelWidth' => 100,
             'labelAlign' => 'left',
          )),
        ),
         'locked' => false,
         'blockedVarsForExport' => 
        array (
        ),
         'fieldtype' => 'tabpanel',
         'border' => false,
         'tabPosition' => 'top',
      )),
    ),
     'locked' => false,
     'blockedVarsForExport' => 
    array (
    ),
     'fieldtype' => 'panel',
     'layout' => NULL,
     'border' => false,
     'icon' => NULL,
     'labelWidth' => 100,
     'labelAlign' => 'left',
  )),
   'icon' => '/bundles/pimcoreadmin/img/flat-color-icons/online_support.svg',
   'group' => '',
   'showAppLoggerTab' => false,
   'linkGeneratorReference' => 'App\\Website\\LinkGenerator\\ConsentLinkGenerator',
   'previewGeneratorReference' => '',
   'compositeIndices' => 
  array (
  ),
   'showFieldLookup' => false,
   'propertyVisibility' => 
  array (
    'grid' => 
    array (
      'id' => true,
      'key' => false,
      'path' => true,
      'published' => true,
      'modificationDate' => true,
      'creationDate' => true,
    ),
    'search' => 
    array (
      'id' => true,
      'key' => false,
      'path' => true,
      'published' => true,
      'modificationDate' => true,
      'creationDate' => true,
    ),
  ),
   'enableGridLocking' => false,
   'deletedDataComponents' => 
  array (
  ),
   'blockedVarsForExport' => 
  array (
  ),
   'fieldDefinitionsCache' => 
  array (
  ),
   'activeDispatchingEvents' => 
  array (
  ),
));
