
    <div class="footer">
        <div class="container">
            <div class="text-muted pull-left">
                <p>
                    <span>&copy;&nbsp;CopyRight <?php echo date('Y'); ?>&nbsp;<?php echo ucfirst(APP_NAME); ?> All Rights Reserved.</span>
                    <span>Powered by <a href="https://crogram.com" target="_blank">Crogram</a>.</span>
                    <span>=<?php echo $app_execution_time; ?>=</span>
                </p>
            </div>
            <div class="text-muted pull-right">
                <a href="http://www.beian.miit.gov.cn" target="_blank">豫ICP备14006598号</a>
            </div>
        </div>
    </div>
</div>
<script src="static/js/jquery.min.js"></script>
<script src="static/bootstrap/js/bootstrap.min.js"></script>
<?php echo doHookAction('view_footer'); ?>

</body>
</html>