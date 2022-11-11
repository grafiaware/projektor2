<?php
/**
 * Description of Projektor2_Model_KurzPlan
 *
 * @author pes2704
 */
class Projektor2_Viewmodel_AktivitaPlanCertifikatParams  extends Framework_Model_DbItemAbstract {
    public $original;
    public $pseudokopie;
    public $monitoring;

    public function __construct(
            $original = null, $pseudokopie = null, $monitoring = null
    ) {
        $this->original = $original;
        $this->pseudokopie = $pseudokopie;
        $this->monitoring = $monitoring;
    }
}
