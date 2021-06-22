<!-- Add Task Modal Form HTML -->
<div class="modal fade" id="addTaskModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="frmAddTask">
                <div class="modal-header">
                    <h4 class="modal-title">
                        Add New Kind of Salary
                    </h4>
                    <button aria-hidden="true" class="close" data-dismiss="modal" type="button">
                        ×
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger" id="add-error-bag">
                        <ul id="add-task-errors">
                        </ul>
                    </div>
                    <div class="form-group">
                        <label>
                            userID
                        </label>
                        <input class="form-control" type="text" id="name" name="userID" required>
                        <label>
                            Thời gian
                        </label>
                        <input class="form-control" type="text" id="name" name="date" required>

                        <label>
                            Giờ điểm danh
                        </label>
                        <input class="form-control" type="text" id="name" name="timeAttend" required>
                    </div>
                    <!-- <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-danger btn-number form-control" data-type="minus"
                                    data-field="soluong">
                                    <span class="glyphicon glyphicon-minus"></span>
                                </button>
                            </span>
                            <input name="soluong" class="form-control input-number form-control" value="1" min="1"
                                max="10" type="text" id="soluong">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-success btn-number form-control" data-type="plus"
                                    data-field="soluong">
                                    <span class="glyphicon glyphicon-plus"></span>
                                </button>
                            </span>
                        </div>
                    </div> -->
                </div>
                <div class="modal-footer">
                    <input class="btn btn-default" data-dismiss="modal" type="button" value="Cancel">
                    <button class="btn btn-info" id="btn-add" type="button" value="add">
                        OK
                    </button>
                    </input>
                </div>
            </form>
        </div>
    </div>
</div>
