<?php
class addShipment {
  /**
   * @var przesylkaType
   */
  public $przesylki;
  /**
   * @var int
   */
  public $idBufor;
}

class addShipmentResponse {
  /**
   * @var addShipmentResponseItemType
   */
  public $retval;
}

class przesylkaType {
  /**
   * @var string
   */
  public $guid;
  /**
   * @var string
   */
  public $pakietGuid;
  /**
   * @var string
   */
  public $opakowanieGuid;
  /**
   * @var string
   */
  public $opis;
}

class pocztexKrajowyType extends przesylkaRejestrowanaType {
  /**
   * @var string
   */
  public $pobranie;
  /**
   * @var odbiorPrzesylkiOdNadawcyType
   */
  public $odbiorPrzesylkiOdNadawcy;
  /**
   * @var doreczenieType
   */
  public $doreczenie;
  /**
   * @var zwrotDokumentowType
   */
  public $zwrotDokumentow;
  /**
   * @var potwierdzenieOdbioruType
   */
  public $potwierdzenieOdbioru;
  /**
   * @var potwierdzenieDoreczeniaType
   */
  public $potwierdzenieDoreczenia;
  /**
   * @var ubezpieczenieType
   */
  public $ubezpieczenie;
  /**
   * @var bool
   */
  public $posteRestante;
  /**
   * @var string
   */
  public $terminRodzaj;
  /**
   * @var bool
   */
  public $kopertaFirmowa;
  /**
   * @var int
   */
  public $masa;
  /**
   * @var int
   */
  public $wartosc;
  /**
   * @var bool
   */
  public $ostroznie;
  /**
   * @var bool
   */
  public $ponadgabaryt;
  /**
   * @var string
   */
  public $uiszczaOplate;
  /**
   * @var int
   */
  public $odleglosc;
  /**
   * @var string
   */
  public $zawartosc;
  /**
   * @var bool
   */
  public $sprawdzenieZawartosciPrzesylkiPrzezOdbiorce;
}

class umowaType {
}

class masaType {
}

class numerNadaniaType {
}

class changePassword {
  /**
   * @var string
   */
  public $newPassword;
}

class changePasswordResponse {
  /**
   * @var errorType
   */
  public $error;
}

class terminRodzajType {
  const MIEJSKI_DO_3H_DO_5KM = 'MIEJSKI_DO_3H_DO_5KM';
  const MIEJSKI_DO_3H_DO_10KM = 'MIEJSKI_DO_3H_DO_10KM';
  const MIEJSKI_DO_3H_DO_15KM = 'MIEJSKI_DO_3H_DO_15KM';
  const MIEJSKI_DO_3H_POWYZEJ_15KM = 'MIEJSKI_DO_3H_POWYZEJ_15KM';
  const MIEJSKI_DO_4H_DO_10KM = 'MIEJSKI_DO_4H_DO_10KM';
  const MIEJSKI_DO_4H_DO_15KM = 'MIEJSKI_DO_4H_DO_15KM';
  const MIEJSKI_DO_4H_DO_20KM = 'MIEJSKI_DO_4H_DO_20KM';
  const MIEJSKI_DO_4H_DO_30KM = 'MIEJSKI_DO_4H_DO_30KM';
  const MIEJSKI_DO_4H_DO_40KM = 'MIEJSKI_DO_4H_DO_40KM';
  const KRAJOWY = 'KRAJOWY';
  const BEZPOSREDNI_DO_20KG = 'BEZPOSREDNI_DO_20KG';
  const BEZPOSREDNI_DO_30KG = 'BEZPOSREDNI_DO_30KG';
  const BEZPOSREDNI_OD_30KG_DO_100KG = 'BEZPOSREDNI_OD_30KG_DO_100KG';
  const EKSPRES24 = 'EKSPRES24';
}

class uiszczaOplateType {
  const NADAWCA = 'NADAWCA';
  const ADRESAT = 'ADRESAT';
}

class wartoscType {
}

class kwotaPobraniaType {
}

class sposobPobraniaType {
  const PRZEKAZ = 'PRZEKAZ';
  const RACHUNEK_BANKOWY = 'RACHUNEK_BANKOWY';
}

class sposobPrzekazaniaType {
  const LIST_ZWYKLY_PRIOTYTET = 'LIST_ZWYKLY_PRIOTYTET';
  const POCZTEX = 'POCZTEX';
}

class sposobDoreczeniaPotwierdzeniaType {
  const TELEFON = 'TELEFON';
  const TELEFAX = 'TELEFAX';
  const SMS = 'SMS';
  const EMAIL = 'EMAIL';
}

class iloscPotwierdzenOdbioruType {
}

class dataDlaDostarczeniaType {
}

class razemType {
}

class nazwaType {
}

class nazwa2Type {
}

class ulicaType {
}

class numerDomuType {
}

class numerLokaluType {
}

class miejscowoscType {
}

class kodPocztowyType {
}

class terminType {
}

class sygnaturaType {
}

class rodzajType {
}

class paczkaPocztowaType extends przesylkaRejestrowanaType {
  /**
   * @var EPOType
   */
  public $epo;
  /**
   * @var string
   */
  public $zasadySpecjalne;
  /**
   * @var bool
   */
  public $posteRestante;
  /**
   * @var int
   */
  public $iloscPotwierdzenOdbioru;
  /**
   * @var string
   */
  public $kategoria;
  /**
   * @var string
   */
  public $gabaryt;
  /**
   * @var int
   */
  public $masa;
  /**
   * @var int
   */
  public $wartosc;
  /**
   * @var bool
   */
  public $zwrotDoslanie;
  /**
   * @var bool
   */
  public $egzemplarzBiblioteczny;
  /**
   * @var bool
   */
  public $dlaOciemnialych;
}

class kategoriaType {
  const EKONOMICZNA = 'EKONOMICZNA';
  const PRIORYTETOWA = 'PRIORYTETOWA';
}

class gabarytType {
  const GABARYT_A = 'GABARYT_A';
  const GABARYT_B = 'GABARYT_B';
}

class paczkaPocztowaPLUSType extends przesylkaRejestrowanaType {
  /**
   * @var bool
   */
  public $posteRestante;
  /**
   * @var int
   */
  public $iloscPotwierdzenOdbioru;
  /**
   * @var string
   */
  public $kategoria;
  /**
   * @var string
   */
  public $gabaryt;
  /**
   * @var int
   */
  public $wartosc;
  /**
   * @var int
   */
  public $masa;
  /**
   * @var bool
   */
  public $zwrotDoslanie;
}

class przesylkaPobraniowaType extends przesylkaRejestrowanaType {
  /**
   * @var string
   */
  public $pobranie;
  /**
   * @var bool
   */
  public $posteRestante;
  /**
   * @var int
   */
  public $iloscPotwierdzenOdbioru;
  /**
   * @var string
   */
  public $kategoria;
  /**
   * @var string
   */
  public $gabaryt;
  /**
   * @var bool
   */
  public $ostroznie;
  /**
   * @var int
   */
  public $wartosc;
  /**
   * @var int
   */
  public $masa;
}

class przesylkaNaWarunkachSzczegolnychType extends przesylkaRejestrowanaType {
  /**
   * @var bool
   */
  public $posteRestante;
  /**
   * @var int
   */
  public $iloscPotwierdzenOdbioru;
  /**
   * @var string
   */
  public $kategoria;
  /**
   * @var int
   */
  public $wartosc;
  /**
   * @var int
   */
  public $masa;
}

class przesylkaPoleconaKrajowaType extends przesylkaRejestrowanaType {
  /**
   * @var EPOType
   */
  public $epo;
  /**
   * @var string
   */
  public $zasadySpecjalne;
  /**
   * @var bool
   */
  public $posteRestante;
  /**
   * @var int
   */
  public $iloscPotwierdzenOdbioru;
  /**
   * @var string
   */
  public $kategoria;
  /**
   * @var string
   */
  public $gabaryt;
  /**
   * @var string
   */
  public $format;
  /**
   * @var int
   */
  public $masa;
  /**
   * @var bool
   */
  public $egzemplarzBiblioteczny;
  /**
   * @var bool
   */
  public $dlaOciemnialych;
  /**
   * @var bool
   */
  public $obszarMiasto;
  /**
   * @var bool
   */
  public $miejscowa;
}

class przesylkaHandlowaType extends przesylkaRejestrowanaType {
  /**
   * @var bool
   */
  public $posteRestante;
  /**
   * @var int
   */
  public $masa;
}

class przesylkaListowaZadeklarowanaWartoscType extends przesylkaRejestrowanaType {
  /**
   * @var bool
   */
  public $posteRestante;
  /**
   * @var int
   */
  public $wartosc;
  /**
   * @var int
   */
  public $iloscPotwierdzenOdbioru;
  /**
   * @var string
   */
  public $kategoria;
  /**
   * @var string
   */
  public $gabaryt;
  /**
   * @var int
   */
  public $masa;
}

class przesylkaFullType {
  /**
   * @var przesylkaShortType
   */
  public $przesylkaShort;
  /**
   * @var przesylkaType
   */
  public $przesylkaFull;
}

class errorType {
  /**
   * @var int
   */
  public $errorNumber;
  /**
   * @var string
   */
  public $errorDesc;
  /**
   * @var string
   */
  public $guid;
}

class adresType {
  /**
   * @var string
   */
  public $nazwa;
  /**
   * @var string
   */
  public $nazwa2;
  /**
   * @var string
   */
  public $ulica;
  /**
   * @var string
   */
  public $numerDomu;
  /**
   * @var string
   */
  public $numerLokalu;
  /**
   * @var string
   */
  public $miejscowosc;
  /**
   * @var string
   */
  public $kodPocztowy;
  /**
   * @var string
   */
  public $kraj;
  /**
   * @var string
   */
  public $telefon;
  /**
   * @var string
   */
  public $email;
  /**
   * @var string
   */
  public $mobile;
  /**
   * @var string
   */
  public $osobaKontaktowa;
  /**
   * @var string
   */
  public $nip;
}

class sendEnvelope {
  /**
   * @var int
   */
  public $urzadNadania;
  /**
   * @var pakietType
   */
  public $pakiet;
  /**
   * @var int
   */
  public $idBufor;
  /**
   * @var profilType
   */
  public $profil;
}

class sendEnvelopeResponseType {
  /**
   * @var int
   */
  public $idEnvelope;
  /**
   * @var string
   */
  public $envelopeStatus;
  /**
   * @var errorType
   */
  public $error;
  /**
   * @var string
   */
  public $envelopeFilename;
}

class urzadNadaniaType {
}

class getUrzedyNadania {
}

class getUrzedyNadaniaResponse {
  /**
   * @var urzadNadaniaFullType
   */
  public $urzedyNadania;
}

class clearEnvelope {
  /**
   * @var int
   */
  public $idBufor;
}

class clearEnvelopeResponse {
  /**
   * @var bool
   */
  public $retval;
  /**
   * @var errorType
   */
  public $error;
}

class urzadNadaniaFullType {
  /**
   * @var int
   */
  public $urzadNadania;
  /**
   * @var string
   */
  public $opis;
  /**
   * @var string
   */
  public $nazwaWydruk;
}

class guidType {
}

class ePrzesylkaType extends przesylkaRejestrowanaType {
  /**
   * @var urzadWydaniaEPrzesylkiType
   */
  public $urzadWydaniaEPrzesylki;
  /**
   * @var string
   */
  public $pobranie;
  /**
   * @var int
   */
  public $masa;
  /**
   * @var string
   */
  public $eSposobPowiadomieniaAdresata;
  /**
   * @var string
   */
  public $eSposobPowiadomieniaNadawcy;
  /**
   * @var string
   */
  public $eKontaktAdresata;
  /**
   * @var string
   */
  public $eKontaktNadawcy;
  /**
   * @var bool
   */
  public $ostroznie;
  /**
   * @var int
   */
  public $wartosc;
}

class eSposobPowiadomieniaType {
  const SMS = 'SMS';
  const EMAIL = 'EMAIL';
}

class eKontaktType {
}

class urzadWydaniaEPrzesylkiType extends placowkaPocztowaType {
}

class pobranieType {
  /**
   * @var string
   */
  public $sposobPobrania;
  /**
   * @var int
   */
  public $kwotaPobrania;
  /**
   * @var anonymous55
   */
  public $nrb;
  /**
   * @var anonymous56
   */
  public $tytulem;
  /**
   * @var bool
   */
  public $sprawdzenieZawartosciPrzesylkiPrzezOdbiorce;
}

class anonymous55 {
}

class anonymous56 {
}

class przesylkaPoleconaZagranicznaType extends przesylkaRejestrowanaType {
  /**
   * @var deklaracjaCelna2Type
   */
  public $deklaracjaCelna2;
  /**
   * @var bool
   */
  public $posteRestante;
  /**
   * @var int
   */
  public $masa;
  /**
   * @var int
   */
  public $iloscPotwierdzenOdbioru;
}

class przesylkaZadeklarowanaWartoscZagranicznaType extends przesylkaRejestrowanaType {
  /**
   * @var deklaracjaCelna2Type
   */
  public $deklaracjaCelna2;
  /**
   * @var bool
   */
  public $posteRestante;
  /**
   * @var int
   */
  public $masa;
  /**
   * @var int
   */
  public $iloscPotwierdzenOdbioru;
  /**
   * @var int
   */
  public $wartosc;
}

class krajType {
}

class getUrzedyWydajaceEPrzesylki {
}

class getUrzedyWydajaceEPrzesylkiResponse {
  /**
   * @var urzadWydaniaEPrzesylkiType
   */
  public $urzadWydaniaEPrzesylki;
}

class uploadIWDContent {
  /**
   * @var int
   */
  public $urzadNadania;
  /**
   * @var string
   */
  public $IWDContent;
}

class getEnvelopeStatus {
  /**
   * @var int
   */
  public $idEnvelope;
}

class getEnvelopeStatusResponse {
  /**
   * @var string
   */
  public $envelopeStatus;
  /**
   * @var errorType
   */
  public $error;
}

class envelopeStatusType {
  const WYSLANY = 'WYSLANY';
  const DOSTARCZONY = 'DOSTARCZONY';
  const PRZYJETY = 'PRZYJETY';
  const WALIDOWANY = 'WALIDOWANY';
  const BLEDNY = 'BLEDNY';
}

class downloadIWDContent {
  /**
   * @var int
   */
  public $idEnvelope;
}

class downloadIWDContentResponse {
  /**
   * @var string
   */
  public $IWDContent;
  /**
   * @var errorType
   */
  public $error;
}

class przesylkaShortType {
  /**
   * @var string
   */
  public $czynnosciUpustowe;
  /**
   * @var string
   */
  public $numerNadania;
  /**
   * @var string
   */
  public $guid;
  /**
   * @var date
   */
  public $dataNadania;
  /**
   * @var int
   */
  public $razem;
  /**
   * @var int
   */
  public $pobranie;
  /**
   * @var string
   */
  public $status;
}

