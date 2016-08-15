<?php
require_once("config.php");
require_once("connection.php");
require_once("lib.php");

//generate general journal accounts
//cash account
mysql_query("insert into generaljournalaccounts(accname,acctype,debit,credit,createdby,createdon,lasteditedby,lasteditedon) values('cash A/C','cash',0,0,1,Now(),1,Now())");

//sales account
mysql_query("insert into generaljournalaccounts(accname,acctype,debit,credit,createdby,createdon,lasteditedby,lasteditedon) values('sales A/C','sales',0,0,1,Now(),1,Now())");

//return inwards account
mysql_query("insert into generaljournalaccounts(accname,acctype,debit,credit,createdby,createdon,lasteditedby,lasteditedon) values('return inwards A/C','return inwards',0,0,1,Now(),1,Now())");

//return outwards account
mysql_query("insert into generaljournalaccounts(accname,acctype,debit,credit,createdby,createdon,lasteditedby,lasteditedon) values('return outwards A/C','return outwards',0,0,1,Now(),1,Now())");

//purchases account
mysql_query("insert into generaljournalaccounts(accname,acctype,debit,credit,createdby,createdon,lasteditedby,lasteditedon) values('purchases A/C','purchases',0,0,1,Now(),1,Now())");

//salaries expense account
mysql_query("insert into expenses(name,createdby,createdon,lasteditedby,lasteditedon) values('Salaries Expense',1,Now(),1,Now())");
$id=mysql_insert_id();
mysql_query("insert into generaljournalaccounts(accname,refid,acctype,debit,credit,createdby,createdon,lasteditedby,lasteditedon) values('Salaries Expense A/C','$id','expenses',0,0,1,Now(),1,Now())");

//Customer Accounts
$sql="select * from customers";
$res=mysql_query($sql);
while($row=mysql_fetch_object($res))
{
	mysql_query("insert into generaljournalaccounts(refid,accname,acctype,createdby,createdon,lasteditedby,lasteditedon) values('$row->id','$row->name A/C','customer',1,Now(),1,Now())");
}

//supplier Accounts
$sql="select * from suppliers";
$res=mysql_query($sql);
while($row=mysql_fetch_object($res))
{
	mysql_query("insert into generaljournalaccounts(refid,accname,acctype,createdby,createdon,lasteditedby,lasteditedon) values('$row->id','$row->sname A/C','supplier',1,Now(),1,Now())");
}

//Bank accounts
$sql="select * from banks";
$res=mysql_query($sql);
while($row=mysql_fetch_object($res))
{
	mysql_query("insert into generaljournalaccounts(refid,accname,acctype,createdby,createdon,lasteditedby,lasteditedon) values('$row->id','$row->bankname [$row->bankacc] A/C','bank',1,Now(),1,Now())");
}
?>