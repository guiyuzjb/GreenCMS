<?php
/**
 * Created by PhpStorm.
 * User: Timothy Zhang
 * Date: 14-10-23
 * Time: 下午10:50
 */

namespace Weixin\Util;


use Think\Log;

class ResponseMsg
{


    /**
     * 文本
     * @param $fromusername
     * @param $tousername
     * @param $content 回复的消息内容（换行：在content中能够换行，微信客户端就支持换行显示）
     * @param int|\Weixin\Util\默认为0 $funcFlag 默认为0，设为1时星标刚才收到的消息
     * @return string
     */
    public function text($fromusername, $tousername, $content, $funcFlag = 0)
    {
        $template = <<<XML
<xml>
    <ToUserName><![CDATA[%s]]></ToUserName>
    <FromUserName><![CDATA[%s]]></FromUserName>
    <CreateTime>%s</CreateTime>
    <MsgType><![CDATA[text]]></MsgType>
    <Content><![CDATA[%s]]></Content>
    <FuncFlag>%s</FuncFlag>
</xml>
XML;
        return sprintf($template, $fromusername, $tousername, time(), $content, $funcFlag);
    }

    /**
     * 图片
     * @param $fromusername
     * @param $tousername
     * @param $mediaId 通过上传多媒体文件，得到的id。
     * @param int|\Weixin\Util\默认为0 $funcFlag 默认为0，设为1时星标刚才收到的消息
     * @return string
     */
    public function image($fromusername, $tousername, $mediaId, $funcFlag = 0)
    {
        $template = <<<XML
<xml>
    <ToUserName><![CDATA[%s]]></ToUserName>
    <FromUserName><![CDATA[%s]]></FromUserName>
    <CreateTime>%s</CreateTime>
    <MsgType><![CDATA[image]]></MsgType>
    <Image>
    <MediaId><![CDATA[%s]]></MediaId>
    </Image>
    <FuncFlag>%s</FuncFlag>
</xml>
XML;
        return sprintf($template, $fromusername, $tousername, time(), $mediaId, $funcFlag);
    }

    /**
     * 语音
     * @param $fromusername
     * @param $tousername
     * @param $mediaId 通过上传多媒体文件，得到的id
     * @param int|\Weixin\Util\默认为0 $funcFlag 默认为0，设为1时星标刚才收到的消息
     * @return string
     */
    public function voice($fromusername, $tousername, $mediaId, $funcFlag = 0)
    {
        $template = <<<XML
<xml>
    <ToUserName><![CDATA[%s]]></ToUserName>
    <FromUserName><![CDATA[%s]]></FromUserName>
    <CreateTime>%s</CreateTime>
    <MsgType><![CDATA[voice]]></MsgType>
    <Voice>
    <MediaId><![CDATA[%s]]></MediaId>
    </Voice>
    <FuncFlag>%s</FuncFlag>
</xml>
XML;
        return sprintf($template, $fromusername, $tousername, time(), $mediaId, $funcFlag);
    }

    /**
     * 视频
     * @param $fromusername
     * @param $tousername
     * @param $mediaId 通过上传多媒体文件，得到的id
     * @param $title 标题
     * @param $description 描述
     * @param int|\Weixin\Util\默认为0 $funcFlag 默认为0，设为1时星标刚才收到的消息
     * @return string
     */
    public function video($fromusername, $tousername, $mediaId, $title, $description, $funcFlag = 0)
    {
        $template = <<<XML
<xml>
    <ToUserName><![CDATA[%s]]></ToUserName>
    <FromUserName><![CDATA[%s]]></FromUserName>
    <CreateTime>%s</CreateTime>
    <MsgType><![CDATA[video]]></MsgType>
    <Video>
    <MediaId><![CDATA[%s]]></MediaId>
    <Title><![CDATA[%s]]></Title>
    <Description><![CDATA[%s]]></Description>
    </Video>
    <FuncFlag>%s</FuncFlag>
</xml>
XML;
        return sprintf($template, $fromusername, $tousername, time(), $mediaId, $title, $description, $funcFlag);
    }

    /**
     * 音乐
     * @param $fromusername
     * @param $tousername
     * @param $title 标题
     * @param $description 描述
     * @param $musicUrl 音乐链接
     * @param $hqMusicUrl 高质量音乐链接，WIFI环境优先使用该链接播放音乐
     * @param $thumbMediaId 缩略图的媒体id，通过上传多媒体文件，得到的id
     * @param int|\Weixin\Util\默认为0 $funcFlag 默认为0，设为1时星标刚才收到的消息
     * @return string
     */
    public function music($fromusername, $tousername, $title, $description, $musicUrl, $hqMusicUrl, $thumbMediaId, $funcFlag = 0)
    {
        $template = <<<XML
<xml>
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
    <FuncFlag>%s</FuncFlag>
</xml>
XML;
        return sprintf($template, $fromusername, $tousername, time(), $title, $description, $musicUrl, $hqMusicUrl, $thumbMediaId, $funcFlag);
    }

    /**
     * 图文消息 - 单个项目的准备工作，用于内嵌到self::news()中。现调用本方法，再调用self::news()
     *              多条图文消息信息，默认第一个item为大图,注意，如果调用本方法得到的数组总项数超过10，则将会无响应
     * @param $title 标题
     * @param $description 描述
     * @param $picUrl 图片链接，支持JPG、PNG格式，较好的效果为大图360*200，小图200*200
     * @param $url 点击图文消息跳转链接
     * @return string
     */
    public function newsItem($title, $description, $picUrl, $url)
    {
        $template = <<<XML
<item>
  <Title><![CDATA[%s]]></Title>
  <Description><![CDATA[%s]]></Description>
  <PicUrl><![CDATA[%s]]></PicUrl>
  <Url><![CDATA[%s]]></Url>
</item>
XML;
        return sprintf($template, $title, $description, $picUrl, $url);
    }

    /**
     * 图文 - 先调用self::newsItem()再调用本方法
     * @param $fromusername
     * @param $tousername
     * @param $item 数组，每个项由self::newsItem()返回
     * @param int|\Weixin\Util\默认为0 $funcFlag 默认为0，设为1时星标刚才收到的消息
     * @return string
     */
    public function news($fromusername, $tousername, $item, $funcFlag = 0)
    {
        //多条图文消息信息，默认第一个item为大图,注意，如果图文数超过10，则将会无响应
        if (count($item) >= 10) {
            $request = array('fromusername' => $fromusername, 'tousername' => $tousername);
            //return Msg::returnErrMsg(MsgConstant::ERROR_NEWS_ITEM_COUNT_MORE_TEN, '图文消息的项数不能超过10条', $request);
            Log::write("图文消息的项数不能超过10条");
        }
        $template = <<<XML
<xml>
    <ToUserName><![CDATA[%s]]></ToUserName>
    <FromUserName><![CDATA[%s]]></FromUserName>
    <CreateTime>%s</CreateTime>
    <MsgType><![CDATA[news]]></MsgType>
    <ArticleCount>%s</ArticleCount>
    <Articles>
    %s
    </Articles>
    <FuncFlag>%s</FuncFlag>
</xml>
XML;
        return sprintf($template, $fromusername, $tousername, time(), count($item), implode($item), $funcFlag);
    }


} 