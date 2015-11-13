-- set all games to inactive
-- reset player table
-- update start date for games that have passed

UPDATE game SET active = 0;
UPDATE game SET tie_breaker = 0;
TRUNCATE player;
TRUNCATE winner;
CALL IncrementGame;
