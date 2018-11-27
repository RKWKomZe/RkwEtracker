#
# Table structure for table 'tx_rkwetracker_domain_model_report'
#
CREATE TABLE tx_rkwetracker_domain_model_report (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	name varchar(255) DEFAULT '' NOT NULL,
	description text NOT NULL,
	recipient text NOT NULL,
	groups varchar(255) DEFAULT '' NOT NULL,
	groups_fetch varchar(255) DEFAULT '' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	type int(1) unsigned DEFAULT '0' NOT NULL,
	status int(11) unsigned DEFAULT '0' NOT NULL,
	link_to_api int(1) unsigned DEFAULT '1' NOT NULL,
	fetch_counter int(11) DEFAULT '0' NOT NULL,
	last_fetch_tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	last_mail_tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	last_start_tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	last_end_tstamp int(11) unsigned DEFAULT '0' NOT NULL,
    month int(11) DEFAULT '0' NOT NULL,
	quarter int(11) DEFAULT '0' NOT NULL,
	year int(11) DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid),

);

#
# Table structure for table 'tx_rkwetracker_domain_model_reportfilter'
#
CREATE TABLE tx_rkwetracker_domain_model_reportfilter (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	reportgroup int(11) unsigned DEFAULT '0' NOT NULL,

    domain varchar(255) DEFAULT '' NOT NULL,
    domain_free varchar(255) DEFAULT '' NOT NULL,

    category_level1 varchar(255) DEFAULT '' NOT NULL,
	category_level2 varchar(255) DEFAULT '' NOT NULL,
	category_level3 varchar(255) DEFAULT '' NOT NULL,
	category_level4 varchar(255) DEFAULT '' NOT NULL,
	category_level5 varchar(255) DEFAULT '' NOT NULL,
    category_free_level1 varchar(255) DEFAULT '' NOT NULL,
	category_free_level2 varchar(255) DEFAULT '' NOT NULL,
	category_free_level3 varchar(255) DEFAULT '' NOT NULL,
	category_free_level4 varchar(255) DEFAULT '' NOT NULL,
	category_free_level5 varchar(255) DEFAULT '' NOT NULL,	

	download_filter1 varchar(255) DEFAULT '' NOT NULL,
	download_filter2 varchar(255) DEFAULT '' NOT NULL,
	download_filter3 varchar(255) DEFAULT '' NOT NULL,
	download_free_filter1 varchar(255) DEFAULT '' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	sorting int(11) DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid),


);

#
# Table structure for table 'tx_rkwetracker_domain_model_reportgroup'
#
CREATE TABLE tx_rkwetracker_domain_model_reportgroup (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	name varchar(255) DEFAULT '' NOT NULL,
	description text NOT NULL,
	filter int(11) unsigned DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid),

);


#
# Table structure for table 'tx_rkwetracker_domain_model_reportfilter'
#
CREATE TABLE tx_rkwetracker_domain_model_reportfilter (

	reportgroup  int(11) unsigned DEFAULT '0' NOT NULL,

);


#
# Table structure for table 'tx_rkwetracker_domain_model_areadata'
#
CREATE TABLE tx_rkwetracker_domain_model_areadata (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	visits int(11) DEFAULT '0' NOT NULL,
	visitors int(11) DEFAULT '0' NOT NULL,
	page_impressions int(11) DEFAULT '0' NOT NULL,
	bounces_per_visit double DEFAULT '0' NOT NULL,
	time_per_visit int(11) DEFAULT '0' NOT NULL,

	domain varchar(255) DEFAULT '' NOT NULL,
	category_level1 varchar(255) DEFAULT '' NOT NULL,
	category_level2 varchar(255) DEFAULT '' NOT NULL,
	category_level3 varchar(255) DEFAULT '' NOT NULL,
	category_level4 varchar(255) DEFAULT '' NOT NULL,
	category_level5 varchar(255) DEFAULT '' NOT NULL,

    report int(11) DEFAULT '0' NOT NULL,
    report_group int(11) DEFAULT '0' NOT NULL,
    report_filter int(11) DEFAULT '0' NOT NULL,
    report_fetch_counter int(11) DEFAULT '0' NOT NULL,
    month int(11) DEFAULT '0' NOT NULL,
	quarter int(11) DEFAULT '0' NOT NULL,
	year int(11) DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid),

);


