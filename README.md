# PDO-for-SQL-Inject
PHP study pdo for SQL inject

# 非专业开发仅只学习
SQL防注入之PDO

前端页面采用
https://github.com/ybbthdwqe/star_login

# 操作
导入localhost的sql文件即可
初始账号密码:admin/admin123

#逻辑

输入账号密码---->验证账号密码---->验证成功---->检查当前ip十否存在黑名单，存在则返回密码或账号错误，反之登入并录入sessionid
					|
					|
					|
				登录错误3次---->验证当前ip与上次登录成功ip是否一致---->相同锁定账户5分钟（自己密码都记不住，给你5分钟时间回忆）
					|
					|
			与上次登录成功ip不一致---->将当前ip加入黑名单（ip多算你厉害）