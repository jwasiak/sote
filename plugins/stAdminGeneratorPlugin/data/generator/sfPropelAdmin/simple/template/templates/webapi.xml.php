<?php echo '<?xml version="1.0" encoding="UTF-8"?>' ?>
<?php
    $ArrayOfInteger = null;
    $ArrayOfString = null;
    $ArrayOfDouble = null;
    $customTypes = $this->getParameterValue('webapi.types', array());
?>
<definitions name="StWebApi" targetNamespace="urn:StWebApi"
    xmlns:typens="urn:StWebApi"
    xmlns:wsdl="http://schemas.xmlsoap.org/wsdl/"
    xmlns:xsd="http://www.w3.org/2001/XMLSchema"
    xmlns:soap="http://schemas.xmlsoap.org/wsdl/soap/"
    xmlns:soapenc="http://schemas.xmlsoap.org/soap/encoding/"
    xmlns="http://schemas.xmlsoap.org/wsdl/">
<types>
<xsd:schema xmlns="http://www.w3.org/2001/XMLSchema"
    targetNamespace="urn:StWebApi">
    <import namespace="http://schemas.xmlsoap.org/soap/encoding/" />
    <?php $webApiFields = $this->getParameterValue('webapi.fields'); 
        $webApiFields['_delete']['type'] = "integer";
        $webApiFields['_offset']['type'] = "integer";
        $webApiFields['_limit']['type'] = "integer";
        $webApiFields['_count']['type'] = "integer";
        $webApiFields['_update']['type'] = "integer";
        $webApiFields['created_at']['type'] = "dateTime";
        $webApiFields['updated_at']['type'] = "dateTime";
        $webApiFields['_modified_from']['type'] = "dateTime";
        $webApiFields['_modified_to']['type'] = "dateTime";
        $webApiFields['_session_hash']['type'] = "string";
        $webApiFields['_culture']['type'] = "string";
        ?>

    <?php foreach ($this->getParameterValue('webapi.methods') as $methodName => $method): ?>
    <xsd:complexType name="<?php echo $methodName ?>">
        <xsd:all>
        <?php $inFields = $this->getParameterValue('webapi.methods.'.$methodName.'.fields.in', array()) ?>
        <?php
            if ($this->getParameterValue('webapi.methods.'.$methodName.'.culture') !== false)
            {
                $inFields = array_merge(array('_culture'), $inFields);
            } 
            if ($this->getParameterValue('webapi.methods.'.$methodName.'.secure') !== false)
            {   
                $inFields = array_merge(array('=_session_hash'), $inFields); 
            }
        ?>
        <?php if (is_array($this->getParameterValue('webapi.methods.'.$methodName.'.custom_fields'))): 
            $webApiFields_custom = array_merge($webApiFields, $this->getParameterValue('webapi.methods.'.$methodName.'.custom_fields')); ?>
        <?php else: $webApiFields_custom= $webApiFields; endif;?>
        <?php foreach ($inFields as $field): $field_name = str_replace("=","",$field) ?>
            <xsd:element name="<?php echo $field_name ?>"
                type="<?php 
                    $type = $webApiFields_custom[$field_name]['type'];
                    $type = ($type{0} == strtolower($type{0}) ? 'xsd:' : 'typens:').$type;
                    if ($type == 'typens:ArrayOfInteger')
                    {
                        $ArrayOfInteger = true;
                    }
                    elseif ($type == 'typens:ArrayOfString')
                    {
                        $ArrayOfString = true;
                    }
                    elseif ($type == 'typens:ArrayOfDouble')
                    {
                        $ArrayOfDouble = true;
                    }
                    echo $type;
                    ?>" minOccurs="<?php echo intval($field{0} == '=') ?>"></xsd:element>
                <?php endforeach; ?>
        </xsd:all>
    </xsd:complexType>

    <?php if ($this->getParameterValue('webapi.methods.'.$methodName.'.inOutTypes.in')=="array"): ?>
    <xsd:complexType name="ArrayOf<?php echo $methodName ?>">
        <xsd:complexContent>
            <xsd:restriction base="soapenc:Array">
                <xsd:attribute ref="soapenc:arrayType"
                    wsdl:arrayType="typens:<?php echo $methodName ?>[]" />
            </xsd:restriction>
        </xsd:complexContent>
    </xsd:complexType>
    <?php endif; ?>

    <xsd:complexType name="<?php echo $methodName ?>Response">
        <xsd:all>
        <?php if (is_array($this->getParameterValue('webapi.methods.'.$methodName.'.fields.out'))): ?>
        <?php if (is_array($this->getParameterValue('webapi.methods.'.$methodName.'.custom_fields'))): 
            $webApiFields_custom = array_merge($webApiFields, $this->getParameterValue('webapi.methods.'.$methodName.'.custom_fields')); ?>
        <?php else: $webApiFields_custom= $webApiFields; endif;?>
        <?php foreach ($this->getParameterValue('webapi.methods.'.$methodName.'.fields.out') as $field): $field_name = str_replace("=","",$field) ?>
            <xsd:element name="<?php echo $field_name ?>"
                type="<?php 
                    $type = $webApiFields_custom[$field_name]['type'];
                    $type = ($type{0} == strtolower($type{0}) ? 'xsd:' : 'typens:').$type;
                    if ($type == 'typens:ArrayOfInteger')
                    {
                        $ArrayOfInteger = true;
                    }
                    elseif ($type == 'typens:ArrayOfString')
                    {
                        $ArrayOfString = true;
                    }
                    elseif ($type == 'typens:ArrayOfDouble')
                    {
                        $ArrayOfDouble = true;
                    }
                    echo $type;
                    ?>" minOccurs="0"></xsd:element>
                <?php endforeach; ?>
       <?php endif; ?>
        </xsd:all>
    </xsd:complexType>

    <?php if ($this->getParameterValue('webapi.methods.'.$methodName.'.inOutTypes.out')=="array"): ?>
    <xsd:complexType name="ArrayOf<?php echo $methodName ?>Response">
        <xsd:complexContent>
            <xsd:restriction base="soapenc:Array">
                <xsd:attribute ref="soapenc:arrayType"
                    wsdl:arrayType="typens:<?php echo $methodName ?>Response[]" />
            </xsd:restriction>
        </xsd:complexContent>
    </xsd:complexType>
    <?php endif; ?>

    <?php endforeach; ?>

    <?php foreach ($customTypes as $name => $type): ?>
        <xsd:complexType name="<?php echo $name ?>">
            <?php if (isset($type['arrayType']) && $type['arrayType']): $type_prefix = isset($customTypes[$type['arrayType']]) ? 'typens' : 'xsd' ?>
                <xsd:complexContent>
                    <xsd:restriction base="soapenc:Array">
                        <xsd:attribute ref="soapenc:arrayType"
                            wsdl:arrayType="<?php echo $type_prefix ?>:<?php echo $type['arrayType'] ?>[]" />
                    </xsd:restriction>
                </xsd:complexContent>
            <?php else: ?>
                <xsd:all>
                    <?php foreach ($type['fields'] as $fieldName => $field): $type_prefix = isset($customTypes[$field['type']]) ? 'typens' : 'xsd' ?>
                        <xsd:element type="<?php echo $type_prefix ?>:<?php echo $field['type'] ?>" name="<?php echo $fieldName ?>" minOccurs="<?php echo intval(isset($field['required']) && $field['required']) ?>" />
                    <?php endforeach ?>
                </xsd:all>
            <?php endif ?>
        </xsd:complexType>
    <?php endforeach ?>

    <?php if ($ArrayOfInteger): ?>
        <xsd:complexType name="ArrayOfInteger">
            <xsd:complexContent>
                <xsd:restriction base="soapenc:Array">
                    <xsd:attribute ref="soapenc:arrayType"
                        wsdl:arrayType="xsd:integer[]" />
                </xsd:restriction>
            </xsd:complexContent>
        </xsd:complexType> 
    <?php endif; ?> 

    <?php if ($ArrayOfString): ?>
        <xsd:complexType name="ArrayOfString">
            <xsd:complexContent>
                <xsd:restriction base="soapenc:Array">
                    <xsd:attribute ref="soapenc:arrayType"
                        wsdl:arrayType="xsd:string[]" />
                </xsd:restriction>
            </xsd:complexContent>
        </xsd:complexType>   
    <?php endif; ?> 

    <?php if ($ArrayOfDouble): ?>    
        <xsd:complexType name="ArrayOfDouble">
            <xsd:complexContent>
                <xsd:restriction base="soapenc:Array">
                    <xsd:attribute ref="soapenc:arrayType"
                        wsdl:arrayType="xsd:double[]" />
                </xsd:restriction>
            </xsd:complexContent>
        </xsd:complexType>
    <?php endif; ?>
