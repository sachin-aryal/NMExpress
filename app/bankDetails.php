    <div id="bankDetail<?php echo $payment["id"];?>" class="modal fade" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" id = "bankDetailClose" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Receiver Bank Details</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-4">
                        <label for="account_name">Account Name</label>
                        <p id = "account_name"><?php echo $payment["account_name"];?></p>
                    </div>
                    <div class="col-xs-4">
                        <label for="account_no">Account Number</label>
                        <p id = "account_no"><?php echo $payment["account_no"];?></p>
                    </div>
                    <div class="col-xs-4">
                        <label for="bank_name">Bank Name</label>
                        <p id = "bank_name"><?php echo $payment["bank_name"];?></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-4">
                        <label for="branch_name">Branch Name</label>
                        <p id = "branch_name"><?php echo $payment["branch_name"];?></p>
                    </div>
                    <div class="col-xs-4">
                    </div>
                    <div class="col-xs-4">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>