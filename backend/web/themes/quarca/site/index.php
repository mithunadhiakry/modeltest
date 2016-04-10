<?php
        $this->registerJsFile($this->theme->baseUrl."/vendor/js/required.min.js", ['depends' => [\yii\web\JqueryAsset::className()]]); 
        $this->registerJsFile($this->theme->baseUrl."/assets/js/quarca.js", ['depends' => [\yii\web\JqueryAsset::className()]]); 

        $this->registerJsFile($this->theme->baseUrl."/vendor/plugins/others/underscore/underscore-min.js", ['depends' => [\yii\web\JqueryAsset::className()]]); 
        $this->registerJsFile($this->theme->baseUrl."/vendor/jqueryui/jquery-ui.min.js", ['depends' => [\yii\web\JqueryAsset::className()]]); 
        $this->registerJsFile($this->theme->baseUrl."/vendor/jqueryui/jquery.ui.touch-punch.min.js", ['depends' => [\yii\web\JqueryAsset::className()]]); 
        $this->registerJsFile($this->theme->baseUrl."/vendor/plugins/ui/gridstack/gridstack.min.js", ['depends' => [\yii\web\JqueryAsset::className()]]);
         
        $this->registerJsFile($this->theme->baseUrl."/vendor/plugins/ui/fittext/jquery.fittext.js", ['depends' => [\yii\web\JqueryAsset::className()]]); 

        $this->registerJsFile($this->theme->baseUrl."/vendor/plugins/charts/flot/jquery.flot.min.js", ['depends' => [\yii\web\JqueryAsset::className()]]); 
        $this->registerJsFile($this->theme->baseUrl."/vendor/plugins/charts/flot/jquery.flot.resize.min.js", ['depends' => [\yii\web\JqueryAsset::className()]]);
        $this->registerJsFile($this->theme->baseUrl."/vendor/plugins/charts/flot/jquery.flot.tooltip.min.js", ['depends' => [\yii\web\JqueryAsset::className()]]); 
        $this->registerJsFile($this->theme->baseUrl."/vendor/plugins/charts/flot/jquery.flot.pie.min.js", ['depends' => [\yii\web\JqueryAsset::className()]]); 
        $this->registerJsFile($this->theme->baseUrl."/vendor/plugins/charts/flot/jquery.flot.time.min.js", ['depends' => [\yii\web\JqueryAsset::className()]]); 

        $this->registerJsFile($this->theme->baseUrl."/assets/js/init/init.dashboard-new.js", ['depends' => [\yii\web\JqueryAsset::className()]]);  

?>
<?php
/* @var $this yii\web\View */

$this->title = 'Dashboard';



?>