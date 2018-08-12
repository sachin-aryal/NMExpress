<?php
/**
 * Created by IntelliJ IDEA.
 * User: sachin
 * Date: 5/20/2016
 * Time: 11:00 AM
 */

?>
<div id="editSubscriberDiv" class="modal fade" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" id = "editSubscriberClose" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Edit Subscriber</h4>
            </div>
            <div class="modal-body">
                <div class="col-lg-8">
                    <input type="hidden" name="subscriberId" id="subscriberId"/>
                    <label for="emailAddress">Email Address</label>
                    <input type="email" name="emailAddress" id="emailAddress" class="form-control"/>
                </div>
            </div>
            <br><br><br>
            <div class="modal-footer">
                <input type="submit" value="Update"  class="btn btn-primary" onclick="editSubscriber()"/>
            </div>
        </div>
    </div>
</div>
