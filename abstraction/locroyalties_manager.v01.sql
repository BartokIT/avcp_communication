DROP TABLE IF EXISTS `locroyal_users`;
DROP TABLE IF EXISTS `locroyal_canoni`;
DROP TABLE IF EXISTS `locroyal_abitazioni`;
DROP TABLE IF EXISTS `locroyal_`;



CREATE TABLE IF NOT EXISTS `locroyal_canoni` (
	cid INT AUTO_INCREMENT PRIMARY KEY,
	scelta_contraente NUMERIC,
	importo NUMERIC(15,2),
	importo_liquidato NUMERIC(15,2),
	dummy CHAR(1),
	data_inizio DATE,
	data_fine DATE,
	f_user_id VARCHAR(100),
	f_aid NUMERIC,
	f_pid NUMERIC,
	CONSTRAINT fk_pubblicazione FOREIGN KEY  (f_pub_anno,f_pub_numero) REFERENCES avcpman_pubblicazione (anno,numero) ON DELETE NO ACTION	
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Contiene le informazioni sui lotti di gara';


INSERT INTO `locroyal_users` VALUES ('administrator','Utente amministratore','$2y$10$k8MM746TrhQCyZEUw7fTA.u0YsYx8WZJMkF5HGGW.R3TK0l582Yx6','administrator');
