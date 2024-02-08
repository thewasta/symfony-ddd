create table if not exists doctrine_migration_versions
(
    version        varchar(191) not null
        primary key,
    executed_at    datetime     null,
    execution_time int          null
)
    collate = utf8mb3_unicode_ci;

create table if not exists user
(
    id         int auto_increment
        primary key,
    uuid       char(36)                            not null,
    first_name varchar(50)                         not null,
    last_name  varchar(50)                         not null,
    email      varchar(100)                        not null,
    password   varchar(255)                        not null,
    created_at timestamp default CURRENT_TIMESTAMP null,
    updated_at timestamp default CURRENT_TIMESTAMP null,
    constraint email_unique
        unique (email),
    constraint idx_uuid
        unique (uuid)
);

create table if not exists posts
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
        foreign key (user_uuid) references user (uuid)
);

create table if not exists comments
(
    id            int auto_increment
        primary key,
    post_uuid     char(36)                            not null,
    user_uuid     char(36)                            not null,
    comment_text  text                                not null,
    creation_date timestamp default CURRENT_TIMESTAMP not null,
    constraint comments_ibfk_1
        foreign key (post_uuid) references posts (uuid),
    constraint comments_ibfk_2
        foreign key (user_uuid) references user (uuid)
);

create index post_uuid
    on comments (post_uuid);

create index user_uuid
    on comments (user_uuid);

create table if not exists likes
(
    user_uuid char(36) not null,
    post_uuid char(36) not null,
    primary key (user_uuid, post_uuid),
    constraint likes_ibfk_1
        foreign key (user_uuid) references user (uuid),
    constraint likes_ibfk_2
        foreign key (post_uuid) references posts (uuid)
);

create index post_uuid
    on likes (post_uuid);