class addShipmentResponseItemType {
  /**
   * @var errorType
   */
  public $error;
  /**
   * @var string
   */
  public $numerNadania;
  /**
   * @var string
   */
  public $guid;
  /**
   * @var string
   */
  public $numerTransakcjiOdbioru;
}

class getKarty {
}

class getKartyResponse {
  /**
   * @var kartaType
   */
  public $karta;
}

class getPasswordExpiredDate {
}

class getPasswordExpiredDateResponse {
  /**
   * @var date
   */
  public $dataWygasniecia;
}

class setAktywnaKarta {
  /**
   * @var int
   */
  public $idKarta;
}

class setAktywnaKartaResponse {
  /**
   * @var errorType
   */
  public $error;
}

class getEnvelopeContentFull {
  /**
   * @var int
   */
  public $idEnvelope;
}

class getEnvelopeContentFullResponse {
  /**
   * @var przesylkaFullType
   */
  public $przesylka;
}

class getEnvelopeContentShort {
  /**
   * @var int
   */
  public $idEnvelope;
}

class getEnvelopeContentShortResponse {
  /**
   * @var przesylkaShortType
   */
  public $przesylka;
}

class hello {
  /**
   * @var string
   */
  public $in;
}

class helloResponse {
  /**
   * @var string
   */
  public $out;
}

class kartaType {
  /**
   * @var int
   */
  public $idKarta;
  /**
   * @var string
   */
  public $opis;
  /**
   * @var bool
   */
  public $aktywna;
}

class telefonType {
}

class getAddressLabel {
  /**
   * @var int
   */
  public $idEnvelope;
}

class getAddressLabelResponse {
  /**
   * @var addressLabelContent
   */
  public $content;
  /**
   * @var errorType
   */
  public $error;
}

class addressLabelContent {
  /**
   * @var string
   */
  public $pdfContent;
  /**
   * @var string
   */
  public $nrNadania;
  /**
   * @var string
   */
  public $guid;
}

class getOutboxBook {
  /**
   * @var int
   */
  public $idEnvelope;
  /**
   * @var bool
   */
  public $includeNierejestrowane;
}

class getOutboxBookResponse {
  /**
   * @var string
   */
  public $pdfContent;
  /**
   * @var errorType
   */
  public $error;
}

class getFirmowaPocztaBook {
  /**
   * @var int
   */
  public $idEnvelope;
}

class getFirmowaPocztaBookResponse {
  /**
   * @var string
   */
  public $pdfContent;
  /**
   * @var errorType
   */
  public $error;
}

class getEnvelopeList {
  /**
   * @var date
   */
  public $startDate;
  /**
   * @var date
   */
  public $endDate;
}

class getEnvelopeListResponse {
  /**
   * @var envelopeInfoType
   */
  public $envelopes;
}

class envelopeInfoType {
  /**
   * @var errorType
   */
  public $error;
  /**
   * @var int
   */
  public $idEnvelope;
  /**
   * @var string
   */
  public $envelopeStatus;
  /**
   * @var date
   */
  public $dataTransmisji;
}

class przesylkaZagranicznaType extends przesylkaNieRejestrowanaType {
  /**
   * @var adresType
   */
  public $adres;
  /**
   * @var adresType
   */
  public $nadawca;
  /**
   * @var deklaracjaCelna2Type
   */
  public $deklaracjaCelna2;
  /**
   * @var bool
   */
  public $posteRestante;
  /**
   * @var string
   */
  public $kategoria;
  /**
   * @var int
   */
  public $masa;
  /**
   * @var bool
   */
  public $ekspres;
  /**
   * @var string
   */
  public $kraj;
}

class przesylkaRejestrowanaType extends przesylkaType {
  /**
   * @var adresType
   */
  public $adres;
  /**
   * @var adresType
   */
  public $nadawca;
  /**
   * @var relatedToAllegroType
   */
  public $relatedToAllegro;
  /**
   * @var string
   */
  public $numerNadania;
  /**
   * @var string
   */
  public $sygnatura;
  /**
   * @var string
   */
  public $terminSprawy;
  /**
   * @var string
   */
  public $rodzaj;
}

class przesylkaNieRejestrowanaType extends przesylkaType {
  /**
   * @var anonymous97
   */
  public $ilosc;
}

class anonymous97 {
}

class przesylkaBiznesowaType extends przesylkaRejestrowanaType {
  /**
   * @var string
   */
  public $pobranie;
  /**
   * @var urzadWydaniaEPrzesylkiType
   */
  public $urzadWydaniaEPrzesylki;
  /**
   * @var subPrzesylkaBiznesowaType
   */
  public $subPrzesylka;
  /**
   * @var ubezpieczenieType
   */
  public $ubezpieczenie;
  /**
   * @var EPOType
   */
  public $epo;
  /**
   * @var string
   */
  public $zasadySpecjalne;
  /**
   * @var int
   */
  public $masa;
  /**
   * @var string
   */
  public $gabaryt;
  /**
   * @var int
   */
  public $wartosc;
  /**
   * @var bool
   */
  public $ostroznie;
  /**
   * @var string
   */
  public $numerTransakcjiOdbioru;
}

class gabarytBiznesowaType {
  const XS = 'XS';
  const S = 'S';
  const M = 'M';
  const L = 'L';
  const XL = 'XL';
  const XXL = 'XXL';
}

class subPrzesylkaBiznesowaType extends przesylkaType {
  /**
   * @var ubezpieczenieType
   */
  public $ubezpieczenie;
  /**
   * @var string
   */
  public $numerNadania;
  /**
   * @var int
   */
  public $masa;
  /**
   * @var string
   */
  public $gabaryt;
  /**
   * @var int
   */
  public $wartosc;
  /**
   * @var bool
   */
  public $ostroznie;
}

class subPrzesylkaBiznesowaPlusType extends przesylkaType {
  /**
   * @var string
   */
  public $pobranie;
  /**
   * @var string
   */
  public $numerNadania;
  /**
   * @var int
   */
  public $masa;
  /**
   * @var string
   */
  public $gabaryt;
  /**
   * @var int
   */
  public $wartosc;
  /**
   * @var bool
   */
  public $ostroznie;
  /**
   * @var string
   */
  public $numerPrzesylkiKlienta;
  /**
   * @var int
   */
  public $kwotaTranzakcji;
  /**
   * @var string
   */
  public $numerTransakcjiOdbioru;
}

class getAddresLabelByGuid {
  /**
   * @var string
   */
  public $guid;
  /**
   * @var int
   */
  public $idBufor;
}

class getAddresLabelByGuidResponse {
  /**
   * @var addressLabelContent
   */
  public $content;
  /**
   * @var errorType
   */
  public $error;
}

class przesylkaBiznesowaPlusType extends przesylkaRejestrowanaType {
  /**
   * @var string
   */
  public $pobranie;
  /**
   * @var string
   */
  public $urzadWydaniaPrzesylki;
  /**
   * @var subPrzesylkaBiznesowaPlusType
   */
  public $subPrzesylka;
  /**
   * @var date
   */
  public $dataDrugiejProbyDoreczenia;
  /**
   * @var int
   */
  public $drugaProbaDoreczeniaPoLiczbieDni;
  /**
   * @var bool
   */
  public $posteRestante;
  /**
   * @var int
   */
  public $masa;
  /**
   * @var string
   */
  public $gabaryt;
  /**
   * @var int
   */
  public $wartosc;
  /**
   * @var int
   */
  public $kwotaTranzakcji;
  /**
   * @var bool
   */
  public $ostroznie;
  /**
   * @var string
   */
  public $kategoria;
  /**
   * @var int
   */
  public $iloscPotwierdzenOdbioru;
  /**
   * @var bool
   */
  public $zwrotDoslanie;
  /**
   * @var string
   */
  public $eKontaktAdresata;
  /**
   * @var string
   */
  public $eSposobPowiadomieniaAdresata;
  /**
   * @var string
   */
  public $numerPrzesylkiKlienta;
  /**
   * @var int
   */
  public $iloscDniOczekiwaniaNaWydanie;
  /**
   * @var dateTime
   */
  public $oczekiwanyTerminDoreczenia;
  /**
   * @var string
   */
  public $terminRodzajPlus;
  /**
   * @var string
   */
  public $numerTransakcjiOdbioru;
}

class opisType {
}

class numerPrzesylkiKlientaType {
}

class pakietType {
  /**
   * @var kierunekType
   */
  public $kierunek;
  /**
   * @var opakowanieType
   */
  public $opakowanie;
  /**
   * @var string
   */
  public $czynnoscUpustowa;
  /**
   * @var string
   */
  public $pakietGuid;
  /**
   * @var string
   */
  public $miejsceOdbioru;
  /**
   * @var string
   */
  public $sposobNadania;
}

class opakowanieType {
  /**
   * @var string
   */
  public $opakowanieGuid;
  /**
   * @var string
   */
  public $typ;
  /**
   * @var string
   */
  public $sygnatura;
  /**
   * @var int
   */
  public $ilosc;
  /**
   * @var string
   */
  public $numerOpakowaniaZbiorczego;
}

class typOpakowaniaType {
}

class getPlacowkiPocztowe {
  /**
   * @var string
   */
  public $idWojewodztwo;
}

class getPlacowkiPocztoweResponse {
  /**
   * @var string
   */
  public $placowka;
}

class getGuid {
  /**
   * @var int
   */
  public $ilosc;
}

class getGuidResponse {
  /**
   * @var string
   */
  public $guid;
}

class kierunekType {
  /**
   * @var string
   */
  public $kodPocztowy;
  /**
   * @var int
   */
  public $id;
  /**
   * @var string
   */
  public $opis;
  /**
   * @var string
   */
  public $pna;
}

class getKierunki {
  /**
   * @var string
   */
  public $plan;
  /**
   * @var prefixKodPocztowy
   */
  public $prefixKodPocztowy;
}

class prefixKodPocztowy {
}

class getKierunkiResponse {
  /**
   * @var kierunekType
   */
  public $kierunek;
  /**
   * @var errorType
   */
  public $error;
}

class czynnoscUpustowaType {
  const POSORTOWANA = 'POSORTOWANA';
}

class miejsceOdbioruType {
  const NADAWCA = 'NADAWCA';
  const URZAD_NADANIA = 'URZAD_NADANIA';
}

class sposobNadaniaType {
  const WERYFIKACJA_WEZEL_DOCELOWY = 'WERYFIKACJA_WEZEL_DOCELOWY';
  const WERYFIKACJA_WEZEL_NADAWCZY = 'WERYFIKACJA_WEZEL_NADAWCZY';
}

class getKierunkiInfo {
  /**
   * @var string
   */
  public $plan;
}

class getKierunkiInfoResponse {
  /**
   * @var date
   */
  public $lastUpdate;
  /**
   * @var uslugiType
   */
  public $usluga;
  /**
   * @var errorType
   */
  public $error;
}

class kwotaTranzakcjiType {
}

class uslugiType {
  /**
   * @var string
   */
  public $id;
  /**
   * @var string
   */
  public $opis;
}

class idWojewodztwoType {
  const value_02 = '02';
  const value_04 = '04';
  const value_06 = '06';
  const value_08 = '08';
  const value_10 = '10';
  const value_12 = '12';
  const value_14 = '14';
  const value_16 = '16';
  const value_18 = '18';
  const value_20 = '20';
  const value_22 = '22';
  const value_24 = '24';
  const value_26 = '26';
  const value_28 = '28';
  const value_30 = '30';
  const value_32 = '32';
}

class placowkaPocztowaType {
  /**
   * @var lokalizacjaGeograficznaType
   */
  public $lokalizacjaGeograficzna;
  /**
   * @var int
   */
  public $id;
  /**
   * @var string
   */
  public $prefixNazwy;
  /**
   * @var string
   */
  public $nazwa;
  /**
   * @var string
   */
  public $wojewodztwo;
  /**
   * @var string
   */
  public $powiat;
  /**
   * @var string
   */
  public $miejsce;
  /**
   * @var anonymous127
   */
  public $kodPocztowy;
  /**
   * @var anonymous128
   */
  public $miejscowosc;
  /**
   * @var string
   */
  public $ulica;
  /**
   * @var string
   */
  public $numerDomu;
  /**
   * @var string
   */
  public $numerLokalu;
  /**
   * @var string
   */
  public $nazwaWydruk;
  /**
   * @var bool
   */
  public $punktWydaniaEPrzesylki;
  /**
   * @var bool
   */
  public $powiadomienieSMS;
  /**
   * @var bool
   */
  public $punktWydaniaPrzesylkiBiznesowejPlus;
  /**
   * @var bool
   */
  public $punktWydaniaPrzesylkiBiznesowej;
  /**
   * @var string
   */
  public $siecPlacowek;
  /**
   * @var string
   */
  public $idZPO;
}

class anonymous127 {
}

class anonymous128 {
}

class punktWydaniaPrzesylkiBiznesowejPlus {
}

class statusType {
  const NIEPOTWIERDZONA = 'NIEPOTWIERDZONA';
  const POTWIERDZONA = 'POTWIERDZONA';
  const NOWA = 'NOWA';
  const BRAK = 'BRAK';
}

class terminRodzajPlusType {
  const PORANEK = 'PORANEK';
  const POLUDNIE = 'POLUDNIE';
  const STANDARD = 'STANDARD';
}

class typOpakowanieType {
  const KL1 = 'KL1';
  const KL2 = 'KL2';
  const KL3 = 'KL3';
  const S21 = 'S21';
  const S22 = 'S22';
  const S23 = 'S23';
  const P31 = 'P31';
  const P32 = 'P32';
  const P33 = 'P33';
  const SP41 = 'SP41';
  const SP42 = 'SP42';
  const WKL51 = 'WKL51';
  const K1 = 'K1';
  const K2 = 'K2';
  const K3 = 'K3';
  const P = 'P';
  const W = 'W';
}

class getEnvelopeBufor {
  /**
   * @var int
   */
  public $idBufor;
}

class getEnvelopeBuforResponse {
  /**
   * @var przesylkaType
   */
  public $przesylka;
  /**
   * @var errorType
   */
  public $error;
}

class clearEnvelopeByGuids {
  /**
   * @var string
   */
  public $guid;
  /**
   * @var int
   */
  public $idBufor;
}

class clearEnvelopeByGuidsResponse {
  /**
   * @var errorType
   */
  public $error;
}

class zwrotDokumentowType {
  /**
   * @var string
   */
  public $rodzajPocztex;
  /**
   * @var rodzajListType
   */
  public $rodzajList;
  /**
   * @var int
   */
  public $odleglosc;
}

class odbiorPrzesylkiOdNadawcyType {
  /**
   * @var bool
   */
  public $wSobote;
  /**
   * @var bool
   */
  public $wNiedzieleLubSwieto;
  /**
   * @var bool
   */
  public $wGodzinachOd20Do7;
}

class potwierdzenieDoreczeniaType {
  /**
   * @var string
   */
  public $sposob;
  /**
   * @var string
   */
  public $kontakt;
}

class rodzajListType {
  /**
   * @var bool
   */
  public $polecony;
  /**
   * @var string
   */
  public $kategoria;
}

