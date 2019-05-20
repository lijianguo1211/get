# get
2018/4/20创建首个项目


git 工作流

基于master分支创建一个新的本地分支

```git
git checkout -b feature-test-jayli master
```

添加功能

添加到缓存区

```git
git add .
```

添加本次提交的备注

```git
git commit -m 'bug修改'
```

切换到测试分支

```git
git checkout develop
```

拉取远程的测试develop分支

```git
git fetch origin develop
```

合并最新的线上的测试分支develop

```git
git merge origin/develop
```

合并功能到develop测试分支

```git
git merge feature-test-jayli
```

推送合并后的测试分支develop到远端

```git
git push origin develop
```