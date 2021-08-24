<?php
session_start();
if (!isset($_SESSION['europe_username'])) 
{
  header("Location: login.php");
}
include ("../cfginclude/globalinc.php");
include ("../cfginclude/dbconfig.php");
include ("../cfginclude/dbfunction.php");
include ("../cfginclude/salesservices.php");

if (isset($_GET['sub'])) {
			$sub = $_GET['sub'];
	} else {$sub=""; }
	if (isset($_GET['op'])) {
			$op = $_GET['op'];
		}else {$op=""; }
		if (isset($_GET['add'])) {
			$add = $_GET['add'];
		}else {$add="";}


$draft_id = $_GET['id'];
$btok = $_POST['btnback'];
$custmer = $_GET['cust'];
$item_qty = $_POST['item_pcs'];
$tgl = $_POST['tgl'];
$box_no = $_POST['boxe'];
if($btok == "edit"){

header("Location: item_pack_edit.php?op=sub&tanggal=$tgl&box=$box_no");
}


if ($btok == "update"){
	$countid = count($_POST['item_pilih']);
	for($i=0;$i<$countid;$i++) {

$query = "UPDATE 209dispatch SET pack_item = '".$_POST['items_Pack'][$i]."', boxcase_no = '".$_POST['items_box'][$i]."', ".
			" dispt_qty = '".$_POST['items_pcs'][$i]."' ,weight_prod =".$_POST['items_wpcs'][$i]." , tag_cust ='".$_POST['items_tag'][$i]."', ".
			"dispt_note ='".$_POST['box_list']."', gweigth ='".$_POST['tot_gweigt']."' where dispatch_id = ".$_POST['item_pilih'][$i]."";
opendb();
$rec = querydb($query);
	var_dump($_POST['tot_gweigt']);

}	
}
if ($btok == "tambah") {
	# codeadd


	$countid = count($_POST['item_pilih']);
	for($i=0;$i<$countid;$i++) {
var_dump($_POST['item_nopilih'][$i]);
$query1 = "insert into 209dispatch (pack_id,pack_cust_id,item_no,so_number,export_date,pack_item,dispt_qty,boxcase_no,weight_prod)".
		 "values".
		 "(".
		 "'".$_POST['item_id'][$i]."',".
		 "'".$_POST['item_custid'][$i]."',".
		 " '".$_POST['item_nopilih'][$i]."',".
		 " '".$_POST['item_so'][$i]."',".
		 " '".$_POST['item_dateexport'][$i]."',".
		 " '".$_POST['items_Pack'][$i]."',".
		" '".$_POST['items_pcs'][$i]."',".
		" '".$_POST['items_box'][$i]."', ".
		" '".$_POST['items_wpcs'][$i]."'".
		")";

		
//opendb();
$rec = querydb($query1);
closedb();
//var_dump($_POST['tot_gweigt']);
}
}


?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
<title><?php echo $inc_window_title; ?></title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />  
<link href="../cfgcss/styles.css" rel="stylesheet" type="text/css" /> 
<link rel="shortcut icon" href="../images/pages/favicon.ico" />
</head>
<style type="text/css">
	.containgr {
  height: 33px;
  width: 103px;
  position: relative;
  border: 1px solid green;

}

.list-info {
  margin: 0;
  position: relative;
  top: 12%;
  text-align: left;
  left: 5%;
  margin-left: -3px;
}

th .tbl-detail {
	 position: relative;
  top: 53%;
}

p.ex11 {
  position: absolute;
  left: 13px;
  top: 260px;
}
</style>
<body>
	<div id="pageheader">
			 <?php include ("../cfginclude/pageheader.php");?>					 
	</div>	
	<div id="menumain">
			 <?php include ("../cfgmenu/menumain.php");?>
	</div>		
	<div id="menulevel1">
			 <?php include ("../cfgmenu/menusupplychain.php");?>
	</div>	
<div id="menulevel2"> Draft Packing	</div>	
	<div id="pagecontent" >
	<?php echo "<a href = 'draft_pack_new.php'>Create Draft</a>";?>		
		<td id = "containgr" width="300">
<div>	<header class = "list-info">	
<td   >
	 		
	 		<?php
	 		