class potwierdzenieOdbioruType {
  /**
   * @var int
   */
  public $ilosc;
  /**
   * @var string
   */
  public $sposob;
}

class sposobPrzekazaniaPotwierdzeniaOdbioruType {
  const MIEJSKI_DO_3H_DO_5KM = 'MIEJSKI_DO_3H_DO_5KM';
  const MIEJSKI_DO_3H_DO_10KM = 'MIEJSKI_DO_3H_DO_10KM';
  const MIEJSKI_DO_3H_DO_15KM = 'MIEJSKI_DO_3H_DO_15KM';
  const MIEJSKI_DO_3H_POWYZEJ_15KM = 'MIEJSKI_DO_3H_POWYZEJ_15KM';
  const MIEJSKI_DO_4H_DO_10KM = 'MIEJSKI_DO_4H_DO_10KM';
  const MIEJSKI_DO_4H_DO_15KM = 'MIEJSKI_DO_4H_DO_15KM';
  const MIEJSKI_DO_4H_DO_20KM = 'MIEJSKI_DO_4H_DO_20KM';
  const MIEJSKI_DO_4H_DO_30KM = 'MIEJSKI_DO_4H_DO_30KM';
  const MIEJSKI_DO_4H_DO_40KM = 'MIEJSKI_DO_4H_DO_40KM';
  const EKSPRES24 = 'EKSPRES24';
  const LIST_ZWYKLY = 'LIST_ZWYKLY';
}

class doreczenieType {
  /**
   * @var date
   */
  public $oczekiwanyTerminDoreczenia;
  /**
   * @var string
   */
  public $oczekiwanaGodzinaDoreczenia;
  /**
   * @var bool
   */
  public $wSobote;
  /**
   * @var bool
   */
  public $w90Minut;
  /**
   * @var bool
   */
  public $wNiedzieleLubSwieto;
  /**
   * @var bool
   */
  public $doRakWlasnych;
  /**
   * @var bool
   */
  public $wGodzinachOd20Do7;
}

class doreczenieUslugaPocztowaType {
  /**
   * @var date
   */
  public $oczekiwanyTerminDoreczenia;
  /**
   * @var string
   */
  public $oczekiwanaGodzinaDoreczenia;
  /**
   * @var bool
   */
  public $wSobote;
  /**
   * @var bool
   */
  public $doRakWlasnych;
}

class doreczenieUslugaKurierskaType {
  /**
   * @var date
   */
  public $oczekiwanyTerminDoreczenia;
  /**
   * @var string
   */
  public $oczekiwanaGodzinaDoreczenia;
  /**
   * @var bool
   */
  public $wSobote;
  /**
   * @var bool
   */
  public $w90Minut;
  /**
   * @var bool
   */
  public $wNiedzieleLubSwieto;
  /**
   * @var bool
   */
  public $doRakWlasnych;
  /**
   * @var bool
   */
  public $wGodzinachOd20Do7;
  /**
   * @var bool
   */
  public $po17;
}

class oczekiwanaGodzinaDoreczeniaType {
  const DO_08_00 = 'DO 08:00';
  const DO_09_00 = 'DO 09:00';
  const DO_12_00 = 'DO 12:00';
  const NA_13_00 = 'NA 13:00';
  const NA_14_00 = 'NA 14:00';
  const NA_15_00 = 'NA 15:00';
  const NA_16_00 = 'NA 16:00';
  const NA_17_00 = 'NA 17:00';
  const NA_18_00 = 'NA 18:00';
  const NA_19_00 = 'NA 19:00';
  const NA_20_00 = 'NA 20:00';
}

class oczekiwanaGodzinaDoreczeniaUslugiType {
  const DO_08_00 = 'DO 08:00';
  const DO_09_00 = 'DO 09:00';
  const DO_12_00 = 'DO 12:00';
  const NA_13_00 = 'NA 13:00';
  const NA_14_00 = 'NA 14:00';
  const NA_15_00 = 'NA 15:00';
  const NA_16_00 = 'NA 16:00';
  const NA_17_00 = 'NA 17:00';
  const NA_18_00 = 'NA 18:00';
  const NA_19_00 = 'NA 19:00';
  const NA_20_00 = 'NA 20:00';
  const PO_17_00 = 'PO 17:00';
}

class paczkaZagranicznaType extends przesylkaRejestrowanaType {
  /**
   * @var zwrotType
   */
  public $zwrot;
  /**
   * @var deklaracjaCelnaType
   */
  public $deklaracjaCelna;
  /**
   * @var deklaracjaCelna2Type
   */
  public $deklaracjaCelna2;
  /**
   * @var string
   */
  public $sposobNadaniaInterconnect;
  /**
   * @var bool
   */
  public $posteRestante;
  /**
   * @var int
   */
  public $masa;
  /**
   * @var int
   */
  public $wartosc;
  /**
   * @var string
   */
  public $kategoria;
  /**
   * @var int
   */
  public $iloscPotwierdzenOdbioru;
  /**
   * @var bool
   */
  public $utrudnionaManipulacja;
  /**
   * @var bool
   */
  public $ekspres;
  /**
   * @var string
   */
  public $numerReferencyjnyCelny;
}

class paczkaZagranicznaPremiumType extends przesylkaRejestrowanaType {
  /**
   * @var zwrotType
   */
  public $zwrot;
  /**
   * @var bool
   */
  public $posteRestante;
  /**
   * @var int
   */
  public $masa;
  /**
   * @var deklaracjaCelna2Type
   */
  public $deklaracjaCelna2;
  /**
   * @var string
   */
  public $sposobNadaniaInterconnect;
  /**
   * @var potwierdzenieDoreczeniaType
   */
  public $potwierdzenieDoreczenia;
  /**
   * @var ubezpieczenieType
   */
  public $ubezpieczenie;
  /**
   * @var string
   */
  public $numerPrzesylkiKlienta;
}

class setEnvelopeBuforDataNadania {
  /**
   * @var date
   */
  public $dataNadania;
}

class setEnvelopeBuforDataNadaniaResponse {
  /**
   * @var errorType
   */
  public $error;
}

class lokalizacjaGeograficznaType {
  /**
   * @var wspolrzednaGeograficznaType
   */
  public $dlugosc;
  /**
   * @var wspolrzednaGeograficznaType
   */
  public $szerokosc;
}

class wspolrzednaGeograficznaType {
  /**
   * @var float
   */
  public $dec;
  /**
   * @var int
   */
  public $stopien;
  /**
   * @var int
   */
  public $minuta;
  /**
   * @var float
   */
  public $sekunda;
}

class zwrotType {
  /**
   * @var int
   */
  public $zwrotPoLiczbieDni;
  /**
   * @var bool
   */
  public $traktowacJakPorzucona;
  /**
   * @var string
   */
  public $sposobZwrotu;
}

class sposobZwrotuType {
  const LADOWO_MORSKA = 'LADOWO_MORSKA';
  const LOTNICZA = 'LOTNICZA';
}

class listZwyklyType extends przesylkaNieRejestrowanaType {
  /**
   * @var bool
   */
  public $posteRestante;
  /**
   * @var string
   */
  public $kategoria;
  /**
   * @var string
   */
  public $gabaryt;
  /**
   * @var int
   */
  public $masa;
  /**
   * @var bool
   */
  public $egzemplarzBiblioteczny;
  /**
   * @var bool
   */
  public $dlaOciemnialych;
  /**
   * @var bool
   */
  public $obszarMiasto;
  /**
   * @var bool
   */
  public $miejscowa;
}

class listZwyklyFirmowyType extends przesylkaNieRejestrowanaType {
  /**
   * @var adresType
   */
  public $adres;
  /**
   * @var bool
   */
  public $posteRestante;
  /**
   * @var bool
   */
  public $miejscowa;
  /**
   * @var int
   */
  public $masa;
  /**
   * @var bool
   */
  public $egzemplarzBiblioteczny;
  /**
   * @var bool
   */
  public $dlaOciemnialych;
  /**
   * @var bool
   */
  public $obszarMiasto;
  /**
   * @var string
   */
  public $kategoria;
  /**
   * @var string
   */
  public $gabaryt;
}

class reklamowaType extends przesylkaNieRejestrowanaType {
  /**
   * @var int
   */
  public $masa;
  /**
   * @var string
   */
  public $gabaryt;
}

class getEPOStatus {
  /**
   * @var string
   */
  public $guid;
  /**
   * @var bool
   */
  public $endedOnly;
  /**
   * @var int
   */
  public $idEnvelope;
  /**
   * @var bool
   */
  public $withBioepo;
}

class getEPOStatusResponse {
  /**
   * @var przesylkaEPOType
   */
  public $epo;
  /**
   * @var errorType
   */
  public $error;
}

class statusEPOEnum {
  const ERROR = 'ERROR';
  const NADANIE = 'NADANIE';
  const W_TRANSPORCIE = 'W_TRANSPORCIE';
  const CLO = 'CLO';
  const SMS = 'SMS';
  const W_DORECZENIU = 'W_DORECZENIU';
  const AWIZO = 'AWIZO';
  const PONOWNE_AWIZO = 'PONOWNE_AWIZO';
  const ZWROT = 'ZWROT';
  const DORECZONA = 'DORECZONA';
}

class EPOType {
}

class EPOSimpleType extends EPOType {
}

class EPOExtendedType extends EPOType {
  /**
   * @var string
   */
  public $zasadySpecjalne;
}

class zasadySpecjalneEnum {
  const ADMINISTRACYJNA = 'ADMINISTRACYJNA';
  const PODATKOWA = 'PODATKOWA';
  const SADOWA_CYWILNA = 'SADOWA_CYWILNA';
  const SADOWA_KARNA = 'SADOWA_KARNA';
}

class przesylkaEPOType {
  /**
   * @var EPOInfoType
   */
  public $EPOInfo;
  /**
   * @var string
   */
  public $biometricSignatureContent;
  /**
   * @var int
   */
  public $version;
  /**
   * @var string
   */
  public $guid;
  /**
   * @var string
   */
  public $numerNadania;
  /**
   * @var string
   */
  public $statusEPO;
}

class przesylkaFirmowaPoleconaType extends przesylkaRejestrowanaType {
  /**
   * @var EPOType
   */
  public $epo;
  /**
   * @var string
   */
  public $zasadySpecjalne;
  /**
   * @var bool
   */
  public $posteRestante;
  /**
   * @var int
   */
  public $iloscPotwierdzenOdbioru;
  /**
   * @var int
   */
  public $masa;
  /**
   * @var bool
   */
  public $miejscowa;
  /**
   * @var bool
   */
  public $obszarMiasto;
  /**
   * @var string
   */
  public $kategoria;
  /**
   * @var string
   */
  public $gabaryt;
}

class EPOInfoType {
  /**
   * @var awizoPrzesylkiType
   */
  public $awizoPrzesylki;
  /**
   * @var doreczeniePrzesylkiType
   */
  public $doreczeniePrzesylki;
  /**
   * @var zwrotPrzesylkiType
   */
  public $zwrotPrzesylki;
}

class awizoPrzesylkiType {
  /**
   * @var date
   */
  public $dataPierwszegoAwizowania;
  /**
   * @var date
   */
  public $dataDrugiegoAwizowania;
  /**
   * @var string
   */
  public $miejscePozostawienia;
  /**
   * @var int
   */
  public $idPlacowkaPocztowaWydajaca;
}

class doreczeniePrzesylkiType {
  /**
   * @var dateTime
   */
  public $data;
  /**
   * @var string
   */
  public $osobaOdbierajaca;
  /**
   * @var string
   */
  public $podmiotDoreczenia;
  /**
   * @var date
   */
  public $dataPelnomocnictwa;
  /**
   * @var string
   */
  public $numerPelnomocnictwa;
  /**
   * @var bool
   */
  public $pieczecFirmowa;
  /**
   * @var string
   */
  public $miejscePozostawieniaZawiadomieniaODoreczeniu;
}

class zwrotPrzesylkiType {
  /**
   * @var string
   */
  public $przyczyna;
  /**
   * @var dateTime
   */
  public $data;
  /**
   * @var string
   */
  public $przyczynaZwrotuDodatkowa;
}

class miejscaPozostawieniaAwizoEnum {
  const SKRZYNKA_ODDAWCZA = 'SKRZYNKA_ODDAWCZA';
  const DRZWI_MIESZKANIA = 'DRZWI_MIESZKANIA';
  const DRZWI_INNEGO_POMIESZCZENIA = 'DRZWI_INNEGO_POMIESZCZENIA';
  const PRZY_WEJSCIU_NA_POSESJE = 'PRZY_WEJSCIU_NA_POSESJE';
  const SKRYTKA_POCZTOWA = 'SKRYTKA_POCZTOWA';
  const INNE_WIDOCZNE_MIEJSCE = 'INNE_WIDOCZNE_MIEJSCE';
}

class podmiotDoreczeniaEnum {
  const ADRESAT = 'ADRESAT';
  const PELNOLETNI_DOMOWNIK = 'PELNOLETNI_DOMOWNIK';
  const SASIAD = 'SASIAD';
  const DOZORCA_DOMU = 'DOZORCA_DOMU';
  const SOLTYS = 'SOLTYS';
  const ADMINISTRACJA_DOMU = 'ADMINISTRACJA_DOMU';
  const UPOWAZNIONY_PRACOWNIK = 'UPOWAZNIONY_PRACOWNIK';
  const PELNOMOCNIK_POCZTOWY = 'PELNOMOCNIK_POCZTOWY';
  const PRZEDSTAWICIEL_USTAWOWY = 'PRZEDSTAWICIEL_USTAWOWY';
  const PELNOMOCNIK_ADRESATA = 'PELNOMOCNIK_ADRESATA';
  const OSOBA_UPRAWNIONA_DO_REPREZENTACJI = 'OSOBA_UPRAWNIONA_DO_REPREZENTACJI';
  const SKRZYNKA_ODDAWCZA = 'SKRZYNKA_ODDAWCZA';
  const ADRESAT_KTORY_NIE_MOGL = 'ADRESAT_KTORY_NIE_MOGL';
  const OSOBA_UPRAWNIONA_DO_ODBIORU = 'OSOBA_UPRAWNIONA_DO_ODBIORU';
  const DOROSLY_DOMOWNIK = 'DOROSLY_DOMOWNIK';
  const OSOBA_UPOWAZNIONA_DO_ODB_KORESP = 'OSOBA_UPOWAZNIONA_DO_ODB_KORESP';
  const KIEROWNIK_JEDNOSTKI_LUB_UPOWAZNIONY = 'KIEROWNIK_JEDNOSTKI_LUB_UPOWAZNIONY';
  const PRZEDSTAWICIEL_ADRESATA = 'PRZEDSTAWICIEL_ADRESATA';
  const OSOBA_UPOWAZNIONA_DO_REPREZENT_ADRESATA = 'OSOBA_UPOWAZNIONA_DO_REPREZENT_ADRESATA';
  const OSOBA_UPOWAZNIONA_PRZEZ_PRACODAWCE = 'OSOBA_UPOWAZNIONA_PRZEZ_PRACODAWCE';
  const PRZELOZONY_ABW = 'PRZELOZONY_ABW';
  const PRZELOZONY_AW = 'PRZELOZONY_AW';
  const PRZELOZONY_CBA = 'PRZELOZONY_CBA';
  const PRZELOZONY_POLICJI = 'PRZELOZONY_POLICJI';
  const PRZELOZONY_SC = 'PRZELOZONY_SC';
  const PRZELOZONY_SG = 'PRZELOZONY_SG';
  const PRZELOZONY_SKW = 'PRZELOZONY_SKW';
  const PRZELOZONY_SW = 'PRZELOZONY_SW';
  const PRZELOZONY_SWW = 'PRZELOZONY_SWW';
  const PRZELOZONY_ZOLNIERZA = 'PRZELOZONY_ZOLNIERZA';
  const SKRYTKA_POCZTOWA = 'SKRYTKA_POCZTOWA';
  const PROKURENT = 'PROKURENT';
  const ZARZADCA_DOMU = 'ZARZADCA_DOMU';
  const OSOBA_UPOWAZNIONA_PRZEZ_KIER_WIEZIENIA = 'OSOBA_UPOWAZNIONA_PRZEZ_KIER_WIEZIENIA';
}

