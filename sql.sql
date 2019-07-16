create database zhihu;
use zhihu;
create table users(
    id int auto_increment primary key,
    username varchar(50) not null,
    passwd varchar(100) not null,
    email varchar(100) not null,
    answers int default 0, # 回答数
    questions int default 0, # 提问数
    sex varchar(10) default '男'
)default charset=utf8;

create table questions(
    id int auto_increment primary key,
    users_id int not null,
    qtypeid int not null,
    qtype varchar(20) not null,
    qkey varchar(100) not null,

    qtitle varchar(100) not null,
    qcontent text not null,

    love int default 0, # 点赞数
    look int default 0,
    img int default 1,

    index(users_id),
    foreign key(users_id) references users(id) ON UPDATE CASCADE ON DELETE RESTRICT
)default charset=utf8;

# 用户回答表
create table comments(
    id int auto_increment primary key,
    users_id int not null,
    questions_id int not null,
    content text not null,
    love int default 0, # 点赞数

    index(users_id),
    index(questions_id),
    foreign key(users_id) references users(id) ON UPDATE CASCADE ON DELETE RESTRICT,
    foreign key(questions_id) references questions(id) ON UPDATE CASCADE ON DELETE RESTRICT
)default charset=utf8;

# 用户问题关注表
create table attentions(
    id int auto_increment primary key,
    users_id int not null,
    questions_id int not null,

    index(users_id),
    index(questions_id),
    foreign key(users_id) references users(id) ON UPDATE CASCADE ON DELETE RESTRICT,
    foreign key(questions_id) references questions(id) ON UPDATE CASCADE ON DELETE RESTRICT
)default charset=utf8;

#邀请表
create table invite(
    id int auto_increment primary key,
    users_id int not null, # 提问的人
    invite_id int not null,# 邀请的人
    questions_id int not null, # 题目ID

    an_status int(2) default 0, # 标记是否已经查看了这个消息
    index (invite_id),
    index(users_id),
    index(questions_id),
    foreign key(users_id) references users(id) ON UPDATE CASCADE ON DELETE RESTRICT,
    foreign key(invite_id) references users(id) ON UPDATE CASCADE ON DELETE RESTRICT,
    foreign key(questions_id) references questions(id) ON UPDATE CASCADE ON DELETE RESTRICT
)default charset=utf8;
select count(*)  nums from users;
alter table users add column questions int default 0; # 一次只修改一个增减一个字段
alter table comments add column addtime timestamp default current_timestamp; #自动增减修改时间
