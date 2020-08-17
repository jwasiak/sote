<?php
$fields = array();
$defaults = array();

$c = new Criteria();
$c->addAscendingOrderByColumn(ExportFieldPeer::NAME);
$c->add(ExportFieldPeer::MODEL, $sf_request->getParameter('model'));

foreach (ExportFieldPeer::doSelect($c) as $field)
{
    $fields[$field->getId()] = array('id' => $field->getId(), 'name' => $field->getProfileName());
}

if ($sf_request->getMethod() == sfRequest::POST && $sf_request->getParameter('export_profile_fields'))
{
    $checked = $sf_request->getParameter('export_profile_fields');
}

if ($sf_request->hasErrors()) 
{           
    $parameters = $sf_request->getParameter("export_profile_fields");
    $defaults = stJQueryToolsHelper::parseTokensFromRequest($parameters);
}
else
{
    $c = new Criteria();
    $c->addSelectColumn(ExportProfileHasExportFieldPeer::EXPORT_FIELD_ID);
    $c->add(ExportProfileHasExportFieldPeer::EXPORT_PROFILE_ID, $export_profile->getId());
    $rs = ExportProfileHasExportFieldPeer::doSelectRS($c);

    while($rs->next())
    {
        list($id) = $rs->getRow();

        if (isset($fields[$id]))
        {
            $defaults[] = $fields[$id];
        }
    }
}



echo st_tokenizer_input_tag("export_profile_fields", array_values($fields), $defaults, array('tokenizer' => array('preventDuplicates' => true, 'hintText' => __('Wpisz szukane pole'))));