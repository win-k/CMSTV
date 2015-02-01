set names utf8;
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

-- --------------------------------------------------------

--
-- テーブルの構造 `blocks`
--

DROP TABLE IF EXISTS `blocks`;
CREATE TABLE `blocks` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `page_id` bigint(20) unsigned NOT NULL,
  `package` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `sheet` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `order` smallint(4) unsigned NOT NULL DEFAULT '0',
  `data` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- テーブルのデータのダンプ `blocks`
--

INSERT INTO `blocks` (`id`, `page_id`, `package`, `sheet`, `order`, `data`, `created`, `modified`) VALUES
(71, 6, 'BlockHeading', 'main', 0, '{"h":"1","text":"\\u304a\\u554f\\u3044\\u5408\\u308f\\u305b"}', '2013-07-24 10:30:54', '2013-08-19 00:52:51'),
(124, 17, 'BlockPhotoGallery', 'visual', 1, '{"slider_theme":"default","slider_animation":"fold","slider_pause_time":"5","type":"slider","width":80,"photos":{"234":{"file_id":"234","file":{"id":"234","mime":"image\\/png","ext":"png","size":"384770","code":"FbO4qax5RasAx43C","path":"original\\/2013\\/08\\/FbO4qax5RasAx43C.png","created":"2013-08-22 08:25:35","modified":"2013-08-22 08:25:35","absolute_path":"\\/Library\\/WebServer\\/Documents\\/baked\\/app\\/webroot\\/files\\/original\\/2013\\/08\\/FbO4qax5RasAx43C.png"},"title":"","caption":null,"alt":""},"235":{"file_id":"235","file":{"id":"235","mime":"image\\/png","ext":"png","size":"562758","code":"G0SuHijV079H8oSb","path":"original\\/2013\\/08\\/G0SuHijV079H8oSb.png","created":"2013-08-22 08:25:36","modified":"2013-08-22 08:25:36","absolute_path":"\\/Library\\/WebServer\\/Documents\\/baked\\/app\\/webroot\\/files\\/original\\/2013\\/08\\/G0SuHijV079H8oSb.png"},"title":"","caption":null,"alt":""},"236":{"file_id":"236","file":{"id":"236","mime":"image\\/png","ext":"png","size":"483746","code":"KEC92GDg1Mi5ePfp","path":"original\\/2013\\/08\\/KEC92GDg1Mi5ePfp.png","created":"2013-08-22 08:25:36","modified":"2013-08-22 08:25:36","absolute_path":"\\/Library\\/WebServer\\/Documents\\/baked\\/app\\/webroot\\/files\\/original\\/2013\\/08\\/KEC92GDg1Mi5ePfp.png"},"title":"","caption":null,"alt":""}}}', '2013-08-03 05:45:21', '2013-09-01 11:01:21'),
(128, 17, 'BlockHeading', 'main', 1, '{"h":"1","text":"Welcome to Baked !!"}', '2013-08-03 06:08:56', '2013-09-06 05:19:20'),
(160, 6, 'BlockForm', 'main', 3, '{"sent_text":"The message has been sent.","lastId":8,"items":{"1":{"item_id":"1","name":"\\u304a\\u540d\\u524d","required":"1","type":"text"},"2":{"item_id":"2","name":"\\u30e1\\u30fc\\u30eb\\u30a2\\u30c9\\u30ec\\u30b9","required":"1","type":"email"},"8":{"name":"\\u90fd\\u9053\\u5e9c\\u770c","required":"1","type":"ja_states","item_id":8},"3":{"item_id":"3","name":"\\u304a\\u96fb\\u8a71\\u756a\\u53f7","required":"0","type":"tel"},"4":{"item_id":"4","name":"\\u304a\\u554f\\u3044\\u5408\\u308f\\u305b\\u5185\\u5bb9","required":"1","type":"textarea"}}}', '2013-08-03 23:03:23', '2013-08-19 00:52:51'),
(181, 39, 'BlockText', 'main', 1, '{"text":"<table border=\\"1\\" cellpadding=\\"1\\" cellspacing=\\"1\\" style=\\"width:100%\\">\\r\\n\\t<tbody>\\r\\n\\t\\t<tr>\\r\\n\\t\\t\\t<th scope=\\"row\\" style=\\"width:60px\\">\\u540d\\u524d<\\/th>\\r\\n\\t\\t\\t<td style=\\"width:100px\\">\\u30d1\\u30f3\\u5927\\u597d\\u304d<\\/td>\\r\\n\\t\\t<\\/tr>\\r\\n\\t\\t<tr>\\r\\n\\t\\t\\t<th scope=\\"row\\">\\u8077\\u696d<\\/th>\\r\\n\\t\\t\\t<td>\\u30d1\\u30f3\\u5c4b<\\/td>\\r\\n\\t\\t<\\/tr>\\r\\n\\t\\t<tr>\\r\\n\\t\\t\\t<th scope=\\"row\\">\\u51fa\\u8eab\\u5730<\\/th>\\r\\n\\t\\t\\t<td>\\u6771\\u4eac\\u90fd\\u56fd\\u5206\\u5bfa\\u5e02\\u5185\\u85e4\\u753a<\\/td>\\r\\n\\t\\t<\\/tr>\\r\\n\\t\\t<tr>\\r\\n\\t\\t\\t<th scope=\\"row\\">\\u751f\\u5e74\\u6708\\u65e5<\\/th>\\r\\n\\t\\t\\t<td>2013\\u5e745\\u670824\\u65e5<\\/td>\\r\\n\\t\\t<\\/tr>\\r\\n\\t\\t<tr>\\r\\n\\t\\t\\t<th scope=\\"row\\">\\u81ea\\u5df1\\u7d39\\u4ecb<\\/th>\\r\\n\\t\\t\\t<td>\\u3053\\u306e\\u30c6\\u30ad\\u30b9\\u30c8\\u306f\\u30b5\\u30f3\\u30d7\\u30eb\\u30c6\\u30ad\\u30b9\\u30c8\\u3067\\u3059\\u3002<br \\/>\\r\\n\\t\\t\\t\\u3053\\u308c\\u3089\\u306e\\u30c6\\u30ad\\u30b9\\u30c8\\u306f\\u7c21\\u5358\\u306b\\u7de8\\u96c6\\u3067\\u304d\\u307e\\u3059\\u3002<br \\/>\\r\\n\\t\\t\\t\\u307e\\u305f\\u3001\\uff0b\\u30a2\\u30a4\\u30b3\\u30f3\\u3092\\u30af\\u30ea\\u30c3\\u30af\\u3059\\u308c\\u3070\\u3001\\u65b0\\u3057\\u3044\\u30b3\\u30f3\\u30c6\\u30f3\\u30c4\\u3092\\u8ffd\\u52a0\\u3067\\u304d\\u307e\\u3059\\u3002<\\/td>\\r\\n\\t\\t<\\/tr>\\r\\n\\t<\\/tbody>\\r\\n<\\/table>\\r\\n"}', '2013-08-04 00:03:42', '2013-08-21 04:20:02'),
(183, 39, 'BlockHeading', 'main', 0, '{"h":"1","text":"\\u30d7\\u30ed\\u30d5\\u30a3\\u30fc\\u30eb"}', '2013-08-04 00:03:50', '2013-08-21 04:20:02'),
(203, 62, 'BlockForm', 'visual', 1, '{"sent_text":"The message has been sent.","lastId":4,"items":{"1":{"item_id":1,"name":"Name","type":"text","required":1},"2":{"item_id":2,"name":"Email","type":"email","required":1},"3":{"item_id":3,"name":"Tel","type":"tel","required":0},"4":{"item_id":4,"name":"Message","type":"textarea","required":1}}}', '2013-08-04 04:00:04', '2013-08-04 04:00:04'),
(220, 77, 'BlockHeading', 'main', 0, '{"h":"1","text":"\\u5199\\u771f\\u96c6"}', '2013-08-17 10:01:15', '2013-08-17 10:52:35'),
(221, 77, 'BlockHeading', 'main', 1, '{"h":"2","text":"\\u732b\\u306e\\u5199\\u771f"}', '2013-08-17 10:01:36', '2013-08-18 22:56:54'),
(222, 77, 'BlockPhotoGallery', 'main', 2, '{"slider_theme":"default","slider_animation":"random","slider_pause_time":"3","type":"lightbox","width":80,"photos":{"201":{"file_id":"201","file":{"id":"201","mime":"image\\/jpeg","ext":"jpg","size":"51592","code":"kzOGM0m2fBBwThNe","path":"original\\/2013\\/08\\/kzOGM0m2fBBwThNe.jpg","created":"2013-08-17 10:20:15","modified":"2013-08-17 10:20:15","absolute_path":"\\/Library\\/WebServer\\/Documents\\/baked\\/app\\/webroot\\/files\\/original\\/2013\\/08\\/kzOGM0m2fBBwThNe.jpg"},"title":"","caption":null,"alt":""},"198":{"file_id":"198","file":{"id":"198","mime":"image\\/jpeg","ext":"jpg","size":"52211","code":"08TcosTHrVpIkSq7","path":"original\\/2013\\/08\\/08TcosTHrVpIkSq7.jpg","created":"2013-08-17 10:20:14","modified":"2013-08-17 10:20:14","absolute_path":"\\/Library\\/WebServer\\/Documents\\/baked\\/app\\/webroot\\/files\\/original\\/2013\\/08\\/08TcosTHrVpIkSq7.jpg"},"title":"","caption":null,"alt":""},"197":{"file_id":"197","file":{"id":"197","mime":"image\\/jpeg","ext":"jpg","size":"76976","code":"_LXsGMDqHdY0kL8r","path":"original\\/2013\\/08\\/_LXsGMDqHdY0kL8r.jpg","created":"2013-08-17 10:20:13","modified":"2013-08-17 10:20:13","absolute_path":"\\/Library\\/WebServer\\/Documents\\/baked\\/app\\/webroot\\/files\\/original\\/2013\\/08\\/_LXsGMDqHdY0kL8r.jpg"},"title":"","caption":null,"alt":""},"199":{"file_id":"199","file":{"id":"199","mime":"image\\/jpeg","ext":"jpg","size":"63975","code":"RBTLFpy0djJ7ylvT","path":"original\\/2013\\/08\\/RBTLFpy0djJ7ylvT.jpg","created":"2013-08-17 10:20:14","modified":"2013-08-17 10:20:14","absolute_path":"\\/Library\\/WebServer\\/Documents\\/baked\\/app\\/webroot\\/files\\/original\\/2013\\/08\\/RBTLFpy0djJ7ylvT.jpg"},"title":"","caption":null,"alt":""},"205":{"file_id":"205","file":{"id":"205","mime":"image\\/jpeg","ext":"jpg","size":"24699","code":"AkvY8F4lGxSTd9_y","path":"original\\/2013\\/08\\/AkvY8F4lGxSTd9_y.jpg","created":"2013-08-17 10:21:31","modified":"2013-08-17 10:21:31","absolute_path":"\\/Library\\/WebServer\\/Documents\\/baked\\/app\\/webroot\\/files\\/original\\/2013\\/08\\/AkvY8F4lGxSTd9_y.jpg"},"title":"","caption":null,"alt":""},"200":{"file_id":"200","file":{"id":"200","mime":"image\\/jpeg","ext":"jpg","size":"45639","code":"dJZGjjmOBIUbcvpQ","path":"original\\/2013\\/08\\/dJZGjjmOBIUbcvpQ.jpg","created":"2013-08-17 10:20:14","modified":"2013-08-17 10:20:14","absolute_path":"\\/Library\\/WebServer\\/Documents\\/baked\\/app\\/webroot\\/files\\/original\\/2013\\/08\\/dJZGjjmOBIUbcvpQ.jpg"},"title":"","caption":null,"alt":""},"202":{"file_id":"202","file":{"id":"202","mime":"image\\/jpeg","ext":"jpg","size":"43327","code":"AVZjwVA18aAw3uQZ","path":"original\\/2013\\/08\\/AVZjwVA18aAw3uQZ.jpg","created":"2013-08-17 10:20:15","modified":"2013-08-17 10:20:15","absolute_path":"\\/Library\\/WebServer\\/Documents\\/baked\\/app\\/webroot\\/files\\/original\\/2013\\/08\\/AVZjwVA18aAw3uQZ.jpg"},"title":"","caption":null,"alt":""},"204":{"file_id":"204","file":{"id":"204","mime":"image\\/jpeg","ext":"jpg","size":"33680","code":"u9Hx0fLUrOXrQRgw","path":"original\\/2013\\/08\\/u9Hx0fLUrOXrQRgw.jpg","created":"2013-08-17 10:20:15","modified":"2013-08-17 10:20:15","absolute_path":"\\/Library\\/WebServer\\/Documents\\/baked\\/app\\/webroot\\/files\\/original\\/2013\\/08\\/u9Hx0fLUrOXrQRgw.jpg"},"title":"","caption":null,"alt":""},"210":{"file_id":"210","file":{"id":"210","mime":"image\\/jpeg","ext":"jpg","size":"29751","code":"Mbe6Yjo_7DSmZ9hC","path":"original\\/2013\\/08\\/Mbe6Yjo_7DSmZ9hC.jpg","created":"2013-08-17 10:25:49","modified":"2013-08-17 10:25:49","absolute_path":"\\/Library\\/WebServer\\/Documents\\/baked\\/app\\/webroot\\/files\\/original\\/2013\\/08\\/Mbe6Yjo_7DSmZ9hC.jpg"},"title":null,"caption":null,"alt":null},"206":{"file_id":"206","file":{"id":"206","mime":"image\\/jpeg","ext":"jpg","size":"44541","code":"tl1pDjUn4VcoMjCo","path":"original\\/2013\\/08\\/tl1pDjUn4VcoMjCo.jpg","created":"2013-08-17 10:23:40","modified":"2013-08-17 10:23:40","absolute_path":"\\/Library\\/WebServer\\/Documents\\/baked\\/app\\/webroot\\/files\\/original\\/2013\\/08\\/tl1pDjUn4VcoMjCo.jpg"},"title":"","caption":null,"alt":""},"207":{"file_id":"207","file":{"id":"207","mime":"image\\/jpeg","ext":"jpg","size":"44892","code":"hAvYFNYX2FX77SvA","path":"original\\/2013\\/08\\/hAvYFNYX2FX77SvA.jpg","created":"2013-08-17 10:23:41","modified":"2013-08-17 10:23:41","absolute_path":"\\/Library\\/WebServer\\/Documents\\/baked\\/app\\/webroot\\/files\\/original\\/2013\\/08\\/hAvYFNYX2FX77SvA.jpg"},"title":"","caption":null,"alt":""},"209":{"file_id":"209","file":{"id":"209","mime":"image\\/jpeg","ext":"jpg","size":"55755","code":"e8JvTUKMQPs6yUeU","path":"original\\/2013\\/08\\/e8JvTUKMQPs6yUeU.jpg","created":"2013-08-17 10:25:10","modified":"2013-08-17 10:25:10","absolute_path":"\\/Library\\/WebServer\\/Documents\\/baked\\/app\\/webroot\\/files\\/original\\/2013\\/08\\/e8JvTUKMQPs6yUeU.jpg"},"title":"","caption":null,"alt":""}}}', '2013-08-17 10:20:05', '2013-08-17 13:23:28'),
(223, 77, 'BlockHeading', 'main', 4, '{"h":"2","text":"\\u30d1\\u30f3\\u306e\\u5199\\u771f"}', '2013-08-17 10:26:03', '2013-08-17 10:52:35'),
(224, 77, 'BlockPhotoGallery', 'main', 5, '{"type":"lightbox","width":80,"photos":{"219":{"file_id":"219","file":{"id":"219","mime":"image\\/jpeg","ext":"jpg","size":"109064","code":"ijtM3ICpnVJ8hXDd","path":"original\\/2013\\/08\\/ijtM3ICpnVJ8hXDd.jpg","created":"2013-08-17 10:50:26","modified":"2013-08-17 10:50:26","absolute_path":"\\/Library\\/WebServer\\/Documents\\/baked\\/app\\/webroot\\/files\\/original\\/2013\\/08\\/ijtM3ICpnVJ8hXDd.jpg"},"title":null,"caption":null,"alt":null},"220":{"file_id":"220","file":{"id":"220","mime":"image\\/jpeg","ext":"jpg","size":"81140","code":"cARXD7dTJkjWOmY4","path":"original\\/2013\\/08\\/cARXD7dTJkjWOmY4.jpg","created":"2013-08-17 10:50:27","modified":"2013-08-17 10:50:27","absolute_path":"\\/Library\\/WebServer\\/Documents\\/baked\\/app\\/webroot\\/files\\/original\\/2013\\/08\\/cARXD7dTJkjWOmY4.jpg"},"title":null,"caption":null,"alt":null},"221":{"file_id":"221","file":{"id":"221","mime":"image\\/jpeg","ext":"jpg","size":"54477","code":"0EXZDSf6nMbSzh0o","path":"original\\/2013\\/08\\/0EXZDSf6nMbSzh0o.jpg","created":"2013-08-17 10:50:27","modified":"2013-08-17 10:50:27","absolute_path":"\\/Library\\/WebServer\\/Documents\\/baked\\/app\\/webroot\\/files\\/original\\/2013\\/08\\/0EXZDSf6nMbSzh0o.jpg"},"title":null,"caption":null,"alt":null},"222":{"file_id":"222","file":{"id":"222","mime":"image\\/jpeg","ext":"jpg","size":"96552","code":"V_rw6c9JSP4iud1z","path":"original\\/2013\\/08\\/V_rw6c9JSP4iud1z.jpg","created":"2013-08-17 10:50:27","modified":"2013-08-17 10:50:27","absolute_path":"\\/Library\\/WebServer\\/Documents\\/baked\\/app\\/webroot\\/files\\/original\\/2013\\/08\\/V_rw6c9JSP4iud1z.jpg"},"title":null,"caption":null,"alt":null},"223":{"file_id":"223","file":{"id":"223","mime":"image\\/jpeg","ext":"jpg","size":"45236","code":"gvv3igYUFqlzktbZ","path":"original\\/2013\\/08\\/gvv3igYUFqlzktbZ.jpg","created":"2013-08-17 10:50:27","modified":"2013-08-17 10:50:27","absolute_path":"\\/Library\\/WebServer\\/Documents\\/baked\\/app\\/webroot\\/files\\/original\\/2013\\/08\\/gvv3igYUFqlzktbZ.jpg"},"title":null,"caption":null,"alt":null},"224":{"file_id":"224","file":{"id":"224","mime":"image\\/jpeg","ext":"jpg","size":"106493","code":"yLAVFHF4EuPPs71T","path":"original\\/2013\\/08\\/yLAVFHF4EuPPs71T.jpg","created":"2013-08-17 10:50:28","modified":"2013-08-17 10:50:28","absolute_path":"\\/Library\\/WebServer\\/Documents\\/baked\\/app\\/webroot\\/files\\/original\\/2013\\/08\\/yLAVFHF4EuPPs71T.jpg"},"title":null,"caption":null,"alt":null},"225":{"file_id":"225","file":{"id":"225","mime":"image\\/jpeg","ext":"jpg","size":"56397","code":"5uTjhDpAqzxxxkZQ","path":"original\\/2013\\/08\\/5uTjhDpAqzxxxkZQ.jpg","created":"2013-08-17 10:50:28","modified":"2013-08-17 10:50:28","absolute_path":"\\/Library\\/WebServer\\/Documents\\/baked\\/app\\/webroot\\/files\\/original\\/2013\\/08\\/5uTjhDpAqzxxxkZQ.jpg"},"title":null,"caption":null,"alt":null},"226":{"file_id":"226","file":{"id":"226","mime":"image\\/jpeg","ext":"jpg","size":"46651","code":"ePMWZuEXAKTolkLv","path":"original\\/2013\\/08\\/ePMWZuEXAKTolkLv.jpg","created":"2013-08-17 10:50:28","modified":"2013-08-17 10:50:28","absolute_path":"\\/Library\\/WebServer\\/Documents\\/baked\\/app\\/webroot\\/files\\/original\\/2013\\/08\\/ePMWZuEXAKTolkLv.jpg"},"title":null,"caption":null,"alt":null},"227":{"file_id":"227","file":{"id":"227","mime":"image\\/jpeg","ext":"jpg","size":"145122","code":"X0zezQfPFb4cvKnb","path":"original\\/2013\\/08\\/X0zezQfPFb4cvKnb.jpg","created":"2013-08-17 10:50:28","modified":"2013-08-17 10:50:28","absolute_path":"\\/Library\\/WebServer\\/Documents\\/baked\\/app\\/webroot\\/files\\/original\\/2013\\/08\\/X0zezQfPFb4cvKnb.jpg"},"title":null,"caption":null,"alt":null},"228":{"file_id":"228","file":{"id":"228","mime":"image\\/jpeg","ext":"jpg","size":"77800","code":"niEIhpKtUWs_uTvT","path":"original\\/2013\\/08\\/niEIhpKtUWs_uTvT.jpg","created":"2013-08-17 10:50:29","modified":"2013-08-17 10:50:29","absolute_path":"\\/Library\\/WebServer\\/Documents\\/baked\\/app\\/webroot\\/files\\/original\\/2013\\/08\\/niEIhpKtUWs_uTvT.jpg"},"title":null,"caption":null,"alt":null},"229":{"file_id":"229","file":{"id":"229","mime":"image\\/jpeg","ext":"jpg","size":"94906","code":"YGHcLame4Tg0PaQX","path":"original\\/2013\\/08\\/YGHcLame4Tg0PaQX.jpg","created":"2013-08-17 10:50:29","modified":"2013-08-17 10:50:29","absolute_path":"\\/Library\\/WebServer\\/Documents\\/baked\\/app\\/webroot\\/files\\/original\\/2013\\/08\\/YGHcLame4Tg0PaQX.jpg"},"title":null,"caption":null,"alt":null},"230":{"file_id":"230","file":{"id":"230","mime":"image\\/jpeg","ext":"jpg","size":"117127","code":"pZO2GqFvtteC8rfn","path":"original\\/2013\\/08\\/pZO2GqFvtteC8rfn.jpg","created":"2013-08-17 10:50:29","modified":"2013-08-17 10:50:29","absolute_path":"\\/Library\\/WebServer\\/Documents\\/baked\\/app\\/webroot\\/files\\/original\\/2013\\/08\\/pZO2GqFvtteC8rfn.jpg"},"title":null,"caption":null,"alt":null}},"slider_pause_time":3,"slider_animation":"random","slider_theme":"default"}', '2013-08-17 10:48:10', '2013-08-17 10:52:35'),
(226, 77, 'BlockSpace', 'main', 3, '{"size":20}', '2013-08-17 10:51:12', '2013-08-17 10:52:35'),
(227, 67, 'BlockCode', 'main', 1, '{"code":"<iframe width=\\"100%\\" height=\\"315\\" src=\\"\\/\\/www.youtube.com\\/embed\\/9QnFFpyDGgs\\" frameborder=\\"0\\" allowfullscreen><\\/iframe>"}', '2013-08-17 11:07:04', '2013-08-31 02:57:34'),
(229, 67, 'BlockHeading', 'main', 0, '{"h":"1","text":"\\u52d5\\u753b"}', '2013-08-17 13:16:32', '2013-08-31 02:57:34'),
(230, 67, 'BlockHeading', 'sub', 0, '{"h":"2","text":"\\u30d2\\u30f3\\u30c8"}', '2013-08-17 13:16:57', '2013-08-31 02:57:34'),
(231, 67, 'BlockText', 'sub', 1, '{"text":"Google Map \\u3084\\u30d6\\u30ed\\u30b0\\u30d1\\u30fc\\u30c4\\u306e\\u30bf\\u30b0\\u306a\\u3069\\u3092\\u3001\\u30b5\\u30a4\\u30c8\\u306e\\u597d\\u304d\\u306a\\u90e8\\u5206\\u306b\\u8cbc\\u4ed8\\u3051\\u308b\\u3053\\u3068\\u304c\\u3067\\u304d\\u307e\\u3059\\u3002<br \\/>\\r\\n\\u30bf\\u30b0\\u3092\\u8cbc\\u4ed8\\u3051\\u308b\\u306b\\u306f\\u3001\\u300c\\u30b3\\u30fc\\u30c9\\u300d\\u30d6\\u30ed\\u30c3\\u30af\\u3092\\u4f7f\\u7528\\u3057\\u3066\\u304f\\u3060\\u3055\\u3044\\u3002"}', '2013-08-17 13:17:10', '2013-09-07 05:51:30'),
(232, 6, 'BlockHeading', 'main', 1, '{"h":"2","text":"\\u30e1\\u30fc\\u30eb\\u30d5\\u30a9\\u30fc\\u30e0"}', '2013-08-17 13:18:37', '2013-08-19 00:52:51'),
(234, 6, 'BlockText', 'main', 2, '{"text":"\\u304a\\u6c17\\u8efd\\u306b\\u304a\\u554f\\u3044\\u5408\\u308f\\u305b\\u304f\\u3060\\u3055\\u3044\\u3002<br \\/>\\r\\n<span style=\\"color:rgb(255, 0, 0)\\">*<\\/span> \\u30de\\u30fc\\u30af\\u304c\\u4ed8\\u3044\\u3066\\u3044\\u308b\\u9805\\u76ee\\u306f\\u5165\\u529b\\u5fc5\\u9808\\u3068\\u306a\\u3063\\u3066\\u3044\\u307e\\u3059\\u3002"}', '2013-08-17 13:18:55', '2013-08-19 00:52:51'),
(237, 39, 'BlockSpace', 'main', 2, '{"size":20}', '2013-08-17 13:26:14', '2013-08-21 04:20:02'),
(238, 39, 'BlockCode', 'main', 3, '{"code":"<iframe width=\\"100%\\" height=\\"350\\" frameborder=\\"0\\" scrolling=\\"no\\" marginheight=\\"0\\" marginwidth=\\"0\\" src=\\"https:\\/\\/maps.google.co.jp\\/maps?f=q&amp;source=s_q&amp;hl=ja&amp;geocode=&amp;q=%E5%86%85%E8%97%A4&amp;aq=&amp;sll=34.728949,138.455511&amp;sspn=41.299709,79.013672&amp;t=h&amp;brcurrent=3,0x60188cc1ec9a1fe7:0x4e4cc182e5c0302f,0&amp;ttype=now&amp;noexp=0&amp;noal=0&amp;sort=def&amp;ie=UTF8&amp;hq=&amp;hnear=%E6%9D%B1%E4%BA%AC%E9%83%BD%E6%96%B0%E5%AE%BF%E5%8C%BA%E5%86%85%E8%97%A4%E7%94%BA&amp;z=14&amp;ll=35.685003,139.715254&amp;output=embed\\"><\\/iframe>"}', '2013-08-17 13:26:19', '2013-09-07 06:05:01'),
(239, 39, 'BlockTextPhoto', 'sub', 1, '{"text":"\\u3053\\u308c\\u306f\\u30b5\\u30f3\\u30d7\\u30eb\\u30c6\\u30ad\\u30b9\\u30c8\\u3067\\u3059\\u3002<br \\/>\\r\\nBaked \\u3067\\u306f\\u3001\\u300c\\u30d6\\u30ed\\u30c3\\u30af\\u300d\\u3068\\u3044\\u3046\\u30b3\\u30f3\\u30c6\\u30f3\\u30c4\\u3092\\u7a4d\\u307f\\u91cd\\u306d\\u3066\\u30b5\\u30a4\\u30c8\\u3092\\u4f5c\\u3063\\u3066\\u3044\\u304d\\u307e\\u3059\\u3002<br \\/>\\r\\n\\u30d6\\u30ed\\u30c3\\u30af\\u306f\\u3001\\u666e\\u901a\\u306e\\u30c6\\u30ad\\u30b9\\u30c8\\u3084\\u753b\\u50cf\\u3001\\u30d5\\u30a9\\u30c8\\u30ae\\u30e3\\u30e9\\u30ea\\u30fc\\u3001\\u554f\\u3044\\u5408\\u308f\\u305b\\u30d5\\u30a9\\u30fc\\u30e0\\u7b49\\u3005\\u306e\\u7a2e\\u985e\\u304c\\u3042\\u308a\\u307e\\u3059\\u3002","size":90,"align":2,"photo":{"id":"231","mime":"image\\/jpeg","ext":"jpg","size":"24971","code":"gbYjiXDGlfqdpdA_","path":"original\\/2013\\/08\\/gbYjiXDGlfqdpdA_.jpg","created":"2013-08-17 13:36:21","modified":"2013-08-17 13:36:21","absolute_path":"\\/Library\\/WebServer\\/Documents\\/baked\\/app\\/webroot\\/files\\/original\\/2013\\/08\\/gbYjiXDGlfqdpdA_.jpg"}}', '2013-08-17 13:30:42', '2013-08-21 04:20:02'),
(240, 39, 'BlockHeading', 'sub', 0, '{"h":"2","text":"\\u3054\\u6328\\u62f6"}', '2013-08-17 13:31:01', '2013-08-21 04:20:02'),
(241, 17, 'BlockHeading', 'main', 3, '{"h":"2","text":"\\u7de8\\u96c6\\u30e2\\u30fc\\u30c9\\u306e\\u5165\\u308a\\u65b9"}', '2013-08-17 13:39:25', '2013-09-06 05:19:20'),
(242, 17, 'BlockSpace', 'main', 5, '{"size":20}', '2013-08-17 13:40:08', '2013-09-06 05:19:20'),
(243, 17, 'BlockHeading', 'main', 6, '{"h":"2","text":"Baked \\u306e\\u7279\\u5fb4"}', '2013-08-17 13:40:11', '2013-09-06 05:19:20'),
(245, 17, 'BlockHeading', 'sub', 0, '{"h":"2","text":"Baked \\u3068\\u306f\\uff1f"}', '2013-08-17 13:53:31', '2013-09-06 05:10:40'),
(246, 17, 'BlockText', 'sub', 1, '{"text":"Baked\\uff08\\u30d9\\u30a4\\u30af\\u30c9\\uff09 \\u306f\\u3001\\u300c\\u76f4\\u611f\\u7684\\u64cd\\u4f5c\\u300d\\u3092\\u30b3\\u30f3\\u30bb\\u30d7\\u30c8\\u306b\\u958b\\u767a\\u304c\\u9032\\u3081\\u3089\\u308c\\u3066\\u3044\\u308b\\u3001\\u30aa\\u30fc\\u30d7\\u30f3\\u30bd\\u30fc\\u30b9\\u306eCMS\\u3067\\u3059\\u3002<br \\/>\\r\\nBaked \\u306e\\u30c7\\u30b6\\u30a4\\u30f3\\u30c6\\u30f3\\u30d7\\u30ec\\u30fc\\u30c8\\u306f&nbsp;<strong>\\u30c6\\u30fc\\u30de&nbsp;<\\/strong>\\u3068\\u547c\\u3070\\u308c\\u3001\\u5358\\u7d14\\u306aPHP,HTML,CSS\\u306a\\u3069\\u3067\\u69cb\\u6210\\u3055\\u308c\\u3066\\u3044\\u307e\\u3059\\u3002\\u5c11\\u306a\\u3044\\u5b66\\u7fd2\\u30b3\\u30b9\\u30c8\\u3067\\u81ea\\u7531\\u306b\\u30c6\\u30fc\\u30de\\u3092\\u4f5c\\u308b\\u4e8b\\u304c\\u53ef\\u80fd\\u3067\\u3059\\u3002"}', '2013-08-17 13:53:44', '2013-09-06 05:10:40'),
(247, 17, 'BlockTextPhoto', 'main', 7, '{"size":180,"text":"<ol>\\r\\n\\t<li><strong>\\u76f4\\u611f\\u7684\\u64cd\\u4f5c<\\/strong>&nbsp;-&nbsp;\\u7de8\\u96c6\\u3057\\u305f\\u3044\\u90e8\\u5206\\u3092\\u30af\\u30ea\\u30c3\\u30af\\u3059\\u308b\\u3068\\u3001\\u3059\\u3050\\u306b\\u7de8\\u96c6\\u3092\\u958b\\u59cb\\u3059\\u308b\\u3053\\u3068\\u3067\\u304d\\u307e\\u3059\\u3002<\\/li>\\r\\n\\t<li><strong>\\u30b3\\u30f3\\u30c6\\u30f3\\u30c4\\u3092\\u30b9\\u30e0\\u30fc\\u30ba\\u306b\\u4e26\\u3073\\u66ff\\u3048<\\/strong>&nbsp;- \\u30c9\\u30e9\\u30c3\\u30b0&amp;\\u30c9\\u30ed\\u30c3\\u30d7\\u3067\\u30da\\u30fc\\u30b8\\u5185\\u306e\\u30b3\\u30f3\\u30c6\\u30f3\\u30c4\\u3092\\u81ea\\u7531\\u306b\\u4e26\\u3073\\u66ff\\u3048\\u3067\\u304d\\u307e\\u3059\\u3002<\\/li>\\r\\n\\t<li><strong>\\u91cd\\u8981\\u306a\\u6a5f\\u80fd\\u3092\\u6a19\\u6e96\\u88c5\\u5099<\\/strong>&nbsp;- \\u30e1\\u30fc\\u30eb\\u30d5\\u30a9\\u30fc\\u30e0\\u3084\\u30b9\\u30e9\\u30a4\\u30c9\\u30b7\\u30e7\\u30fc\\u306a\\u3069\\u3001\\u5fc5\\u8981\\u306a\\u6a5f\\u80fd\\u304c\\u4e88\\u3081\\u642d\\u8f09\\u3055\\u308c\\u3066\\u3044\\u307e\\u3059\\u3002<\\/li>\\r\\n\\t<li><strong>\\u30b9\\u30de\\u30fc\\u30c8\\u30d5\\u30a9\\u30f3\\u306b\\u5bfe\\u5fdc<\\/strong>&nbsp;- \\u6700\\u521d\\u304b\\u3089\\u30b9\\u30de\\u30fc\\u30c8\\u30d5\\u30a9\\u30f3\\u7528\\u306e\\u30c7\\u30b6\\u30a4\\u30f3\\u304c\\u5099\\u308f\\u3063\\u3066\\u304a\\u308a\\u3001\\u95b2\\u89a7\\u7aef\\u672b\\u306b\\u3088\\u3063\\u3066\\u81ea\\u52d5\\u7684\\u306b\\u8868\\u793a\\u3092\\u5207\\u308a\\u66ff\\u3048\\u307e\\u3059\\u3002<\\/li>\\r\\n\\t<li><strong>\\u30c6\\u30fc\\u30de\\u3092\\u81ea\\u7531\\u306b\\u4f5c\\u6210\\u3067\\u304d\\u308b<\\/strong>&nbsp;- Baked\\u306e\\u30c6\\u30fc\\u30de\\uff08\\u30c6\\u30f3\\u30d7\\u30ec\\u30fc\\u30c8\\uff09\\u306f\\u30b7\\u30f3\\u30d7\\u30eb\\u306ePHP\\u30d5\\u30a1\\u30a4\\u30eb\\u3067\\u3059\\u3002\\u5c11\\u3057\\u306e\\u5b66\\u7fd2\\u30b3\\u30b9\\u30c8\\u3067\\u30c6\\u30fc\\u30de\\u3092\\u4f5c\\u6210\\u3059\\u308b\\u3053\\u3068\\u304c\\u3067\\u304d\\u307e\\u3059\\u3002<\\/li>\\r\\n<\\/ol>\\r\\n","align":2,"photo":{"id":"232","mime":"image\\/jpeg","ext":"jpg","size":"55020","code":"hSQ_qm5VftLRwSaj","path":"original\\/2013\\/08\\/hSQ_qm5VftLRwSaj.jpg","created":"2013-08-17 14:05:56","modified":"2013-08-17 14:05:56","absolute_path":"\\/Library\\/WebServer\\/Documents\\/baked\\/app\\/webroot\\/files\\/original\\/2013\\/08\\/hSQ_qm5VftLRwSaj.jpg"}}', '2013-08-17 14:05:48', '2013-09-06 05:19:20'),
(248, 17, 'BlockTextPhoto', 'main', 4, '{"text":"<a href=\\"http:\\/\\/bakedcms.org\\/\\">Baked<\\/a>&nbsp;\\u3092\\u30a4\\u30f3\\u30b9\\u30c8\\u30fc\\u30eb\\u3057\\u3066\\u3044\\u305f\\u3060\\u304d\\u3042\\u308a\\u304c\\u3068\\u3046\\u3054\\u3056\\u3044\\u307e\\u3059\\uff01<br \\/>\\r\\n<br \\/>\\r\\n<strong>ESC\\u30ad\\u30fc\\u30923\\u56de<\\/strong><span style=\\"color:rgb(255, 0, 0)\\"><strong>&nbsp;<\\/strong><\\/span>\\u62bc\\u3059\\u3068<span style=\\"color:rgb(102, 102, 102)\\">\\uff08\\u30ad\\u30fc\\u30dc\\u30fc\\u30c9\\u306e\\u5de6\\u4e0a\\uff09<\\/span>\\u3001\\u30ed\\u30b0\\u30a4\\u30f3\\u753b\\u9762\\u304c\\u30dd\\u30c3\\u30d7\\u30a2\\u30c3\\u30d7\\u3055\\u308c\\u3001\\u7de8\\u96c6\\u30e2\\u30fc\\u30c9\\u306b\\u5165\\u308b\\u3053\\u3068\\u304c\\u3067\\u304d\\u307e\\u3059\\u3002","align":"1","size":150,"photo":{"id":"233","mime":"image\\/jpeg","ext":"jpg","size":"11919","code":"3TLOO_aiTtSeL6Su","path":"original\\/2013\\/08\\/3TLOO_aiTtSeL6Su.jpg","created":"2013-08-17 14:14:27","modified":"2013-08-17 14:14:27","absolute_path":"\\/Library\\/WebServer\\/Documents\\/baked\\/app\\/webroot\\/files\\/original\\/2013\\/08\\/3TLOO_aiTtSeL6Su.jpg"}}', '2013-08-17 14:14:15', '2013-09-06 05:19:20'),
(249, 17, 'BlockSpace', 'sub', 2, '{"size":"10"}', '2013-08-17 14:16:22', '2013-09-06 05:10:40'),
(250, 17, 'BlockHeading', 'sub', 3, '{"h":"2","text":"\\u30d6\\u30ed\\u30c3\\u30af\\u3068\\u306f\\uff1f"}', '2013-08-17 14:16:24', '2013-09-06 05:10:40'),
(255, 80, 'BlockHeading', 'main', 1, '{"h":"1","text":"\\u30d6\\u30ed\\u30b0"}', '2013-08-25 17:22:43', '2013-08-25 17:22:46'),
(256, 80, 'BlockHeading', 'blog-header', 0, '{"h":"1","text":"\\u304a\\u77e5\\u3089\\u305b"}', '2013-08-25 17:24:15', '2013-09-01 14:31:21'),
(258, 80, 'BlockTextPhoto', 'sub', 0, '{"text":"\\u4e07\\u4e00\\u30d6\\u30ed\\u30b0\\u5185\\u5bb9\\u306b\\u4e0d\\u5099\\u304c\\u3042\\u308a\\u307e\\u3057\\u305f\\u3089\\u3054\\u9023\\u7d61\\u304f\\u3060\\u3055\\u3044\\u3002","align":2,"size":200,"photo":null}', '2013-08-25 17:24:33', '2013-09-07 05:51:13'),
(271, 17, 'BlockTextPhoto', 'sub', 4, '{"text":"<strong>\\u30d6\\u30ed\\u30c3\\u30af&nbsp;<\\/strong>\\u306f \\uff11\\u56fa\\u307e\\u308a\\u306e\\u30b3\\u30f3\\u30c6\\u30f3\\u30c4\\u3067\\u3059\\u3002\\u4f8b\\u3048\\u3070\\u3001\\u666e\\u901a\\u306e\\u30c6\\u30ad\\u30b9\\u30c8\\u3001\\u753b\\u50cf\\u3001\\u30e9\\u30a4\\u30f3\\u3001\\u30e1\\u30fc\\u30eb\\u30d5\\u30a9\\u30fc\\u30e0\\u3001\\u30b9\\u30e9\\u30a4\\u30c9\\u30b7\\u30e7\\u30fc\\u306a\\u3069\\u3001\\u305d\\u308c\\u305e\\u308c\\u306e\\u30b3\\u30f3\\u30c6\\u30f3\\u30c4\\u3092\\u30d6\\u30ed\\u30c3\\u30af\\u3068\\u547c\\u3073\\u307e\\u3059\\u3002<br \\/>\\r\\n\\uff11\\u30da\\u30fc\\u30b8\\u306b\\u8907\\u6570\\u306e\\u30d6\\u30ed\\u30c3\\u30af\\u3092\\u7a4d\\u307f\\u91cd\\u306d\\u3066\\u3001\\u30b5\\u30a4\\u30c8\\u3092\\u69cb\\u7bc9\\u3057\\u3066\\u3044\\u304d\\u307e\\u3059\\u3002","align":2,"size":200,"photo":null}', '2013-08-31 03:00:53', '2013-09-06 05:10:40'),
(275, 77, 'BlockText', 'sub', 1, '{"text":"<iframe allowfullscreen=\\"\\" frameborder=\\"0\\" height=\\"160\\" scrolling=\\"no\\" src=\\"\\/\\/www.youtube.com\\/embed\\/LF-pBTuL2mI\\" width=\\"320\\"><\\/iframe>"}', '2013-09-01 14:30:28', '2013-09-01 10:56:02');

