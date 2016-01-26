ALTER TABLE  `avcpman_gara` 
 ADD COLUMN streamid INT;

DELIMITER //
DROP PROCEDURE IF EXISTS update_gare;
DROP PROCEDURE IF EXISTS update_gara;
CREATE PROCEDURE update_gare()
 BEGIN
    DECLARE done INT DEFAULT FALSE;
    DECLARE id INT;
-- alter the table if the streamid column doesn't exists
    DECLARE colname TEXT;
    DECLARE garecursor CURSOR FOR SELECT gid FROM avcpman_gara WHERE streamid IS NULL;    
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
    SELECT IFNULL(column_name, '') INTO @colname
        FROM information_schema.columns 
        WHERE table_name = 'avcpman_gara'
            AND column_name = 'streamid';
    IF @colname = '' THEN 
        ALTER TABLE  `avcpman_gara` 
            ADD COLUMN streamid INT;
    END IF;
    OPEN garecursor;
        gare_loop: LOOP
        FETCH garecursor INTO id;
        IF done THEN
            LEAVE gare_loop;
        END IF;
        UPDATE avcpman_gara
                SET streamid = id
                WHERE gid = id;
    END LOOP;
    CLOSE garecursor;
    END //

DELIMITER ;

CALL update_gare();
DROP PROCEDURE IF EXISTS update_gare;
DROP PROCEDURE IF EXISTS update_gara;