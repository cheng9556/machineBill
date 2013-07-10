#Install And Demo

bash#mysql

mysql>create database machineBill;

mysql>grant all privileges on machineBill.* to machineBill@localhost identified by 'machineBill123';

mysql>flush privileges;

mysql>exit;

bash#mysql machineBill < sql/demo_with_data.sql

#Watch the demo
 --> http://bill.bbkanba.com
