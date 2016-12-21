<?php

/**
 * 提供微信回复模板
 */

//文字消息
$config['wx_text'] = "<xml>
	<ToUserName><![CDATA[%s]]></ToUserName>
	<FromUserName><![CDATA[%s]]></FromUserName>
	<CreateTime>%s</CreateTime>
	<MsgType><![CDATA[text]]></MsgType>
	<Content><![CDATA[%s]]></Content>
	</xml>";

//图片消息
$config['wx_image'] = '<xml>
	<ToUserName><![CDATA[%s]]></ToUserName>
	<FromUserName><![CDATA[%s]]></FromUserName>
	<CreateTime>%s</CreateTime>
	<MsgType><![CDATA[image]]></MsgType>
	<Image>
	<MediaId><![CDATA[%s]]></MediaId>
	</Image>
	</xml>';

// 语音
$config['wx_voice'] = '<xml>
	<ToUserName><![CDATA[%s]]></ToUserName>
	<FromUserName><![CDATA[%s]]></FromUserName>
	<CreateTime>%s</CreateTime>
	<MsgType><![CDATA[voice]]></MsgType>
	<Voice>
	<MediaId><![CDATA[%s]]></MediaId>
	</Voice>
	</xml>';

// 视频
$config['wx_video'] = '<xml>
	<ToUserName><![CDATA[%s]]></ToUserName>
	<FromUserName><![CDATA[%s]]></FromUserName>
	<CreateTime>%s</CreateTime>
	<MsgType><![CDATA[video]]></MsgType>
	<Video>
	<MediaId><![CDATA[%s]]></MediaId>
	<Title><![CDATA[%s]]></Title>
	<Description><![CDATA[%s]]></Description>
	</Video> 
	</xml>';

// 音乐
$config['wx_music'] = '<xml>
	<ToUserName><![CDATA[%s]]></ToUserName>
	<FromUserName><![CDATA[%s]]></FromUserName>
	<CreateTime>%s</CreateTime>
	<MsgType><![CDATA[music]]></MsgType>
	<Music>
	<Title><![CDATA[%s]]></Title>
	<Description><![CDATA[%s]]></Description>
	<MusicUrl><![CDATA[%s]]></MusicUrl>
	<HQMusicUrl><![CDATA[%s]]></HQMusicUrl>
	<ThumbMediaId><![CDATA[%s]]></ThumbMediaId>
	</Music>
	</xml>';

// 图文
$config['wx_news'] = '<xml>
	<ToUserName><![CDATA[%s]]></ToUserName>
	<FromUserName><![CDATA[%s]]></FromUserName>
	<CreateTime>%s</CreateTime>
	<MsgType><![CDATA[news]]></MsgType>
	<ArticleCount>%s</ArticleCount>
	<Articles>
	%s
	</Articles>
	</xml>';

// 图文选项
$config['wx_news_item']	= '<item>
	<Title><![CDATA[%s]]></Title> 
	<Description><![CDATA[%s]]></Description>
	<PicUrl><![CDATA[%s]]></PicUrl>
	<Url><![CDATA[%s]]></Url>
	</item>';