class przyczynaZwrotuEnum {
  const ODMOWA = 'ODMOWA';
  const ADRESAT_ZMARL = 'ADRESAT_ZMARL';
  const ADRESAT_NIEZNANY = 'ADRESAT_NIEZNANY';
  const ADRESAT_WYPROWADZIL_SIE = 'ADRESAT_WYPROWADZIL_SIE';
  const ADRESAT_NIE_PODJAL = 'ADRESAT_NIE_PODJAL';
  const INNA = 'INNA';
  const ADRES_NIEPELNY = 'ADRES_NIEPELNY';
  const ADRES_BLEDNY = 'ADRES_BLEDNY';
  const ADRES_NIEZGODNY = 'ADRES_NIEZGODNY';
  const ADRES_NIEZNALEZIONY = 'ADRES_NIEZNALEZIONY';
  const ADRESAT_NIE_ZASTANO = 'ADRESAT_NIE_ZASTANO';
  const ADRESAT_NIE_ZGLASZA_SIE = 'ADRESAT_NIE_ZGLASZA_SIE';
  const ADRESAT_NIEOBECNY = 'ADRESAT_NIEOBECNY';
  const ADRESAT_NIEODNALEZIONY = 'ADRESAT_NIEODNALEZIONY';
  const ADRESAT_STRAJKUJE = 'ADRESAT_STRAJKUJE';
  const DO_NADAWCY_NA_POZNIEJ = 'DO_NADAWCY_NA_POZNIEJ';
  const MYLNE_SKIEROWANIE = 'MYLNE_SKIEROWANIE';
  const NADAWCA_ODMOWIL = 'NADAWCA_ODMOWIL';
  const NIE_PODJETO = 'NIE_PODJETO';
  const NIEZGODNE_WYMAGANIA = 'NIEZGODNE_WYMAGANIA';
  const ODMOWA_USZKODZENIA = 'ODMOWA_USZKODZENIA';
  const POBRANIE_NIEZGODNE = 'POBRANIE_NIEZGODNE';
  const USZKODZONA = 'USZKODZONA';
  const ZAMKNIETA_SIEDZIBA = 'ZAMKNIETA_SIEDZIBA';
}

class miejscePozostawieniaZawiadomieniaODoreczeniuEnum {
  const SKRZYNKA_ADRESATA = 'SKRZYNKA_ADRESATA';
  const DRZWI_MIESZKANIA = 'DRZWI_MIESZKANIA';
  const INNE_WIDOCZNE_MIEJSCE = 'INNE_WIDOCZNE_MIEJSCE';
  const SKRYTKA_POCZTOWA = 'SKRYTKA_POCZTOWA';
}

class getAddresLabelCompact {
  /**
   * @var int
   */
  public $idEnvelope;
}

class getAddresLabelCompactResponse {
  /**
   * @var string
   */
  public $pdfContent;
  /**
   * @var errorType
   */
  public $error;
}

class getAddresLabelByGuidCompact {
  /**
   * @var string
   */
  public $guid;
  /**
   * @var int
   */
  public $idBufor;
}

class getAddresLabelByGuidCompactResponse {
  /**
   * @var string
   */
  public $pdfContent;
  /**
   * @var errorType
   */
  public $error;
}

class ubezpieczenieType {
  /**
   * @var string
   */
  public $rodzaj;
  /**
   * @var decimal
   */
  public $kwota;
  /**
   * @var bool
   */
  public $akceptacjaOWU;
}

class rodzajUbezpieczeniaType {
  const STANDARD = 'STANDARD';
  const PRECJOZA = 'PRECJOZA';
}

class kwotaUbezpieczeniaType {
}

class emailType {
}

class mobileType {
}

class EMSType extends przesylkaRejestrowanaType {
  /**
   * @var ubezpieczenieType
   */
  public $ubezpieczenie;
  /**
   * @var deklaracjaCelnaType
   */
  public $deklaracjaCelna;
  /**
   * @var potwierdzenieDoreczeniaType
   */
  public $potwierdzenieDoreczenia;
  /**
   * @var deklaracjaCelna2Type
   */
  public $deklaracjaCelna2;
  /**
   * @var string
   */
  public $sposobNadaniaInterconnect;
  /**
   * @var string
   */
  public $typOpakowania;
  /**
   * @var int
   */
  public $masa;
  /**
   * @var bool
   */
  public $zalaczoneDokumenty;
}

class EMSTypOpakowaniaType {
  const ZWYKLY = 'ZWYKLY';
  const DOKUMENT_PACK = 'DOKUMENT_PACK';
  const KILO_PACK = 'KILO_PACK';
}

class getEnvelopeBuforList {
}

class getEnvelopeBuforListResponse {
  /**
   * @var buforType
   */
  public $bufor;
  /**
   * @var errorType
   */
  public $error;
}

class buforType {
  /**
   * @var profilType
   */
  public $profil;
  /**
   * @var int
   */
  public $idBufor;
  /**
   * @var date
   */
  public $dataNadania;
  /**
   * @var int
   */
  public $urzadNadania;
  /**
   * @var bool
   */
  public $active;
  /**
   * @var string
   */
  public $opis;
  /**
   * @var bool
   */
  public $aktualizujPlanowanaDateNadaniaPrzesylek;
}

class createEnvelopeBufor {
  /**
   * @var buforType
   */
  public $bufor;
}

class createEnvelopeBuforResponse {
  /**
   * @var buforType
   */
  public $createdBufor;
  /**
   * @var errorType
   */
  public $error;
}

class moveShipments {
  /**
   * @var int
   */
  public $idBuforFrom;
  /**
   * @var int
   */
  public $idBuforTo;
  /**
   * @var string
   */
  public $guid;
}

class moveShipmentsResponse {
  /**
   * @var string
   */
  public $notMovedGuid;
  /**
   * @var errorType
   */
  public $error;
}

class updateEnvelopeBufor {
  /**
   * @var buforType
   */
  public $bufor;
}

class updateEnvelopeBuforResponse {
  /**
   * @var errorType
   */
  public $error;
}

class getUbezpieczeniaInfo {
}

class getUbezpieczeniaInfoResponse {
  /**
   * @var ubezpieczeniaInfoType
   */
  public $poziomyUbezpieczenia;
}

class ubezpieczeniaInfoType {
  /**
   * @var string
   */
  public $typPrzesylki;
  /**
   * @var decimal
   */
  public $kwota;
}

class isMiejscowa {
  /**
   * @var trasaRequestType
   */
  public $trasaRequest;
}

class isMiejscowaResponse {
  /**
   * @var trasaResponseType
   */
  public $trasaResponse;
}

class trasaRequestType {
  /**
   * @var int
   */
  public $fromUrzadNadania;
  /**
   * @var string
   */
  public $toKodPocztowy;
  /**
   * @var string
   */
  public $guid;
}

class trasaResponseType {
  /**
   * @var bool
   */
  public $isMiejscowa;
  /**
   * @var string
   */
  public $guid;
}

class deklaracjaCelnaType {
  /**
   * @var szczegolyDeklaracjiCelnejType
   */
  public $szczegoly;
  /**
   * @var bool
   */
  public $podarunek;
  /**
   * @var bool
   */
  public $dokument;
  /**
   * @var bool
   */
  public $probkaHandlowa;
  /**
   * @var bool
   */
  public $zwrotTowaru;
  /**
   * @var bool
   */
  public $towary;
  /**
   * @var bool
   */
  public $inny;
  /**
   * @var string
   */
  public $wyjasnienie;
  /**
   * @var string
   */
  public $oplatyPocztowe;
  /**
   * @var string
   */
  public $uwagi;
  /**
   * @var string
   */
  public $licencja;
  /**
   * @var string
   */
  public $swiadectwo;
  /**
   * @var string
   */
  public $faktura;
  /**
   * @var string
   */
  public $numerReferencyjnyImportera;
  /**
   * @var string
   */
  public $numerTelefonuImportera;
  /**
   * @var string
   */
  public $waluta;
}

class szczegolyDeklaracjiCelnejType {
  /**
   * @var string
   */
  public $zawartosc;
  /**
   * @var float
   */
  public $ilosc;
  /**
   * @var int
   */
  public $masa;
  /**
   * @var int
   */
  public $wartosc;
  /**
   * @var string
   */
  public $numerTaryfowy;
  /**
   * @var string
   */
  public $krajPochodzenia;
}

class przesylkaPaletowaType extends przesylkaRejestrowanaType {
  /**
   * @var adresType
   */
  public $miejsceOdbioru;
  /**
   * @var adresType
   */
  public $miejsceDoreczenia;
  /**
   * @var paletaType
   */
  public $paleta;
  /**
   * @var platnikType
   */
  public $platnik;
  /**
   * @var string
   */
  public $pobranie;
  /**
   * @var subPrzesylkaPaletowaType
   */
  public $subPaleta;
  /**
   * @var daneSentType
   */
  public $daneSent;
  /**
   * @var awizacjaType
   */
  public $awizacja;
  /**
   * @var string
   */
  public $zawartosc;
  /**
   * @var int
   */
  public $masa;
  /**
   * @var date
   */
  public $dataZaladunku;
  /**
   * @var date
   */
  public $dataDostawy;
  /**
   * @var int
   */
  public $wartosc;
  /**
   * @var int
   */
  public $iloscZwracanychPaletEUR;
  /**
   * @var string
   */
  public $zalaczonaFV;
  /**
   * @var string
   */
  public $zalaczonyWZ;
  /**
   * @var string
   */
  public $zalaczoneInne;
  /**
   * @var string
   */
  public $zwracanaFV;
  /**
   * @var string
   */
  public $zwracanyWZ;
  /**
   * @var string
   */
  public $zwracaneInne;
  /**
   * @var string
   */
  public $powiadomienieNadawcy;
  /**
   * @var string
   */
  public $powiadomienieOdbiorcy;
  /**
   * @var bool
   */
  public $dostawaWSobote;
  /**
   * @var bool
   */
  public $przygotowanieDokumentowPrzewozowych;
  /**
   * @var bool
   */
  public $dostawaSamochodemDedykowanym;
  /**
   * @var bool
   */
  public $zmianaDanychAdresowych;
  /**
   * @var bool
   */
  public $ustalenieTerminuDostawy;
  /**
   * @var bool
   */
  public $samochodZWinda;
  /**
   * @var bool
   */
  public $zabranieOpakowania;
  /**
   * @var bool
   */
  public $wniesienie;
  /**
   * @var bool
   */
  public $awizoSMS;
}

class rodzajPaletyType {
  const EUR = 'EUR';
  const POLPALETA = 'POLPALETA';
  const INNA = 'INNA';
  const PRZEMYSLOWA = 'PRZEMYSLOWA';
}

class paletaType {
  /**
   * @var string
   */
  public $rodzajPalety;
  /**
   * @var int
   */
  public $szerokosc;
  /**
   * @var string
   */
  public $dlugosc;
  /**
   * @var string
   */
  public $wysokosc;
}

class platnikType {
  /**
   * @var string
   */
  public $uiszczaOplate;
  /**
   * @var adresType
   */
  public $adresPlatnika;
}

class subPrzesylkaPaletowaType extends przesylkaType {
  /**
   * @var paletaType
   */
  public $paleta;
  /**
   * @var string
   */
  public $zawartosc;
  /**
   * @var int
   */
  public $masa;
}

class getBlankietPobraniaByGuids {
  /**
   * @var string
   */
  public $guid;
  /**
   * @var int
   */
  public $idBufor;
}

class getBlankietPobraniaByGuidsResponse {
  /**
   * @var addressLabelContent
   */
  public $content;
  /**
   * @var errorType
   */
  public $error;
}

class updateAccount {
  /**
   * @var accountType
   */
  public $account;
}

class updateAccountResponse {
  /**
   * @var errorType
   */
  public $error;
}

class accountType {
  /**
   * @var kartaType
   */
  public $karta;
  /**
   * @var string
   */
  public $permision;
  /**
   * @var profilType
   */
  public $profil;
  /**
   * @var string
   */
  public $jednostka;
  /**
   * @var string
   */
  public $domyslnaJednostka;
  /**
   * @var profilType
   */
  public $domyslnyProfil;
  /**
   * @var string
   */
  public $dostepPoAdresieIP;
  /**
   * @var string
   */
  public $userName;
  /**
   * @var string
   */
  public $firstName;
  /**
   * @var string
   */
  public $lastName;
  /**
   * @var string
   */
  public $email;
  /**
   * @var string
   */
  public $status;
}

class permisionType {
  const MANAGE_USERS = 'MANAGE_USERS';
  const TRANSMIT = 'TRANSMIT';
  const MANAGE_PROFILES = 'MANAGE_PROFILES';
  const MANAGE_ORGANIZATION_UNIT = 'MANAGE_ORGANIZATION_UNIT';
  const MANAGE_TEMPLATES = 'MANAGE_TEMPLATES';
  const EDIT_PARCELS = 'EDIT_PARCELS';
  const EDIT_PARCELS_FROM_TEMPLATES = 'EDIT_PARCELS_FROM_TEMPLATES';
  const MANAGE_ADDRESS_BOOK = 'MANAGE_ADDRESS_BOOK';
  const SAVE_SELF_SETTINGS = 'SAVE_SELF_SETTINGS';
  const MANAGE_DICTIONARIES = 'MANAGE_DICTIONARIES';
}

class getAccountList {
}

class getAccountListResponse {
  /**
   * @var accountType
   */
  public $account;
}

class profilType extends adresType {
  /**
   * @var int
   */
  public $idProfil;
  /**
   * @var string
   */
  public $nazwaSkrocona;
  /**
   * @var string
   */
  public $fax;
}

class getProfilList {
}

class getProfilListResponse {
  /**
   * @var profilType
   */
  public $profil;
}

class updateProfil {
  /**
   * @var profilType
   */
  public $profil;
}

class updateProfilResponse {
  /**
   * @var errorType
   */
  public $error;
}

