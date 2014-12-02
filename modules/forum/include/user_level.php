<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
$user_level_cache = array();

function get_user_level($uid)
{
  global $db, $bbTable, $user_level_cache;

  if ($user_level_cache[$uid])
  {
  	return $user_level_cache[$uid];
  }
  
$user = new RcxUser($uid);

/* LEVEL_TIME_INTERVAL
 * This value is used for how far 'back' to look for the MP and HP calculations.
 * For versitility, it is represented in seconds.
 *
 * The higher this value is, the further back it will look.
 *
 * By default, this value is set to 604800, which is equivalent to 7 days.
 *
 * Note: This value should NOT be fractional.
 */

$level_time_interval = 604800;
$level_time = time() - $level_time_interval;
$level_time = max($level_time, $user->getVar('user_regdate'));


/* Retrieve Database Variables
 * These statements retrieve needed variables from the database
 * put into one sql statement for efficiancy.
 * 
 * None of this should be changed unless you know what you're doing. ;)
 */
 
$sql = "SELECT COUNT(p.post_id), AVG(CHAR_LENGTH(p.post_text)) FROM ".$bbTable['posts']." p WHERE p.uid='".$uid."' AND p.post_time>='$level_time'";
if ($result = $db->query($sql))
{
  $level_sql_result = $db->fetch_row($result);
}
	
$level_avg_chars = $level_sql_result[1];
$level_mp_posts = $level_sql_result[0];

/* Calculate Level 
* A user's level is determined by their total number of posts. 
* A nice mathmatical formula is used to translate their post count 
* into an intager level. 
* 
* Note: A user with zero (0) posts is considered level 0, however 
* making one (1) post, raises them to level 1. 
* 
*/


if($user->getVar('posts') < 1)
{
	$level_level = 0;
}
else
{
	$level_level = floor( pow( log10( $user->getVar('posts') ), 3 ) ) + 1;
}


/* Calculate Experience Percentage
 * Experience is determined by how far the user is away
 * from the next level. This is expressed as a percentage.
 *
 * Note: a user of level 0 has 100% experience. Making one post
 * will putthem at level 1. Also, a user that is shown to have 100%
 * experience will go up a level after their next post.
 *
 */
 
if($level_level < 1)
{
	$level_exp = "0 / 0";
	$level_exp_percent = 100;
}
else
{
	$level_posts_for_next = floor( pow( 10, pow( $level_level, (1/3) ) ) );

	$level_posts_for_this = max(1, floor( pow( 10, pow( ($level_level-1), (1/3) ) ) ) );

	$level_exp = ($user->getVar('posts') - $level_posts_for_this) .' / '. ($level_posts_for_next - $level_posts_for_this);
	
	$level_exp_percent = floor( ( ($user->getVar('posts') - $level_posts_for_this) / max( 1, ($level_posts_for_next - $level_posts_for_this) ) ) * 100 );

}


/* Calculate Maximum and Current HP
 * 
 * Maximum HP is a function of a user's level.
 * The higher level a user is, the higher maximum MP they will have.
 *
 * Current HP is a ratio of how many posts a user has made compared to
 * how much the user has written.
 * 
 */
 
 /* LEVEL_HP_POST_BONUS
  * This value is the ammount of HP added to the user's max HP for each
  * post they have made.
  *
  * Rationale: HP measure the "Quality" of the user's recent posts.
  * Therefore, the more a user posts, the more they should be required to
  * meet, and exceed those expectations of Quality.
  *
  * Note: This value may be set to any value. Negative values are not recommended.
  */
$level_hp_post_bonus = .1;

 /* LEVEL_AVERAGE_CHARPOST_RATIO
 * This value represents how many characters per post you expect your users
 * to post, on average. This can be adjusted, depending on your board and
 * personal preferences.
 *
 * Raising this value will generally result in lower HP percentages,
 * while lowering this value will result in higher HP percentages.
 * 
 * Note: This number may be fractional, or zero. It should not be negative.
 */
$level_average_charpost_ratio = 50;

if($level_level < 1)
{
	$level_hp = "0 / 0";
	$level_hp_percent = 0;
}
else
{
	$level_max_hp = ( (pow( $level_level, (1/4) ) ) * (pow( 10, pow( $level_level+2, (1/3) ) ) ) / (1.5) );
	
	$level_cur_hp = floor( $level_max_hp * ( $level_avg_chars / (2 * $level_average_charpost_ratio) ) );
	
	$level_max_hp = floor($level_max_hp + ($level_hp_post_bonus * $user->getVar('posts')) );
	$level_cur_hp = max(0, $level_cur_hp);
	$level_cur_hp = min($level_max_hp, $level_cur_hp);
	
	$level_hp = $level_cur_hp .' / '. $level_max_hp;
	$level_hp_percent = min(100, floor( ($level_cur_hp/$level_max_hp) * 100) );
}

/* Calculate Maximum and Current MP
 * Maximum MP is a function of a user's level.
 * The higher level a user is, the higher maximum MP they will have.
 *
 * Current MP is based on how many posts a user has made within a
 * specified time period. The more posts they have made, the lower
 * their MP will be.
 */

/* LEVEL_MP_TIME_BONUS
 * This value is the ammount of MP is added to the user's max mp for each
 * unit of $level_time_interval that has passed since they registered.
 * 
 * For example, using the default time interval of 7 days, 
 * and the default mp bonus of 1, a user who has been registered for
 * one year (52 weeks) will have 52 mp added to their normal maximum.
 *
 * Rationale: The rational behind this is that users who have been
 * registered longer should have more MP to post with than newer users.
 * Even if they are of the same Exp level.
 *
 * Note: This can theoretically be any number, positive, negative, zero, or fractional.
 * If zero, a user gains no bonus MP, if negative, a user will have less MP the longer
 * they're registered. This is not recommended.
 */
$level_mp_time_bonus = 1;

/* LEVEL_MP_POST_COST
 * This value represents how much MP each post costs a user.
 * The number of posts the user has made in the time period
 * specified in $level_mp_time will each cost this ammount of
 * MP, which will be subtracted from the user's max MP.
 *
 * In general, raising this value will decrease the ammount of
 * MP users will have, while lowering it will increase the ammount
 * of MP users have.
 *
 * Note: This value may be fractional. It should NOT be negative.
 * It MAY be set to zero, but it will cause everyone to have Max
 * MP.
 */
$level_mp_post_cost = 1;

if($level_level < 1)
{
	$level_mp = '0 / 0';
	$level_mp_percent = 0;
}
else
{
	$level_max_mp = floor( (pow( $level_level, (1/4) ) ) * (pow( 10, pow( $level_level+2, (1/3) ) ) ) / (pi()) + ($level_mp_time_bonus * ( (time()-$user->getVar('user_regdate')) / $level_time_interval) ) );
	
	$level_cur_mp = floor($level_max_mp - ($level_mp_posts * $level_mp_post_cost));
	$level_cur_mp = min($level_cur_mp, $level_max_mp);
	$level_cur_mp = max($level_cur_mp, 0);

	$level_mp = $level_cur_mp .' / '. $level_max_mp;
	$level_mp_percent = floor($level_cur_mp / $level_max_mp * 100 );
}


$level = array();
$level['LEVEL']  = $level_level ;
$level['EXP'] = $level_exp;
$level['EXP_WIDTH'] = $level_exp_percent;
$level['EXP_EMPTY'] = (100 - $level_exp_percent);
$level['HP']  = $level_hp;
$level['HP_WIDTH']  = $level_hp_percent;
$level['HP_EMPTY'] = (100 - $level_hp_percent);
$level['MP']  = $level_mp;
$level['MP_WIDTH']  = $level_mp_percent;
$level['MP_EMPTY'] = (100 - $level_mp_percent);

// Cache it for later use if required
$user_level_cache[$uid] = $level;

return $level;
}

?>
