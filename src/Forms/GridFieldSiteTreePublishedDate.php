<?php

namespace SilverStripe\Lumberjack\Forms;

use SilverStripe\Core\Injector\Injectable;
use SilverStripe\Forms\GridField\GridField_ColumnProvider;

/**
 * Provides a component to the {@link GridField} which shows the publish status of a page.
 *
 * @package silverstripe
 * @subpackage lumberjack
 *
 * @author Michael Strong <mstrong@silverstripe.org>
**/
class GridFieldSiteTreePublishedDate implements GridField_ColumnProvider
{
    use Injectable;

    public function augmentColumns($gridField, &$columns)
    {
        // Ensure Actions always appears as the last column.        
        $columns = array_merge($columns, array(
            'LastEdited'
        ));
    }

    public function getColumnsHandled($gridField)
    {
        return array('LastEdited');
    }

    public function getColumnContent($gridField, $record, $columnName)
    {
        if ($columnName == 'LastEdited') {
            if ($record->hasMethod('isPublished')) {
                $modifiedLabel = '';
                if ($record->isModifiedOnDraft()) {
                    $modifiedLabel = '<span class="modified">' . _t(__CLASS__ . '.Modified', 'Modified') . '</span>';
                }

                $published = $record->isPublished();
                
                if (!$published) {
                    return $record->dbObject('LastEdited')->Nice();
                } else {
                    return $record->dbObject('LastEdited')->Nice();
                }                
            }
        } 
    }

    public function getColumnAttributes($gridField, $record, $columnName)
    {       
        return array();
    }

    public function getColumnMetaData($gridField, $columnName)
    {
        switch ($columnName) {
            case 'LastEdited':
                return array('title' => _t(__CLASS__ . '.StateTitle', 'Last Modifed Date', 'Column title for Modifed'));
            default:
                break;
        }
    }
}
