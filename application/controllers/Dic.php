<?php

/**
 * 用来提供百度接口翻译
 */

class Dic extends CI_Controller{

	public function query(){
		$query = $this->input->get('query');
		$option = $this->input->get('option')+0;
		//这个要求和微信小程序的相对应
		$lan = array('zh','en','yue','wyw','jp','kor','fra','th','spa','ara','ru','pt','de','it','el','nl','pl','bul','est','dan','fin','cs','rom','slo','swe','hu','cht');
		$option = $lan[$option];
		$this->load->library('Transapi');
		//自己导入的类不是类原名，首字母是小写的
		$re = $this->transapi->translate($query,$option);
		echo $re['trans_result'][0]['dst'];
	}

}