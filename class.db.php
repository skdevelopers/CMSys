<?php
class DBConnect
{
	private 	$strHost;
	private 	$strUserName;
	private 	$strPassword;
	private 	$strDatabaseName;
	public  	$dbConnect;
	protected 	$intErrorNo;
	function __construct()
	{
		$this->strHost="localhost";	
		$this->strUserName="root";
		$this->strPassword="";
		$this->strDatabaseName="cmsys";
		$this->Connect();
	}	
	function Connect()
	{
		$dbConnect=mysql_connect($this->strHost,$this->strUserName,$this->strPassword);
		if($dbConnect)
		{
			mysql_select_db($this->strDatabaseName);	

		}
		else
		{
			echo(mysql_error());	
		}
	}
	public function ExecuteQry($pStrSql)
	{
		return mysql_query($pStrSql);	
	}
	public function InsertRecord($pStrTableName,$pArrFileds,$pArrValues)
	{
		$strSql="insert into $pStrTableName ";
		$strSql.="( ";
		$intFieldSize=count($pArrFileds);
		for($i=0;$i<$intFieldSize;$i++)
		{
			if($i==$intFieldSize-1)
			{
				$strSql.=$pArrFileds[$i];	
			}
			else
			{
				$strSql.=$pArrFileds[$i].",";	
			}
		}
		$strSql.=") values (";
		
		$intValueSize=count($pArrValues);
		for($i=0;$i<$intFieldSize;$i++)
		{
			if($i==$intValueSize-1)
			{
				$strSql.="'".$pArrValues[$i]."'";	
			}
			else
			{
				$strSql.="'".$pArrValues[$i]."'".",";	
			}
		}
		$strSql.=")";
		return $this->ExecuteQry($strSql);
		
	}
	function DeleteRecord($pStrTableName,$pStrCondition)
	{
		$strSql="delete from $pStrTableName ".$pStrCondition;	
		$this->ExecuteQry($strSql);
	}
	function UpdateRecord($pStrTableName,$pArrFileds,$pArrValues,$pStrCondition)
	{
		$strSql="update $pStrTableName set ";
		$intFieldSize=count($pArrFileds);
		for($i=0;$i<$intFieldSize;$i++)
		{
			if($i==$intFieldSize-1)
			{
				$strSql.=$pArrFileds[$i]."='".$pArrValues[$i]."'";	
			}
			else
			{
				$strSql.=$pArrFileds[$i]."='".$pArrValues[$i]."'".",";	
			}
		}
		$strSql.=" $pStrCondition";
		$this->ExecuteQry($strSql);
	}
	function GetFieldValues($pArrFileds,$pArrTable,$pStrCondition)
	{
		$strSql="select ";	
		$intArrFiledSize=count($pArrFileds);
		for($i=0;$i<$intArrFiledSize;$i++)
		{
			if($i==$intArrFiledSize-1)
			{	
				$strSql.=$pArrFileds[$i];
			}
			else
			{
				$strSql.=$pArrFileds[$i].",";
			}
		}
		$strSql.=" from ";
		
		$intArrTableSize=count($pArrTable);
		for($j=0;$j<$intArrTableSize;$j++)
		{
			if($j==$intArrTableSize-1)
			{
				$strSql.=$pArrTable[$j];
			}
			else
			{
				$strSql.=$pArrTable[$j].",";
			}
		}
		$strSql.=" ".$pStrCondition;
		return $this->ExecuteQry($strSql);
		
	}

}
//$objDbConnect=new DBConnect();
//
//$objDbConnect->GetFieldValues(array("ProductId","ProductCode","ProductName"),array("product"),"where ProductId=1");

?>
