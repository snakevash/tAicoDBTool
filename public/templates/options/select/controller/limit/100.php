<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">
            <div class="widget-box">
                <div class="widget-title">
                    <span class="icon">
                        <i class="icon-th"></i>
                    </span>
                    <h5>最近上传遥控器</h5>
                </div>
                <div class="widget-content nopadding">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>英文名称</th>
                                <th>中文名称</th>
                                <th>品牌</th>
                                <th>设备</th>
                                <th>图片</th>
                                <th>是否有键盘</th>
                                <th>来源</th>
                                <th>上传日期</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                foreach($response as $i => $e){
                                    echo "
                                        <tr>
                                            <td>{$e['ControllerID']}</td>
                                            <td>{$e['ControllerName']}</td>
                                            <td>{$e['ControllerNameCN']}</td>
                                            <td>{$e['BrandName']}</td>
                                            <td>{$e['DeviceName']}</td>
                                            <td>{$e['ControllerImage']}</td>
                                            <td>{$e['HasNumberPad']}</td>
                                            <td>{$e['SourceFrom']}</td>
                                            <td>{$e['LastModAt']}</td>
                                        </tr>
                                    ";
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>