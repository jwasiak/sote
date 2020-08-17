<?php use_helper('stUpdate');?>
<?php use_stylesheet('/css/update/stInstallerWebPlugin.css?version=1');?>
<?php use_stylesheet('/css/update/stWebStorePlugin.css?version=1');?>
<?php echo get_partial('stInstallerWeb/menu_top');?>
<div id="frame_update">   
    <?php echo get_partial('stInstallerWeb/menu_home', array('selected' => 'webstore'));?>
    <div class="content">
        <div class="content_update_box">
            <h2 class="title">Webstore</h2>

            <?php if (!empty($notice)):?>
                <div style="margin-bottom: 10px; background-color: #73B65A; color: #fff; padding: 5px 20px 5px 10px; font-size: 11px; font-weight: bold"><?php echo __($notice);?></div>
            <?php endif;?>
            <div style="margin-bottom: 10px;"><a href="<?php if($sf_user->getCulture() == 'pl_PL'):?>http://www.sote.pl/category/aplikacje<?php else: ?>http://www.soteshop.com/category/webstore<?php endif;?>" target="_blank"> <?php echo __('Sprawdź nasze dodatkowe aplikacje');?></a></div> 
            <?php if (!empty($applications)):?>
            <h2 class="subhead_txt_module">
                <?php echo __('Zainstalowane dodatkowe aplikacje');?>
            </h2>
            <table cellpadding="0" cellspacing="5" id="applications-list">
                <thead>
                    <tr>
                        <th class="application-icon-th"></th>
                        <th><?php echo __('Nazwa') ?></th>
                        <?php if($sf_user->getCulture() == 'pl_PL'):?>
                            <th><?php echo __('Opis') ?></th>
                        <?php endif;?>
                        <th><?php echo __('Wersja') ?></th>
                        <th></th>
                        
                    </tr>
                </thead>
                <?php foreach ($applications as $name => $params):?>
                    <tr>
                        <td>
                            <?php $imagePath = 'images/backend/main/icons/red/'.$name.'.png';?>
                            <img class="application-icon" src="/<?php echo (is_file($imagePath) ? $imagePath : 'images/update/red/modules/empty.png');?>"/>
                        </td>
                        <td><?php echo link_to($name, 'stWebStore/info?package='.$name);?></td>
                        <?php if($sf_user->getCulture() == 'pl_PL'):?>
                            <td><?php echo $params['description'];?></td>
                        <?php endif;?>
                        <td><?php echo $params['version'];?></td>
                        <td width="180">
                            <div class="right">
                            <?php if ($params['isActive'] == false):
                                echo st_get_update_actions_head();
                                echo st_get_update_action('add', __('Aktywuj'), 'stWebStore/activate?package='.$name, 'post=false');?>
                                <li class="st_admin-action-add" style="margin-left: 5px;">
                                    <div>
                                        <div>
                                            <a id="button_buy" target="_blank" style="background-image: url(/images/update/red/icons/basket.png)" href="<?php echo $params['info']['url'];?>"><?php echo __('Kup');?></a>
                                        </div>
                                    </div>
                                </li>
                            <?php echo st_get_update_actions_foot(); endif; ?>
                            </div>
                        </td>

                    </tr>
               
                <?php endforeach;?>
            </table>
            <?php endif;?>
        </div>
    </div>
    <div class="clear"></div>
</div>
<div class="st_clear_all"></div>