#
# Table structure for table 'tx_rkwetracker_domain_model_downloaddata'
#
CREATE TABLE tx_rkwetracker_domain_model_downloaddata (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	action varchar(255) DEFAULT '' NOT NULL,
	category varchar(255) DEFAULT '' NOT NULL,
	time_per_event int(11) DEFAULT '0' NOT NULL,
	events int(11) DEFAULT '0' NOT NULL,
	unique_events int(11) DEFAULT '0' NOT NULL,

    report int(11) DEFAULT '0' NOT NULL,
    report_group int(11) DEFAULT '0' NOT NULL,
    report_filter int(11) DEFAULT '0' NOT NULL,
    report_fetch_counter int(11) DEFAULT '0' NOT NULL,
    month int(11) DEFAULT '0' NOT NULL,
	quarter int(11) DEFAULT '0' NOT NULL,
	year int(11) DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid),
    KEY action (action),
    KEY category (category),

);



#
# Table structure for table 'tx_rkwetracker_domain_model_areasum'
#
CREATE TABLE tx_rkwetracker_domain_model_areasum (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	visits int(11) DEFAULT '0' NOT NULL,
	visitors int(11) DEFAULT '0' NOT NULL,
	page_impressions int(11) DEFAULT '0' NOT NULL,
	page_impressions_per_visit double(11,2) DEFAULT '0.00' NOT NULL,
	time_per_visit int(11) DEFAULT '0' NOT NULL,

	report int(11) DEFAULT '0' NOT NULL,
	report_group int(11) DEFAULT '0' NOT NULL,
	report_fetch_counter int(11) DEFAULT '0' NOT NULL,
    month int(11) DEFAULT '0' NOT NULL,
	quarter int(11) DEFAULT '0' NOT NULL,
	year int(11) DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid),

);

#
# Table structure for table 'tx_rkwetracker_domain_model_downloadsum'
#
CREATE TABLE tx_rkwetracker_domain_model_downloadsum (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	time_per_event int(11) DEFAULT '0' NOT NULL,
	events int(11) DEFAULT '0' NOT NULL,
	unique_events int(11) DEFAULT '0' NOT NULL,

	report int(11) DEFAULT '0' NOT NULL,
	report_group int(11) DEFAULT '0' NOT NULL,
	report_fetch_counter varchar(255) DEFAULT '' NOT NULL,
    month int(11) DEFAULT '0' NOT NULL,
	quarter int(11) DEFAULT '0' NOT NULL,
	year int(11) DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,


	PRIMARY KEY (uid),
	KEY parent (pid),

);



#
# Table structure for table 'tx_rkwetracker_domain_model_reportareasum'
#
CREATE TABLE tx_rkwetracker_domain_model_reportareasum (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	visits int(11) DEFAULT '0' NOT NULL,
	visitors int(11) DEFAULT '0' NOT NULL,
	page_impressions int(11) DEFAULT '0' NOT NULL,
	page_impressions_per_visit double(11,2) DEFAULT '0.00' NOT NULL,
	time_per_visit int(11) DEFAULT '0' NOT NULL,

	report int(11) DEFAULT '0' NOT NULL,
	report_group int(11) DEFAULT '0' NOT NULL,
	report_fetch_counter int(11) DEFAULT '0' NOT NULL,
    month int(11) DEFAULT '0' NOT NULL,
	quarter int(11) DEFAULT '0' NOT NULL,
	year int(11) DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid),

);



#
# Table structure for table 'tx_rkwetracker_domain_model_reportdownloadsum'
#
CREATE TABLE tx_rkwetracker_domain_model_reportdownloadsum (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	time_per_event int(11) DEFAULT '0' NOT NULL,
	events int(11) DEFAULT '0' NOT NULL,
	unique_events int(11) DEFAULT '0' NOT NULL,
	report int(11) DEFAULT '0' NOT NULL,
	report_group int(11) DEFAULT '0' NOT NULL,
	report_fetch_counter varchar(255) DEFAULT '' NOT NULL,
    month int(11) DEFAULT '0' NOT NULL,
	quarter int(11) DEFAULT '0' NOT NULL,
	year int(11) DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,


	PRIMARY KEY (uid),
	KEY parent (pid),

);


#
# Table structure for table 'pages'
#
CREATE TABLE pages (

	tx_rkwetracker_category_level1 varchar(255) DEFAULT '' NOT NULL,
	tx_rkwetracker_category_level2 varchar(255) DEFAULT '' NOT NULL,
	tx_rkwetracker_category_level3 varchar(255) DEFAULT '' NOT NULL,
	tx_rkwetracker_category_level4 varchar(255) DEFAULT '' NOT NULL,
	tx_rkwetracker_category_level5 varchar(255) DEFAULT '' NOT NULL,

);