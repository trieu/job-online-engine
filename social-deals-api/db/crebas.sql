/*==============================================================*/
/* DBMS name:      MySQL 5.0                                    */
/* Created on:     3/25/2012 2:03:30 PM                         */
/*==============================================================*/


drop table if exists business_location;

drop table if exists business_types;

drop table if exists businesses;

drop table if exists deal_categories;

drop table if exists deal_location;

drop table if exists deal_types;

drop table if exists deals;

drop table if exists locations;

drop table if exists membership_types;

drop table if exists users;

/*==============================================================*/
/* Table: business_location                                     */
/*==============================================================*/
create table business_location
(
   business_id          int unsigned,
   location_id          bigint unsigned
);

/*==============================================================*/
/* Table: business_types                                        */
/*==============================================================*/
create table business_types
(
   business_type_id     int not null,
   name                 varchar(250),
   primary key (business_type_id)
);

/*==============================================================*/
/* Table: businesses                                            */
/*==============================================================*/
create table businesses
(
   business_id          int unsigned not null,
   name                 varchar(250) not null,
   website              varchar(500),
   description          varchar(1000),
   business_type_id     int unsigned,
   primary key (business_id)
);

/*==============================================================*/
/* Table: deal_categories                                       */
/*==============================================================*/
create table deal_categories
(
   cat_id               int unsigned not null,
   cat_name             varchar(250) not null,
   cat_description      varchar(500) not null,
   primary key (cat_id)
);

/*==============================================================*/
/* Table: deal_location                                         */
/*==============================================================*/
create table deal_location
(
   deal_id              int unsigned not null,
   location_id          bigint unsigned not null
);

/*==============================================================*/
/* Table: deal_types                                            */
/*==============================================================*/
create table deal_types
(
   deal_type_id         int unsigned not null,
   description          text not null,
   primary key (deal_type_id)
);

/*==============================================================*/
/* Table: deals                                                 */
/*==============================================================*/
create table deals
(
   deal_id              int unsigned not null,
   title                varchar(500) not null,
   thumbnail_url        varchar(500) not null,
   description          text not null,
   list_price           float unsigned not null,
   original_price       float unsigned,
   expiry_time          bigint(20) unsigned,
   rating               tinyint unsigned,
   number_sold          mediumint unsigned default 0,
   discount_percentage  float unsigned,
   is_featured          tinyint unsigned not null default 0,
   cat_id               int unsigned,
   deal_type_id         int unsigned,
   primary key (deal_id)
);

/*==============================================================*/
/* Table: locations                                             */
/*==============================================================*/
create table locations
(
   location_id          bigint unsigned not null,
   address              varchar(1000) not null default '',
   latitude             float,
   longitude            float,
   primary key (location_id)
);

/*==============================================================*/
/* Table: membership_types                                      */
/*==============================================================*/
create table membership_types
(
   mem_id               int not null,
   name                 varchar(100),
   description          varchar(1000),
   primary key (mem_id)
);

/*==============================================================*/
/* Table: users                                                 */
/*==============================================================*/
create table users
(
   user_id              int unsigned not null,
   first_name           varchar(100) not null,
   last_name            varchar(100) not null default '',
   email                varchar(100) not null,
   password             varchar(50) not null,
   birthday             char(10) not null,
   gender               tinyint not null,
   phone_number          varchar(15),
   zipcode              varchar(10),
   phone_notification   tinyint,
   location_id          bigint not null,
   mem_id               int,
   creation_date        bigint unsigned,
   update_date          bigint unsigned,
   primary key (user_id)
);

alter table business_location add constraint FK_REFERENCE_5 foreign key (business_id)
      references businesses (business_id) on delete restrict on update restrict;

alter table business_location add constraint FK_REFERENCE_6 foreign key (location_id)
      references locations (location_id) on delete restrict on update restrict;

alter table businesses add constraint FK_REFERENCE_7 foreign key (business_type_id)
      references business_types (business_type_id) on delete restrict on update restrict;

alter table deal_location add constraint FK_REFERENCE_3 foreign key (location_id)
      references locations (location_id) on delete restrict on update restrict;

alter table deal_location add constraint FK_REFERENCE_4 foreign key (deal_id)
      references deals (deal_id) on delete restrict on update restrict;

alter table deals add constraint FK_REFERENCE_2 foreign key (cat_id)
      references deal_categories (cat_id) on delete restrict on update restrict;

alter table deals add constraint FK_REFERENCE_9 foreign key (deal_type_id)
      references deal_types (deal_type_id) on delete restrict on update restrict;

alter table users add constraint FK_REFERENCE_1 foreign key (location_id)
      references locations (location_id) on delete restrict on update restrict;

alter table users add constraint FK_REFERENCE_8 foreign key (mem_id)
      references membership_types (mem_id) on delete restrict on update restrict;