class statusAccountType {
  const WYLACZONY = 'WYLACZONY';
  const ZABLOKOWANY = 'ZABLOKOWANY';
  const ODBLOKOWANY = 'ODBLOKOWANY';
}

class uslugaPaczkowaType extends przesylkaRejestrowanaType {
  /**
   * @var string
   */
  public $pobranie;
  /**
   * @var potwierdzenieDoreczeniaType
   */
  public $potwierdzenieDoreczenia;
  /**
   * @var urzadWydaniaEPrzesylkiType
   */
  public $urzadWydaniaEPrzesylki;
  /**
   * @var subUslugaPaczkowaType
   */
  public $subPrzesylka;
  /**
   * @var potwierdzenieOdbioruPaczkowaType
   */
  public $potwierdzenieOdbioru;
  /**
   * @var ubezpieczenieType
   */
  public $ubezpieczenie;
  /**
   * @var string
   */
  public $zwrotDokumentow;
  /**
   * @var doreczenieUslugaPocztowaType
   */
  public $doreczenie;
  /**
   * @var EPOType
   */
  public $epo;
  /**
   * @var string
   */
  public $zasadySpecjalne;
  /**
   * @var int
   */
  public $masa;
  /**
   * @var int
   */
  public $wartosc;
  /**
   * @var bool
   */
  public $ponadgabaryt;
  /**
   * @var string
   */
  public $zawartosc;
  /**
   * @var bool
   */
  public $sprawdzenieZawartosciPrzesylkiPrzezOdbiorce;
  /**
   * @var bool
   */
  public $ostroznie;
  /**
   * @var string
   */
  public $uiszczaOplate;
  /**
   * @var string
   */
  public $termin;
  /**
   * @var string
   */
  public $opakowanie;
  /**
   * @var string
   */
  public $numerPrzesylkiKlienta;
  /**
   * @var string
   */
  public $numerTransakcjiOdbioru;
  /**
   * @var string
   */
  public $gabaryt;
}

class subUslugaPaczkowaType extends przesylkaType {
  /**
   * @var string
   */
  public $pobranie;
  /**
   * @var ubezpieczenieType
   */
  public $ubezpieczenie;
  /**
   * @var string
   */
  public $numerNadania;
  /**
   * @var int
   */
  public $masa;
  /**
   * @var int
   */
  public $wartosc;
  /**
   * @var bool
   */
  public $ostroznie;
  /**
   * @var string
   */
  public $opakowanie;
  /**
   * @var bool
   */
  public $ponadgabaryt;
  /**
   * @var string
   */
  public $numerPrzesylkiKlienta;
  /**
   * @var string
   */
  public $gabaryt;
}

class terminPaczkowaType {
  const PACZKA_24 = 'PACZKA_24';
  const PACZKA_48 = 'PACZKA_48';
  const PACZKA_EKSTRA_24 = 'PACZKA_EKSTRA_24';
}

class opakowaniePocztowaType {
  const PACZKA_DO_POL_KILO = 'PACZKA_DO_POL_KILO';
  const FIRMOWA_DO_1KG = 'FIRMOWA_DO_1KG';
  const GABARYT_G1 = 'GABARYT_G1';
  const GABARYT_G2 = 'GABARYT_G2';
  const GABARYT_G3 = 'GABARYT_G3';
  const GABARYT_G4 = 'GABARYT_G4';
  const GABARYT_G5 = 'GABARYT_G5';
}

class uslugaKurierskaType extends przesylkaRejestrowanaType {
  /**
   * @var string
   */
  public $pobranie;
  /**
   * @var odbiorPrzesylkiOdNadawcyType
   */
  public $odbiorPrzesylkiOdNadawcy;
  /**
   * @var potwierdzenieDoreczeniaType
   */
  public $potwierdzenieDoreczenia;
  /**
   * @var urzadWydaniaEPrzesylkiType
   */
  public $urzadWydaniaEPrzesylki;
  /**
   * @var subUslugaKurierskaType
   */
  public $subPrzesylka;
  /**
   * @var potwierdzenieOdbioruKurierskaType
   */
  public $potwierdzenieOdbioru;
  /**
   * @var ubezpieczenieType
   */
  public $ubezpieczenie;
  /**
   * @var zwrotDokumentowKurierskaType
   */
  public $zwrotDokumentow;
  /**
   * @var doreczenieUslugaKurierskaType
   */
  public $doreczenie;
  /**
   * @var EPOType
   */
  public $epo;
  /**
   * @var string
   */
  public $zasadySpecjalne;
  /**
   * @var int
   */
  public $masa;
  /**
   * @var int
   */
  public $wartosc;
  /**
   * @var bool
   */
  public $ponadgabaryt;
  /**
   * @var int
   */
  public $odleglosc;
  /**
   * @var string
   */
  public $zawartosc;
  /**
   * @var bool
   */
  public $sprawdzenieZawartosciPrzesylkiPrzezOdbiorce;
  /**
   * @var bool
   */
  public $ostroznie;
  /**
   * @var string
   */
  public $uiszczaOplate;
  /**
   * @var string
   */
  public $termin;
  /**
   * @var string
   */
  public $opakowanie;
  /**
   * @var string
   */
  public $numerPrzesylkiKlienta;
  /**
   * @var string
   */
  public $numerTransakcjiOdbioru;
}

class subUslugaKurierskaType extends przesylkaType {
  /**
   * @var string
   */
  public $pobranie;
  /**
   * @var ubezpieczenieType
   */
  public $ubezpieczenie;
  /**
   * @var string
   */
  public $numerNadania;
  /**
   * @var int
   */
  public $masa;
  /**
   * @var int
   */
  public $wartosc;
  /**
   * @var bool
   */
  public $ostroznie;
  /**
   * @var string
   */
  public $opakowanie;
  /**
   * @var bool
   */
  public $ponadgabaryt;
  /**
   * @var string
   */
  public $numerPrzesylkiKlienta;
}

class createAccount {
  /**
   * @var accountType
   */
  public $account;
}

class createAccountResponse {
  /**
   * @var errorType
   */
  public $error;
}

class createProfil {
  /**
   * @var profilType
   */
  public $profil;
}

class createProfilResponse {
  /**
   * @var errorType
   */
  public $error;
}

class terminKurierskaType {
  const MIEJSKI_DO_3H_DO_5KM = 'MIEJSKI_DO_3H_DO_5KM';
  const MIEJSKI_DO_3H_DO_10KM = 'MIEJSKI_DO_3H_DO_10KM';
  const MIEJSKI_DO_3H_DO_15KM = 'MIEJSKI_DO_3H_DO_15KM';
  const MIEJSKI_DO_3H_POWYZEJ_15KM = 'MIEJSKI_DO_3H_POWYZEJ_15KM';
  const MIEJSKI_DO_4H_DO_10KM = 'MIEJSKI_DO_4H_DO_10KM';
  const MIEJSKI_DO_4H_DO_15KM = 'MIEJSKI_DO_4H_DO_15KM';
  const MIEJSKI_DO_4H_DO_20KM = 'MIEJSKI_DO_4H_DO_20KM';
  const MIEJSKI_DO_4H_DO_30KM = 'MIEJSKI_DO_4H_DO_30KM';
  const MIEJSKI_DO_4H_DO_40KM = 'MIEJSKI_DO_4H_DO_40KM';
  const KRAJOWY = 'KRAJOWY';
  const BEZPOSREDNI_DO_20KG = 'BEZPOSREDNI_DO_20KG';
  const BEZPOSREDNI_OD_20KG_DO_30KG = 'BEZPOSREDNI_OD_20KG_DO_30KG';
  const BEZPOSREDNI_OD_30KG_DO_100KG = 'BEZPOSREDNI_OD_30KG_DO_100KG';
  const EKSPRES24 = 'EKSPRES24';
}

class opakowanieKurierskaType {
  const FIRMOWA_DO_1KG = 'FIRMOWA_DO_1KG';
}

class zwrotDokumentowPaczkowaType {
  const EKSPRES24 = 'EKSPRES24';
  const PACZKA_EKSTRA_24 = 'PACZKA_EKSTRA_24';
  const PACZKA_24 = 'PACZKA_24';
  const PACZKA_48 = 'PACZKA_48';
  const LIST_ZWYKLY_PRIORYTETOWY = 'LIST_ZWYKLY_PRIORYTETOWY';
  const LIST_ZWYKLY_EKONOMICZNY = 'LIST_ZWYKLY_EKONOMICZNY';
  const LIST_POLECONY_PRIORYTETOWY = 'LIST_POLECONY_PRIORYTETOWY';
  const LIST_POLECONY_EKONOMICZNY = 'LIST_POLECONY_EKONOMICZNY';
}

class potwierdzenieOdbioruPaczkowaType {
  /**
   * @var int
   */
  public $ilosc;
  /**
   * @var string
   */
  public $sposob;
}

class sposobPrzekazaniaPotwierdzeniaOdbioruPocztowaType {
  const EKSPRES24 = 'EKSPRES24';
  const PACZKA_EKSTRA_24 = 'PACZKA_EKSTRA_24';
  const PACZKA_24 = 'PACZKA_24';
  const PACZKA_48 = 'PACZKA_48';
  const LIST_ZWYKLY_PRIORYTETOWY = 'LIST_ZWYKLY_PRIORYTETOWY';
}

class zwrotDokumentowKurierskaType {
  /**
   * @var string
   */
  public $rodzajPocztex;
  /**
   * @var string
   */
  public $rodzajPaczka;
  /**
   * @var rodzajListType
   */
  public $rodzajList;
}

class terminZwrotDokumentowKurierskaType {
  const MIEJSKI_DO_3H_DO_5KM = 'MIEJSKI_DO_3H_DO_5KM';
  const MIEJSKI_DO_3H_DO_10KM = 'MIEJSKI_DO_3H_DO_10KM';
  const MIEJSKI_DO_3H_DO_15KM = 'MIEJSKI_DO_3H_DO_15KM';
  const MIEJSKI_DO_3H_POWYZEJ_15KM = 'MIEJSKI_DO_3H_POWYZEJ_15KM';
  const BEZPOSREDNI_DO_20KG = 'BEZPOSREDNI_DO_20KG';
  const EKSPRES24 = 'EKSPRES24';
}

class terminZwrotDokumentowPaczkowaType {
  const PACZKA_24 = 'PACZKA_24';
  const PACZKA_48 = 'PACZKA_48';
}

class potwierdzenieOdbioruKurierskaType {
  /**
   * @var int
   */
  public $ilosc;
  /**
   * @var string
   */
  public $sposob;
}

class sposobPrzekazaniaPotwierdzeniaOdbioruKurierskaType {
  const MIEJSKI_DO_3H_DO_5KM = 'MIEJSKI_DO_3H_DO_5KM';
  const MIEJSKI_DO_3H_DO_10KM = 'MIEJSKI_DO_3H_DO_10KM';
  const MIEJSKI_DO_3H_DO_15KM = 'MIEJSKI_DO_3H_DO_15KM';
  const MIEJSKI_DO_3H_POWYZEJ_15KM = 'MIEJSKI_DO_3H_POWYZEJ_15KM';
  const BEZPOSREDNI_DO_20KG = 'BEZPOSREDNI_DO_20KG';
  const EKSPRES24 = 'EKSPRES24';
  const PACZKA_24 = 'PACZKA_24';
  const PACZKA_48 = 'PACZKA_48';
  const LIST_ZWYKLY_PRIORYTETOWY = 'LIST_ZWYKLY_PRIORYTETOWY';
}

class addReklamacje {
  /**
   * @var reklamowanaPrzesylkaType
   */
  public $reklamowanaPrzesylka;
}

class addReklamacjeResponse {
  /**
   * @var errorType
   */
  public $error;
  /**
   * @var reklamacjaInfoType
   */
  public $reklamacjaInfo;
}

class getReklamacje {
  /**
   * @var date
   */
  public $dataRozpatrzenia;
}

class getReklamacjeResponse {
  /**
   * @var reklamacjaRozpatrzonaType
   */
  public $reklamacja;
}

class getZapowiedziFaktur {
  /**
   * @var date
   */
  public $data;
}

class getZapowiedziFakturResponse {
  /**
   * @var string
   */
  public $zapowiedzFakturyZipFile;
}

class addOdwolanieDoReklamacji {
  /**
   * @var reklamowanaPrzesylkaType
   */
  public $reklamacja;
}

class addOdwolanieDoReklamacjiResponse {
  /**
   * @var errorType
   */
  public $error;
  /**
   * @var reklamacjaInfoType
   */
  public $reklamacjaInfo;
}

class addRozbieznoscDoZapowiedziFaktur {
  /**
   * @var string
   */
  public $rozbieznosciZipFile;
}

class addRozbieznoscDoZapowiedziFakturResponse {
  /**
   * @var errorType
   */
  public $error;
}

class reklamowanaPrzesylkaType {
  /**
   * @var przesylkaType
   */
  public $przesylka;
  /**
   * @var powodReklamacjiType
   */
  public $powodReklamacji;
  /**
   * @var date
   */
  public $dataNadania;
  /**
   * @var int
   */
  public $urzadNadania;
  /**
   * @var string
   */
  public $powodReklamacjiOpis;
  /**
   * @var int
   */
  public $odszkodowanie;
  /**
   * @var int
   */
  public $oplata;
  /**
   * @var int
   */
  public $oczekiwaneOdszkodowanie;
}

class powodReklamacjiType {
  /**
   * @var powodSzczegolowyType
   */
  public $powodSzczegolowy;
  /**
   * @var int
   */
  public $idPowodGlowny;
  /**
   * @var string
   */
  public $powodGlownyOpis;
}

class reklamacjaRozpatrzonaType {
  /**
   * @var string
   */
  public $guid;
  /**
   * @var string
   */
  public $numerNadania;
  /**
   * @var string
   */
  public $rozstrzygniecie;
  /**
   * @var int
   */
  public $przyznaneOdszkodowanie;
  /**
   * @var string
   */
  public $uzasadnienie;
  /**
   * @var date
   */
  public $dataRozpatrzenia;
  /**
   * @var string
   */
  public $nazwaJednostkiRozpatrujacej;
  /**
   * @var string
   */
  public $osobaRozpatrujaca;
  /**
   * @var string
   */
  public $idReklamacja;
}

class rozstrzygniecieType {
  const UZASADNIONA = 'UZASADNIONA';
  const NIEUZASADNIONA = 'NIEUZASADNIONA';
  const NIEWNIESIONA = 'NIEWNIESIONA';
}

class getListaPowodowReklamacji {
}

class getListaPowodowReklamacjiResponse {
  /**
   * @var kategoriePowodowReklamacjiType
   */
  public $kategoriePowodowReklamacji;
}

class powodSzczegolowyType {
  /**
   * @var int
   */
  public $idPowodSzczegolowy;
  /**
   * @var string
   */
  public $powodSzczegolowyOpis;
}

class kategoriePowodowReklamacjiType {
  /**
   * @var string
   */
  public $nazwa;
  /**
   * @var powodReklamacjiType
   */
  public $powodReklamacji;
}

