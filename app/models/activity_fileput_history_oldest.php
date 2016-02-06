<?php
class ActivityFileputHistoryOldest extends AppModel {
	var $name = 'ActivityFileputHistoryOldest';
	var $useTable = 'getput_activity_fileput_history_oldest';
	var $primaryKey = 'activity_fileput_history_num_id';
	var $virtualFields = array(
		'total_put' => 'COUNT(*)',
		'total_put_txt' => 'COUNT(*)',
		'total_put_pho' => 'COUNT(*)',
		'year' => 'FROM_UNIXTIME(activity_fileput_history_date,"%Y")',
		'month' => 'FROM_UNIXTIME(activity_fileput_history_date,"%m")'
	);
}
?>