<!--/**
 * Created by IntelliJ IDEA.
 * User: sachin
 * Date: 5/3/2016
 * Time: 10:57 PM
 */-->
<div id="changePasswordModal" class="modal fade" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" id = "changePasswordClose" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Change Password</h4>
            </div>
            <div class="modal-body">
                <div class="col-xs-4">
                    <label for="oldPassword">Old Password</label>
                    <input type="password" placeholder="Old Password" name="oldPassword" id="oldPassword" class="form-control"/></br>
                </div>
                <div class="col-xs-4">
                    <label for="newPassword">New Password</label>
                    <input type="password" placeholder="New Password" name="newPassword" id="newPassword" class="form-control"/><br>
                </div>
                <div class="col-xs-4">
                    <label for="newPassword">Repeat Password</label>
                    <input type="password" placeholder="Repeat Password" name="repeatPassword" id="repeatPassword" class="form-control"/><br>
                </div>
            </div>
            <br><br><br>
            <div class="modal-footer">
                <input type="submit" value="Change"  class="btn btn-primary" onclick="changePassword()"/>
            </div>
        </div>
    </div>
</div>