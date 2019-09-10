### webpack 打包scss结尾的文件，过滤css的一些属性

* 在laravel框架中，使用scss文件编写css的时候，利用css的属性控制字体的样式属性，有时候会打包失败，也不是打包失败，是打包成功，但是它会过滤掉一些
css属性，比如：

```css
.add {
    -webkit-box-orient: vertical;
    display:-webkit-box;
}
```
这个属性，在打包的时候就会过滤掉，scss文件有，但是打包之后的文件就没有这个属性了，在这个时候，一个比较简单的解决的办法就是在scss文件中，对不被打包
的属性添加注释，如下面这样：

```css
.add {
    /* autoprefixer: off */
    -webkit-box-orient: vertical;
    display:-webkit-box;
    /* autoprefixer: on */
}
```

这个时候，对已经添加被上下注释的代码，就不会被打包压缩，是默认展示的，这样最后在已经打包的文件中就会有这个被过滤的属性