</xsd:schema>
</types>
    <?php foreach ($this->getParameterValue('webapi.methods') as $methodName => $method): ?>
    <?php if ($this->getParameterValue('webapi.methods.'.$methodName.'.inOutTypes.in')=="array"): ?>
<message name="<?php echo $methodName ?>">
<part name="<?php echo $methodName ?>"
    type="typens:ArrayOf<?php echo $methodName ?>" />

</message>
    <?php endif; ?>
    <?php if ($this->getParameterValue('webapi.methods.'.$methodName.'.inOutTypes.in')=="object"): ?>
<message name="<?php echo $methodName ?>">
<part name="<?php echo $methodName ?>"
    type="typens:<?php echo $methodName ?>" />

</message>
    <?php endif; ?>

    <?php if ($this->getParameterValue('webapi.methods.'.$methodName.'.inOutTypes.out')=="array"): ?>
<message name="<?php echo $methodName ?>Response">
<part name="<?php echo $methodName ?>Response"
    type="typens:ArrayOf<?php echo $methodName ?>Response" />

</message>
    <?php endif; ?>
    <?php if ($this->getParameterValue('webapi.methods.'.$methodName.'.inOutTypes.out')=="object"): ?>
<message name="<?php echo $methodName ?>Response">
<part name="<?php echo $methodName ?>Response"
    type="typens:<?php echo $methodName ?>Response" />

