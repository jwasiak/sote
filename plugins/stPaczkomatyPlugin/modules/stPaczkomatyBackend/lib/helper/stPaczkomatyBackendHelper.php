<?php

function st_inpost_organization_select_tag($name, $value, array $params = array())
{
    $api = stInPostApi::getInstance();

    $organizations = sfContext::getInstance()->getRequest()->getParameter('organizations', null, 'soteshop/stInPostApi');

    if (null === $organizations)
    {
        try
        {
            $organizations = $api->getOrganizations();
        }
        catch(stInPostApiException $e)
        {
        }
    }

    if ($organizations)
    {
        foreach ($organizations->items as $organization)
        {
            $options[$organization->id] = $organization->name;
        }
    }
    else
    {
        $options = array();
    }

    return select_tag($name, options_for_select($options, $value), $params);
}

function st_inpost_sending_method_select_tag($name, $value, array $params = array())
{
    $api = stInPostApi::getInstance();

    $service = null;

    if (isset($params['service']))
    {
        $service = $params['service'];
        unset($params['service']);
    }

    $target = null;

    if (isset($params['target']))
    {
        $target = $params['target'];
    }

    $options = array();

    try
    {
        $options = $api->getSendingMethods($service);
    }
    catch (stInPostApiException $e)
    {
    }

    if ($target)
    {
        $id = get_id_from_name($name);
        $content =<<<HTML
        <script>
            jQuery(function($) {
                \$('#$id').change(function() {
                    var select = \$(this);
                    
                    if (select.val() == 'parcel_locker') {
                        $('$target').show();
                    } else {
                        $('$target').hide();
                    }
                }).change();
            });
        </script>
HTML;
    }

    return select_tag($name, options_for_select($options, $value, array('include_custom' => __('Wybierz'))), $params).$content;
}

function st_inpost_point_select_tag($name, $value, array $params = array())
{
    static $init = false;

    $config = stConfig::getInstance('stPaczkomatyBackend');

    $api = stInPostApi::getInstance();

    $i18n = sfContext::getInstance()->getI18N();

    $label = $i18n->__('Wybierz punkt');

    $id = get_id_from_name($name);

    $title = isset($params['title']) ? __($params['title']) : __('Wybierz punkt');

    $disabled = isset($params['disabled']) && $params['disabled'];

    $js = '';
    $trigger  = '';

    if (!$disabled)
    {
        if (!$init)
        {
            $easypackWidgetUrl = st_url_for('@stPaczkomatyPlugin?action=easypackWidget&sandbox=' . $api->isSandbox());
            $js =<<<HTML
                <div id="inpost-easypack-modal" class="popup_window" style="width: 800px">
                    <div class="close"><img src="/images/backend/beta/gadgets/close.png" alt="" /></div>
                    <h2></h2>
                    <div class="content"></div>
                </div>
            
                <script>
                    jQuery(function($) {
                        $('.inpost-easypack-widget').overlay({
                            closeOnClick: false,
                            closeOnEsc: false,
                            top: "5%", 
                            speed: 'fast',
                            oneInstance: true,
                            fixed: false,

                            mask: {
                                color: '#444',
                                loadSpeed: 'fast',
                                opacity: 0.5,
                                zIndex: 30000
                            }, 

                            target: '#inpost-easypack-modal',
                            onClose: function() {
                                
                            },
                            onBeforeLoad: function() {
                                var api = this;
                                var content = this.getOverlay().children('.content');
                                var title = this.getOverlay().children('h2');
                                var overlay = this.getOverlay();

                                var scope = this.getTrigger().data('related')


                                title.html(this.getTrigger().data('title'));
                                content.html('<iframe src="$easypackWidgetUrl?scope='+scope+'" style="width: 100%; height: 536px; border: none;"></iframe>');

                                
                                overlay.css("top", Math.max(28, $(window).scrollTop() + 28) + "px");
                                overlay.css("left", Math.max(0, (($(window).width() - overlay.outerWidth()) / 2) + 
                                                                $(window).scrollLeft()) + "px");              
                            },
                            onLoad: function() {
                                var overlay = this.getOverlay();
                        
                                overlay.css("top", Math.max(28, $(window).scrollTop() + 28) + "px");
                                overlay.css("left", Math.max(0, (($(window).width() - overlay.outerWidth()) / 2) + 
                                                                $(window).scrollLeft()) + "px");
                            }
                        });
                    });

                    /*
                    window.easyPackAsyncInit = function () {
                        var defaults = {
                            defaultLocale: 'pl',
                            apiEndpoint: '',
                            mapType: 'osm',
                            searchType: 'osm',
                            display: {
                                showTypesFilters: false 
                            },
                            points: {
                                types: ['parcel_locker', 'pop']
                            },
                            map: {
                                initialTypes: ['parcel_locker', 'pop']
                            }
                        }
                        
                        jQuery(function($) {
                            easyPack.init(defaults);
                            var link = null;
                            var map = null;
                            $('.inpost-easypack-widget').click(function() {
                                link = $(this);

                                if (link.data('selected')) {
                                    map.searchLockerPoint(link.data('selected'));
                                }
                            
                                map = easyPack.modalMap(function(point, modal) {
                                    var scope = '#' + link.data('related');
                                    $(scope + '_label').html(point.name + '<p>' + point.address.line1 + ', ' + point.address.line2 + '</p>');
                                    link.data('selected', point.name);
                                    $(scope).val(point.name);
                                    modal.closeModal();
                                }, { width: 500, height: 600 });

                                return false;
                            });

                        });
                    };
                    */
                </script>
HTML;
        }
        
        $trigger = '<a href="#" id="'.$id.'_trigger" class="inpost-easypack-widget" data-title="'. $title .'" data-related="' . $id . '">' . $label . '</a>';
        $init = true;
    }

    $selected = '';

    if ($value) 
    {
        try
        {
            $point = $api->getPoint($value);

            $selected = $point->name . '<p>' . $point->address->line1 . ', ' . $point->address->line2 . '</p>';
        }
        catch(stInPostApiException $e)
        {
        }
    }

    return input_hidden_tag($name, $value) . '<div id="' . $id . '_label">' . $selected . '</div>' . $trigger . $js;
}