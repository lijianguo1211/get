create table bind_category_resources_fiels(
`id` int(11) UNSIGNED primary key auto_increment comment '主键',
`one_product_categories` int(11) not null comment '一级分类id',
`two_product_categories` int(11) comment '二级分类id',
`three_product_categories` int(11) comment '三级分类id',
`four_product_categories` int(11) comment '四级分类id',
`file_name` varchar(255) not null comment '文件名',
`file_type` tinyint(1) not null default 1 comment '文件类型，默认为1，代表case study，2代表video，3代表blog'
)ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

create table bind_product_fiels (
`id` int(11) UNSIGNED primary key auto_increment comment '主键',
`resources_product_binding_id` int(11) not null comment '资源文件绑定主键id',
`product_name` varchar(255) not null comment '商品名',
`product_id` int(11) not null comment '商品id',
`file_page_status` tinyint(1) not null comment '文件所属页面状态',
`file_page` varchar(50) not null comment '文件所属页面'
)ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;



