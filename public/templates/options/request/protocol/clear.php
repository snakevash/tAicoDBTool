<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">
            <div class="widget-box">
                <div class="widget-title">
                    <span class="icon">
                        <i class="icon-th"></i>
                    </span>
                    <h5>清理多余的协议关系</h5>
                </div>
                <div class="widget-content nopadding">
                    <?php
                        foreach($response as $unit){
                            foreach($unit as $line){
                                echo $line . "</br>";
                            }
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>