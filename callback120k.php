<?php
// Đạo nhái từ nhiều nguồn bởi to9xvn
// trang web: https://dailysieure.com
// facebook: https://dailysieure.com/to9xvn
include 'quantri_hethong/xuly_ketnoi.php';
include 'to9xvn_tsr.php';
$hostname = 'localhost';
   
/////////////////////////
//  Anti Bug hack by to9xvn //
// Xoá đi hoặc sửa nếu bị bug thì mình k chịu trách nhiệm //
///////////////////////// GET
 foreach($_GET as $var => $value) {
      if (preg_match('/[^\da-zA-Z_ÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéếêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ.\/\:\-\@\|\(\)\_\s]+/', $value)) {
  $_GET["$var"]= '';
}else{
    $_GET["$var"]= addslashes(mysqli_real_escape_string($ketnoi, $value));
}
}

// POST
foreach($_POST as $var => $value) {
 if (preg_match('/[^\da-zA-Z_ÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ.\/\:\-\@\|\(\)\_\s]+/', $value)) {
  $_POST["$var"]= '';
}else{
    $_POST["$var"] = addslashes(mysqli_real_escape_string($ketnoi, $value));
  
}
} 






			$callback_sign = md5($partner_key.$_GET['code'].$_GET['serial']);
			if($_GET['callback_sign'] == $callback_sign) { 
				
				$getdata['status'] = $_GET['status'];
				$getdata['message'] = $_GET['message'];
				$getdata['request_id'] = $_GET['request_id'];   /// Mã giao dịch của bạn
				$getdata['trans_id'] = $_GET['trans_id'];   /// Mã giao dịch của website webthedfull.com
				$getdata['declared_value'] = $_GET['declared_value'];  /// Mệnh giá mà bạn khai báo lên
				$getdata['value'] = $_GET['value'];  /// Mệnh giá thực tế của thẻ
				$getdata['amount'] = $_GET['amount'];   /// Số tiền bạn nhận về (VND)
				$getdata['code'] = $_GET['code'];   /// Mã nạp
				$getdata['serial'] = $_GET['serial'];  /// Serial thẻ
				$getdata['telco'] = $_GET['telco'];   /// Nhà mạng
				
	$menhgiathe =	$_GET['value'];  		
			if(isset($_GET['status'])) {
						
						/// status = 1 ==> thẻ đúng
						/// status = 2 ==> thẻ sai
						/// status = 3 ==> thẻ ko dùng đc
						/// status = 99 ==> thẻ chờ xử lý
					
			if ($_GET['status'] == "1") {
				
				// status = 1 ==> thẻ đúng + Cộng tiền cho khách bằng  $_GET['amount'] tại đây
				
			mysqli_query($ketnoi, "UPDATE `to9xvn_napthenhanh` SET `tinhtrang` = '1' WHERE  `code` = '".$_GET['code']."' AND `seri` = '".$_GET['serial']."'  ");
			$to9xvn_code = mysqli_fetch_array(mysqli_query($ketnoi, "SELECT * FROM `to9xvn_napthenhanh` WHERE  `code` = '".$_GET['code']."' AND `seri` = '".$_GET['serial']."'  "));
$to9xvn_id = $to9xvn_code['uid'];
 $to9xvn_noidung = $to9xvn_code['noidung'];
$str_to9xvn = explode("|", $to9xvn_noidung);
$to9xvn_ten = $str_to9xvn[0];
$to9xvn_tk = $str_to9xvn['1'];
mysqli_query($ketnoi, "UPDATE nguoidung SET `tien` = `tien` + '".$menhgiathe."' WHERE `id` = '".$to9xvn_id."'");
//mysqli_query($ketnoi, "UPDATE to9xvn_nguoidung SET `123` = `123` + '".$menhgiathe."' WHERE `id` = '".$to9xvn_id."'");
// top nạp 
$total_records = mysqli_num_rows(mysqli_query($ketnoi, "SELECT * FROM  `top_recharge`  WHERE  `username` = '".$to9xvn_tk."' "));	
			if($total_records > 0){
mysqli_query($ketnoi,"UPDATE `top_recharge` SET `cash` = `cash` + '".$menhgiathe."' WHERE `username` = '{$to9xvn_tk}'");			    
			}else{
mysqli_query($ketnoi,"INSERT INTO `top_recharge` (username,name,cash) VALUES ('$to9xvn_tk','".$to9xvn_ten."','".$menhgiathe."') ");			    
			    
			    
			} // kết thúc 	$total_records
			}
			else {
				/// Thẻ sai hoặc đã được nạp
				//DEMO cập nhật trạng thái thẻ của khách nạp
			mysqli_query($ketnoi, "UPDATE `to9xvn_napthenhanh` SET `tinhtrang` = '2' WHERE  `code` = '".$_GET['code']."' AND `seri` = '".$_GET['serial']."'  ");
			
			
			
			}
			
		}		
				
				
				
				
				
			//	print_r($getdata);
			}		





/*















	// amount_declare mệnh giá thực
	$menhgiathe = abs($_GET['amount']);	
	
	$url = 'http://sys.napthenhanh.com/api/charging-wcb'; //url API gạch thẻ của hệ thống
$partner_id = $caidat['idnap']; //API key, lấy từ website napthenhanh.com
	$partner_key =  $caidat['keynap'];//API secret lấy từ website napthenhanh.com
		$xacthucthem = 'xcvzkdlkspoffdsprppTO9XVN';
        $callback_sign = md5($partner_key.$_GET['tranid'].$_GET['pin'].$_GET['serial']);
        $callback_sign = md5($callback_sign.$xacthucthem);
        $chuky = $_GET['callback_sign'];
        $chuky = md5($chuky.$xacthucthem);
        if($chuky!=$callback_sign){
               exit();
        }

		if(isset($_GET['status'])) {
			
			if ($_GET['status'] == "1") {
				
				// status = 1 ==> thẻ đúng + Cộng tiền cho khách bằng  $_GET['amount'] tại đây
				
			mysqli_query($ketnoi, "UPDATE `to9xvn_napthenhanh` SET `tinhtrang` = '1' WHERE  `code` = '".$_GET['pin']."' AND `seri` = '".$_GET['serial']."'  ");
			$to9xvn_code = mysqli_fetch_array(mysqli_query($ketnoi, "SELECT * FROM `to9xvn_napthenhanh` WHERE  `code` = '".$_GET['pin']."' AND `seri` = '".$_GET['serial']."'  "));
$to9xvn_id = $to9xvn_code['uid'];
mysqli_query($ketnoi, "UPDATE to9xvn_nguoidung SET `vnd` = `vnd` + '".$menhgiathe."' WHERE `id` = '".$to9xvn_id."'");
//mysqli_query($ketnoi, "UPDATE to9xvn_nguoidung SET `123` = `123` + '".$menhgiathe."' WHERE `id` = '".$to9xvn_id."'");

					
			}
			else {
				/// Thẻ sai hoặc đã được nạp
				//DEMO cập nhật trạng thái thẻ của khách nạp
			mysqli_query($ketnoi, "UPDATE `to9xvn_napthenhanh` SET `tinhtrang` = '2' WHERE  `code` = '".$_GET['pin']."' AND `seri` = '".$_GET['serial']."'  ");
			
			
			
			}
			
		}

?>