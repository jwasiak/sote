<?php
class stPositioningUrlGenerator
{
    public static function generate($model, $name, $id, $culture)
    {
        $url = $name;
        $i = 1;
        $c = new Criteria();
        $c->add(constant($model.'I18nPeer::URL'), $url);
        $c->add(constant($model.'I18nPeer::ID'), $id, Criteria::NOT_EQUAL);
        while (call_user_func($model.'Peer::doSelectOne', $c))
        {
            $url = $name.'-'.$i;
            $c->add(constant($model.'I18nPeer::URL'), $url);
            $i++;
        }
        return $url;
    }
}