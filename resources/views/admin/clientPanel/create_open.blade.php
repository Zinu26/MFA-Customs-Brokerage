<button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#exampleModal"><i
        class="fas fa-truck-ramp-box"></i><span class="sr-only"> ADD SHIPMENT</span></button>

<!--Add modal-->
<div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header mbc3" style="background-color: #4EA646">
                <h5 class="modal-title">ADD SHIPMENT</h5>
                <a style="cursor: pointer;" data-bs-dismiss="modal"><i class="fa fa-xmark"></i></a>
            </div>
            <form
                action="@if (Auth::user()->type == 'admin') {{ route('add_shipment') }} @elseif(Auth::user()->type == 'employee'){{ route('add_shipment.employee') }} @endif"
                method="POST">
                @csrf
                <div class="modal-body">
                    <div class="input-group">
                        <input type="hidden" name="consignee_name" value="{{ $consignee->user->name }}"
                            class="form-control" readonly>
                    </div></br>
                    <div class="input-group">
                        <span class="input-group-text w-25 text-white text-center"
                            style="background-color: #4EA646; font-weight: 600;">Item Description</span>
                        <input type="text" name="item_description" placeholder="Item Description"
                            aria-label="item_description" class="form-control" required>
                    </div></br>
                    <div class="input-group">
                        <span class="input-group-text w-25 text-white text-center"
                            style="background-color: #4EA646; font-weight: 600;">Size</span>
                        <input type="text" name="size" placeholder="Size" aria-label="Size" class="form-control"
                            required>

                        <span class="input-group-text w-25 text-white text-center"
                            style="background-color: #4EA646; font-weight: 600;">Weight</span>
                        <input type="number" name="weight" placeholder="Weight" aria-label="Weight"
                            class="form-control" required>
                    </div></br>
                    <div class="input-group">
                        <span class="input-group-text w-25 text-white text-center"
                            style="background-color: #4EA646; font-weight: 600;">BL Number</span>
                        <input type="text" name="BL_number" placeholder="BL Number" aria-label="BL Number"
                            class="form-control" required>

                        <span class="input-group-text w-25 text-white text-center"
                            style="background-color: #4EA646; font-weight: 600;">Entry Number</span>
                        <input type="text" name="entry_number" placeholder="Entry Number" aria-label="Entry Number"
                            class="form-control" required>
                    </div></br>
                    <div class="input-group">
                        <span class="input-group-text w-25 text-white text-center"
                            style="background-color: #4EA646; font-weight: 600;">Shipping Line</span>
                        <select name="shipping_line" class="form-control" required onchange="showOtherInput(this)">
                            <option value="">Select a shipping line</option>
                            <?php
                            // assuming you have an array of shipping lines called $shipping_lines
                            foreach ($shipping_lines as $line) {
                                echo '<option value="' . $line . '">' . $line . '</option>';
                            }
                            ?>
                            <option value="other">Other</option>
                        </select>
                        <input type="text" name="other_shipping_line" placeholder="Other Shipping Line"
                            aria-label="Other Shipping Line" class="form-control d-none">
                    </div></br>
                    <div class="input-group">
                        <span class="input-group-text w-25 text-white text-center"
                            style="background-color: #4EA646; font-weight: 600;">Arrival Date</span>
                        <input type="date" name="arrival_date" placeholder="Arrival Date" aria-label="Arrival Date"
                            class="form-control" required>
                    </div></br>
                    <div class="input-group">
                        <span class="input-group-text w-25 text-white text-center"
                            style="background-color: #4EA646; font-weight: 600;">Port of Origin</span>
                        <select class="form-control" id="exampleFormControlSelect1" name="port_of_origin">
                            <option value="" disabled selected>---Select---</option>
                            <option value="MANILA NORTH PORT, PHILIPPINES">MANILA NORTH PORT, PHILIPPINES</option>
                            <option value="MANILA SOUTH PORT, PHILIPPINES">MANILA SOUTH PORT, PHILIPPINES</option>
                        </select>
                    </div></br>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="exampleFormControlSelect1">Shipment Status</label>
                            <select class="form-control" id="exampleFormControlSelect1" name="shipment_status">
                                <option value="" disabled selected>---Select---</option>
                                <option value="AG">AG</option>
                                <option value="AS">AS</option>
                                <option value="AP">AP</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="exampleFormControlSelect1">DO Status</label>
                            <select class="form-control" id="exampleFormControlSelect1" name="do_status">
                                <option value="" disabled selected>---Select---</option>
                                <option value="Pending">Pending</option>
                                <option value="On Going">On Going</option>
                                <option value="Done">Done</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="exampleFormControlSelect1">Billing Status</label>
                            <select class="form-control" id="exampleFormControlSelect1" name="billing_status">
                                <option value="" disabled selected>---Select---</option>
                                <option value="Pending">Pending</option>
                                <option value="On Going">On Going</option>
                                <option value="Done">Done</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="add_shipment" class="btn btn-success">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function showOtherInput(select) {
        var otherInput = document.getElementsByName("other_shipping_line")[0];
        if (select.value === "other") {
            otherInput.classList.remove("d-none");
            otherInput.setAttribute("required", true);
        } else {
            otherInput.classList.add("d-none");
            otherInput.removeAttribute("required");
        }
    }
</script>
