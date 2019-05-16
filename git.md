创建新分支并切换  git checkout -b develop

把新创建的分支推送到远端，云端不存在新创建的分支  git push origin develop

新建分支与远程分支做关联 git checkout -b develop origin/develop

查看当前远程分支 git branch -a | git branch -r

创建分支test git branch test 

查看分支 git branch


### 工作流

* 基于master分支新创建一个本地工作分支

```git
git checkout -b bug-test-jayli master
```

 
