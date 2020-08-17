<?php

class stCheckTheme {

    public static function check() {
        $config = sfYaml::load(sfConfig::get('sf_root_dir').'/config/databases.yml');
        $c = $config['all']['propel']['param'];

        try {
            $pdo = new PDO('mysql:dbname='.$c['database'].';host='.$c['host'], $c['username'], $c['password']);

            $sth = $pdo->prepare('SELECT COUNT(`id`) as `count` FROM `st_theme` WHERE `active` = 1 AND (`version` < 2 OR `version` IS NULL);');
            $sth->execute();
            $result = $sth->fetch(PDO::FETCH_ASSOC);

            if(isset($result['count']))
                return !(int) $result['count'];
            else
                return false;
        } catch (PDOException $e) {
            return -1;
        }
        return -2;
    }
}
