create table event_store
(
    id int primary key,
    aggregate_id int not null,
    aggregate_name varchar(50) not null,
    version int not null,
    data json not null,
    occurred_on datetime not null
);

