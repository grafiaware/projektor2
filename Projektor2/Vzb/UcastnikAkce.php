<?php
class Vzb_UcastnikAkce
{
	const TABULKA = "vzb_ucastnik_akce";
	const ID = "id_v_ucastnik_akce";
	const ID_UCASTNIK_FK = "id_ucastnik_FK";
	const ID_AKCE_FK = "id_akce_FK";
	const ID_S_STAV_UCASTNIK_AKCE_FK = "id_s_stav_ucastnik_akce_FK";
	
	/**
	 * Vraci stavy Ucastnika vzhledem k vybranym Akcim.
	 * @param UcastnikB $ucastnik Ucastnik jehoz stav vzhledem k Akcim nas zajima.
	 * @param array $akceUcastnika Pole instanci Akce, pro ktere hledame stavy.
	 * @return array Pole stavu ucastnika akce (Seznam_SStavUcastnikAkce).
	 */
	
	public static function dejStavy($ucastnik, $akceUcastnika)
	{		
		$stavyAkciUcastnika = array();
		$pocitadlo = 0;
		$dbh = Projektor2_AppContext::getDb();
		foreach($akceUcastnika as $akce)
		{
			$query = "SELECT ~1 FROM ~2 WHERE ~3 = :4 AND ~5 = :6";
			$radky = $dbh->prepare($query)->execute(Vzb_UcastnikAkce::ID_S_STAV_UCASTNIK_AKCE_FK, Vzb_UcastnikAkce::TABULKA, 
													Vzb_UcastnikAkce::ID_UCASTNIK_FK, $ucastnik->id,
													Vzb_UcastnikAkce::ID_AKCE_FK, $akce->id
										   			)->fetch();
										   			
			$stavyAkciUcastnika[$pocitadlo++] = Seznam_SStavUcastnikAkce::najdiPodleId($radky[Vzb_UcastnikAkce::ID_S_STAV_UCASTNIK_AKCE_FK]);
		}
		
		return $stavyAkciUcastnika;
	}
}