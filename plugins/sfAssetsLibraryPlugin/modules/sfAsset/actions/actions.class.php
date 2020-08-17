<?php

require_once(sfConfig::get('sf_plugins_dir'). '/sfAssetsLibraryPlugin/modules/sfAsset/lib/BasesfAssetActions.class.php');

class sfAssetActions extends BasesfAssetActions
{   
    public function executeList()
    {
        // pobranie parametrow odnosnie katalogów
        $tokens = split("/", $this->getRequest()->getUri());

        $flag = false;
        $path = "";
        foreach($tokens as $token)
        {
            if (! $flag && $token != "media")
            {

                continue;
            }
            $flag = true;
            $path .= "/".$token;
        }
        
        if($path == "")
        {
            
            $path = "media";
        }

        $folder = sfAssetFolderPeer::retrieveByPath($path);

        $this->parent_folder = $path;
        
        
        
        if(!$folder)
        {

            if ($this->getFlash('sfAsset_folder_not_found'))
            {
                throw new sfException('You must create a root folder. Use the `php symfony sfassetlibrary-create-root` command for that.');
            }
            else
            {
                if ($popup = $this->getRequestParameter('popup'))
                {
                    $this->getUser()->setAttribute('popup', $popup, 'sf_admin/sf_asset/navigation');
                }
                $this->setFlash('sfAsset_folder_not_found', true);
                $this->redirect('sfAsset/list');
            }
        }

        $dirs = $folder->getChildren();
        $c = new Criteria();
        $c->add(sfAssetPeer::FOLDER_ID, $folder->getId());
        $this->processSort();
        $sortOrder = $this->getUser()->getAttribute('sort', 'name', 'sf_admin/sf_asset/sort');
        switch($sortOrder)
        {
            case 'date':
                $dirs = sfAssetFolderPeer::sortByDate($dirs);
                $c->addDescendingOrderByColumn(sfAssetPeer::CREATED_AT);
                break;
            default:
                $dirs = sfAssetFolderPeer::sortByName($dirs);
                $c->addAscendingOrderByColumn(sfAssetPeer::FILENAME);
                break;
        }
        $this->files = sfAssetPeer::doSelect($c);
        $this->nb_files = count($this->files);
        if($this->nb_files)
        {
            $total_size = 0;
            foreach ($this->files as $file)
            {
                $total_size += $file->getFilesize();
            }
            $this->total_size = $total_size;
        }
        $this->dirs = $dirs;
        $this->nb_dirs = count($dirs);
        $this->folder = $folder;

        $this->removeLayoutIfPopup();

        return sfView::SUCCESS;
    }  
    
    public function executeAddQuick()
    { 
        $folder = sfAssetFolderPeer::retrieveByPath($this->getRequestParameter('parent_folder'));

        $this->forward404Unless($folder);
        try
        {
            $asset = new sfAsset();
            $asset->setsfAssetFolder($folder);
            $asset->setDescription($this->getRequest()->getFileName('new_file'));
            try
            {
                $asset->setAuthor($this->getUser()->getUsername());
            }
            catch(sfException $e)
            {
                // no getUsername() method in sfUser, all right: do nothing
            }
            $asset->setFilename($this->getRequest()->getFileName('new_file'));
            $asset->create($this->getRequest()->getFilePath('new_file'));
            $asset->save();
        }
        catch(sfAssetException $e)
        {
            $this->setFlash('warning_message', $e->getMessage());
            $this->setFlash('warning_params', $e->getMessageParams());
            $this->redirectToPath('sfAsset/list?dir='.$folder->getRelativePath());
        }

        if($this->getUser()->hasAttribute('popup', 'sf_admin/sf_asset/navigation'))
        {
            if($this->getUser()->getAttribute('popup', null, 'sf_admin/sf_asset/navigation') == 1)
            {
                $this->redirect('sfAsset/tinyConfigMedia?id='.$asset->getId());
            }
            else
            {
                $this->redirectToPath('sfAsset/list?dir='.$folder->getRelativePath());
            }
        }
        $this->redirectToPath('sfAsset/list?dir='.$folder->getRelativePath());
        //$this->redirect('sfAsset/edit?id='.$asset->getId());
    }
    
    public function executeEdit()
    {
        $this->sf_asset = $this->getsfAssetOrCreate();

        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $this->updatesfAssetFromRequest();

            $this->sf_asset->save();

            $this->setFlash('notice', 'Twoje zmiany zostały zapisane.');

            return $this->redirect('sfAsset/edit?id='.$this->sf_asset->getId());
        }
    }
    
    public function executeMoveAsset()
    {
        $this->forward404Unless($this->getRequest()->getMethod() == sfRequest::POST);
        $sf_asset = sfAssetPeer::retrieveByPk($this->getRequestParameter('id'));
        $this->forward404Unless($sf_asset);
        $folder = sfAssetFolderPeer::retrieveByPath($this->getRequestParameter('new_folder'));
        $this->forward404Unless($folder);
        if ($folder->getId() != $sf_asset->getFolderId())
        {
            try
            {
                $sf_asset->move($folder);
                $sf_asset->save();
                $this->setFlash('notice', 'Plik został przeniesiony');
            }
            catch(sfAssetException $e)
            {
                $this->setFlash('warning_message', $e->getMessage());
                $this->setFlash('warning_params', $e->getMessageParams());
            }
        }
        else
        {
            $this->setFlash('warning', 'Katalog docelowy jest identyczny z katalogiem, w którym znajduje się plik. Plik nie został przeniesiony.');
        }

        return $this->redirect('sfAsset/edit?id='.$sf_asset->getId());
    } 
}