<?php
class Projektor2_Model_Db_SysUser {

    public $id;
    public $username;
    public $name;
    public $authtype;
    public $password;
    public $povolen_zapis;
    public $monitor;
    public $tl_spzp_sml;
    public $tl_spzp_dot;
    public $tl_spzp_plan;
    public $tl_spzp_ukon;
    public $tl_spzp_testpc;
    public $tl_spzp_zam;
    public $tl_spzp_dopRK;
    public $tl_spzp_dopRKdoplneni1;
    public $tl_spzp_dopRKdoplneni2;
    public $tl_spzp_dopRKvyrazeni;
    public $tl_spzp_agp;
    public $tl_rnh_sml;
    public $tl_rnh_dot;
    public $tl_rnh_plan;
    public $tl_rnh_ukon;
    public $tl_rnh_testpc;
    public $tl_rnh_zam;
    public $tl_rnh_dopRK;
    public $tl_rnh_dopRKdoplneni1;
    public $tl_rnh_dopRKdoplneni2;
    public $tl_rnh_dopRKvyrazeni;
    public $tl_rnh_agp;
    public $tl_agp_sml;
    public $tl_agp_souhlas;
    public $tl_agp_dot;
    public $tl_agp_plan;
    public $tl_agp_ukon;
    public $tl_agp_zam;
    public $tl_he_sml;
    public $tl_he_souhlas;
    public $tl_he_dot;
    public $tl_he_plan;
    public $tl_he_zam;
    public $tl_he_ukon;
    public $tl_ap_sml;
    public $tl_ap_souhlas;
    public $tl_ap_dot;
    public $tl_ap_ip1;
    public $tl_ap_plan;
    public $tl_ap_porad;
    public $tl_ap_zam;
    public $tl_ap_ukon;
    public $tl_sj_sml;
    public $tl_sj_souhlas;
    public $tl_sj_dot;
    public $tl_sj_plan;
    public $tl_sj_porad;
    public $tl_sj_ukon;
    public $tl_sj_zam;
    public $tl_vz_sml;
    public $tl_vz_plan;
    public $tl_vz_ukon;
    public $tl_zpm_sml;
    public $tl_zpm_plan;
    public $tl_zpm_ukon;
    public $tl_spp_sml;
    public $tl_spp_plan;
    public $tl_spp_ukon;
    public $tl_rp_sml;
    public $tl_rp_plan;
    public $tl_rp_ukon;
    public $tl_sp_sml;
    public $tl_sp_souhlas;
    public $tl_sp_dot;
    public $tl_sp_plan;
    public $tl_sp_porad;
    public $tl_sp_ukon;
    public $tl_sp_zam;
    public $tl_so_sml;
    public $tl_so_souhlas;
    public $tl_so_dot;
    public $tl_so_plan;
    public $tl_so_porad;
    public $tl_so_ukon;
    public $tl_so_zam;
    public $tl_sl_sml;
    public $tl_sl_souhlas;
    public $tl_sl_dot;
    public $tl_sl_plan;
    public $tl_sl_porad;
    public $tl_sl_ukon;
    public $tl_sl_zam;
    public $tl_vdtp_sml;
    public $tl_vdtp_plan;
    public $tl_vdtp_ukon;
    public $tl_pdu_sml;
    public $tl_pdu_plan;
    public $tl_pdu_ukon;
    public $tl_mb_sml;
    public $tl_mb_souhlas;
    public $tl_mb_dot;
    public $tl_mb_plan;
    public $tl_mb_porad;
    public $tl_mb_ukon;
    public $tl_mb_zam;
    public $tl_cj_sml;
    public $tl_cj_souhlas;
    public $tl_cj_cizinec;
    public $tl_cj_plan;