class listBiznesowyType extends przesylkaNieRejestrowanaType {
  /**
   * @var int
   */
  public $masa;
}

class zamowKuriera {
  /**
   * @var adresType
   */
  public $miejsceOdbioru;
  /**
   * @var adresType
   */
  public $nadawca;
  /**
   * @var string
   */
  public $oczekiwanaDataOdbioru;
  /**
   * @var string
   */
  public $oczekiwanaGodzinaOdbioru;
  /**
   * @var string
   */
  public $szacowanaIloscPrzeslek;
  /**
   * @var string
   */
  public $szacowanaLacznaMasaPrzesylek;
}

class zamowKurieraResponse {
  /**
   * @var errorType
   */
  public $error;
}

class getEZDOList {
}

class getEZDOListResponse {
  /**
   * @var EZDOPakietType
   */
  public $EZDOPakiet;
}

class getEZDO {
  /**
   * @var int
   */
  public $idEZDOPakiet;
}

class getEZDOResponse {
  /**
   * @var adresType
   */
  public $adres;
  /**
   * @var EZDOPrzesylkaType
   */
  public $przesylka;
  /**
   * @var errorType
   */
  public $error;
  /**
   * @var string
   */
  public $numerKD;
  /**
   * @var string
   */
  public $numerEZDO;
}

class EZDOPakietType {
  /**
   * @var int
   */
  public $idEZDOPakiet;
  /**
   * @var date
   */
  public $exported;
  /**
   * @var string
   */
  public $idEZDOFile;
}

class EZDOPrzesylkaType {
  /**
   * @var string
   */
  public $numerNadania;
  /**
   * @var string
   */
  public $rodzaj;
  /**
   * @var string
   */
  public $kategoria;
  /**
   * @var int
   */
  public $masa;
  /**
   * @var int
   */
  public $wartosc;
  /**
   * @var int
   */
  public $kwotaPobrania;
  /**
   * @var string
   */
  public $numerWewnetrznyPrzesylki;
  /**
   * @var string
   */
  public $zwrot;
}

class wplataCKPType {
  /**
   * @var string
   */
  public $unikalnyIdentyfikatorWplaty;
  /**
   * @var string
   */
  public $numerNadania;
  /**
   * @var int
   */
  public $kwota;
  /**
   * @var date
   */
  public $dataPobrania;
  /**
   * @var date
   */
  public $dataPrzelewu;
  /**
   * @var int
   */
  public $idUmowy;
  /**
   * @var string
   */
  public $tytulPrzelewuZbiorczego;
}

class getWplatyCKP {
  /**
   * @var string
   */
  public $numerNadania;
  /**
   * @var date
   */
  public $startDate;
  /**
   * @var date
   */
  public $stopDate;
}

class getWplatyCKPResponse {
  /**
   * @var wplataCKPType
   */
  public $wplaty;
  /**
   * @var errorType
   */
  public $error;
}

class globalExpresType extends przesylkaRejestrowanaType {
  /**
   * @var ubezpieczenieType
   */
  public $ubezpieczenie;
  /**
   * @var potwierdzenieDoreczeniaType
   */
  public $potwierdzenieDoreczenia;
  /**
   * @var deklaracjaCelna2Type
   */
  public $deklaracjaCelna2;
  /**
   * @var int
   */
  public $masa;
  /**
   * @var bool
   */
  public $posteRestante;
  /**
   * @var string
   */
  public $zawartosc;
  /**
   * @var string
   */
  public $kategoria;
  /**
   * @var string
   */
  public $numerPrzesylkiKlienta;
}

class cancelReklamacja {
  /**
   * @var int
   */
  public $idRelkamacja;
}

class cancelReklamacjaResponse {
  /**
   * @var errorType
   */
  public $error;
}

class zalacznikDoReklamacjiType {
  /**
   * @var string
   */
  public $fileContent;
  /**
   * @var string
   */
  public $fileName;
  /**
   * @var string
   */
  public $fileDesc;
}

class addZalacznikDoReklamacji {
  /**
   * @var string
   */
  public $idReklamacja;
  /**
   * @var zalacznikDoReklamacjiType
   */
  public $zalacznik;
}

class addZalacznikDoReklamacjiResponse {
  /**
   * @var errorType
   */
  public $error;
}

class updateShopEZwroty {
  /**
   * @var shopEZwrotyType
   */
  public $shop;
}

class updateShopEZwrotyResponse {
  /**
   * @var errorType
   */
  public $error;
}

class shopEZwrotyType {
  /**
   * @var string
   */
  public $eZwrotPrzesylki;
  /**
   * @var int
   */
  public $idShop;
  /**
   * @var string
   */
  public $nazwa;
  /**
   * @var string
   */
  public $nazwa2;
  /**
   * @var string
   */
  public $przyjaznaNazwa;
  /**
   * @var string
   */
  public $ulica;
  /**
   * @var string
   */
  public $numerDomu;
  /**
   * @var string
   */
  public $numerLokalu;
  /**
   * @var string
   */
  public $miejscowosc;
  /**
   * @var string
   */
  public $kodPocztowy;
  /**
   * @var string
   */
  public $mobile;
  /**
   * @var string
   */
  public $email;
  /**
   * @var string
   */
  public $nip;
  /**
   * @var string
   */
  public $regon;
  /**
   * @var string
   */
  public $krs;
  /**
   * @var string
   */
  public $eZwrotTyp;
  /**
   * @var bool
   */
  public $wymagalnoscNumeruIdentyfikujacegoPrzesylke;
}

class nazwaEZwrotyType {
}

class statusZgodyEZwrotNameType {
  const NOWY = 'NOWY';
  const ZAAKCEPTOWANY = 'ZAAKCEPTOWANY';
  const ODRZUCONY = 'ODRZUCONY';
}

class eZwrotPrzesylkiType {
  const ZWROTPACZKA48 = 'ZWROTPACZKA48';
  const ZWROTKURIEREKSPRES24 = 'ZWROTKURIEREKSPRES24';
}

class getListaZgodEZwrotow {
  /**
   * @var string
   */
  public $status;
}

class getListaZgodEZwrotowResponse {
  /**
   * @var oczekujeNaZgodeEZwrotType
   */
  public $lista;
  /**
   * @var errorType
   */
  public $error;
}

class oczekujeNaZgodeEZwrotType {
  /**
   * @var shopEZwrotyType
   */
  public $sklepEZwrot;
  /**
   * @var int
   */
  public $idZgody;
  /**
   * @var string
   */
  public $nazwaProduktu;
  /**
   * @var string
   */
  public $numerZamowienia;
  /**
   * @var string
   */
  public $numerNadania;
  /**
   * @var string
   */
  public $email;
  /**
   * @var date
   */
  public $dataNadania;
  /**
   * @var string
   */
  public $guidZgodaEZwrot;
}

class nazwaProduktuEZwrotType {
}

class numerZamowieniaEZwrotType {
}

class setStatusZgodyNaEZwrot {
  /**
   * @var statusZgodyEZwrotType
   */
  public $statusZgody;
}

class setStatusZgodyNaEZwrotResponse {
  /**
   * @var errorType
   */
  public $error;
}

class statusZgodyEZwrotType {
  /**
   * @var string
   */
  public $eZwrotPrzesylki;
  /**
   * @var string
   */
  public $guidZgodaEZwrot;
  /**
   * @var string
   */
  public $status;
  /**
   * @var bool
   */
  public $platnoscZaPrzesylke;
  /**
   * @var int
   */
  public $kosztKontrahenta;
  /**
   * @var date
   */
  public $dataWygasnieciaZgody;
}

class eZwrotTypZgodyType {
  const ZGODA_BRAK = 'ZGODA_BRAK';
  const ZGODA_AUTOMATYCZNA = 'ZGODA_AUTOMATYCZNA';
  const ZGODA_INDYWIDUALNA = 'ZGODA_INDYWIDUALNA';
}

class przesylkaEZwrotPocztexType extends przesylkaRejestrowanaType {
  /**
   * @var string
   */
  public $numerNadaniaZwrot;
}

class przesylkaEZwrotPaczkaType extends przesylkaRejestrowanaType {
  /**
   * @var string
   */
  public $numerNadaniaZwrot;
}

class nazwaProduktuType {
}

class numerZamowieniaType {
}

class wyslijLinkaOStatusieEZwrotu {
  /**
   * @var string
   */
  public $guidZgodaEZwrot;
}

class wyslijLinkaOStatusieEZwrotuResponse {
  /**
   * @var errorType
   */
  public $error;
}

class isObszarMiasto {
  /**
   * @var obszarAdresowyType
   */
  public $adres;
}

class isObszarMiastoResponse {
  /**
   * @var obszarAdresowyResponseType
   */
  public $obszarAdresowy;
}

class obszarAdresowyType {
  /**
   * @var string
   */
  public $kodPocztowy;
  /**
   * @var string
   */
  public $miejscowosc;
  /**
   * @var string
   */
  public $ulica;
  /**
   * @var string
   */
  public $numerDomu;
  /**
   * @var string
   */
  public $guid;
}

class obszarAdresowyResponseType {
  /**
   * @var bool
   */
  public $isObszarMiasto;
  /**
   * @var string
   */
  public $guid;
}

class getPaczkaKorzysciInfo {
}

class statusPaczkaKorzysciType {
  const ERROR = 'ERROR';
  const NIEAKTYWNA = 'NIEAKTYWNA';
  const AKTYWNA = 'AKTYWNA';
  const PRZETERMINOWANA = 'PRZETERMINOWANA';
}

class infoPaczkaKorzysciType {
  /**
   * @var int
   */
  public $iloscStandardDo5kg;
  /**
   * @var int
   */
  public $iloscPobranieDo5kg;
  /**
   * @var int
   */
  public $iloscOdbiorWPunkcieDo5kg;
  /**
   * @var int
   */
  public $iloscPobranieOdbiorWPunkcieDo5kg;
  /**
   * @var int
   */
  public $iloscStandardDo30kg;
  /**
   * @var int
   */
  public $iloscPobranieDo30kg;
  /**
   * @var int
   */
  public $iloscOdbiorWPunkcieDo30kg;
  /**
   * @var int
   */
  public $iloscPobranieOdbiorWPunkcieDo30kg;
  /**
   * @var date
   */
  public $dataWaznosciUmowy;
}

class getPaczkaKorzysciInfoResponse {
  /**
   * @var string
   */
  public $status;
  /**
   * @var int
   */
  public $idKarta;
  /**
   * @var infoPaczkaKorzysciType
   */
  public $info;
  /**
   * @var errorType
   */
  public $error;
}

class reklamacjaInfoType {
  /**
   * @var string
   */
  public $idReklamacja;
  /**
   * @var string
   */
  public $guidPrzesylki;
}

class setJednostkaOrganizacyjna {
  /**
   * @var string
   */
  public $jednostkaOrganizacyjna;
}

class setJednostkaOrganizacyjnaResponse {
  /**
   * @var errorType
   */
  public $error;
  /**
   * @var string
   */
  public $jednostkaOrganizacyjna;
}

class jednostkaOrganizacyjnaType {
  /**
   * @var accountType
   */
  public $account;
  /**
   * @var string
   */
  public $jednostkaNadrzedna;
  /**
   * @var int
   */
  public $id;
  /**
   * @var anonymous313
   */
  public $nazwa;
  /**
   * @var anonymous314
   */
  public $opis;
  /**
   * @var string
   */
  public $mpk;
}

class anonymous313 {
}

class anonymous314 {
}

class getJednostkaOrganizacyjna {
  /**
   * @var string
   */
  public $jednostka;
}

class getJednostkaOrganizacyjnaResponse {
  /**
   * @var string
   */
  public $jednostkaOrganizacyjna;
  /**
   * @var errorType
   */
  public $error;
}

class siecPlacowekEnum {
  const POCZTAPOLSKA = 'POCZTAPOLSKA';
  const ORLEN = 'ORLEN';
}

class numerTransakcjiOdbioruType {
}

class daneSentType {
  /**
   * @var string
   */
  public $numer;
  /**
   * @var string
   */
  public $kluczPrzewoznika;
  /**
   * @var string
   */
  public $kodCN;
  /**
   * @var string
   */
  public $kodPKWiU;
  /**
   * @var decimal
   */
  public $masa;
  /**
   * @var bool
   */
  public $proceduraAwaryjna;
}

class awizacjaType {
  /**
   * @var time
   */
  public $od;
  /**
   * @var time
   */
  public $do;
}

class formatType {
  const S = 'S';
  const M = 'M';
  const L = 'L';
}

class przesylkaNierejestrowanaKrajowaType extends przesylkaNieRejestrowanaType {
  /**
   * @var string
   */
  public $kategoria;
  /**
   * @var string
   */
  public $format;
  /**
   * @var int
   */
  public $masa;
}

class listWartosciowyKrajowyType extends przesylkaRejestrowanaType {
  /**
   * @var bool
   */
  public $posteRestante;
  /**
   * @var int
   */
  public $wartosc;
  /**
   * @var int
   */
  public $iloscPotwierdzenOdbioru;
  /**
   * @var string
   */
  public $kategoria;
  /**
   * @var string
   */
  public $format;
  /**
   * @var int
   */
  public $masa;
  /**
   * @var string
   */
  public $numerWewnetrznyPrzesylki;
  /**
   * @var bool
   */
  public $egzemplarzBiblioteczny;
  /**
   * @var bool
   */
  public $dlaOciemnialych;
}

class przyczynaZwrotuDodatkowaType {
}

class relatedToAllegroType {
  /**
   * @var string
   */
  public $id;
  /**
   * @var string
   */
  public $sellerId;
  /**
   * @var string
   */
  public $channel;
  /**
   * @var string
   */
  public $deliveryMethod;
}

class relatedToAllegroIdType {
}

class relatedToAllegroSellerIdType {
}

class relatedToAllegroChannelType {
  const MS = 'MS';
  const WEB_API = 'WEB_API';
  const REST_API = 'REST_API';
}

class relatedToAllegroDeliveryMethodType {
}

class getPrintForParcel {
  /**
   * @var string
   */
  public $guid;
  /**
   * @var PrintType
   */
  public $type;
}

class getPrintForParcelResponse {
  /**
   * @var PrintResultType
   */
  public $printResult;
  /**
   * @var errorType
   */
  public $error;
}

class PrintType {
  /**
   * @var string
   */
  public $kind;
  /**
   * @var string
   */
  public $method;
}

class PrintMethodEnum {
  const EACH_PARCEL_SEPARATELY = 'EACH_PARCEL_SEPARATELY';
  const ALL_PARCELS_IN_ONE_FILE = 'ALL_PARCELS_IN_ONE_FILE';
}

class PrintKindEnum {
  const ADDRESS_LABEL = 'ADDRESS_LABEL';
  const CUSTOMS_DECLARATION = 'CUSTOMS_DECLARATION';
  const ADDRESS_LABEL_FOR_RETURN_DOCUMENTS = 'ADDRESS_LABEL_FOR_RETURN_DOCUMENTS';
  const CHECKLIST = 'CHECKLIST';
  const COLLECT_ON_DELIVERY_FORM = 'COLLECT_ON_DELIVERY_FORM';
  const WAYBILL = 'WAYBILL';
  const REPORT = 'REPORT';
  const ADDRESS_LABEL_FOR_ERETURN = 'ADDRESS_LABEL_FOR_ERETURN';
}

