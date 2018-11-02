<?php

function page($tpl,$result)//分頁
{
	$arr['per']=10;
	$arr['count']=count($result);//資料總筆數
	$arr['page']=ceil($arr['count']/$arr['per']);//總頁數

	$arr['start']=($arr['page']<=1)?1:($arr['page']-1)*$arr['per']+1;//開始筆數
	$arr['end']=$arr['page']*$arr['per'];//結束筆數

	for($p=1;$p<=$arr['page'];$p++){
		
		$tpl->newBlock('pageBlock');
		if($p<10)
		{
			$tpl->assign('p','0'.$p);
		}
		else
		{
			$tpl->assign('p',$p);
		}
		if($p==$_GET['p'])
		{
			$tpl->assign('s','selected');
		}
	}
	//$i='';
	if(!isset($_GET['p']))
	{
		$arr['start']=1;//開始筆數
		
	}
	else
	{
		$arr['start']=($_GET['p']-1)*$arr['per']+1;//開始筆數
		
	}
	
	$arr['end']=($arr['start']-1)+$arr['per'];//結束筆數

	return $arr;
}

?>