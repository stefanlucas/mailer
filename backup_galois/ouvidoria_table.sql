use galois;

create table j456_ouvidoria (
	email varchar(255) primary key,
	hash varchar(32) not null,
	active tinyint(1) not null default 0,
	expiration_date datetime not null
);
