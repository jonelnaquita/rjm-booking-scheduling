<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="col-12 destination">
            <p class="destination-route">Cubao &gt; Baguio</p>
        </div>
        <div class="col-12 details">
            <div class="detail-item">
                <span id="bus-type">Regular Aircon (EXPRESS)</span> | <span id="seaters">49 Seaters</span> | Total Passengers: <span id="total-passengers">3</span>
            </div>
        </div>
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="seat-grid">
                        <!-- Driver Seat -->
                        <div class="seat driver-seat">Driver</div>
                        <div class="seat"></div>
                        <div class="seat conductor-seat">Conductor</div>
                        <div class="seat"></div>

                        <!-- Row 1 -->
                        <div class="seat-row row">
                            <div class="seat-pair">
                                <label class="seat">
                                    <input type="checkbox" name="seat" value="1">
                                    <span class="seat-number">1</span>
                                </label>
                                <label class="seat">
                                    <input type="checkbox" name="seat" value="2">
                                    <span class="seat-number">2</span>
                                </label>
                            </div>
                            <div class="seat-pair">
                                <label class="seat">
                                    <input type="checkbox" name="seat" value="3">
                                    <span class="seat-number">3</span>
                                </label>
                                <label class="seat">
                                    <input type="checkbox" name="seat" value="4">
                                    <span class="seat-number">4</span>
                                </label>
                            </div>
                        </div>

                        <!-- Row 2 -->
                        <div class="seat-row row">
                            <div class="seat-pair">
                                <label class="seat">
                                    <input type="checkbox" name="seat" value="5">
                                    <span class="seat-number">5</span>
                                </label>
                                <label class="seat">
                                    <input type="checkbox" name="seat" value="6">
                                    <span class="seat-number">6</span>
                                </label>
                            </div>
                            <div class="seat-pair">
                                <label class="seat">
                                    <input type="checkbox" name="seat" value="7">
                                    <span class="seat-number">7</span>
                                </label>
                                <label class="seat">
                                    <input type="checkbox" name="seat" value="8">
                                    <span class="seat-number">8</span>
                                </label>
                            </div>
                        </div>

                        <div class="seat-row row">
                            <div class="seat-pair">
                                <label class="seat">
                                    <input type="checkbox" name="seat" value="5">
                                    <span class="seat-number">9</span>
                                </label>
                                <label class="seat">
                                    <input type="checkbox" name="seat" value="6">
                                    <span class="seat-number">10</span>
                                </label>
                            </div>
                            <div class="seat-pair">
                                <label class="seat">
                                    <input type="checkbox" name="seat" value="7">
                                    <span class="seat-number">11</span>
                                </label>
                                <label class="seat">
                                    <input type="checkbox" name="seat" value="8">
                                    <span class="seat-number">12</span>
                                </label>
                            </div>
                        </div>

                        <!-- Row 11 (Last Row) -->
                        <div class="seat-row last-row">
                            <div class="seat-pair">
                                <label class="seat">
                                    <input type="checkbox" name="seat" value="45">
                                    <span class="seat-number">41</span>
                                </label>
                                <label class="seat">
                                    <input type="checkbox" name="seat" value="46">
                                    <span class="seat-number">42</span>
                                </label>
                            </div>
                            <div class="seat-pair">
                                <label class="seat">
                                    <input type="checkbox" name="seat" value="47">
                                    <span class="seat-number">43</span>
                                </label>
                                <label class="seat">
                                    <input type="checkbox" name="seat" value="48">
                                    <span class="seat-number">44</span>
                                </label>
                            </div>
                            <label class="seat">
                                <input type="checkbox" name="seat" value="49">
                                <span class="seat-number">45</span>
                            </label>
                        </div>
                    </div>
                    <div class="save-button-container">
                        <button class="btn btn-primary">Save</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="seat-status">
            <div class="status-item">
                <span class="color-box priority-seat"></span>
                <label>Priority Seats</label>
            </div>
            <div class="status-item">
                <span class="color-box booked-seat"></span>
                <label>Booked Seats</label>
            </div>
            <div class="status-item">
                <span class="color-box selected-seat"></span>
                <label>Selected Seats</label>
            </div>
            <div class="status-item">
                <span class="color-box available-seat"></span>
                <label>Available Seats</label>
            </div>
            <div class="status-item">
                <span class="color-box saved-seat"></span>
                <label>Saved Seats</label>
            </div>
        </div>


      </div>
    </div>
  </div>
</div>