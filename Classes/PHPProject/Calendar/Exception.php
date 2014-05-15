<?php

namespace PHPProject\Calendar;

class Exception {
	
	const DAYOFWEEK_SUNDAY = 1;
	const DAYOFWEEK_MONDAY = 2;
	const DAYOFWEEK_TUESDAY = 4;
	const DAYOFWEEK_WEDNESDAY = 8;
	const DAYOFWEEK_THURSDAY = 16;
	const DAYOFWEEK_FRIDAY = 32;
	const DAYOFWEEK_SATURDAY = 64;
	
	public $FromDate;
	public $ToDate;
	public $Occurences;
	public $DaysOfWeek;
}