$halaman = 5; //batasan halaman
$page = isset($_GET['halaman'])? (int)$_GET["halaman"]:1;
$mulai = ($page>1) ? ($page * $halaman) - $halaman : 0;
//$query = mysql_query("select * from tb_masjid LIMIT $mulai, $halaman");
//$sql = mysql_query("select * from tb_masjid");
//$total = mysql_num_rows($sql);
//$pages = ceil($total/$halaman); 
// ?>
 

<?php
 
			$no =$mulai+1;
	 		$comp = $records['company_name'];
	 		$query = "SELECT e.*, e.pack_cust_id, e.pack_id, f.company_name FROM 209dispatch e, 202customer f where cust_id = pack_cust_id  ".
	 				"  group by pack_id LIMIT $mulai, $halaman ";

	 		
	 		opendb();
	 		
	 		$recs = querydb($query);
	 		$sql = mysql_query("SELECT * FROM 209dispatch group by pack_id");
	 		$total = mysql_num_rows($sql);
			$pages = ceil($total/$halaman); 
			for ($i=1; $i<=$total ; $i++){
				

			
	 		while ($records = mysql_fetch_array($recs)) {
	 			# code...
	 			$comp = $records['company_name'];
	 			 
	 			echo "<tr valign = 'left'>".
	 				"<td>".
	 				"<td width = '20px'>[".$records['pack_id']."] .&nbsp;".
	 				"<td><a href ='item_pack_edit.php?op=op&id=".$records['pack_id']."&tanggal=".$records['export_date']."".
	 				"&cust=".$records['pack_cust_id']."&box=".$records['boxcase_no']."'>".$records['export_date']."</a>&nbsp; |&nbsp;".$records['company_name']."".
	 				"</td><br>";

	 				
	 		
	 	
	 	"<tr><br>";
	 }
	 		?>

	 		<a href="?=<?php echo $i; ?>">&nbsp;&nbsp;<?php echo $no."&nbsp;|"; }?></a><br><br>
	 		Export Date :
	 		 <td style="left: 0%"><input type="text"  name="tgl" value='<?php echo $_GET['tanggal'] ;?>' readonly=""/>
	 		 	<br>Customer &nbsp;&nbsp;&nbsp;:
	 		 	<td><input type="text"  name="tgl" value='<?php echo $_GET['cust'].$records['company_name'] ;?>' readonly="" size = "45"/> 
 			 </header></div>

 			 
 			 <tr>
 			 <td>&nbsp;</td>
 			 <?php
 			 if ($add == "add"){
 			 	
 			 ?>

 			 <td width="35">
<!-- 	<form		 	action="<?php $_SERVER["PHP_SELF"]; ?>" method="post"> -->
	<form name = "menu_tambah" action="item_pack_edit.php" method="POST"> 
<table summary="item_sumary" border="1" style=" position: relative;">
						<td width="6" align ="center" ></td>
				   		<td width="8" align ="center">Description</td>
				   		<td width="8" align ="center">Case</td>
				   		<td width="8" align ="center">Pack</td>
				   		<td width="8" align ="center">Quantity</td>
				   		<td width="8" align ="center">Weight</td>

			
<?php 


?>

   
<script >
  function checkAll(ele) {
      var checkboxes = document.getElementsByTagName('input');
      if (ele.checked) {
          for (var i = 0; i < checkboxes.length; i++) {
              if (checkboxes[i].type == 'checkbox' ) {
                  checkboxes[i].checked = true;
              }
          }
      } else {
          for (var i = 0; i < checkboxes.length; i++) {
              if (checkboxes[i].type == 'checkbox') {
                  checkboxes[i].checked = true;
              }
          }
      }
  }
</script>  
	<?php

	$id_pack = $_GET['id'];
	$tanggal_ex = $_GET['tanggal'];
	$custm_id = $_GET['cust'];
$query = "SELECT *,cust_item_name1, cust_item_name2,item_no  FROM  204order_item d where  delivery_date = '".$tanggal_ex."' and delivery_tocust2 = '".$custm_id."' ".
		" GROUP BY item_no, cust_item_name2"	;
opendb();    
                            $result = querydb($query); 
                            closedb();
             $row = mysql_num_rows($result); 
			 for ($i=0 ; $i < $row; $i++){
				$rows[$i]= mysql_fetch_array($result);

	
	
		?>	
	<tr><td><input  id="item_pilih"  name = "item_pilih[]"  value='<?php echo $rows[$i]["dispatch_id"]; ?> ' size="1"   >
		<input type="checkbox" name ="item_nopilih[]"  value='<?php echo $rows[$i]["item_no"]; ?> '><input   type="hidden" name = "item_nopilih[]"  value='<?php echo $rows[$i]["item_no"]; ?> '  >
		<input   type="hidden" name = "item_id[]"  value='<?php echo $_GET['id']; ?> '  >
		<input   type="hidden" name = "item_custid[]"  value='<?php echo $_GET['cust']; ?> '  >
			<input   type="hidden" name = "item_so[]"  value='<?php echo $rows[$i]["so_number"]; ?> '  >
			<input   type="hidden" name = "item_case[]"  value='<?php echo $rows[$i]["so_number"]; ?> '  >
			<input   type="hidden" name = "item_dateexport[]"  value='<?php echo $tanggal_ex; ?> '  >
		<td ><input   type="text" name = "item_n1[]" value='<?php echo $rows[$i]["cust_item_name1"];?>' size="30" readonly=""  > <br>
	<input   type="text" name = "item_n2[]" value='<?php echo $rows[$i]["cust_item_name2"];?>' size="30" readonly="">
	<td>	<input  type='' name="items_box[]" value='<?php  echo  $rows[$i]["boxcase_no"];?>'   size="2"  ><br>
	<td><input  type='' name="items_Pack[]" value='<?php  echo  $rows[$i]["pack_item"]; ?>'   size="2"  >	
	<td><input  type='' name="items_pcs[]" value='<?php  echo  number_format($rows[$i]["qty"],0) ; ?>'  size="3"  > 
		<td><input type='text' name="items_wpcs[]" value='<?php  echo  number_format($rows[$i]["weight_prod"],2) ; ?>'  size="3" ><br>
		 </tr>
       <tr>         <td></td>
 			<!-- 		<td><input type="submit"  name="btnback" value="tambah"/> -->

<?php }
	
?>

 <input type="submit" name="submit" value="submit" >



 			 		<?php
 			 	}
 			
 			if(empty($_POST['item_pilih'])){
 				echo "Please select the checkbox";
 			}else {
 				if(isset($_POST['submit'])) {
		$x = $_POST['item_nopilih'];
		$df = $_POST['item_n1'];
		echo "Your Output: </br>";
		for($i=0;$i<count($x);$i++) {
			echo "".$x[$i]."".$df[$i]."</br>";

		}
		}
;	}

 			 			if ($op == "op"){
 			 		?>
 			 		<th class="tbl-detail">
 			 			<form method="post">
 			 		<td width="380">
 			 			<!-- <td style="left: 0%"><input type="text"  name="tgl" value='<?php echo $_GET['tanggal'] ;?>' readonly=""/> -->
 						<div ><tr>	<table summary="item_sumary" border="1">
						<input type="hidden"  name="tgl" value='<?php echo $_GET['tanggal'] ;?>'/>
						<input type="hidden"  name="boxe" value='<?php echo $_GET['box'] ;?>'/>
									<tr bgcolor='#dddddd' valign="top">
						<div ><p class="ex13"><a href="item_pack_edit.php?add=add&tanggal=<?php echo $_GET['tanggal'] ;?>&id=<?php echo $_GET['id'];?>&cust=<?php echo $_GET['cust'];?>" target =_BLANK style = 'border : 1px solid #1163A7;' >tambah</a></p><tr></div>
						<div ><p class="ex11"><a style="cursor:pointer;" onclick="window.open('add_item_pack.php?tanggal=<?php echo $_GET['tanggal'] ;?>&id=<?php echo $_GET['id'];?>', '','width=800,height=350,location=no,menubar=no,resizeable=no,scrollbars=yes,titlebar=no,toolbar=no')";><font color="#1D3AD7">Tambah Item</font></a></div>				
					   	<td  width="8">No.</td>
				   		<td width="175" >No. PO <br> No SPO</td>
				   		<td width="0.00001">
							
							<td  width="90" align="center">Refer No</td>
							<td  width="290" align="center">Description</td>
							<td  width="80" align="center">Proces</td>
							<td  width="12" colspan="">Size</td>
							
							<td  width="8">Unit</td>
							<td  width="35">Quantity</font><i>
								<td  width="35">Weight</font></td>
								<td width="35" align="center">Jumlah<br>Pack/Bobin</td>
								<td align="center" width="35">No Tag<br>customer</td>
								

								<td  align="center"  width="157" colspan = "3">INFO Weight</font></td>
								 
								<?php		
							$item_date = $_GET['tanggal'];
							$item_cust = $_GET['cust'];
							$box_no = $_POST['boxe'];

							$queryg = "SELECT boxcase_no, max(boxcase_no) as cbox from 209dispatch where export_date =  '".$item_date."' and ".
								" pack_cust_id = '".$item_cust."' group by boxcase_no ";
							opendb();    
							$records1 = querydb($queryg);      
							closedb();
							while ($recs = mysql_fetch_array($records1))
							{
								$grp_case = $recs['boxcase_no'];
								$count_case = $recs['cbox'];
								echo "<tr ><td colspan = '15'  align = 'left' bgcolor='#6495ED' ><b>Case No. : ".$grp_case." of ".$count_case."</b>"; 
										"<tr style = 'height:5px;'>";
									?>
									<?php
							$query = "SELECT N.*, N.qty*N.weight_est as berat, M.dispatch_id, M.dispt_qty, M.weight_prod, M.boxcase_no, M.pack_item,M.tag_cust,O.reff_orderno ".
								" FROM 204order_item as N LEFT JOIN 209dispatch AS M ON N.so_number = M.so_number && N.item_no = M.item_no ".
								"LEFT JOIN 203order as O ON N.so_number = O.so_number ".
										
										"where substr(N.so_number,6,4) <>'1803'  ".
										"and N.delivery_date = '".$item_date."' and M.pack_cust_id = '".$item_cust."' and ".
										" M.boxcase_no = '".$grp_case."'  ".
										"order by delivery_date asc, N.so_number, N.item_no ";
							opendb();    
							$records = querydb($query);      
							closedb();
							

							$i=1;     
							while ($data = mysql_fetch_array($records))    
							{
								#--fungsiproses
								$g_process = $data['proces_group'];
								if($g_process == "RH"){
                        $hname = "Rhodioum Coat";
                    } elseif ($g_process == "GOS") {
                          $hname = "Yellow Gold(GOS)";
                    } elseif ($g_process == "KN") { 
                        $hname = "KN";
                    } elseif ($g_process == "KY") { 
                        $hname = "Y- Coat";
                    } elseif ($g_process == "GOS+KY") { 
                        $hname = "Yellow Gold(GOS)+Y- Coat";
                     }   else {
                      $hname = "$g_process";
                      } 
								$qty_prod = $data['dispt_qty'];
								
								#fugsiqty
								if($qty_prod !=""){
									$data['qty'];
								}else {
									$qty_prod = $data['dispt_qty'];
								}

								$w_prod = $data['weight_prod'];
								


								echo"<tr valign='top'> ".
									"<td >".$i++."<br>".
									"<td colspan ='2' >PO#".$data['po_number']."<br>".$data['so_number']."".
									"<td align = 'center'>".$data['reff_orderno']."".
									"<td >".$data['cust_item_name1']."<br>".$data['cust_item_name2']."".
									
									"<td align = 'center'>".$hname." ".
									"<td align = 'center'><input name='items_berat' size='2' maxlength='12' value='".$data['size']."' readonly = '';> ".
								//	"<td align = 'center'> ".
									"<td align = 'right'><input name='items_berat' size='2' maxlength='12' value='".$data['unit']."' readonly = '';>".
									"<td align = 'right'><input name='items_berat' size='3' maxlength='12' value='".number_format($qty_prod,0)."' readonly = '';>".
									
									"<td align = 'right'><input name='items_berat' size='4' maxlength='12' value='".number_format($w_prod,2)."' readonly = '';>".
									"<td align = 'right'><input  name='items_pack' size='4' maxlength='12' value='".$data['pack_item']."' readonly = '';>".
									"<td align = 'center'><input  name='items_tag' size='1' maxlength='12' value='".$data['tag_cust']."' readonly = '';>".
									"<td align = 'left' colspan = '3' size='4' value='' ;><br> ";
								//	"<input type = 'checkbox' name='item_id[]' size='0' maxlength='3' value='".$data['dispatch_id']."';>";
									
								}
								
								echo"<td><a href ='item_pack_edit.php?op=sub&box=".$grp_case."&tanggal=".$item_date."&cust=".$item_cust."'>edit</a></td>";
								
							?>
						<!--<input type="submit"  name="btnback" value="edit"/> -->
					</header>
							<?php
						
					
						$query = "SELECT c.*, sum(if(unit = 'PCS', dispt_qty, 0)) as totpcs, SUM(IF(unit = 'FT', dispt_qty, 0)) AS jml_ft ,".
								" SUM(IF(unit = 'pair', dispt_qty, 0)) AS jml_pair, SUM(IF(unit = 'meter', dispt_qty, 0)) AS jml_mtr ,".
								"	sum(weight_prod) as totgros , max(c.gweigth) as tot_case, c.dispt_note, e.ship_address, e.contact_ship".
								"  FROM 209dispatch c, 204order_item d , 207shipping_account e where  c.so_number = d.so_number ".
		"and c.item_no = d.item_no and c.export_date = '".$item_date."' and  boxcase_no = '".$grp_case."' and c.pack_cust_id = '".$item_cust."' ".
		"and e.cust_id = d.delivery_tocust2";

		opendb();
		$records = querydb($query);      
							
		while($recs = mysql_fetch_array($records)) {
						?>
						

						
					   	<tr >
					   	</tr><td  colspan="7"> <td  colspan="7" align ="center"><strong>TOTAL<?php echo "&nbsp;Case : ".$grp_case ;?></strong></td>
					   		
					   			<tr bgcolor='#dddddd'>
					   	<td width="6" align ="center" colspan="7">NOTE</td>
				   		<td width="6" align ="center">Pcs<td width="8" align ="center">Pair</td>
				   		<td width="6" align ="center">Feet</td>
				   		<td width="8" align ="center">Meter</td>
				   		<td width="8" align ="center">Inch</td>
				   		
				   			<td width="19" align ="center">Weight <br>(gr) </td>
				   			<td width="21" align ="center">Gros Weight (gr) </td></tr>

				   		<?php

				   		$item_pcs = $recs['totpcs'];
				   		$item_pair = 0.00;
				   		$item_feet =$recs['jml_ft'];;
				   		$item_met = 0.00;
				   		$item_inch = 0.00;
				   		$item_gross = $recs['totgros'];


				   		

				   		echo"<tr valign='top'> ".
									"<td colspan = '7' >Att : &nbsp;&nbsp;&nbsp;<b>".$recs['contact_ship']."</b><br>Ship to : &nbsp;".
									"<br><br>Package : &nbsp;&nbsp;&nbsp;<b>".$recs['dispt_note']."</b>".
									"<br><td align = 'center'><br>".number_format($item_pcs,0)."<strong>" .
									"<br><td align = 'center'><br>".number_format($item_pair,0)."<strong>".
									"<td align = 'center'><br>".number_format($item_feet,0)."<strong>".
									"<td align = 'center'><br>".$item_met."<strong>".
									"<td align = 'center'><br>".$item_inch."<strong>".
									"<td align = 'center'><br><input name='items_net' size='4' maxlength='13' value='".number_format($item_gross,2)."';<td>".
									"<td align = 'center'><br><input name='items_gros' size='4' maxlength='13' value='".number_format($recs['tot_case'],2)."';".
									"<td align = 'right'><strong></strong>";

							
						}
						?>
						<tr style = "height:10px;">
						<?php
					

					}
						
						

				   		?>
				   			<tr >
				   			
				   			
				   			<td width="19" align ="center" colspan="7"> </td>
				   			<td>
				   			</tr>
				   			<td width="19" align ="center" colspan="7"></td>
				   			<td width="6" align ="center"><B>Pcs<B><td width="8" align ="center"><B>Pair<B></td>
				   		<td width="6" align ="center"><B>Feet<B></td>
				   		<td width="8" align ="center"><B>Meter<B></td>
				   		<td width="8" align ="center"><B>Inch<B></td>
				   			<td width="8" align ="center" colspan="2"><strong>Weigth</strong></td><tr>
				   			<td width="8" align ="center" colspan="7" bgcolor='#dddddd'><B>GRAND TOTAL</B>
				   	<?php 
				   	$query = "SELECT c.*, sum(if(unit = 'PCS', dispt_qty, 0)) as totpcs, SUM(IF(unit = 'FT', dispt_qty, 0)) AS jml_ft ,".
								" SUM(IF(unit = 'pair', dispt_qty, 0)) AS jml_pair, SUM(IF(unit = 'meter', dispt_qty, 0)) AS jml_mtr ,".
								"	sum(weight_prod) as totgros , max(c.gweigth) as tot_case".
								"  FROM 209dispatch c, 204order_item d where  c.so_number = d.so_number ".
		"and c.item_no = d.item_no and c.export_date = '".$item_date."'  and c.pack_cust_id = '".$item_cust."' ";

		opendb();
		$record = querydb($query);   
		closedb();
							while ($recs = mysql_fetch_array($record)){

								
							  

				   	$querytot = "select boxcase_no, sum(gweigth) as tot_3 ".
								"from (select boxcase_no, pack_id, gweigth  from  209dispatch  where export_date = '".$item_date."' and ".
								"pack_cust_id = '".$item_cust."'  group by  boxcase_no, gweigth ) A ".
								"";
				/*   	$querytot = "SELECT max(boxcase_no) as c_box,max(gweigth) as jml_berat , min(gweigth) as jml_1,  sum(if(gweigth <> '0',gweigth,0)) as tot3 ".
				   				"FROM 209dispatch where export_date = '".$item_date."' ".
				   				"and pack_cust_id = '".$item_cust."' "; */
						opendb();
						$result = querydb($querytot);
						closedb();
							while ($records = mysql_fetch_array($result)){
								
								$m_box = $records['c_box'];	
								if($m_box == 1){
									$tot1 = $records['jml_berat'];
								} elseif($m_box == 3) {
								
								$tot1 = $records['tot_3'];

							}else {
								$tot = $records['jml_berat'];
								$tot1 = $tot+$records['jml_1'];
							}

				   		echo "<td align = 'center'><B>".number_format($recs['totpcs'],0)."<B>".
				   				"<td align = 'center'><B>".number_format($recs['pair'],0)."<B></td>".
				   				"<td align = 'center'><B>".number_format($recs['jml_ft'],2)."<B></td>".
				   				"<td align = 'center'><B>0.00</B></td>".
				   				"<td align = 'center'><B>0.00</B></td>".
				   				"<td colspan = '2' align = 'center'><B>".number_format($records['tot_3'],2)."<B></td>".
				   				"<td></td>";
				   			}
				   		}
				   	?>			
				  

				   	</td></table>
							</div> 				

<?php
	}	

