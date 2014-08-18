<!--上传品牌更新表格-->
<div class="row-fluid">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-align-justify"></i>
                </span>
                <h5>上传品牌相关文件</h5>
            </div>
            <div class="widget-content nopadding">
                <form action="/brand/deal"
                      method="post"
                      class="form-horizontal"
                      enctype="multipart/form-data"
                    >
                    <div class="control-group">
                        <label class="control-label">
                            文件
                        </label>

                        <div class="controls">
                            <input type="file"
                                   name="fileupload"
                                   id="fileupload"/>
                        </div>

                        <div class="form-actions">
                            <input type="submit" value="上传" class="btn btn-primary"/>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>