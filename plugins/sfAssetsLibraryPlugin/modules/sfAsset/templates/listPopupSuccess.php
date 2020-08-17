
        <div id="container">
        
            <div class="frame" style="float: left; width: 940px;">
                <div class="frame_container">
        
                    <div class="frame_header">
                        <div class="frame_left">
                            <div class="frame_right"></div>
                        </div>

                    </div>

                    <div class="frame_content">
                        

                        
        <?php use_stylesheet('/sf/sf_admin/css/main') ?>
        <?php use_helper('I18N')?>
        
        <h1><?php echo __('Asset Library', null, 'sfAsset') ?></h1>
        
        <?php if (!$popup) : ?>
          <?php include_partial('list_header', array('folder' => $folder)) ?>
        <?php endif; ?>
        
        <div id="sf_asset_bar">
          <p><?php echo $folder->getName() ?></p>
          <?php if ($nb_dirs || $nb_files): ?>
            <?php if ($nb_dirs): ?>
              <p><?php echo format_number_choice('[1]Jeden katalog|(1,+Inf) Liczba katalogów: %nb%', array('%nb%' => $nb_dirs), $nb_dirs, 'sfAsset') ?></p>
            <?php endif; ?>
            <?php if ($nb_files): ?>
              <p><?php echo format_number_choice('[1]Jeden plik, %weight% Kb|(1,+Inf]plików: %nb% , %weight% Kb', array('%nb%' => $nb_files, '%weight%' => $total_size), $nb_files, 'sfAsset') ?></p>
            <?php endif; ?>
          <?php endif; ?>
          <?php include_partial('sfAsset/sidebar_sort') ?>
          <?php include_partial('sfAsset/sidebar_search') ?>
          <?php include_partial('sfAsset/sidebar_list', array('folder' => $folder, 'parent_folder' => $parent_folder)) ?>
        </div>
        
        <div id="sf_asset_container">
          <?php include_partial('sfAsset/messages') ?>
          <?php include_partial('sfAsset/list', array(
            'folder' => $folder,
            'dirs'   => $dirs,
            'files'  => $files
          )) ?>
        </div>
        
        <?php if (!$popup) : ?>
          <?php include_partial('sfAsset/list_footer', array('folder' => $folder)) ?>
        <?php endif; ?>

    </div>
                    <br class="st_clear_all" />
                    <div class="frame_footer">
                        <div class="frame_left">
                            <div class="frame_right"></div>
                        </div>                
                    </div>            
                </div>  
            </div> 
        </div>
 