-- --------------------------------------------------------

--
-- テーブルの構造 `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE `comments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `entry_id` bigint(20) unsigned NOT NULL,
  `approved` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `body` text COLLATE utf8_unicode_ci NOT NULL,
  `ip` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `host` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `entry_id` (`entry_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- テーブルのデータのダンプ `comments`
--

INSERT INTO `comments` (`id`, `entry_id`, `approved`, `name`, `body`, `ip`, `host`, `created`, `modified`) VALUES
(1, 1, 1, 'Guest', 'コメントの投稿も可能です。\nブログごとに、以下のようにコメントの扱いを設定できます。\n・許可\n・管理者による承認制\n・不可\n\nコメントの承認・管理は管理画面から行えます。', '::1', 'localhost', '2013-09-01 12:00:00', '2013-09-01 14:49:04');

-- --------------------------------------------------------

--
-- テーブルの構造 `entries`
--

DROP TABLE IF EXISTS `entries`;
CREATE TABLE `entries` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `page_id` bigint(20) unsigned NOT NULL,
  `staff_id` bigint(20) NOT NULL,
  `title` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `body1` text COLLATE utf8_unicode_ci NOT NULL,
  `body2` text COLLATE utf8_unicode_ci NOT NULL,
  `published` datetime NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `page_id` (`page_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- テーブルのデータのダンプ `entries`
--

INSERT INTO `entries` (`id`, `page_id`, `staff_id`, `title`, `body1`, `body2`, `published`, `created`, `modified`) VALUES
(1, 80, 1, '記事を投稿しよう', 'Baked にはブログ機能が付いています。<br />\r\n編集モードでブログページ（例えばこのページ）を開くと、上部のメニューに「新規投稿」ボタンが表示されます。', '<span style="line-height: 1.6em;"><img alt="" src="<:url>files/upload/images/blog-social-media-strategy.jpeg" style="width: 280px; float: right; margin-left: 10px; margin-right: 10px; height: 186px;" />このように続きとして記事を書く事も可能です。</span>もちろん画像のアップロードも。', '2013-09-01 10:00:00', '2013-09-01 14:44:49', '2013-09-01 14:44:49');

-- --------------------------------------------------------

--
-- テーブルの構造 `files`
--

DROP TABLE IF EXISTS `files`;
CREATE TABLE `files` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'プライマリーキー',
  `mime` varchar(30) NOT NULL COMMENT 'Mime-Type ',
  `ext` varchar(10) NOT NULL COMMENT '拡張子 ',
  `size` int(11) NOT NULL DEFAULT '0' COMMENT 'ファイルサイズ ',
  `code` char(16) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT 'アクセスコード ',
  `path` varchar(100) NOT NULL COMMENT 'Path to file',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `files`
--

INSERT INTO `files` (`id`, `mime`, `ext`, `size`, `code`, `path`, `created`, `modified`) VALUES
(197, 'image/jpeg', 'jpg', 76976, '_LXsGMDqHdY0kL8r', 'original/2013/08/_LXsGMDqHdY0kL8r.jpg', '2013-08-17 10:20:13', '2013-08-17 10:20:13'),
(198, 'image/jpeg', 'jpg', 52211, '08TcosTHrVpIkSq7', 'original/2013/08/08TcosTHrVpIkSq7.jpg', '2013-08-17 10:20:14', '2013-08-17 10:20:14'),
(199, 'image/jpeg', 'jpg', 63975, 'RBTLFpy0djJ7ylvT', 'original/2013/08/RBTLFpy0djJ7ylvT.jpg', '2013-08-17 10:20:14', '2013-08-17 10:20:14'),
(200, 'image/jpeg', 'jpg', 45639, 'dJZGjjmOBIUbcvpQ', 'original/2013/08/dJZGjjmOBIUbcvpQ.jpg', '2013-08-17 10:20:14', '2013-08-17 10:20:14'),
(201, 'image/jpeg', 'jpg', 51592, 'kzOGM0m2fBBwThNe', 'original/2013/08/kzOGM0m2fBBwThNe.jpg', '2013-08-17 10:20:15', '2013-08-17 10:20:15'),
(202, 'image/jpeg', 'jpg', 43327, 'AVZjwVA18aAw3uQZ', 'original/2013/08/AVZjwVA18aAw3uQZ.jpg', '2013-08-17 10:20:15', '2013-08-17 10:20:15'),
(204, 'image/jpeg', 'jpg', 33680, 'u9Hx0fLUrOXrQRgw', 'original/2013/08/u9Hx0fLUrOXrQRgw.jpg', '2013-08-17 10:20:15', '2013-08-17 10:20:15'),
(205, 'image/jpeg', 'jpg', 24699, 'AkvY8F4lGxSTd9_y', 'original/2013/08/AkvY8F4lGxSTd9_y.jpg', '2013-08-17 10:21:31', '2013-08-17 10:21:31'),
(206, 'image/jpeg', 'jpg', 44541, 'tl1pDjUn4VcoMjCo', 'original/2013/08/tl1pDjUn4VcoMjCo.jpg', '2013-08-17 10:23:40', '2013-08-17 10:23:40'),
(207, 'image/jpeg', 'jpg', 44892, 'hAvYFNYX2FX77SvA', 'original/2013/08/hAvYFNYX2FX77SvA.jpg', '2013-08-17 10:23:41', '2013-08-17 10:23:41'),
(209, 'image/jpeg', 'jpg', 55755, 'e8JvTUKMQPs6yUeU', 'original/2013/08/e8JvTUKMQPs6yUeU.jpg', '2013-08-17 10:25:10', '2013-08-17 10:25:10'),
(210, 'image/jpeg', 'jpg', 29751, 'Mbe6Yjo_7DSmZ9hC', 'original/2013/08/Mbe6Yjo_7DSmZ9hC.jpg', '2013-08-17 10:25:49', '2013-08-17 10:25:49'),
(219, 'image/jpeg', 'jpg', 109064, 'ijtM3ICpnVJ8hXDd', 'original/2013/08/ijtM3ICpnVJ8hXDd.jpg', '2013-08-17 10:50:26', '2013-08-17 10:50:26'),
(220, 'image/jpeg', 'jpg', 81140, 'cARXD7dTJkjWOmY4', 'original/2013/08/cARXD7dTJkjWOmY4.jpg', '2013-08-17 10:50:27', '2013-08-17 10:50:27'),
(221, 'image/jpeg', 'jpg', 54477, '0EXZDSf6nMbSzh0o', 'original/2013/08/0EXZDSf6nMbSzh0o.jpg', '2013-08-17 10:50:27', '2013-08-17 10:50:27'),
(222, 'image/jpeg', 'jpg', 96552, 'V_rw6c9JSP4iud1z', 'original/2013/08/V_rw6c9JSP4iud1z.jpg', '2013-08-17 10:50:27', '2013-08-17 10:50:27'),
(223, 'image/jpeg', 'jpg', 45236, 'gvv3igYUFqlzktbZ', 'original/2013/08/gvv3igYUFqlzktbZ.jpg', '2013-08-17 10:50:27', '2013-08-17 10:50:27'),
(224, 'image/jpeg', 'jpg', 106493, 'yLAVFHF4EuPPs71T', 'original/2013/08/yLAVFHF4EuPPs71T.jpg', '2013-08-17 10:50:28', '2013-08-17 10:50:28'),
(225, 'image/jpeg', 'jpg', 56397, '5uTjhDpAqzxxxkZQ', 'original/2013/08/5uTjhDpAqzxxxkZQ.jpg', '2013-08-17 10:50:28', '2013-08-17 10:50:28'),
(226, 'image/jpeg', 'jpg', 46651, 'ePMWZuEXAKTolkLv', 'original/2013/08/ePMWZuEXAKTolkLv.jpg', '2013-08-17 10:50:28', '2013-08-17 10:50:28'),
(227, 'image/jpeg', 'jpg', 145122, 'X0zezQfPFb4cvKnb', 'original/2013/08/X0zezQfPFb4cvKnb.jpg', '2013-08-17 10:50:28', '2013-08-17 10:50:28'),
(228, 'image/jpeg', 'jpg', 77800, 'niEIhpKtUWs_uTvT', 'original/2013/08/niEIhpKtUWs_uTvT.jpg', '2013-08-17 10:50:29', '2013-08-17 10:50:29'),
(229, 'image/jpeg', 'jpg', 94906, 'YGHcLame4Tg0PaQX', 'original/2013/08/YGHcLame4Tg0PaQX.jpg', '2013-08-17 10:50:29', '2013-08-17 10:50:29'),
(230, 'image/jpeg', 'jpg', 117127, 'pZO2GqFvtteC8rfn', 'original/2013/08/pZO2GqFvtteC8rfn.jpg', '2013-08-17 10:50:29', '2013-08-17 10:50:29'),
(231, 'image/jpeg', 'jpg', 24971, 'gbYjiXDGlfqdpdA_', 'original/2013/08/gbYjiXDGlfqdpdA_.jpg', '2013-08-17 13:36:21', '2013-08-17 13:36:21'),
(232, 'image/jpeg', 'jpg', 55020, 'hSQ_qm5VftLRwSaj', 'original/2013/08/hSQ_qm5VftLRwSaj.jpg', '2013-08-17 14:05:56', '2013-08-17 14:05:56'),
(233, 'image/jpeg', 'jpg', 11919, '3TLOO_aiTtSeL6Su', 'original/2013/08/3TLOO_aiTtSeL6Su.jpg', '2013-08-17 14:14:27', '2013-08-17 14:14:27'),
(234, 'image/png', 'png', 384770, 'FbO4qax5RasAx43C', 'original/2013/08/FbO4qax5RasAx43C.png', '2013-08-22 08:25:35', '2013-08-22 08:25:35'),
(235, 'image/png', 'png', 562758, 'G0SuHijV079H8oSb', 'original/2013/08/G0SuHijV079H8oSb.png', '2013-08-22 08:25:36', '2013-08-22 08:25:36'),
(236, 'image/png', 'png', 483746, 'KEC92GDg1Mi5ePfp', 'original/2013/08/KEC92GDg1Mi5ePfp.png', '2013-08-22 08:25:36', '2013-08-22 08:25:36');

-- --------------------------------------------------------

--
-- テーブルの構造 `pages`
--

DROP TABLE IF EXISTS `pages`;
CREATE TABLE `pages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `parent_page_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `package` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'PagePlain',
  `depth` smallint(255) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `path` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `data` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `order` smallint(4) unsigned NOT NULL DEFAULT '0',
  `hidden` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- テーブルのデータのダンプ `pages`
--

INSERT INTO `pages` (`id`, `parent_page_id`, `package`, `depth`, `name`, `path`, `title`, `data`, `order`, `hidden`, `created`, `modified`) VALUES
(6, 0, 'PagePlain', 0, 'contact', '/baked/contact', '問い合わせ', '', 5, 0, '0000-00-00 00:00:00', '2013-09-07 06:24:15'),
(17, 0, 'PagePlain', 0, 'index', '/baked/index', 'HOME', '', 0, 0, '2013-07-27 03:12:28', '2013-09-07 06:24:15'),
(39, 0, 'PagePlain', 0, 'profile', '/baked/profile', 'プロフィール', '', 1, 0, '2013-07-27 17:03:03', '2013-09-07 06:24:15'),
(67, 0, 'PagePlain', 0, 'movie', '/baked/movie', '動画', '', 4, 0, '2013-08-06 03:36:12', '2013-09-07 06:24:15'),
(77, 39, 'PagePlain', 1, 'photos', '/baked/profile/photos', '写真集', '', 2, 0, '2013-08-17 09:30:23', '2013-09-07 06:24:15'),
(80, 0, 'PageBlog', 0, 'news', '/baked/news', 'お知らせ', '{"entries_per_page":"5","can_comment":"2","sent_text":"\\u30b3\\u30e1\\u30f3\\u30c8\\u3092\\u9001\\u4fe1\\u3057\\u307e\\u3057\\u305f\\u3002<br>\\u7ba1\\u7406\\u8005\\u306e\\u627f\\u8a8d\\u5f8c\\u306b\\u30b3\\u30e1\\u30f3\\u30c8\\u304c\\u8868\\u793a\\u3055\\u308c\\u308b\\u5834\\u5408\\u304c\\u3042\\u308a\\u307e\\u3059\\u3002"}', 3, 0, '2013-08-25 16:54:48', '2013-09-07 06:24:15');

-- --------------------------------------------------------

--
-- テーブルの構造 `staffs`
--

DROP TABLE IF EXISTS `staffs`;
CREATE TABLE `staffs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `password` char(64) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- テーブルの構造 `systems`
--

DROP TABLE IF EXISTS `systems`;
CREATE TABLE IF NOT EXISTS `systems` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

