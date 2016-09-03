<?php

AddEventHandler("sale", "OnSalePayOrder", "ChangeStatus"); 

function ChangeStatus($id,$val) { 
	CSaleOrder::StatusOrder($id,'Y'); 
}

?>