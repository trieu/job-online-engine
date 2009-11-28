
LOCK TABLES field_form WRITE;
INSERT INTO field_form VALUES  (8,1),
 (9,1),
 (10,1),
 (11,1);
UNLOCK TABLES;

LOCK TABLES fieldoptions WRITE;
INSERT INTO fieldoptions VALUES  (1,1,'aaaa'),
 (2,1,'bbb'),
 (3,4,'16 - 25'),
 (4,4,'26 - 35'),
 (5,4,'36 - 45'),
 (6,4,'46 - 55'),
 (7,4,'56 - 65'),
 (8,4,'65+'),
 (9,0,'1-10'),
 (10,0,'11-20'),
 (11,9,'10-20'),
 (12,9,'21-30'),
 (13,0,'aa'),
 (14,10,'fsdffsfs'),
 (15,11,'a'),
 (16,11,'b');
UNLOCK TABLES;

LOCK TABLES fields WRITE;
INSERT INTO fields VALUES  (1,4,'field 1 ext','required'),
 (2,2,'field 2',''),
 (3,3,'Ngay sinh',''),
 (4,4,'Tuổi/Age',''),
 (5,1,'aaa',''),
 (6,1,'Job Seeker Name',''),
 (7,4,'What is your Age ?',''),
 (8,1,'Name',''),
 (9,4,'What is your Age ?',''),
 (10,4,'aaaa',''),
 (11,7,'chexcxvbox','');
UNLOCK TABLES;

LOCK TABLES 'fieldtype' WRITE;
UNLOCK TABLES;



LOCK TABLES 'fieldvalues' WRITE;
UNLOCK TABLES;

LOCK TABLES 'form_process' WRITE;
INSERT INTO 'form_process' VALUES  (1,2),
 (4,3),
 (5,1);
UNLOCK TABLES;

LOCK TABLES forms WRITE;
INSERT INTO forms VALUES  (1,'PERSONAL INFORMATION','for Job Seeker'),
 (2,'YOUR DISABILITY','for Job Seeker'),
 (3,'EDUCATION','for Job Seeker'),
 (4,'YOUR SKILLS & INTERESTS','for Job Seeker'),
 (5,'Employment details','for Job Seeker'),
 (6,'3 MONTH FOLLOW UP','for Job Seeker'),
 (7,'6  MONTH FOLLOW UP','for Job Seeker'),
 (8,'12  MONTH FOLLOW UP','for Job Seeker'),
 (9,'EMPLOYER CONTACT DETAILS','for Employer'),
 (10,'Reasonable Accomodation','for Employer'),
 (11,'Education','for Employer'),
 (12,'Skills and Support','for Employer'),
 (13,'Employment','for Employer'),
 (14,'3 MONTH FOLLOW UP','for Employer'),
 (15,'6  MONTH FOLLOW UP','for Employer'),
 (16,'12  MONTH FOLLOW UP','for Employer'),
 (17,'Employer Feedback','for Employer');
UNLOCK TABLES;

LOCK TABLES groups WRITE;
INSERT INTO groups VALUES  (1,'admin','Administrator'),
 (2,'operator','Operator'),
 (3,'user','User');
UNLOCK TABLES;

LOCK TABLES 'language' WRITE;
UNLOCK TABLES;


LOCK TABLES meta WRITE;
INSERT INTO meta VALUES  (1,2,'Trieu','Nguyen tan'),
 (2,3,'Trieu','Nguyen');
UNLOCK TABLES;



LOCK TABLES 'object_ext_info' WRITE;
UNLOCK TABLES;

LOCK TABLES objectclass WRITE;
INSERT INTO objectclass VALUES  (1,'Job Seeker','Nguoi tim viec '),
 (2,'Employers','Nha tuyen dung'),
 (3,'Job Coach','The person who helps the job seeker');
UNLOCK TABLES;

LOCK TABLES 'objecthtmlcaches' WRITE;
INSERT INTO 'objecthtmlcaches' VALUES  (2,'form_',1,'','');
UNLOCK TABLES;

LOCK TABLES 'objects' WRITE;
UNLOCK TABLES;

LOCK TABLES processes WRITE;
INSERT INTO processes VALUES  (1,'Posting a job profile for Job Seeker','test1 des'),
 (2,'Manage Personal Job Seeker Information ','test2 Description1'),
 (3,'Tracking Job Seeker','Tranking Job seeker by a job coach'),
 (4,'Posting Employer Contact Details','This is used by DRD staff'),
 (5,'Posting a job requirements','This process can be used multiple times.'),
 (6,'Tracking Employer','This process is used to manage feedbacks of employer');
UNLOCK TABLES;

LOCK TABLES 'sessions' WRITE;
UNLOCK TABLES;

LOCK TABLES users WRITE;
INSERT INTO users VALUES  (1,3,'127.0.0.1','trieu','1362627da60f8abd4176aaf7b3f02f69bca5515a','tantrieuf31@gmail.com','0','892163d6e309f3f2b66f4986fb49bb8d33f37b27',0),
 (2,2,'127.0.0.1','trieunguyen','28501bb04bd8255bf26ea1f2069511731b404d35','trieunguyen@yopco.com','0','0',0),
 (3,1,'127.0.0.1','trieu_drd','0f376afb66926ffb0f4604223fd83d537b64c415','trieu@drdvietnam.com','0','0',0);
UNLOCK TABLES;

