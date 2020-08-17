<?php
/** 
 * SOTESHOP/stAttributeTemplatePlugin 
 * 
 * Ten plik należy do aplikacji stAttributeTemplatePlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stAttributeTemplatePlugin
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id$
 * @author      Daniel Mendalka <daniel.mendalka@sote.pl>
 */

/** 
 * Akcje modułu stAttributeTemplateBackendBackend
 *
 * @author Marcin Butlak <marcin.butlak@sote.pl>
 *
 * @package     stAttributeTemplatePlugin
 * @subpackage  actions
 */
class stAttributeFieldBackendActions extends autostAttributeFieldBackendActions
{
    /** 
     * Dodaje atrybut
     */
    public function executeAddAttribute()
    {
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $template_id = $this->getRequestParameter('id');
            $template = AttributeTemplatePeer::retrieveByPK($template_id);
            $attribute_template = $this->getRequestParameter('attribute_template');
            $attribute_field = new AttributeField();
            $attribute_field->setName($attribute_template['name']);
            $attribute_field->setAttributeTemplateId($template_id);
            $attribute_field->setRank($template->countAttributeFields()+1);
            $attribute_field->save();
            $this->setFlash('notice', 'Atrybut został dodany');
        }

        $this->redirect('stAttributeFieldBackend/edit?id='.$template_id);
    }
    
    /** 
     * Przechwytuje bląd walidacji.
     *
     * @return   sfView::SUCCESS
     */
    public function handleErrorAddAttribute()
    {  
        $this->preExecute();
        $this->attribute_template = $this->getAttributeTemplateOrCreate();
        $this->updateAttributeTemplateFromRequest();    
        $this->labels = $this->getLabels();           
        
        return sfView::SUCCESS;
    }

    /** 
     * Usuwa atrybut
     */
    public function executeDeleteAttribute()
    {
        $id = $this->getRequestParameter('id');
        $template_id = $this->getRequestParameter('template_id');

        if (AttributeFieldPeer::doDelete($id))
        {
            $this->setFlash('notice', 'Atrybut został usunięty');
        }

        $this->redirect('stAttributeFieldBackend/edit?id='.$template_id);
    }

    /** 
     * Edycja ajaxow'a atrybutu - zmiana nazwy
     *
     * @return   unknown
     */
    public function executeAjaxEditAttribute()
    {
        $id = $this->getRequestParameter('id');
        $value = $this->getRequestParameter('value');

        $attribute_field = AttributeFieldPeer::retrieveByPK($id);
        $renderedText = "";

        if($this->validateAjaxEditAttributes($value))
        {
            if (!empty($value))
            {
                $attribute_field->setName($value);
                $attribute_field->save();
                $renderedText .= $this->getPresentationFor("stAttributeFieldBackend", "validationAjaxTrue");
            }
        }
        else 
        { 
            $renderedText .= $this->getPresentationFor("stAttributeFieldBackend", "validationAjaxFalse");
        }
        $renderedText = $this->renderText($renderedText.$attribute_field->getName());
        
        
        return $renderedText;
    }
    
    /** 
     * Walidacja ajax
     */
    public function executeValidationAjaxTrue()
    {
        $this->id = $this->getRequestParameter('id');        
    }
    
    /** 
     * Walidacja ajax
     */
    public function executeValidationAjaxFalse()
    { 
        $this->id = $this->getRequestParameter('id');  
    }
    
    /** 
     * Sprawdza czy nazwa atrybutu nie jest pustym ciągiem lub nie jest za długa.
     *
     * @param   string      $value              wprowadzona wartość  
     * @return  bool        zwraca true w razie powodzenia walidacji
     */
    public function validateAjaxEditAttributes($value)
    {
        $validationStatus = true;
        if (strlen($value) <= 0)
        {
            $validationStatus = false;
        }
        else if(strlen($value) >= 30)
        {
            $validationStatus = false;
        }
        
        return $validationStatus;
    }

    /** 
     * Zmiana sortowania atrybutu - rekord zmienia swoją pozycję na wyższą
     */
    public function executeAttributeMoveUp()
    {
        $id = $this->getRequestParameter('id');
        $template_id = $this->getRequestParameter('template_id');
        /** 
         */
        $attribute_field = AttributeFieldPeer::retrieveByPK($id);
        $attribute_field->moveUp();
        $attribute_field->save();

        $this->redirect('stAttributeFieldBackend/edit?id='.$template_id);

    }

    /** 
     * Zmiana sortowania atrybutu - rekord zmienia swoją pozycję na niższą
     */
    public function executeAttributeMoveDown()
    {
        $id = $this->getRequestParameter('id');
        $template_id = $this->getRequestParameter('template_id');
        /** 
         */
        $attribute_field = AttributeFieldPeer::retrieveByPK($id);
        $attribute_field->moveDown();
        $attribute_field->save();

        $this->redirect('stAttributeFieldBackend/edit?id='.$template_id);
    }
}