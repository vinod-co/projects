<?php
	
	$d1=new DateTime("2012-07-08 11:14:15.638276");
$d2=new DateTime(strtotime(Date()));
$diff=$d2->diff($d1);
print_r( $diff ) ;
	