class PrintResultType {
  /**
   * @var string
   */
  public $guid;
  /**
   * @var string
   */
  public $print;
}

class deklaracjaCelna2Type {
  /**
   * @var string
   */
  public $rodzaj;
  /**
   * @var string
   */
  public $zawartoscPrzesylki;
  /**
   * @var DokumentyTowarzyszaceType
   */
  public $dokumentyTowarzyszace;
  /**
   * @var string
   */
  public $wyjasnienie;
  /**
   * @var string
   */
  public $oplatyPocztowe;
  /**
   * @var string
   */
  public $uwagi;
  /**
   * @var string
   */
  public $numerReferencyjnyImportera;
  /**
   * @var string
   */
  public $numerTelefonuImportera;
  /**
   * @var string
   */
  public $walutaKodISO;
  /**
   * @var SzczegolyZawartosciPrzesylkiZagranicznejType
   */
  public $szczegolyZawartosciPrzesylki;
  /**
   * @var string
   */
  public $numerReferencyjnyCelny;
}

class ZawartoscPrzesylkiZagranicznejEnum {
  const SPRZEDAZ_TOWARU = 'SPRZEDAZ_TOWARU';
  const ZWROT_TOWARU = 'ZWROT_TOWARU';
  const PREZENT = 'PREZENT';
  const PROBKA_HANDLOWA = 'PROBKA_HANDLOWA';
  const DOKUMENT = 'DOKUMENT';
  const INNE = 'INNE';
}

class DokumentyTowarzyszaceType {
  /**
   * @var string
   */
  public $rodzaj;
  /**
   * @var string
   */
  public $numer;
}

class DokumentTowarzyszacyRodzajEnum {
  const LICENCJA = 'LICENCJA';
  const CERTYFIKAT = 'CERTYFIKAT';
  const FAKTURA = 'FAKTURA';
}

class DeklaracaCelnaRodzajEnum {
  const CN22 = 'CN22';
  const CN23 = 'CN23';
}

class SzczegolyZawartosciPrzesylkiZagranicznejType {
  /**
   * @var string
   */
  public $okreslenieZawartosci;
  /**
   * @var int
   */
  public $ilosc;
  /**
   * @var int
   */
  public $masaNetto;
  /**
   * @var float
   */
  public $wartosc;
  /**
   * @var string
   */
  public $numerTaryfyHs;
  /**
   * @var string
   */
  public $krajPochodzeniaKodAlfa2;
}

class EpoVersionType {
}

class sposobNadaniaInterconnectType {
}


/**
 * ElektronicznyNadawca class
 * 
 *  
 * 
 * @author    {author}
 * @copyright {copyright}
 * @package   {package}
 */
class ElektronicznyNadawca extends SoapClient {

