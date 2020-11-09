<div id="<?php echo $this->name; ?>"></div>
<script type="text/javascript">
KoolReport.widget.init(<?php echo json_encode($this->getResources()); ?>,function(){
    <?php echo $this->name; ?> = new KoolReport.d3.C3Chart(<?php echo \koolreport\core\Utility::jsonEncode($settings); ?>);
    <?php $this->clientSideReady(); ?>
});
</script>