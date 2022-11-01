<?php
class Projektor2_Model_Db_SysUserMapper {
    public static function findById($id) {
        $dbh = Projektor2_AppContext::getDb();
        $query = "SELECT * FROM sys_users WHERE id_sys_users = :id_sys_users";
        $bindParams = array('id_sys_users'=>$id);
        $sth = $dbh->prepare($query);
        $succ = $sth->execute($bindParams);
        $data = $sth->fetch(PDO::FETCH_ASSOC);
        if(!$data) {
            return NULL;
        }
        return self::create($data);
    }

    public static function findByUsername($username) {
        $dbh = Projektor2_AppContext::getDb();
        $query = "SELECT * FROM sys_users WHERE username = :username";
        $bindParams = array('username'=>$username);
        $sth = $dbh->prepare($query);
        $succ = $sth->execute($bindParams);
        $data = $sth->fetch(PDO::FETCH_ASSOC);
        if(!$data) {
            return NULL;
        }
        return self::create($data);

    }

    private static function create($data) {
        return new Projektor2_Model_Db_SysUser(
            $data['id_sys_users'],
            $data['username'],
            $data['name'],
            $data['authtype'],
            $data['password'],
            $data['povolen_zapis'],
            $data['monitor'],
            $data['tl_spzp_sml'],
            $data['tl_spzp_dot'],
            $data['tl_spzp_plan'],
            $data['tl_spzp_ukon'],
            $data['tl_spzp_testpc'],
            $data['tl_spzp_zam'],
            $data['tl_spzp_dopRK'],
            $data['tl_spzp_dopRKdoplneni1'],
            $data['tl_spzp_dopRKdoplneni2'],
            $data['tl_spzp_dopRKvyrazeni'],
            $data['tl_spzp_agp'],
            $data['tl_rnh_sml'],
            $data['tl_rnh_dot'],
            $data['tl_rnh_plan'],
            $data['tl_rnh_ukon'],
            $data['tl_rnh_testpc'],
            $data['tl_rnh_zam'],
            $data['tl_rnh_dopRK'],
            $data['tl_rnh_dopRKdoplneni1'],
            $data['tl_rnh_dopRKdoplneni2'],
            $data['tl_rnh_dopRKvyrazeni'],
            $data['tl_rnh_agp'],
            $data['tl_agp_sml'],
            $data['tl_agp_souhlas'],
            $data['tl_agp_dot'],
            $data['tl_agp_plan'],
            $data['tl_agp_ukon'],
            $data['tl_agp_zam'],
            $data['tl_he_sml'],
            $data['tl_he_souhlas'],
            $data['tl_he_dot'],
            $data['tl_he_plan'],
            $data['tl_he_zam'],
            $data['tl_he_ukon'],
            $data['tl_ap_sml'],
            $data['tl_ap_souhlas'],
            $data['tl_ap_dot'],
            $data['tl_ap_ip1'],
            $data['tl_ap_plan'],
            $data['tl_ap_porad'],
            $data['tl_ap_zam'],
            $data['tl_ap_ukon'],
            $data['tl_sj_sml'],
            $data['tl_sj_souhlas'],
            $data['tl_sj_dot'],
            $data['tl_sj_plan'],
            $data['tl_sj_porad'],
            $data['tl_sj_ukon'],
            $data['tl_sj_zam'],
            $data['tl_vz_sml'],
            $data['tl_vz_plan'],
            $data['tl_vz_ukon'],
            $data['tl_zpm_sml'],
            $data['tl_zpm_plan'],
            $data['tl_zpm_ukon'],
            $data['tl_spp_sml'],
            $data['tl_spp_plan'],
            $data['tl_spp_ukon'],
            $data['tl_rp_sml'],
            $data['tl_rp_plan'],
            $data['tl_rp_ukon'],
            $data['tl_sp_sml'],
            $data['tl_sp_souhlas'],
            $data['tl_sp_dot'],
            $data['tl_sp_plan'],
            $data['tl_sp_porad'],
            $data['tl_sp_ukon'],
            $data['tl_sp_zam'],
            $data['tl_so_sml'],
            $data['tl_so_souhlas'],
            $data['tl_so_dot'],
            $data['tl_so_plan'],
            $data['tl_so_porad'],
            $data['tl_so_ukon'],
            $data['tl_so_zam'],
            $data['tl_sl_sml'],
            $data['tl_sl_souhlas'],
            $data['tl_sl_dot'],
            $data['tl_sl_plan'],
            $data['tl_sl_porad'],
            $data['tl_sl_ukon'],
            $data['tl_sl_zam'],
            $data['tl_vdtp_sml'],
            $data['tl_vdtp_plan'],
            $data['tl_vdtp_ukon'],
            $data['tl_pdu_sml'],
            $data['tl_pdu_plan'],
            $data['tl_pdu_ukon'],
            $data['tl_mb_sml'],
            $data['tl_mb_souhlas'],
            $data['tl_mb_dot'],
            $data['tl_mb_plan'],
            $data['tl_mb_porad'],
            $data['tl_mb_ukon'],
            $data['tl_mb_zam'],
            $data['tl_cj_sml'],
            $data['tl_cj_souhlas'],
            $data['tl_cj_cizinec'],
            $data['tl_cj_plan'],
            $data['tl_ckp_sml'],
            $data['tl_ckp_plan'],
            $data['tl_pkp_sml'],
            $data['tl_pkp_plan']

        );
    }
}
