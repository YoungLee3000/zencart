--
--PZENTEMPLATE_BRAND--
--

CREATE TABLE IF NOT EXISTS pzen_template (
	opt_id int(11) NOT NULL AUTO_INCREMENT,
	lang_id int(11) NOT NULL DEFAULT '0',
	opt_name varchar(255) COLLATE utf8_unicode_ci NOT NULL,
	opt_value text COLLATE utf8_unicode_ci NOT NULL,
	PRIMARY KEY (opt_id)
);
CREATE TABLE IF NOT EXISTS pzen_slider (
	id int(11) NOT NULL AUTO_INCREMENT,
	sort_order int(11) NOT NULL,
	slideshow_image varchar(200) NOT NULL,
	slideshow_caption text NOT NULL,
	trans_style varchar(255) NOT NULL,
	data_masterspeed varchar(255) NOT NULL,
	data_delay varchar(255) NOT NULL,
	data_slotamount int(10) NOT NULL,
	in_animation_class varchar(50) NOT NULL,
	out_animation_class varchar(50) NOT NULL,
	ease_in varchar(50) NOT NULL,
	ease_out varchar(50) NOT NULL,
	data_x varchar(50) NOT NULL,
	data_y varchar(50) NOT NULL,
	data_hoffset varchar(50) NOT NULL,
	data_voffset varchar(50) NOT NULL,
	created_at datetime NOT NULL default '0001-01-01 00:00:00',
	updated_at datetime NOT NULL default '0001-01-01 00:00:00',
	slide_status enum('0','1') NOT NULL DEFAULT '0',
	PRIMARY KEY (id)
);
CREATE TABLE IF NOT EXISTS pzen_topbanner (
  id int(11) NOT NULL AUTO_INCREMENT,
  item_type int(11) NOT NULL COMMENT '1=Slide, 2=Banner',
  sort_order int(11) NOT NULL,
  item_image varchar(200) NOT NULL,
  item_desc text NOT NULL,
  item_link text NOT NULL,
  created_at datetime NOT NULL default '0001-01-01 00:00:00',
  updated_at datetime NOT NULL default '0001-01-01 00:00:00',
  item_status enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (id)
);
CREATE TABLE IF NOT EXISTS pzen_bottombanner (
  id int(11) NOT NULL AUTO_INCREMENT,
  item_type int(11) NOT NULL COMMENT '1=Slide, 2=Banner',
  sort_order int(11) NOT NULL,
  item_image varchar(200) NOT NULL,
  item_desc text NOT NULL,
  item_link text NOT NULL,
  created_at datetime NOT NULL default '0001-01-01 00:00:00',
  updated_at datetime NOT NULL default '0001-01-01 00:00:00',
  item_status enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS pzen_sidebarbanner(
  id int(11) NOT NULL AUTO_INCREMENT,
  item_type int(11) NOT NULL COMMENT '1=Slide, 2=Banner',
  sort_order int(11) NOT NULL,
  item_image varchar(200) NOT NULL,
  item_desc text NOT NULL,
  item_link text NOT NULL,
  created_at datetime NOT NULL default '0001-01-01 00:00:00',
  updated_at datetime NOT NULL default '0001-01-01 00:00:00',
  item_status enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (id)
);