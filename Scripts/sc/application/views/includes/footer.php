    <footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b>CECAITRA</b> Sistema de Administración | Versión 7.10.2
        </div>
        <strong>&copy; <a href="<?= base_url(); ?>">CECAITRA, </a>2017-<?= date('Y'); ?> </strong> Todos los derechos reservados.
    </footer>
    
    <script src="<?= base_url('assets/bootstrap/js/bootstrap.min.js'); ?>" type="text/javascript"></script>
    <script src="<?= base_url('assets/dist/js/app.min.js'); ?>" type="text/javascript"></script>

    <script src="<?= base_url('assets/js/jquery.validate.js'); ?>" type="text/javascript"></script>
    <script src="<?= base_url('assets/js/validation.js'); ?>" type="text/javascript"></script>
    <script src="<?= base_url('assets/js/jquery.PrintArea.js'); ?>" type="text/javascript"></script>
    <script src="<?= base_url('assets/js/validator.js'); ?>"></script>
    <script src="<?= base_url('assets/js/select2/dist/js/select2.full.min.js'); ?>" type="text/javascript"></script>
    <script src="<?= base_url('assets/js/fullcalendar_340.min.js'); ?>" type="text/javascript"></script>
    <script src="<?= base_url('assets/js/fullcalendar_340-local-es.js'); ?>" type="text/javascript"></script>
    
    <script src="<?= base_url('assets/plugins/datepicker/bootstrap-datepicker.js'); ?>" type="text/javascript"></script>
    <script src="<?= base_url('assets/plugins/datepicker/locales/bootstrap-datepicker.es.js'); ?>" type="text/javascript"></script>
  	<script src="<?= base_url('assets/plugins/timepicker/bootstrap-timepicker.min.js'); ?>" type="text/javascript"></script>
  	<script src="<?= base_url('assets/plugins/bootstrap-select/dist/js/bootstrap-select.min.js'); ?>" type="text/javascript"></script>
  	<script src="<?= base_url('assets/plugins/moment/moment.js'); ?>"></script>
    <script src="<?= base_url('assets/plugins/dateformat/date.format.min.js'); ?>"></script>
  	<script src="<?= base_url('assets/plugins/dateformat/locales/es.js'); ?>"></script>
    <script src="<?= base_url('assets/plugins/datatables.net/js/jquery.dataTables.min.js'); ?>"></script>
    <script src="<?= base_url('assets/plugins/datatables.net-bs/js/dataTables.bootstrap.min.js'); ?>"></script>
	  <script src="<?= base_url('assets/plugins/chartjs/Chart.min.js'); ?>"></script>
	  <script src="<?= base_url('assets/plugins/bootstrap-toggle/bootstrap-toggle.min.js'); ?>"></script>
    <script src="<?= base_url('assets/plugins/input-mask/jquery.inputmask.js'); ?>"></script>
    <script src="<?= base_url('assets/plugins/input-mask/jquery.inputmask.date.extensions.js'); ?>"></script>
    <script src="<?= base_url('assets/plugins/input-mask/jquery.inputmask.extensions.js'); ?>"></script>

    <script type="text/javascript">
        var windowURL = window.location.href;
        pageURL = windowURL.substring(0, windowURL.lastIndexOf('/'));
        var x= $('a[href="'+pageURL+'"]');
            x.addClass('active');
            x.parent().addClass('active');
        var y= $('a[href="'+windowURL+'"]');
            y.addClass('active');
            y.parent().addClass('active');
    </script>
  </body>
</html>
