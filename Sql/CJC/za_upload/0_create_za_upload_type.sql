/**
 * Author:  pes2704
 * Created: 13. 10. 2022
 */

CREATE TABLE `za_upload_type` (
  `type` varchar(50) COLLATE utf8_czech_ci NOT NULL,
  `popis` varchar(150) COLLATE utf8_czech_ci DEFAULT NULL,
  PRIMARY KEY (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;
