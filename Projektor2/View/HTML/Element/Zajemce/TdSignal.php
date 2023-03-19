<?php
/**
 * Description
 *
 * @author pes2704
 */
class Projektor2_View_HTML_Element_Zajemce_TdSignal extends Projektor2_View_HTML_Element_TdSignalAbstract {
    public function render() {
        $model = $this->context['model'];
        switch ($model->status) {
            case 'registrace ok':
                $class = 'signal signal-registration-ok';
                $title = 'Osobní údaje komplentní';
                break;
            case 'registrace chyba':
                $class = 'signal signal-registration-error';
                $title = 'Osobní údaje nekomplentní';
                break;
            case 'none':
                $class = 'signal signal-none';
                $title = 'není zadáno';
                break;
            case 'plan':
                $class = 'signal signal-plan';
                $title = 'naplánováno';
                break;
            case 'ukonceni':
                $class = 'signal signal-ukonceni';
                $title = 'ukončena účast';
                break;
            case 'uspesneCekaNaCertifikat':
                $class = 'signal signal-dokonceno';
                $title = 'dokončen úspěšně, čeká na certifikát';
                break;
            case 'uspesne':
                $class = 'signal signal-uspesne';
                $title = 'dokončen úspěšně';
                break;
            case 'neuspesne':
                $class = 'signal signal-neuspesne';
                $title = 'dokončen neúspěšně';
                break;
            case 'uspesneSCertifikatem':
                $class = 'signal signal-certifikat';
                $title = 'dokončen úspěšně, vydán certifikát';
                break;

            case 'zamestnanNoveMisto':
                $class = 'signal signal-novemisto';
                $title = 'zaměstnán na nově zřízené místo';
                break;
            case 'zamestnanSUPM':
                $class = 'signal signal-supm';
                $title = 'zaměstnán na SÚPM';
                break;

            case 'zamestnan':
                $class = 'signal signal-zamestnan';
                $title = 'zaměstnán';
                break;
            case 'zamestnanNavazujici':
                $class = 'signal signal-navazujici';
                $title = 'zaměstnán na navazující místo';
                break;
            case 'nezamestnan':
                $class = 'signal signal-nezamestnan';
                $title = 'nezaměstnán';
                break;
            default:
                $class = '';
                $title = '';
                break;
        }

        return $this->renderTd($title, $class, $model->text);
    }
}
