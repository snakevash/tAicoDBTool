<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">
            <div class="widget-box">
                <div class="widget-title">
                    <span class="icon">
                        <i class="icon-th-list"></i>
                    </span>
                    <h5>导入品牌成功</h5>
                </div>
                <div class="widget-content">
                    <?php
                    foreach($response as $group){
                        foreach($group as $line){
                            echo $line;
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>