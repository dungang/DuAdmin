<div class="col-md-4 col-xs-12">
    <div class="box box-default">
        <div class="box-header with-border">
            <h1 class="box-title"><i class="fa fa-info-circle"></i> 系统信息</h1>
        </div>
        <div class="box-body">
            <table class="table table-bordered table-striped">
                <tr>
                    <th>CMS版本</th>
                    <td> <?= Yii::$app->version ?>&nbsp;&nbsp;&nbsp;
                        <a href="http://www.vintcms.com" target="_blank">
                            发现新版本
                        </a>&nbsp;&nbsp;&nbsp;&nbsp;
                    </td>
                </tr>
                <tr>
                    <th>Yii2版本</th>
                    <td><?= Yii::getVersion() ?></td>
                </tr>
                <tr>
                    <th>时区</th>
                    <td><?= Yii::$app->timeZone ?></td>
                </tr>
                <tr>
                    <th>服务器操作系统</th>
                    <td><?= PHP_OS ?></td>
                </tr>
                <tr>
                    <th>PHP版本</th>
                    <td><?= PHP_VERSION ?></td>
                </tr>
                <tr>
                    <th>MYSQL版本</th>
                    <td><?= Yii::$app->db->pdo->getAttribute(PDO::ATTR_SERVER_VERSION) ?></td>
                </tr>
                <tr>
                    <th>运行环境</th>
                    <td><?= $_SERVER['SERVER_SOFTWARE'] ?></td>
                </tr>
                <tr>
                    <th>上传限制</th>
                    <td><?= ini_get('upload_max_filesize') ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>