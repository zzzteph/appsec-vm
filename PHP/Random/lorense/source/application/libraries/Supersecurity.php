<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Supersecurity {


		//EXTRA SECURITY

        public function encrypt($value)
        {
			$CI =& get_instance();
			$CI->load->library('session');
			$iv=$_COOKIE["ci_session"];
			if(strlen($iv)>16)$iv=substr($iv,0,16);
			$key=$CI->session->userdata('id');
			
			$cipher = "AES-128-CBC";

			$ciphertext = openssl_encrypt($value, $cipher, $key, OPENSSL_RAW_DATA, $iv);				
			return 	bin2hex($ciphertext);
		}

        public function decrypt($ciphertext)
        {
			$CI =& get_instance();
			$iv=$_COOKIE["ci_session"];
			if(strlen($iv)>16)$iv=substr($iv,0,16);
			$key=$CI->session->userdata('id');
			$cipher = "AES-128-CBC";


			$ciphertext=hex2bin($ciphertext);
			$plaintext = openssl_decrypt($ciphertext, $cipher, $key, OPENSSL_RAW_DATA, $iv);
			return $plaintext;
		}
			
			

		
			
			
}
		
		
