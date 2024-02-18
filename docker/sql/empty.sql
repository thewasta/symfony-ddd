create table if not exists main.doctrine_migration_versions
(
    version        varchar(191) not null
    primary key,
    executed_at    datetime     null,
    execution_time int          null
    )
    collate = utf8mb3_unicode_ci;

create table if not exists main.sessions
(
    sess_id       varbinary(128) not null
    primary key,
    sess_data     blob           not null,
    sess_lifetime int unsigned   not null,
    sess_time     int unsigned   not null
    )
    collate = utf8mb4_bin;

create index sessions_sess_lifetime_idx
    on main.sessions (sess_lifetime);

create table if not exists main.user
(
    id             int auto_increment
    primary key,
    auth0_id       char(36)                            not null,
    username       varchar(50)                         not null,
    profile_photo  varchar(255)                        null,
    first_name     varchar(50)                         not null,
    last_name      varchar(50)                         null,
    email          varchar(100)                        not null,
    email_verified tinyint(1)                          null,
    last_login     timestamp                           null,
    created_at     timestamp default CURRENT_TIMESTAMP null,
    updated_at     timestamp default CURRENT_TIMESTAMP null,
    constraint email_unique
    unique (email),
    constraint idx_uuid
    unique (auth0_id)
    );

create table if not exists main.posts
(
    uuid          char(36)                            not null
    primary key,
    user_uuid     char(36)                            not null,
    creation_date timestamp default CURRENT_TIMESTAMP not null,
    likes         int       default 0                 not null,
    author        varchar(100)                        not null,
    file_path     varchar(255)                        not null,
    constraint idx_post_uuid
    unique (uuid),
    constraint fk_user
    foreign key (user_uuid) references main.user (auth0_id)
    );

create table if not exists main.comments
(
    id            int auto_increment
    primary key,
    post_uuid     char(36)                            not null,
    user_uuid     char(36)                            not null,
    comment_text  text                                not null,
    creation_date timestamp default CURRENT_TIMESTAMP not null,
    constraint comments_ibfk_1
    foreign key (post_uuid) references main.posts (uuid),
    constraint comments_ibfk_2
    foreign key (user_uuid) references main.user (auth0_id)
    );

create index post_uuid
    on main.comments (post_uuid);

create index user_uuid
    on main.comments (user_uuid);

create table if not exists main.likes
(
    user_uuid char(36) not null,
    post_uuid char(36) not null,
    primary key (user_uuid, post_uuid),
    constraint likes_ibfk_1
    foreign key (user_uuid) references main.user (auth0_id),
    constraint likes_ibfk_2
    foreign key (post_uuid) references main.posts (uuid)
    );

create index post_uuid
    on main.likes (post_uuid);

