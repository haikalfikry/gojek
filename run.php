<?php
date_default_timezone_set('Asia/Jakarta');
include "function.php";
echo color("green","# # # # # # # # # # # # # # # # # # # # # # # \n");
echo color("yellow","[•]  Time  : ".date('[d-m-Y] [H:i:s]')."   \n");
echo color("yellow","[•]              waiting proses.....           \n");
echo color("yellow","[•] cara menulis nomor pakai 62xxxxxxxxxx \n");
echo color("green","# # # # # # # # # # # # # # # # # # # # # # # \n");
function change(){
        $nama = nama();
        $email = str_replace(" ", "", $nama) . mt_rand(100, 999);
        ulang:
        echo color("nevy","(•) Nomor : ");
        $no = trim(fgets(STDIN));
        $data = '{"email":"'.$email.'@gmail.com","name":"'.$nama.'","phone":"+'.$no.'","signed_up_country":"ID"}';
        $register = request("/v5/customers", null, $data);
        if(strpos($register, '"otp_token"')){
        $otptoken = getStr('"otp_token":"','"',$register);
        echo color("green","+] Kode verifikasi sudah di kirim")."\n";
        otp:
        echo color("nevy","?] Otp: ");
        $otp = trim(fgets(STDIN));
        $data1 = '{"client_name":"gojek:cons:android","data":{"otp":"' . $otp . '","otp_token":"' . $otptoken . '"},"client_secret":"83415d06-ec4e-11e6-a41b-6c40088ab51e"}';
        $verif = request("/v5/customers/phone/verify", null, $data1);
        if(strpos($verif, '"access_token"')){
        echo color("green","+] Berhasil mendaftar");
        $token = getStr('"access_token":"','"',$verif);
        $uuid = getStr('"resource_owner_id":',',',$verif);
         setpin:
         echo color("red","\n========( PIN ANDA = 220600 )========")."\n";
         $data2 = '{"pin":"220600"}';
         $getotpsetpin = request("/wallet/pin", $token, $data2, null, null, $uuid);
         echo color("nevy","?] Otp: ");
         $otpsetpin = trim(fgets(STDIN));
         $verifotpsetpin = request("/wallet/pin", $token, $data2, null, $otpsetpin, $uuid);
         echo $verifotpsetpin;
         }
         else{
         echo color("red","-] Otp yang anda input salah\n");
         echo color("yellow","\nMau menginput ulang? (y/n): ");
         $pilih = trim(fgets(STDIN));
         if($pilih == "y" || $pilih == "Y"){
          echo color("yellow","!] Silahkan input kembali\n");
         goto otp;
         }else{
         Die();}
         }
         }
         else{
         echo color("red","NOMOR SUDAH TERDAFTAR/SALAH !!!");
         echo color("yellow","\nMau ulang? (y/n): ");
         $pilih = trim(fgets(STDIN));
         if($pilih == "y" || $pilih == "Y"){
         echo color("yellow","\n==============Register==============\n");
         goto ulang;
         }else{
         Die();
  }
 }
}
         
echo change()."\n"; ?>
