<?php
/**
 * Description
 *
 * @author pes2704
 */
class Projektor2_View_HTML_Element_Kurz_TdSignal extends Projektor2_View_HTML_Element_TdSignalAbstract {

    public function render() {
        $model = $this->context['model'];
        switch ($model->status) {
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

            case 'planovaniUcastnici':
                $class = 'signal signal-plan';
                $title = 'počet účastníků plán';
                break;
            default:
                $class = '';
                $title = '';
                break;
        }

        return $this->renderTd($title, $class, $model->text);
    }
}
