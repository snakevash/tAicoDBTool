<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">
            <div class="widget-box">
                <div class="widget-title">
                    <span class="icon">
                        <i class="icon-th"></i>
                    </span>
                    <h5>最近上传品牌</h5>
                </div>
                <div class="widget-content nopadding">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>品牌英文名称</th>
                            <th>品牌中文名称</th>
                            <th>设备英文名称</th>
                            <th>设备中文名称</th>
                            <th>上传日期</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            foreach($response as $i => $e){
                                echo "
                                    <tr>
                                        <td>{$e['BrandID']}</td>
                                        <td>{$e['BrandName']}</td>
                                        <td>{$e['DisplayNameCN']}</td>
                                        <td>{$e['DeviceName']}</td>
                                        <td>{$e['DisplayNameCNDevice']}</td>
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