<?php
//Show error messages
if(isset($_GET["msgError"])):
    $msgError = $_GET["msgError"];
    ?>
    <script type="text/javascript">
        $(document).ready(function() {
            noty({layout:'topRight', type: 'error', text: <?="'".addslashes($msgError)."'";?>, timeout: 6000});
        });
    </script>
<?php endif; ?>

<?php
//Show information messages
if(isset($_GET["msgInformation"])):
    $msgInformation = $_GET["msgInformation"];
    ?>
    <script type="text/javascript">
        $(document).ready(function() {
            noty({layout:'topRight', type: 'information', text: <?="'".addslashes($msgInformation)."'";?>, timeout: 6000});
        });
    </script>
<?php endif; ?>

<?php
//Show success messages
if(isset($_GET["msgSuccess"])):
    $msgSuccess = $_GET["msgSuccess"];
?>
    <script type="text/javascript">
        $(document).ready(function() {
            noty({layout:'topRight', type: 'success', text: <?="'".addslashes($msgSuccess)."'";?>, timeout: 6000});
        });
    </script>
<?php endif; ?>
