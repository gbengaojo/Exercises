<?php
// define server
if ($_SERVER['APPLICATION_ENV'] == 'development') {
   define('LOCALHOST', true);
   define('PATH',      '/home/gbenga/dev/shadowandactfilms/');
} else {
   define('LOCALHOST', false);
   define('PATH',      '/home/orion/shadowandactfilms/');
}

// games
define('MONDAY',    6);
define('WEDNESDAY', 1);
define('FRIDAY',    4);
define('SUNDAY',    5);

define('GAME_DURATION',  60);    // game duration in seconds (initial round)
define('TIE_DURATION',   30);    // tie rounds duration in seconds
define('TIE_HIATUS',      7);

// questions // TODO adjust - questions being pulled by type now, not number (20130118)
define('TOTAL_QUESTIONS',             2);  // (3 questions, not including bonus, which the user has the option to attempt or not: index starting at 0)
define('TOTAL_TIE_BREAKER_QUESTIONS', 2);  // (3 tie breaker questions - possibly not necessary because of next definition)
define('TIE_BREAKER',                 4);  // (5th and up questions)

// question types
define('QUESTION_STANDARD',         0);
define('QUESTION_BONUS',            1);
define('QUESTION_TIE_BREAKER',      2);
define('QUESTION_BONUS_DEDUCTION', 10);

// rounds
define('ROUND_INACTIVE', -1);
define('ROUND_INIT',      0);
define('ROUND_TIE_ONE',   1);
define('ROUND_TIE_TWO',   2);
define('ROUND_TIE_THREE', 3);

// game state
define('GAME_STATE_OVER',        0);
define('GAME_STATE_WAIT',        1);
define('GAME_STATE_TIE',         2);
define('GAME_STATE_PLAY',        3);
define('GAME_STATE_PLAY_NO_TIE', 4);
define('GAME_STATE_WON',         5);


// points
define('POINTS_STANDARD',        100);
define('POINTS_BONUS',           200);
define('POINTS_BONUS_DEDUCTION', 50);
define('POINTS_TIE_BREAKER',     100);


// directories
define('TRIVIA_IMAGES', '/images/trivia');

// tables
define('TBL_USER',          'user');
define('TBL_PLAYER',        'player');
define('TBL_GAME',          'game');
define('TBL_QUESTION',      'question');
define('TBL_QUESTION_TYPE', 'question_type');
define('TBL_CLUE',          'clue');
define('TBL_ANSWER',        'answer');
define('TBL_WINNER',        'winner');
