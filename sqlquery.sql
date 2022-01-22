-- drop fk from comment - gallery_id -image_id - user_id
alter table comment drop foreign key FK_9474526C4E7AF8F
alter table comment drop foreign key FK_9474526C3DA5256D
alter table comment drop foreign key FK_9474526CA76ED395

--add fk in comment - gallery_id - image_id - user_id
alter table comment add constraint FK_9474526C4E7AF8F foreign key (gallery_id) references gallery(id) on delete cascade
alter table comment add constraint FK_9474526C3DA5256D foreign key (image_id) references image(id) on delete cascade
alter table comment add constraint FK_9474526CA76ED395 foreign key (user_id) references user(id) on delete cascade

--create moderator_logging table
create table if not exists `moderator_logging` (`id` int primary key auto_increment,`message` varchar(255) not null,`created_at` timestamp null default null)

--add active column in user
alter table `user` add column `active` int default 1

--add nsfw column in user
alter table `user` add column `nsfw` int default 0

--update image links
update image set file_name = concat('https://picsum.photos/200/300?random=', id)

--user password updated to 'password'
update user set password = '$2y$10$fsgdvcrvir/ggyu20oe/xuyqkmh2zdjaapwwrtryxpq8p.lcuuw1e'

--make uniquee slug for gallery
update gallery set `slug` = concat(`slug`, `id`)

--make unique slug for image
update image set `slug` = concat(`slug`, `id`)

--create index for user - username
create index idx_username on user (username)

--create index for image - slug
create index idx_slug on image (slug)

--create index for gallery - slug
create index idx_slug on gallery (slug)