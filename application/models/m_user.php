<?php
class M_user extends CI_Model
{
  
    function cek_user($username,$password){
        $hasil=$this->db->query("SELECT * FROM user WHERE username='$username' AND password='$password' ");
        return $hasil;
    }

   function pendaftaran_user($username, $no_hp, $email, $nama_mitra, $password, $id_role){
            $hasil = $this->db->query("INSERT INTO user(username,no_hp,email,nama_mitra,password,id_user_level) VALUES ('$username','$no_hp','$email','$nama_mitra','$password','$id_role')");
            return $hasil;
        }

   function get_user(){
    $hasil=$this->db->query("SELECT * FROM user");
    return $hasil;
   }

   function get_user_mitra(){
    $hasil=$this->db->query("SELECT * FROM user WHERE NOT id= 3");
    return $hasil;
   }

   function get_user_by_id($id){
    $hasil=$this->db->query("SELECT * FROM user WHERE id='$id'");
    return $hasil;
   }

   function update_user($username, $password, $email, $no_hp, $alamat_mitra, $id){
    $hsl = $this->db->query("UPDATE user SET username='$username', password='$password' , email='$email', no_hp='$no_hp', alamat_mitra='$alamat_mitra' WHERE id='$id'");
     return $hsl;
 }

 function count_all_table($id){
    $hasil=$this->db->query("SELECT  (
        SELECT COUNT(*)
        FROM   kerja_sama_eksternal
        ) AS count1,
        (
        SELECT COUNT(*)
        FROM   kerja_sama_internal
        ) AS count2,
        (
        SELECT COUNT(*)
        FROM   implementasi_kerja_sama
        ) AS count3,
        (
        SELECT COUNT(*)
        FROM   data_pengajuan WHERE id_user_penerima='$id'
        ) AS count4
FROM    dual");
    return $hasil;
 }

 function count_all_table_anngota(){
    $hasil=$this->db->query("SELECT  (
        SELECT COUNT(*)
        FROM   kerja_sama_eksternal
        ) AS count1,
        (
        SELECT COUNT(*)
        FROM   kerja_sama_internal
        ) AS count2,
        (
        SELECT COUNT(*)
        FROM   implementasi_kerja_sama
        ) AS count3,
        (
        SELECT COUNT(*)
        FROM   data_pengajuan
        ) AS count4
FROM    dual");
    return $hasil;
 }

}?>