  private static $classmap = array(
                                    'addShipment' => 'addShipment',
                                    'addShipmentResponse' => 'addShipmentResponse',
                                    'przesylkaType' => 'przesylkaType',
                                    'pocztexKrajowyType' => 'pocztexKrajowyType',
                                    'umowaType' => 'umowaType',
                                    'masaType' => 'masaType',
                                    'numerNadaniaType' => 'numerNadaniaType',
                                    'changePassword' => 'changePassword',
                                    'changePasswordResponse' => 'changePasswordResponse',
                                    'terminRodzajType' => 'terminRodzajType',
                                    'uiszczaOplateType' => 'uiszczaOplateType',
                                    'wartoscType' => 'wartoscType',
                                    'kwotaPobraniaType' => 'kwotaPobraniaType',
                                    'sposobPobraniaType' => 'sposobPobraniaType',
                                    'sposobPrzekazaniaType' => 'sposobPrzekazaniaType',
                                    'sposobDoreczeniaPotwierdzeniaType' => 'sposobDoreczeniaPotwierdzeniaType',
                                    'iloscPotwierdzenOdbioruType' => 'iloscPotwierdzenOdbioruType',
                                    'dataDlaDostarczeniaType' => 'dataDlaDostarczeniaType',
                                    'razemType' => 'razemType',
                                    'nazwaType' => 'nazwaType',
                                    'nazwa2Type' => 'nazwa2Type',
                                    'ulicaType' => 'ulicaType',
                                    'numerDomuType' => 'numerDomuType',
                                    'numerLokaluType' => 'numerLokaluType',
                                    'miejscowoscType' => 'miejscowoscType',
                                    'kodPocztowyType' => 'kodPocztowyType',
                                    'terminType' => 'terminType',
                                    'sygnaturaType' => 'sygnaturaType',
                                    'rodzajType' => 'rodzajType',
                                    'paczkaPocztowaType' => 'paczkaPocztowaType',
                                    'kategoriaType' => 'kategoriaType',
                                    'gabarytType' => 'gabarytType',
                                    'paczkaPocztowaPLUSType' => 'paczkaPocztowaPLUSType',
                                    'przesylkaPobraniowaType' => 'przesylkaPobraniowaType',
                                    'przesylkaNaWarunkachSzczegolnychType' => 'przesylkaNaWarunkachSzczegolnychType',
                                    'przesylkaPoleconaKrajowaType' => 'przesylkaPoleconaKrajowaType',
                                    'przesylkaHandlowaType' => 'przesylkaHandlowaType',
                                    'przesylkaListowaZadeklarowanaWartoscType' => 'przesylkaListowaZadeklarowanaWartoscType',
                                    'przesylkaFullType' => 'przesylkaFullType',
                                    'errorType' => 'errorType',
                                    'adresType' => 'adresType',
                                    'sendEnvelope' => 'sendEnvelope',
                                    'sendEnvelopeResponseType' => 'sendEnvelopeResponseType',
                                    'urzadNadaniaType' => 'urzadNadaniaType',
                                    'getUrzedyNadania' => 'getUrzedyNadania',
                                    'getUrzedyNadaniaResponse' => 'getUrzedyNadaniaResponse',
                                    'clearEnvelope' => 'clearEnvelope',
                                    'clearEnvelopeResponse' => 'clearEnvelopeResponse',
                                    'urzadNadaniaFullType' => 'urzadNadaniaFullType',
                                    'guidType' => 'guidType',
                                    'ePrzesylkaType' => 'ePrzesylkaType',
                                    'eSposobPowiadomieniaType' => 'eSposobPowiadomieniaType',
                                    'eKontaktType' => 'eKontaktType',
                                    'urzadWydaniaEPrzesylkiType' => 'urzadWydaniaEPrzesylkiType',
                                    'pobranieType' => 'pobranieType',
                                    'anonymous55' => 'anonymous55',
                                    'anonymous56' => 'anonymous56',
                                    'przesylkaPoleconaZagranicznaType' => 'przesylkaPoleconaZagranicznaType',
                                    'przesylkaZadeklarowanaWartoscZagranicznaType' => 'przesylkaZadeklarowanaWartoscZagranicznaType',
                                    'krajType' => 'krajType',
                                    'getUrzedyWydajaceEPrzesylki' => 'getUrzedyWydajaceEPrzesylki',
                                    'getUrzedyWydajaceEPrzesylkiResponse' => 'getUrzedyWydajaceEPrzesylkiResponse',
                                    'uploadIWDContent' => 'uploadIWDContent',
                                    'getEnvelopeStatus' => 'getEnvelopeStatus',
                                    'getEnvelopeStatusResponse' => 'getEnvelopeStatusResponse',
                                    'envelopeStatusType' => 'envelopeStatusType',
                                    'downloadIWDContent' => 'downloadIWDContent',
                                    'downloadIWDContentResponse' => 'downloadIWDContentResponse',
                                    'przesylkaShortType' => 'przesylkaShortType',
                                    'addShipmentResponseItemType' => 'addShipmentResponseItemType',
                                    'getKarty' => 'getKarty',
                                    'getKartyResponse' => 'getKartyResponse',
                                    'getPasswordExpiredDate' => 'getPasswordExpiredDate',
                                    'getPasswordExpiredDateResponse' => 'getPasswordExpiredDateResponse',
                                    'setAktywnaKarta' => 'setAktywnaKarta',
                                    'setAktywnaKartaResponse' => 'setAktywnaKartaResponse',
                                    'getEnvelopeContentFull' => 'getEnvelopeContentFull',
                                    'getEnvelopeContentFullResponse' => 'getEnvelopeContentFullResponse',
                                    'getEnvelopeContentShort' => 'getEnvelopeContentShort',
                                    'getEnvelopeContentShortResponse' => 'getEnvelopeContentShortResponse',
                                    'hello' => 'hello',
                                    'helloResponse' => 'helloResponse',
                                    'kartaType' => 'kartaType',
                                    'telefonType' => 'telefonType',
                                    'getAddressLabel' => 'getAddressLabel',
                                    'getAddressLabelResponse' => 'getAddressLabelResponse',
                                    'addressLabelContent' => 'addressLabelContent',
                                    'getOutboxBook' => 'getOutboxBook',
                                    'getOutboxBookResponse' => 'getOutboxBookResponse',
                                    'getFirmowaPocztaBook' => 'getFirmowaPocztaBook',
                                    'getFirmowaPocztaBookResponse' => 'getFirmowaPocztaBookResponse',
                                    'getEnvelopeList' => 'getEnvelopeList',
                                    'getEnvelopeListResponse' => 'getEnvelopeListResponse',
                                    'envelopeInfoType' => 'envelopeInfoType',
                                    'przesylkaZagranicznaType' => 'przesylkaZagranicznaType',
                                    'przesylkaRejestrowanaType' => 'przesylkaRejestrowanaType',
                                    'przesylkaNieRejestrowanaType' => 'przesylkaNieRejestrowanaType',
                                    'anonymous97' => 'anonymous97',
                                    'przesylkaBiznesowaType' => 'przesylkaBiznesowaType',
                                    'gabarytBiznesowaType' => 'gabarytBiznesowaType',
                                    'subPrzesylkaBiznesowaType' => 'subPrzesylkaBiznesowaType',
                                    'subPrzesylkaBiznesowaPlusType' => 'subPrzesylkaBiznesowaPlusType',
                                    'getAddresLabelByGuid' => 'getAddresLabelByGuid',
                                    'getAddresLabelByGuidResponse' => 'getAddresLabelByGuidResponse',
                                    'przesylkaBiznesowaPlusType' => 'przesylkaBiznesowaPlusType',
                                    'opisType' => 'opisType',
                                    'numerPrzesylkiKlientaType' => 'numerPrzesylkiKlientaType',
                                    'pakietType' => 'pakietType',
                                    'opakowanieType' => 'opakowanieType',
                                    'typOpakowaniaType' => 'typOpakowaniaType',
                                    'getPlacowkiPocztowe' => 'getPlacowkiPocztowe',
                                    'getPlacowkiPocztoweResponse' => 'getPlacowkiPocztoweResponse',
                                    'getGuid' => 'getGuid',
                                    'getGuidResponse' => 'getGuidResponse',
                                    'kierunekType' => 'kierunekType',
                                    'getKierunki' => 'getKierunki',
                                    'prefixKodPocztowy' => 'prefixKodPocztowy',
                                    'getKierunkiResponse' => 'getKierunkiResponse',
                                    'czynnoscUpustowaType' => 'czynnoscUpustowaType',
                                    'miejsceOdbioruType' => 'miejsceOdbioruType',
                                    'sposobNadaniaType' => 'sposobNadaniaType',
                                    'getKierunkiInfo' => 'getKierunkiInfo',
                                    'getKierunkiInfoResponse' => 'getKierunkiInfoResponse',
                                    'kwotaTranzakcjiType' => 'kwotaTranzakcjiType',
                                    'uslugiType' => 'uslugiType',
                                    'idWojewodztwoType' => 'idWojewodztwoType',
                                    'placowkaPocztowaType' => 'placowkaPocztowaType',
                                    'anonymous127' => 'anonymous127',
                                    'anonymous128' => 'anonymous128',
                                    'punktWydaniaPrzesylkiBiznesowejPlus' => 'punktWydaniaPrzesylkiBiznesowejPlus',
                                    'statusType' => 'statusType',
                                    'terminRodzajPlusType' => 'terminRodzajPlusType',
                                    'typOpakowanieType' => 'typOpakowanieType',
                                    'getEnvelopeBufor' => 'getEnvelopeBufor',
                                    'getEnvelopeBuforResponse' => 'getEnvelopeBuforResponse',
                                    'clearEnvelopeByGuids' => 'clearEnvelopeByGuids',
                                    'clearEnvelopeByGuidsResponse' => 'clearEnvelopeByGuidsResponse',
                                    'zwrotDokumentowType' => 'zwrotDokumentowType',
                                    'odbiorPrzesylkiOdNadawcyType' => 'odbiorPrzesylkiOdNadawcyType',
                                    'potwierdzenieDoreczeniaType' => 'potwierdzenieDoreczeniaType',
                                    'rodzajListType' => 'rodzajListType',
                                    'potwierdzenieOdbioruType' => 'potwierdzenieOdbioruType',
                                    'sposobPrzekazaniaPotwierdzeniaOdbioruType' => 'sposobPrzekazaniaPotwierdzeniaOdbioruType',
                                    'doreczenieType' => 'doreczenieType',
                                    'doreczenieUslugaPocztowaType' => 'doreczenieUslugaPocztowaType',
                                    'doreczenieUslugaKurierskaType' => 'doreczenieUslugaKurierskaType',
                                    'oczekiwanaGodzinaDoreczeniaType' => 'oczekiwanaGodzinaDoreczeniaType',
                                    'oczekiwanaGodzinaDoreczeniaUslugiType' => 'oczekiwanaGodzinaDoreczeniaUslugiType',
                                    'paczkaZagranicznaType' => 'paczkaZagranicznaType',
                                    'paczkaZagranicznaPremiumType' => 'paczkaZagranicznaPremiumType',
                                    'setEnvelopeBuforDataNadania' => 'setEnvelopeBuforDataNadania',
                                    'setEnvelopeBuforDataNadaniaResponse' => 'setEnvelopeBuforDataNadaniaResponse',
                                    'lokalizacjaGeograficznaType' => 'lokalizacjaGeograficznaType',
                                    'wspolrzednaGeograficznaType' => 'wspolrzednaGeograficznaType',
                                    'zwrotType' => 'zwrotType',
                                    'sposobZwrotuType' => 'sposobZwrotuType',
                                    'listZwyklyType' => 'listZwyklyType',
                                    'listZwyklyFirmowyType' => 'listZwyklyFirmowyType',
                                    'reklamowaType' => 'reklamowaType',
                                    'getEPOStatus' => 'getEPOStatus',
                                    'getEPOStatusResponse' => 'getEPOStatusResponse',
                                    'statusEPOEnum' => 'statusEPOEnum',
                                    'EPOType' => 'EPOType',
                                    'EPOSimpleType' => 'EPOSimpleType',
                                    'EPOExtendedType' => 'EPOExtendedType',
                                    'zasadySpecjalneEnum' => 'zasadySpecjalneEnum',
                                    'przesylkaEPOType' => 'przesylkaEPOType',
                                    'przesylkaFirmowaPoleconaType' => 'przesylkaFirmowaPoleconaType',
                                    'EPOInfoType' => 'EPOInfoType',
                                    'awizoPrzesylkiType' => 'awizoPrzesylkiType',
                                    'doreczeniePrzesylkiType' => 'doreczeniePrzesylkiType',
                                    'zwrotPrzesylkiType' => 'zwrotPrzesylkiType',
                                    'miejscaPozostawieniaAwizoEnum' => 'miejscaPozostawieniaAwizoEnum',
                                    'podmiotDoreczeniaEnum' => 'podmiotDoreczeniaEnum',
                                    'przyczynaZwrotuEnum' => 'przyczynaZwrotuEnum',
                                    'miejscePozostawieniaZawiadomieniaODoreczeniuEnum' => 'miejscePozostawieniaZawiadomieniaODoreczeniuEnum',
                                    'getAddresLabelCompact' => 'getAddresLabelCompact',
                                    'getAddresLabelCompactResponse' => 'getAddresLabelCompactResponse',
                                    'getAddresLabelByGuidCompact' => 'getAddresLabelByGuidCompact',
                                    'getAddresLabelByGuidCompactResponse' => 'getAddresLabelByGuidCompactResponse',
                                    'ubezpieczenieType' => 'ubezpieczenieType',
                                    'rodzajUbezpieczeniaType' => 'rodzajUbezpieczeniaType',
                                    'kwotaUbezpieczeniaType' => 'kwotaUbezpieczeniaType',
                                    'emailType' => 'emailType',
                                    'mobileType' => 'mobileType',
                                    'EMSType' => 'EMSType',
                                    'EMSTypOpakowaniaType' => 'EMSTypOpakowaniaType',
                                    'getEnvelopeBuforList' => 'getEnvelopeBuforList',
                                    'getEnvelopeBuforListResponse' => 'getEnvelopeBuforListResponse',
                                    'buforType' => 'buforType',
                                    'createEnvelopeBufor' => 'createEnvelopeBufor',
                                    'createEnvelopeBuforResponse' => 'createEnvelopeBuforResponse',
                                    'moveShipments' => 'moveShipments',
                                    'moveShipmentsResponse' => 'moveShipmentsResponse',
                                    'updateEnvelopeBufor' => 'updateEnvelopeBufor',
                                    'updateEnvelopeBuforResponse' => 'updateEnvelopeBuforResponse',
                                    'getUbezpieczeniaInfo' => 'getUbezpieczeniaInfo',
                                    'getUbezpieczeniaInfoResponse' => 'getUbezpieczeniaInfoResponse',
                                    'ubezpieczeniaInfoType' => 'ubezpieczeniaInfoType',
                                    'isMiejscowa' => 'isMiejscowa',
                                    'isMiejscowaResponse' => 'isMiejscowaResponse',
                                    'trasaRequestType' => 'trasaRequestType',
                                    'trasaResponseType' => 'trasaResponseType',
                                    'deklaracjaCelnaType' => 'deklaracjaCelnaType',
                                    'szczegolyDeklaracjiCelnejType' => 'szczegolyDeklaracjiCelnejType',
                                    'przesylkaPaletowaType' => 'przesylkaPaletowaType',
                                    'rodzajPaletyType' => 'rodzajPaletyType',
                                    'paletaType' => 'paletaType',
                                    'platnikType' => 'platnikType',
                                    'subPrzesylkaPaletowaType' => 'subPrzesylkaPaletowaType',
                                    'getBlankietPobraniaByGuids' => 'getBlankietPobraniaByGuids',
                                    'getBlankietPobraniaByGuidsResponse' => 'getBlankietPobraniaByGuidsResponse',
                                    'updateAccount' => 'updateAccount',
                                    'updateAccountResponse' => 'updateAccountResponse',
                                    'accountType' => 'accountType',
                                    'permisionType' => 'permisionType',
                                    'getAccountList' => 'getAccountList',
                                    'getAccountListResponse' => 'getAccountListResponse',
                                    'profilType' => 'profilType',
                                    'getProfilList' => 'getProfilList',
                                    'getProfilListResponse' => 'getProfilListResponse',
                                    'updateProfil' => 'updateProfil',
                                    'updateProfilResponse' => 'updateProfilResponse',
                                    'statusAccountType' => 'statusAccountType',
                                    'uslugaPaczkowaType' => 'uslugaPaczkowaType',
                                    'subUslugaPaczkowaType' => 'subUslugaPaczkowaType',
                                    'terminPaczkowaType' => 'terminPaczkowaType',
                                    'opakowaniePocztowaType' => 'opakowaniePocztowaType',
                                    'uslugaKurierskaType' => 'uslugaKurierskaType',
                                    'subUslugaKurierskaType' => 'subUslugaKurierskaType',
                                    'createAccount' => 'createAccount',
                                    'createAccountResponse' => 'createAccountResponse',
                                    'createProfil' => 'createProfil',
                                    'createProfilResponse' => 'createProfilResponse',
                                    'terminKurierskaType' => 'terminKurierskaType',
                                    'opakowanieKurierskaType' => 'opakowanieKurierskaType',
                                    'zwrotDokumentowPaczkowaType' => 'zwrotDokumentowPaczkowaType',
                                    'potwierdzenieOdbioruPaczkowaType' => 'potwierdzenieOdbioruPaczkowaType',
                                    'sposobPrzekazaniaPotwierdzeniaOdbioruPocztowaType' => 'sposobPrzekazaniaPotwierdzeniaOdbioruPocztowaType',
                                    'zwrotDokumentowKurierskaType' => 'zwrotDokumentowKurierskaType',
                                    'terminZwrotDokumentowKurierskaType' => 'terminZwrotDokumentowKurierskaType',
                                    'terminZwrotDokumentowPaczkowaType' => 'terminZwrotDokumentowPaczkowaType',
                                    'potwierdzenieOdbioruKurierskaType' => 'potwierdzenieOdbioruKurierskaType',
                                    'sposobPrzekazaniaPotwierdzeniaOdbioruKurierskaType' => 'sposobPrzekazaniaPotwierdzeniaOdbioruKurierskaType',
                                    'addReklamacje' => 'addReklamacje',
                                    'addReklamacjeResponse' => 'addReklamacjeResponse',
                                    'getReklamacje' => 'getReklamacje',
                                    'getReklamacjeResponse' => 'getReklamacjeResponse',
                                    'getZapowiedziFaktur' => 'getZapowiedziFaktur',
                                    'getZapowiedziFakturResponse' => 'getZapowiedziFakturResponse',
                                    'addOdwolanieDoReklamacji' => 'addOdwolanieDoReklamacji',
                                    'addOdwolanieDoReklamacjiResponse' => 'addOdwolanieDoReklamacjiResponse',
                                    'addRozbieznoscDoZapowiedziFaktur' => 'addRozbieznoscDoZapowiedziFaktur',
                                    'addRozbieznoscDoZapowiedziFakturResponse' => 'addRozbieznoscDoZapowiedziFakturResponse',
                                    'reklamowanaPrzesylkaType' => 'reklamowanaPrzesylkaType',
                                    'powodReklamacjiType' => 'powodReklamacjiType',
                                    'reklamacjaRozpatrzonaType' => 'reklamacjaRozpatrzonaType',
                                    'rozstrzygniecieType' => 'rozstrzygniecieType',
                                    'getListaPowodowReklamacji' => 'getListaPowodowReklamacji',
                                    'getListaPowodowReklamacjiResponse' => 'getListaPowodowReklamacjiResponse',
                                    'powodSzczegolowyType' => 'powodSzczegolowyType',
                                    'kategoriePowodowReklamacjiType' => 'kategoriePowodowReklamacjiType',
                                    'listBiznesowyType' => 'listBiznesowyType',
                                    'zamowKuriera' => 'zamowKuriera',
                                    'zamowKurieraResponse' => 'zamowKurieraResponse',
                                    'getEZDOList' => 'getEZDOList',
                                    'getEZDOListResponse' => 'getEZDOListResponse',
                                    'getEZDO' => 'getEZDO',
                                    'getEZDOResponse' => 'getEZDOResponse',
                                    'EZDOPakietType' => 'EZDOPakietType',
                                    'EZDOPrzesylkaType' => 'EZDOPrzesylkaType',
                                    'wplataCKPType' => 'wplataCKPType',
                                    'getWplatyCKP' => 'getWplatyCKP',
                                    'getWplatyCKPResponse' => 'getWplatyCKPResponse',
                                    'globalExpresType' => 'globalExpresType',
                                    'cancelReklamacja' => 'cancelReklamacja',
                                    'cancelReklamacjaResponse' => 'cancelReklamacjaResponse',
                                    'zalacznikDoReklamacjiType' => 'zalacznikDoReklamacjiType',
                                    'addZalacznikDoReklamacji' => 'addZalacznikDoReklamacji',
                                    'addZalacznikDoReklamacjiResponse' => 'addZalacznikDoReklamacjiResponse',
                                    'updateShopEZwroty' => 'updateShopEZwroty',
                                    'updateShopEZwrotyResponse' => 'updateShopEZwrotyResponse',
                                    'shopEZwrotyType' => 'shopEZwrotyType',
                                    'nazwaEZwrotyType' => 'nazwaEZwrotyType',
                                    'statusZgodyEZwrotNameType' => 'statusZgodyEZwrotNameType',
                                    'eZwrotPrzesylkiType' => 'eZwrotPrzesylkiType',
                                    'getListaZgodEZwrotow' => 'getListaZgodEZwrotow',
                                    'getListaZgodEZwrotowResponse' => 'getListaZgodEZwrotowResponse',
                                    'oczekujeNaZgodeEZwrotType' => 'oczekujeNaZgodeEZwrotType',
                                    'nazwaProduktuEZwrotType' => 'nazwaProduktuEZwrotType',
                                    'numerZamowieniaEZwrotType' => 'numerZamowieniaEZwrotType',
                                    'setStatusZgodyNaEZwrot' => 'setStatusZgodyNaEZwrot',
                                    'setStatusZgodyNaEZwrotResponse' => 'setStatusZgodyNaEZwrotResponse',
                                    'statusZgodyEZwrotType' => 'statusZgodyEZwrotType',
                                    'eZwrotTypZgodyType' => 'eZwrotTypZgodyType',
                                    'przesylkaEZwrotPocztexType' => 'przesylkaEZwrotPocztexType',
                                    'przesylkaEZwrotPaczkaType' => 'przesylkaEZwrotPaczkaType',
                                    'nazwaProduktuType' => 'nazwaProduktuType',
                                    'numerZamowieniaType' => 'numerZamowieniaType',
                                    'wyslijLinkaOStatusieEZwrotu' => 'wyslijLinkaOStatusieEZwrotu',
                                    'wyslijLinkaOStatusieEZwrotuResponse' => 'wyslijLinkaOStatusieEZwrotuResponse',
                                    'isObszarMiasto' => 'isObszarMiasto',
                                    'isObszarMiastoResponse' => 'isObszarMiastoResponse',
                                    'obszarAdresowyType' => 'obszarAdresowyType',
                                    'obszarAdresowyResponseType' => 'obszarAdresowyResponseType',
                                    'getPaczkaKorzysciInfo' => 'getPaczkaKorzysciInfo',
                                    'statusPaczkaKorzysciType' => 'statusPaczkaKorzysciType',
                                    'infoPaczkaKorzysciType' => 'infoPaczkaKorzysciType',
                                    'getPaczkaKorzysciInfoResponse' => 'getPaczkaKorzysciInfoResponse',
                                    'reklamacjaInfoType' => 'reklamacjaInfoType',
                                    'setJednostkaOrganizacyjna' => 'setJednostkaOrganizacyjna',
                                    'setJednostkaOrganizacyjnaResponse' => 'setJednostkaOrganizacyjnaResponse',
                                    'jednostkaOrganizacyjnaType' => 'jednostkaOrganizacyjnaType',
                                    'anonymous313' => 'anonymous313',
                                    'anonymous314' => 'anonymous314',
                                    'getJednostkaOrganizacyjna' => 'getJednostkaOrganizacyjna',
                                    'getJednostkaOrganizacyjnaResponse' => 'getJednostkaOrganizacyjnaResponse',
                                    'siecPlacowekEnum' => 'siecPlacowekEnum',
                                    'numerTransakcjiOdbioruType' => 'numerTransakcjiOdbioruType',
                                    'daneSentType' => 'daneSentType',
                                    'awizacjaType' => 'awizacjaType',
                                    'formatType' => 'formatType',
                                    'przesylkaNierejestrowanaKrajowaType' => 'przesylkaNierejestrowanaKrajowaType',
                                    'listWartosciowyKrajowyType' => 'listWartosciowyKrajowyType',
                                    'przyczynaZwrotuDodatkowaType' => 'przyczynaZwrotuDodatkowaType',
                                    'relatedToAllegroType' => 'relatedToAllegroType',
                                    'relatedToAllegroIdType' => 'relatedToAllegroIdType',
                                    'relatedToAllegroSellerIdType' => 'relatedToAllegroSellerIdType',
                                    'relatedToAllegroChannelType' => 'relatedToAllegroChannelType',
                                    'relatedToAllegroDeliveryMethodType' => 'relatedToAllegroDeliveryMethodType',
                                    'getPrintForParcel' => 'getPrintForParcel',
                                    'getPrintForParcelResponse' => 'getPrintForParcelResponse',
                                    'PrintType' => 'PrintType',
                                    'PrintMethodEnum' => 'PrintMethodEnum',
                                    'PrintKindEnum' => 'PrintKindEnum',
                                    'PrintResultType' => 'PrintResultType',
                                    'deklaracjaCelna2Type' => 'deklaracjaCelna2Type',
                                    'ZawartoscPrzesylkiZagranicznejEnum' => 'ZawartoscPrzesylkiZagranicznejEnum',
                                    'DokumentyTowarzyszaceType' => 'DokumentyTowarzyszaceType',
                                    'DokumentTowarzyszacyRodzajEnum' => 'DokumentTowarzyszacyRodzajEnum',
                                    'DeklaracaCelnaRodzajEnum' => 'DeklaracaCelnaRodzajEnum',
                                    'SzczegolyZawartosciPrzesylkiZagranicznejType' => 'SzczegolyZawartosciPrzesylkiZagranicznejType',
                                    'EpoVersionType' => 'EpoVersionType',
                                    'sposobNadaniaInterconnectType' => 'sposobNadaniaInterconnectType',
                                   );
                                   

  public function __construct($wsdl = "en.wsdl", $options = array()) {
    foreach(self::$classmap as $key => $value) {
      if(!isset($options['classmap'][$key])) {
        $options['classmap'][$key] = $value;
      }
    }

    
    parent::__construct($wsdl, $options);
  }

}

?>
