<?php

class stPaczkomaty {
    public static function isActive() {
        return stConfig::getInstance('stPaczkomatyBackend')->get('enabled', false);
    }

    public static function digestPassword($password) {
        $version = phpversion();
        if ($version[0] < 5)
            return base64_encode(pack('H*', md5($password)));
        else
            return base64_encode(md5($password, true));
    }

    public static function convertStatus($status) {
        $i18n = sfContext::getInstance()->getI18n();

        switch ($status) {
            case 'Created': return $i18n->__('Oczekuje na wysyłkę', array(), 'stPaczkomatyBackend');
            case 'Prepared': return $i18n->__('Gotowa do wysyłki', array(), 'stPaczkomatyBackend');
            case 'Sent': return $i18n->__('Przesyłka nadana', array(), 'stPaczkomatyBackend');
            case 'InTransit': return $i18n->__('Przesyłka w drodze', array(), 'stPaczkomatyBackend');
            case 'Stored': return $i18n->__('Oczekuje na odbiór', array(), 'stPaczkomatyBackend');
            case 'Avizo': return $i18n->__('Ponowne awizo', array(), 'stPaczkomatyBackend');
            case 'CustomerDelivering': return $i18n->__('Nadawana w paczkomacie', array(), 'stPaczkomatyBackend');
            case 'CustomerStored': return $i18n->__('Umieszczona przez klienta', array(), 'stPaczkomatyBackend');
            case 'LabelExpired': return $i18n->__('Etykieta przeterminowana', array(), 'stPaczkomatyBackend');
            case 'Expired': return $i18n->__('Nie odebrana', array(), 'stPaczkomatyBackend');
            case 'Delivered': return $i18n->__('Dostarczona', array(), 'stPaczkomatyBackend');
            case 'RetunedToAgency': return $i18n->__('Przekazana do oddziału', array(), 'stPaczkomatyBackend');
            case 'Cancelled': return $i18n->__('Anulowana', array(), 'stPaczkomatyBackend');
            case 'Claimed': return $i18n->__('Przyjęto zgłoszenie reklamacyjne', array(), 'stPaczkomatyBackend');
            case 'ClaimProcessed': return $i18n->__('Rozpatrzono zgłoszenie reklamacyjne', array(), 'stPaczkomatyBackend');
        }
    }
}
