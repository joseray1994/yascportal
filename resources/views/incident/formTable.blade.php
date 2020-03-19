<div class="card" id="incidentReport" style="display:none;">
                       <div class="card-body">
                            <div class="row">
                                <div class="col-sm-4">
                                    <form id="formIncident" class="form-row">

                                        <div class="form-group col-sm-6">
                                            <h4 id="labelTimer">00:00:00</h4>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <h4 id="labelDate"></h4>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label>Reason</label>
                                            <select name="id_setting" id="id_setting" class="form-control"></select>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label>Supervisor</label>
                                            <select name="id_supervisor" id="id_supervisor" class="form-control"></select>
                                        </div>
                                        <div class="form-group col-sm-12">
                                            <label>Note</label>
                                            <textarea name="note" id="note" rows="4" class="form-control"></textarea>
                                        </div>
                                        <div class="form-group col-sm-12 text-center">
                                            <button type="button" class="btn btn-danger" id="btn-cancel-incident">Cancel</button>
                                            <button type="submit" class="btn btn-success" id="btn-save-incident" value="add">Save</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-sm-8" >
                                    <legend>List</legend>
                                    <div class="row form-group">
                                        <div class="col-sm-4">
                                            <select name="filter_setting" id="filter_setting" class="form-control"></select>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="date" class="form-control" name="filter_start" id="filter_start">
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="date" class="form-control" name="filter_end" id="filter_end">
                                        </div>
                                    </div>
                                    <div style="max-height:65vh; overflow: scroll;">
                                    <table class="table table-striped text-center" id="table-incidents">
                                        <thead class="text-white thead-yasc">
                                            <tr>
                                                <th>Date</th>
                                                <th>Operator</th>
                                                <th>Reason</th>
                                                <th>Supervisor</th>
                                                <th>Total</th>
                                                <th>Start</th>
                                                <th>End</th>
                                                <th>Detail</th>
                                            </tr>
                                        </thead>
                                        <tbody id = 'incident-list'></tbody>
                                    </table>
                                    </div>
                                </div>
                            </div>
                       </div>
                    </div>