    public function __construct(
            $id = null,
            $username= null,
            $name= null,
            $authtype= null,
            $password= null,
            $povolen_zapis= null,
            $monitor= null,
            $tl_spzp_sml= null,
            $tl_spzp_dot= null,
            $tl_spzp_plan= null,
            $tl_spzp_ukon= null,
            $tl_spzp_testpc= null,
            $tl_spzp_zam= null,
            $tl_spzp_dopRK= null,
            $tl_spzp_dopRKdoplneni1= null,
            $tl_spzp_dopRKdoplneni2= null,
            $tl_spzp_dopRKvyrazeni= null,
            $tl_spzp_agp= null,
            $tl_rnh_sml= null,
            $tl_rnh_dot= null,
            $tl_rnh_plan= null,
            $tl_rnh_ukon= null,
            $tl_rnh_testpc= null,
            $tl_rnh_zam= null,
            $tl_rnh_dopRK= null,
            $tl_rnh_dopRKdoplneni1= null,
            $tl_rnh_dopRKdoplneni2= null,
            $tl_rnh_dopRKvyrazeni= null,
            $tl_rnh_agp= null,
            $tl_agp_sml= null,
            $tl_agp_souhlas= null,
            $tl_agp_dot= null,
            $tl_agp_plan= null,
            $tl_agp_ukon= null,
            $tl_agp_zam= null,
            $tl_he_sml= null,
            $tl_he_souhlas= null,
            $tl_he_dot= null,
            $tl_he_plan= null,
            $tl_he_ukon= null,
            $tl_he_zam= null,
            $tl_ap_sml= null,
            $tl_ap_souhlas= null,
            $tl_ap_dot= null,
            $tl_ap_ip1= null,
            $tl_ap_plan= null,
            $tl_ap_porad= null,
            $tl_ap_ukon= null,
            $tl_ap_zam= null,
            $tl_sj_sml= null,
            $tl_sj_souhlas= null,
            $tl_sj_dot= null,
            $tl_sj_plan= null,
            $tl_sj_porad= null,
            $tl_sj_ukon= null,
            $tl_sj_zam= null,
            $tl_vz_sml= null,
            $tl_vz_plan= null,
            $tl_vz_ukon= null,
            $tl_zpm_sml= null,
            $tl_zpm_plan= null,
            $tl_zpm_ukon= null,
            $tl_spp_sml= null,
            $tl_spp_plan= null,
            $tl_spp_ukon= null,
            $tl_rp_sml= null,
            $tl_rp_plan= null,
            $tl_rp_ukon= null,

            $tl_sp_sml= null,
            $tl_sp_souhlas= null,
            $tl_sp_dot= null,
            $tl_sp_plan= null,
            $tl_sp_porad= null,
            $tl_sp_ukon= null,
            $tl_sp_zam= null,
            $tl_so_sml= null,
            $tl_so_souhlas= null,
            $tl_so_dot= null,
            $tl_so_plan= null,
            $tl_so_porad= null,
            $tl_so_ukon= null,
            $tl_so_zam= null,

            $tl_sl_sml= null,
            $tl_sl_souhlas= null,
            $tl_sl_dot= null,
            $tl_sl_plan= null,
            $tl_sl_porad= null,
            $tl_sl_ukon= null,
            $tl_sl_zam= null,
            $tl_vdtp_sml= null,
            $tl_vdtp_plan= null,
            $tl_vdtp_ukon= null,
            $tl_pdu_sml= null,
            $tl_pdu_plan= null,
            $tl_pdu_ukon= null,

            $tl_mb_sml= null,
            $tl_mb_souhlas= null,
            $tl_mb_dot= null,
            $tl_mb_plan= null,
            $tl_mb_porad= null,
            $tl_mb_ukon= null,
            $tl_mb_zam= null,

            $tl_cj_sml= null,
            $tl_cj_souhlas= null,
            $tl_cj_cizinec = null,
            $tl_cj_plan = null
           )
       {

        $this->id = $id;
        $this->username = $username;
        $this->name = $name;
        $this->authtype = $authtype;
        $this->password = $password;
        $this->povolen_zapis = $povolen_zapis;
        $this->monitor = $monitor;
        $this->tl_spzp_sml = $tl_spzp_sml;
        $this->tl_spzp_dot = $tl_spzp_dot;
        $this->tl_spzp_plan = $tl_spzp_plan;
        $this->tl_spzp_ukon = $tl_spzp_ukon;
        $this->tl_spzp_testpc = $tl_spzp_testpc;
        $this->tl_spzp_zam = $tl_spzp_zam;
        $this->tl_spzp_dopRK = $tl_spzp_dopRK;
        $this->tl_spzp_dopRKdoplneni1 = $tl_spzp_dopRKdoplneni1;
        $this->tl_spzp_dopRKdoplneni2 = $tl_spzp_dopRKdoplneni2;
        $this->tl_spzp_dopRKvyrazeni = $tl_spzp_dopRKvyrazeni;
        $this->tl_spzp_agp = $tl_spzp_agp;
        $this->tl_rnh_sml = $tl_rnh_sml;
        $this->tl_rnh_dot = $tl_rnh_dot;
        $this->tl_rnh_plan = $tl_rnh_plan;
        $this->tl_rnh_ukon = $tl_rnh_ukon;
        $this->tl_rnh_testpc = $tl_rnh_testpc;
        $this->tl_rnh_zam = $tl_rnh_zam;
        $this->tl_rnh_dopRK = $tl_rnh_dopRK;
        $this->tl_rnh_dopRKdoplneni1 = $tl_rnh_dopRKdoplneni1;
        $this->tl_rnh_dopRKdoplneni2 = $tl_rnh_dopRKdoplneni2;
        $this->tl_rnh_dopRKvyrazeni = $tl_rnh_dopRKvyrazeni;
        $this->tl_rnh_agp = $tl_rnh_agp;
        $this->tl_agp_sml = $tl_agp_sml;
        $this->tl_agp_souhlas = $tl_agp_souhlas;
        $this->tl_agp_dot = $tl_agp_dot;
        $this->tl_agp_plan = $tl_agp_plan;
        $this->tl_agp_ukon = $tl_agp_ukon;
        $this->tl_agp_zam = $tl_agp_zam;
        $this->tl_he_sml = $tl_he_sml;
        $this->tl_he_souhlas = $tl_he_souhlas;
        $this->tl_he_dot = $tl_he_dot;
        $this->tl_he_plan = $tl_he_plan;
        $this->tl_he_zam = $tl_he_zam;
        $this->tl_he_ukon = $tl_he_ukon;
        $this->tl_ap_sml = $tl_ap_sml;
        $this->tl_ap_souhlas = $tl_ap_souhlas;
        $this->tl_ap_dot = $tl_ap_dot;
        $this->tl_ap_ip1 = $tl_ap_ip1;
        $this->tl_ap_plan = $tl_ap_plan;
        $this->tl_ap_porad = $tl_ap_porad;
        $this->tl_ap_zam = $tl_ap_zam;
        $this->tl_ap_ukon = $tl_ap_ukon;
        $this->tl_sj_sml = $tl_sj_sml;
        $this->tl_sj_souhlas = $tl_sj_souhlas;
        $this->tl_sj_dot = $tl_sj_dot;
        $this->tl_sj_plan = $tl_sj_plan;
        $this->tl_sj_porad = $tl_sj_porad;
        $this->tl_sj_ukon = $tl_sj_ukon;
        $this->tl_sj_zam = $tl_sj_zam;
        $this->tl_vz_sml = $tl_vz_sml;
        $this->tl_vz_plan = $tl_vz_plan;
        $this->tl_vz_ukon = $tl_vz_ukon;
        $this->tl_zpm_sml = $tl_zpm_sml;
        $this->tl_zpm_plan = $tl_zpm_plan;
        $this->tl_zpm_ukon = $tl_zpm_ukon;
        $this->tl_spp_sml = $tl_spp_sml;
        $this->tl_spp_plan = $tl_spp_plan;
        $this->tl_spp_ukon = $tl_spp_ukon;
        $this->tl_rp_sml = $tl_rp_sml;
        $this->tl_rp_plan = $tl_rp_plan;
        $this->tl_rp_ukon = $tl_rp_ukon;

        $this->tl_sp_sml = $tl_sp_sml;
        $this->tl_sp_souhlas = $tl_sp_souhlas;
        $this->tl_sp_dot = $tl_sp_dot;
        $this->tl_sp_plan = $tl_sp_plan;
        $this->tl_sp_porad = $tl_sp_porad;
        $this->tl_sp_ukon = $tl_sp_ukon;
        $this->tl_sp_zam = $tl_sp_zam;

        $this->tl_so_sml = $tl_so_sml;
        $this->tl_so_souhlas = $tl_so_souhlas;
        $this->tl_so_dot = $tl_so_dot;
        $this->tl_so_plan = $tl_so_plan;
        $this->tl_so_porad = $tl_so_porad;
        $this->tl_so_ukon = $tl_so_ukon;
        $this->tl_so_zam = $tl_so_zam;

        $this->tl_sl_sml = $tl_sl_sml;
        $this->tl_sl_souhlas = $tl_sl_souhlas;
        $this->tl_sl_dot = $tl_sl_dot;
        $this->tl_sl_plan = $tl_sl_plan;
        $this->tl_sl_porad = $tl_sl_porad;
        $this->tl_sl_ukon = $tl_sl_ukon;
        $this->tl_sl_zam = $tl_sl_zam;

        $this->tl_vdtp_sml = $tl_vdtp_sml;
        $this->tl_vdtp_plan = $tl_vdtp_plan;
        $this->tl_vdtp_ukon = $tl_vdtp_ukon;

        $this->tl_pdu_sml = $tl_pdu_sml;
        $this->tl_pdu_plan = $tl_pdu_plan;
        $this->tl_pdu_ukon = $tl_pdu_ukon;

        $this->tl_mb_sml = $tl_mb_sml;
        $this->tl_mb_souhlas = $tl_mb_souhlas;
        $this->tl_mb_dot = $tl_mb_dot;
        $this->tl_mb_plan = $tl_mb_plan;
        $this->tl_mb_porad = $tl_mb_porad;
        $this->tl_mb_ukon = $tl_mb_ukon;
        $this->tl_mb_zam = $tl_mb_zam;

        $this->tl_cj_sml = $tl_cj_sml;
        $this->tl_cj_souhlas = $tl_cj_souhlas;
        $this->tl_cj_cizinec = $tl_cj_cizinec;
        $this->tl_cj_plan = $tl_cj_plan;
        }

}
