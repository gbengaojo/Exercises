DROP PROCEDURE IF EXISTS IncrementGame;
CREATE PROCEDURE IncrementGame()
   BEGIN
      DECLARE ti, id, sentinel INT DEFAULT 0;
      DECLARE d DATETIME;

      DECLARE cur_start CURSOR FOR (SELECT `game_id`, `start` FROM game);
      DECLARE CONTINUE HANDLER FOR NOT FOUND SET sentinel = 1;

      SET ti := 10;

      OPEN cur_start;

      WHILE NOT sentinel DO
         FETCH cur_start INTO id, d;

         IF (d <= now()) THEN
            SELECT "updating...";
            UPDATE game SET `start` = d + INTERVAL 7 DAY WHERE game_id = id;
            UPDATE game SET `tie1` = d + INTERVAL 7 DAY + INTERVAL 3 MINUTE + INTERVAL 30 SECOND WHERE game_id = id;
            UPDATE game SET `tie2` = d + INTERVAL 7 DAY + INTERVAL 3 MINUTE + INTERVAL 60 SECOND WHERE game_id = id;
            UPDATE game SET `tie3` = d + INTERVAL 7 DAY + INTERVAL 3 MINUTE + INTERVAL 90 SECOND WHERE game_id = id;
         END IF;
      END WHILE;
   END
