create table flag(`id` varchar(50));
create table employees(`id` int NOT NULL AUTO_INCREMENT ,`name` varchar(255),`surname` varchar(255),`birth` varchar(32),`department` varchar(32), PRIMARY KEY (id));
create table departments(`id` int NOT NULL AUTO_INCREMENT ,`name` varchar(255), PRIMARY KEY (id));
insert into departments (`name`) values ('Network');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Henry','Johnson','10/24/1993','Network');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Emma','Martinez','04/11/1996','Network');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Amelia','Davis','02/24/1993','Network');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Mia','Davis','11/15/1974','Network');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Henry','Miller','06/07/1985','Network');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Emma','Gonzalez','03/28/2002','Network');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Noah','Garcia','06/28/1977','Network');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Henry','Davis','07/31/1996','Network');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Ava','Jones','06/19/1979','Network');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Olivia','Miller','12/02/1991','Network');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Amelia','Davis','03/02/1986','Network');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Noah','Lopez','09/20/1991','Network');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Alexander','Miller','01/11/1991','Network');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Oliver','Rodriguez','06/04/2001','Network');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Lucas','Gonzalez','03/22/2001','Network');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Olivia','Garcia','11/23/1984','Network');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Charlotte','Davis','11/15/1977','Network');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Isabella','Martinez','10/06/1976','Network');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Isabella','Gonzalez','08/01/1979','Network');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Emma','Brown','04/15/1978','Network');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Alexander','Rodriguez','06/03/1979','Network');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Oliver','Johnson','12/26/1985','Network');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Benjamin','Johnson','01/06/1986','Network');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Emma','Lopez','08/25/1977','Network');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Alexander','Hernandez','03/08/1993','Network');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Mia','Anderson','09/25/1992','Network');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Lucas','Johnson','04/27/1975','Network');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Charlotte','Taylor','02/08/1985','Network');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Charlotte','Martinez','11/28/1976','Network');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Ava','Anderson','12/24/1974','Network');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Alexander','Anderson','01/11/1997','Network');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Liam','Moore','02/18/1981','Network');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Henry','Davis','12/01/1983','Network');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Olivia','Lopez','10/13/1993','Network');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Amelia','Garcia','10/12/1998','Network');
insert into departments (`name`) values ('Development');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Lucas','Davis','05/20/1995','Development');
insert into employees (`name`,`surname`,`birth`,`department`) values ('William','Taylor','11/14/1983','Development');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Liam','Garcia','12/20/1977','Development');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Ava','Thomas','02/14/2002','Development');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Ava','Rodriguez','12/10/1985','Development');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Mia','Miller','10/27/1989','Development');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Emma','Smith','03/10/1979','Development');
insert into employees (`name`,`surname`,`birth`,`department`) values ('James','Wilson','11/01/1990','Development');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Oliver','Anderson','08/19/1984','Development');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Emma','Jones','11/19/1992','Development');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Noah','Smith','01/05/1990','Development');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Lucas','Hernandez','06/25/1974','Development');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Emma','Taylor','04/29/1987','Development');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Olivia','Garcia','06/27/1994','Development');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Henry','Lopez','12/29/1991','Development');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Noah','Thomas','12/07/1985','Development');
insert into employees (`name`,`surname`,`birth`,`department`) values ('James','Brown','03/20/1984','Development');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Evelyn','Taylor','08/12/1982','Development');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Mia','Garcia','08/06/1989','Development');
insert into departments (`name`) values ('Telephony');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Oliver','Wilson','11/20/2000','Telephony');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Evelyn','Moore','04/12/1975','Telephony');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Olivia','Taylor','11/03/1979','Telephony');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Charlotte','Martinez','07/17/2002','Telephony');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Lucas','Lopez','03/07/1995','Telephony');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Benjamin','Brown','08/26/1999','Telephony');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Amelia','Taylor','05/10/1979','Telephony');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Oliver','Brown','04/11/1999','Telephony');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Henry','Brown','01/25/1987','Telephony');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Lucas','Gonzalez','01/27/1980','Telephony');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Emma','Moore','12/15/1985','Telephony');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Henry','Rodriguez','10/24/1989','Telephony');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Charlotte','Hernandez','09/13/1995','Telephony');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Sophia','Moore','03/22/1976','Telephony');
insert into employees (`name`,`surname`,`birth`,`department`) values ('James','Garcia','08/19/1997','Telephony');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Benjamin','Gonzalez','05/21/1993','Telephony');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Harper','Wilson','01/07/1998','Telephony');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Sophia','Johnson','05/26/1990','Telephony');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Elijah','Davis','05/23/1977','Telephony');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Isabella','Miller','11/18/1979','Telephony');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Charlotte','Taylor','02/23/1986','Telephony');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Elijah','Thomas','04/03/1991','Telephony');
insert into employees (`name`,`surname`,`birth`,`department`) values ('William','Jones','11/17/1978','Telephony');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Liam','Rodriguez','01/25/1979','Telephony');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Olivia','Jones','11/03/1995','Telephony');
insert into employees (`name`,`surname`,`birth`,`department`) values ('James','Taylor','03/14/1984','Telephony');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Emma','Rodriguez','04/26/1997','Telephony');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Ava','Lopez','09/09/2000','Telephony');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Ava','Johnson','01/27/2001','Telephony');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Ava','Smith','03/23/1990','Telephony');
insert into departments (`name`) values ('Support');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Noah','Gonzalez','08/01/1995','Support');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Liam','Johnson','06/27/1997','Support');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Harper','Moore','03/17/1991','Support');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Elijah','Davis','05/09/1979','Support');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Henry','Jones','05/05/1996','Support');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Amelia','Hernandez','12/02/1977','Support');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Amelia','Anderson','01/03/1994','Support');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Lucas','Martinez','04/07/2001','Support');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Alexander','Johnson','02/22/1981','Support');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Amelia','Miller','11/13/2000','Support');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Ava','Miller','08/17/1979','Support');
insert into employees (`name`,`surname`,`birth`,`department`) values ('James','Moore','07/18/1997','Support');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Isabella','Taylor','07/04/1990','Support');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Emma','Wilson','03/19/1978','Support');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Elijah','Wilson','03/22/1999','Support');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Elijah','Johnson','05/08/1975','Support');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Oliver','Williams','05/27/1997','Support');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Harper','Wilson','05/12/2002','Support');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Charlotte','Anderson','10/23/1979','Support');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Isabella','Thomas','03/13/1991','Support');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Ava','Moore','01/21/2001','Support');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Henry','Williams','12/23/1977','Support');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Alexander','Garcia','10/06/1990','Support');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Lucas','Moore','08/05/1992','Support');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Liam','Smith','04/22/2002','Support');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Henry','Davis','10/21/2001','Support');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Benjamin','Williams','01/11/2000','Support');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Sophia','Anderson','02/28/1993','Support');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Alexander','Williams','12/17/1986','Support');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Ava','Lopez','11/26/1983','Support');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Henry','Williams','06/09/1998','Support');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Liam','Moore','11/17/1991','Support');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Charlotte','Gonzalez','10/26/1996','Support');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Amelia','Moore','05/24/2003','Support');
insert into departments (`name`) values ('Sales');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Mia','Martinez','05/16/1975','Sales');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Ava','Gonzalez','09/24/1993','Sales');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Emma','Smith','10/18/2002','Sales');
insert into employees (`name`,`surname`,`birth`,`department`) values ('William','Thomas','08/23/1978','Sales');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Charlotte','Smith','09/12/1987','Sales');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Sophia','Davis','03/29/1999','Sales');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Sophia','Davis','06/20/2000','Sales');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Charlotte','Smith','01/30/1988','Sales');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Henry','Wilson','09/02/1992','Sales');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Sophia','Williams','11/08/1987','Sales');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Henry','Wilson','10/20/1994','Sales');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Emma','Anderson','03/18/1985','Sales');
insert into employees (`name`,`surname`,`birth`,`department`) values ('Oliver','Williams','10/09/1993','Sales');
