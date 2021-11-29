<?php

namespace DuAdmin\Widgets;

use yii\bootstrap\InputWidget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;

class SimpleUploader extends InputWidget
{
    public $width = "100%";

    public $height = "160";

    public $entityId;

    public $entityName;

    public $entityIdField='entityId';

    public $entityNameField = 'entityName';

    public $fileField = 'file';

    public $url = ['/attachment/admin/upload'];

    public $zoneClass = '';

    public $checkImageSize = false;

    public $imageSize = [
        'height'=>100,
        'width'=>100,
    ];

    public function run()
    {
        $baseUrl = \Yii::$app->request->baseUrl;
        $this->url = Url::to($this->url);
        if(empty($this->entityId)) {
            $this->entityId = 0;
        }

        $this->clientOptions['extraData'][$this->entityIdField]=$this->entityId;
        $this->clientOptions['extraData'][$this->entityNameField]=$this->entityName;
        $this->clientOptions['fileName'] = $this->fileField;
        $this->clientOptions['url'] = $this->url;
        if ($this->hasModel()) {
            $image = $this->model->{$this->attribute};
            $input = Html::activeHiddenInput($this->model, $this->attribute,$this->options);
        } else {
            $image = $this->value;
            $input = Html::hiddenInput($this->name, $this->value,$this->options);
        }

        if($this->checkImageSize) {
            $this->clientOptions['checkImageSize'] = true;
            $this->clientOptions['imageSize'] = $this->imageSize;
        }

        $this->clientOptions['onPreview'] = new JsExpression("
            function(imageData){
                this.find('div.simple-uploader-preview').each(function(){
                    var _this = $(this);
                    var image = $('<img height=\'100%\' width=\'100%\' />');
                    image.attr('src',imageData);
                    _this.empty().append(image);
                    _this.css({'border':'0'});
                });
            }
        ");

        $this->clientOptions['onUploadProgress'] = new JsExpression("
            function(percent){
                this.find('div.simple-uploader-process-bar').each(function(){
                    var _this = $(this);
                    _this.show();
                    _this.find('div.progress-bar').each(function(){
                        var span = $(this);
                        span.css({width: percent+'%'});
                    });
                });
            }
        ");

        $this->clientOptions['onUploadSuccess'] = new JsExpression("
            function(data){
                this.find('div.simple-uploader-process-bar').each(function(){
                    var _this = $(this);
                    _this.hide();
                    _this.find('div.progress-bar').each(function(){
                        var span = $(this);
                        span.css({width: '1%'});
                    });
                });
                var result = $.parseJSON(data);
                if (result.success) {
                    var url = result.url;
                    if (result.place == 'local') {
                        url = '$baseUrl' + '/'+ result.url;
                    }
                    $('#{$this->options['id']}').val(url);
                }
            }
        ");

        $this->registerPlugin('simpleUploader');
        $paddingTop = $this->height / 2 - 10;
        $processOptions = [
            'class'=>'simple-uploader-process-bar',
            'style'=>"display:none;position:absolute;top:0; padding: 0 20px; padding-top:{$paddingTop}px;left:0;height:{$this->height}px; width:{$this->width}px;",
        ];
        $processBar = Html::tag('div',
            "<div class=\"progress\">
              <div class=\"progress-bar progress-bar-info progress-bar-striped\" role=\"progressbar\" aria-valuenow=\"40\" aria-valuemin=\"0\" aria-valuemax=\"100\" style=\"width: 40%\">
                <span class=\"sr-only\">40% Complete (success)</span>
              </div>
            </div>",
            $processOptions);


        $previewBorder = '';
        if ($image) {
            $image = "<img src='$image' height='100%' width='100%'/>";
        } else {
            $previewBorder = "border: 1px dashed rgba(0, 0, 0, 0.3);";
            $image = "<i class=\"fa fa-plus\" style=\"line-height: {$this->height}px; color:#ccc;\"></i>";
        }

        $previewOptions = [
            'style'=>"$previewBorder text-align:center;height:{$this->height}px; width:{$this->width}px;",
            'class'=>"simple-uploader-preview",
        ];
        $preview = Html::tag('div',$image,$previewOptions);

        $zoneOptions['style']="position:relative;height:{$this->height}px; width:{$this->width}px; cursor:pointer";
        $zoneOptions['class']='simple-uploader-zone ' . $this->zoneClass;
        $zoneOptions['id'] = 'zone-' . $this->options['id'];
        return $input . Html::tag('div', $preview . $processBar, $zoneOptions);
    }
}