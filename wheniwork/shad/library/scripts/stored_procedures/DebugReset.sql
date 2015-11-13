DROP PROCEDURE IF EXISTS DebugReset;
CREATE PROCEDURE DebugReset()
   BEGIN
      DECLARE d DATETIME;
      DECLARE ti INT; -- time interval before any tie-breaker round starts

      SET ti := 10;

      SELECT now() + INTERVAL 15 SECOND INTO d;
--      SELECT now() INTO d;
      UPDATE game SET `start` = d;                      -- 1 minute for game execution
      UPDATE game SET `tie1`  = d + INTERVAL 1 MINUTE + INTERVAL 30 SECOND + INTERVAL ti SECOND;  -- end of tie1 (allowing 1 minute for game execution)
      UPDATE game SET `tie2`  = `tie1` + INTERVAL 30 SECOND + INTERVAL ti SECOND;  -- end of tie2 (allowing 1 minute for game execution)
      UPDATE game SET `tie3`  = `tie2` + INTERVAL 30 SECOND + INTERVAL ti SECOND;  -- end of tie3 (allowing 1 minute for game execution)
      UPDATE game SET active = 1, tie_breaker = 0 WHERE game_id = 1;
   END