if ($op == "sub"){

?>
<td width="35">
<form name = "menu_perubahan" action="item_pack_edit.php" method="POST">
			
<table summary="item_sumary" border="1" style=" position: relative;">
						<td width="6" align ="center" >checkAll<br><input align ="center" type="checkbox" onchange="checkAll(this)" name="chk[]" ></td>
				   		<td width="8" align ="center">Description</td>
				   		<td width="8" align ="center">Case</td>
				   		<td width="8" align ="center">Pack</td>
				   		<td width="8" align ="center">Quantity</td>
				   		<td width="8" align ="center">Weight</td>
				   		<td width="8" align ="center">NO Tag<br>customer</td>

			<?php 
	$id_pack = $_GET['box'];
	$tanggal_ex = $_GET['tanggal'];
$query = "SELECT c.*, d.cust_item_name1, d.cust_item_name2,c.dispatch_id,c.tag_cust  FROM 209dispatch c, 204order_item d where  c.so_number = d.so_number ".
		"and c.item_no = d.item_no and c.boxcase_no = '".$id_pack."' and c.export_date = '".$tanggal_ex."' and c.pack_cust_id = '".$_GET['cust']."'";
opendb();    
                            $result = querydb($query); 
                            closedb();
             $row = mysql_num_rows($result); 
			 for ($i=0 ; $i < $row; $i++){
				$rows[$i]= mysql_fetch_array($result);

//	var_dump($rows[$i]['cust_item_name1']);
	
		?>	

	<tr><td><input   type="checkbox" name = "item_pilih[]"  value='<?php echo $rows[$i]["dispatch_id"]; ?> '  >
		<td ><input   type="text" name = "item_n1[]" value='<?php echo $rows[$i]["cust_item_name1"]; ?>' size="10" readonly=""  > <br>
	<input   type="text" name = "item_n2[]" value='<?php echo $rows[$i]["cust_item_name2"]; ?>' size="26" readonly="">
	<td>	<input  type='text' name="items_box[]" value='<?php  echo  $rows[$i]["boxcase_no"]; ?>'   size="2"  ><br>
	<td><input  type='' name="items_Pack[]" value='<?php  echo  $rows[$i]["pack_item"]; ?>'   size="2"  >	
	<td><input  type='' name="items_pcs[]" value='<?php  echo  number_format($rows[$i]["dispt_qty"],0) ; ?>'  size="2"  >
				<td><input type='text' name="items_wpcs[]" value='<?php  echo  number_format($rows[$i]["weight_prod"],2) ; ?>'  size="2" >
					<td><input type='text' name="items_tag[]" value='<?php  echo  number_format($rows[$i]["tag_cust"],2) ; ?>'  size="2" >
								


	



	<?php
			}
		$query = "SELECT c.*, c.gweigth,c.dispatch_id  FROM 209dispatch c, 204order_item d where  c.so_number = d.so_number ".
		"and c.item_no = d.item_no and c.boxcase_no = '".$id_pack."' and c.export_date = '".$tanggal_ex."' and c.pack_cust_id = '".$_GET['cust']."'";
		opendb();    
                            $result = querydb($query); 
                            closedb();
                            $rows = mysql_fetch_array($result);
	?>
	
	<td>
		
		<td><select name="box_list">
			<option valu="UPS ENVELOPE">UPS ENVELOPE</option>
			<option value="FEDEX ENVELOPE">FEDEX ENVELOPE</option>
			<option value="FEDEX (S)">FEDEX (S)</option>
			<option value="FEDEX (M)">FEDEX (M)</option>
			<option value="FEDEX (L)">FEDEX (L)</option>
			<option value="YAMAMORI BOX (S)">YAMAMORI BOX (S)</option>
			<option value="YAMAMORI BOX (M)">YAMAMORI BOX (M)</option>
			<option value="YAMAMORI BOX (ML)">YAMAMORI BOX (ML)</option>
			<option value="YAMAMORI BOX (L)">YAMAMORI BOX (L)</option>
			<option value="CASE BIRU (S)">CASE BIRU (S)</option>
				<option value="KARDUS PXLXT : 20X13X9">KARDUS PXLXT : 20X13X9</option>
		</select>
		<select name="delivery_tocust1">
			 	 	 			<option value="">Select Customer</option>
			 	 	 			<?php 
			 	 	 				$query = "select * from 207shipping_account order by cust_id ";
			 	 	 				opendb(); 
									$records = querydb($query);      				 
									closedb();
									while ($data = mysql_fetch_array($records))    
									{
										echo " <option value='".$data['acc_id']."' " .  is_selected($acc, $data['acc_id']) . "> " . $data['company_add'] . " ".$data['exp_name']."-&nbsp;".$data['account_cust']." </option> ";
									}
			 	 	 			?>
						</select >
		
			<br>Gross Weight<br><input type='text' name="tot_gweigt" size= "3" value='<?php  echo  $rows["gweigth"] ; ?>'  size="2" >
<script >
  function checkAll(ele) {
      var checkboxes = document.getElementsByTagName('input');
      if (ele.checked) {
          for (var i = 0; i < checkboxes.length; i++) {
              if (checkboxes[i].type == 'checkbox' ) {
                  checkboxes[i].checked = true;
              }
          }
      } else {
          for (var i = 0; i < checkboxes.length; i++) {
              if (checkboxes[i].type == 'checkbox') {
                  checkboxes[i].checked = false;
              }
          }
      }
  }
</script>

 	<input type="submit"  name="btnback" value="update"/></div>		 		
		
		
	<?php
}
	?>

	

  			<td width="600">
			<section class="main-body bg-dark text-white">
    <!-- html code hear -->

    <table>
        <form action="<?php $_SERVER["PHP_SELF"]; ?>" method="post">
            <tr>
                
                </td>
            </tr>

            <tr>
                <td></td>
                <td>
                   
                </td>
            </tr>
        </form>
    </table>
    <!-- php code hear -->
    <?php

    
    ?>
</section>		
 
	
  <div id="pagefooter">
  	<!-- <?php include ("../cfginclude/pagefooter.php");?> -->
  </div>
</body>
</html>