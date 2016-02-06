<?php
class ActivityFileputHistory extends AppModel {
	var $name = 'ActivityFileputHistory';
	var $useTable = 'getput_activity_fileput_history';
	var $primaryKey = 'activity_fileput_history_num_id';
	var $virtualFields = array(
		'total_put' => 'COUNT(activity_fileput_history_filedest)',
		'total_put_txt' => 'COUNT(*)',
		'total_put_pho' => 'COUNT(*)',
		'year' => 'FROM_UNIXTIME(activity_fileput_history_date,"%Y")',
		'month' => 'FROM_UNIXTIME(activity_fileput_history_date,"%m")'
	);
}
?>