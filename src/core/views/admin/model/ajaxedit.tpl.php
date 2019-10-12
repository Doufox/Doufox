<?php include $this->admin_view('header'); ?>
<?php include $this->admin_view('navbar'); ?>

<div class="container">
    <div class="list-group page_menu">
        <a class="list-group-item" href="<?php echo url('admin/model/index', array('typeid' => $typeid)); ?>">模型管理</a>
        <a class="list-group-item" href="<?php echo url('admin/model/fields/', array('typeid' => $typeid, 'modelid' => $modelid)); ?>">字段管理</a>
    </div>
    <div class="page_content">
        <form method="post" action="" class="form-inline">
            <div class="panel panel-default">
                <div class="panel-heading">基础字段编辑</div>
                <div class="panel-body">
                    <table width="100%" class="table_form">
                        <tr>
                            <th width="100">模型名称：</th>
                            <td><?php echo $name; ?></td>
                        </tr>
                        <tr>
                            <th>
                                <font color="red">*</font> 字段别名：
                            </th>
                            <td><input class="form-control" type="text" name="data[name]" value="<?php echo $data['name']; ?>" size="20" />
                                <div class="show-tips">例如：标题。</div>
                            </td>
                        </tr>
                        <tr>
                            <th>是否显示：</th>
                            <td>
                                <label class="label-group"><input type="radio" <?php if ($data['show']) { ?>checked<?php } ?> value="1" name="data[show]">显示</label>
                                <label class="label-group"><input type="radio" <?php if (empty($data['show'])) { ?>checked<?php } ?> value="0" name="data[show]">隐藏</label>
                            </td>
                        </tr>
                    </table>
                    <hr />
                    <button class="btn btn-default btn-sm" type="submit" name="submit" id="submit" value="提交">提交</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php include $this->admin_view('footer'); ?>