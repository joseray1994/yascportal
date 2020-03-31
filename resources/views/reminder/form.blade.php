<form id="formReminder" class="form-row" style = "hidden:true">
    <div class="form-group col-sm-12">
        <label>Reminder</label>
        <textarea name="reminder" id="reminder" rows="4" class="form-control"></textarea>
    </div>
    <div class="form-group col-sm-12">
        <label>Assign</label>
    </div>
    <div class="form-group col-sm-6">
        <label>Clients</label>
        <select name="clients" id="clients" class="form-control"></select>
    </div>
    <div class="form-group col-sm-6">
        <label>Operators</label>
        <select name="operators" id="operators" class="form-control"></select>
    </div>
    <div class="form-group col-sm-6">
        <label>Start Date</label>
        <input type="date" id="start_date" name="startSearch" class="form-control">
    </div>
    <div class="form-group col-sm-6">
        <label>End Date</label>
        <input type="date" id="end_date" name="endSearch" class="form-control">
    </div>

    <div class="form-group col-sm-12 text-center">
        <button type="button" class="btn btn-danger" id="btn-cancel">Cancel</button>
        <button type="submit" class="btn btn-success" id="btn-save" value="add">Save</button>
    </div>
</form>