</message>
    <?php endif; ?>
    <?php endforeach; ?>

<wsdl:portType name="<?php echo $this->getModuleName(); ?>PortType">
<?php foreach ($this->getParameterValue('webapi.methods') as $methodName => $method): ?>
    <operation name="<?php echo $methodName ?>">
    <documentation><?php echo $methodName ?></documentation>
    <?php if ($this->getParameterValue('webapi.methods.'.$methodName.'.inOutTypes.in')): ?>
    <input message="typens:<?php echo $methodName ?>"></input>
    <?php endif; ?>
    <?php if ($this->getParameterValue('webapi.methods.'.$methodName.'.inOutTypes.out')): ?>
    <output message="typens:<?php echo $methodName ?>Response"></output>
    <?php endif; ?>
    </operation>
    <?php endforeach; ?>

</wsdl:portType>
<binding name="StWebApiBinding" type="typens:<?php echo $this->getModuleName(); ?>PortType">

<soap:binding style="rpc"
    transport="http://schemas.xmlsoap.org/soap/http" />
<?php foreach ($this->getParameterValue('webapi.methods') as $methodName => $method): ?>
<operation name="<?php echo $methodName ?>">
<soap:operation soapAction="urn:StWebApiSoapServer" />
<input>
<soap:body use="encoded" namespace="urn:StWebApi"
    encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
</input>
<output>
<soap:body use="encoded" namespace="urn:StWebApi"
    encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
</output>
</operation>
<?php endforeach; ?>
</binding>

<service name="StWebApiSoapServer">
<port name="<?php echo $this->getModuleName(); ?>PortType" binding="typens:StWebApiBinding">
<soap:address
    location="http<?php $config = stConfig::getInstance('stWebApiBackend'); if ($config->get('ssl', false)) echo 's';?>://<?php $webRequest = new sfWebRequest(); echo $webRequest->getHost(); ?>/backend.php/<?php echo $this->getModuleName(); ?>/soap" />
</port>
</service>

</definitions>
