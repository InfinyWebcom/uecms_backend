
    <div id="main">
        <div class="row">
            
            <div class="pt-3 pb-1" id="breadcrumbs-wrapper">
                <div class="container">
                    <div class="row">
                        <div class="col s12 m12 l12">
                            <h5 class="breadcrumbs-title mt-0 mb-0">
                                <span class="highlightedText"><?php echo $order['name'] ;?></span>
                            </h5>

                            <?php if($this->session->flashdata('success')): ?>
                                <div class="card-alert card green lighten-5 flashMsg">
                                    <div class="card-content green-text">
                                      <p><?php echo $this->session->flashdata('success'); ?></p>
                                    </div>
                                </div>
                            <?php elseif($this->session->flashdata('error')): ?>
                                <div class="card-alert card red lighten-5 flashMsg">
                                    <div class="card-content red-text">
                                      <p><?php echo $this->session->flashdata('error'); ?></p>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col s12">
                <div class="container">
                    <div class="section section-data-tables">
                        <div class="card">
                            <div class="card-content">
                                <p class="caption mb-0 p-0 col s12 m12 l12">
                                    Total cost of order is <span class="highlightedText">₹ <?php echo $totalCost; ?></span>
                                </p>
                                <br style="clear: both;" />
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-content">
                                
                                <table id="scroll-vert-hor222" class="display nowrap" style="table-layout: fixed;">
                                    <thead>
                                        <tr>
                                            <th>Item Name</th>
                                            <th>Quantity</th>
                                            <th>Rate</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($orderItems as $key => $value) { ?>
                                            <tr>
                                                <td><?php echo $value['item_name']; ?></td>
                                                <td><?php echo $value['quantity']; ?></td>
                                                <td>₹ <?php echo $value['rate']; ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                    <!-- <tfoot>
                                        <tr>
                                            <th>Item Name</th>
                                            <th>Quantity</th>
                                            <th>Rate</th>
                                        </tr>
                                    </tfoot> -->
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

