
    <div id="main">
        <div class="row">
            
        	<div class="pt-3 pb-1" id="breadcrumbs-wrapper">
                <div class="container">
                    <div class="row">
                        <div class="col s12 m12 l12">
                            <h5 class="breadcrumbs-title mt-0 mb-0">
                                <span class="highlightedText">
                                	<a href="<?php echo base_url(); ?>user/inventory">Inventory</a> > <?php echo $inventory['name']; ?> (Track Record)
                                </span>
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
                                <table class="display">
                                    <thead>
                                        <tr>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Contract</th>
                                            <th>Site</th>
                                            <th>Supervisor</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($track as $key => $value) { ?>
                                            <tr>
                                                <td><?php echo date("d/m/Y",strtotime($value['start_date'])); ?>
                                                    <?php if($value['status']=='assigned'){echo '<span class="purple badge" style="font-size: 12px;">current</span>';} ?>
                                                </td>
                                                <td><?php echo date("d/m/Y",strtotime($value['end_date'])); ?></td>
                                                <td><?php echo $value['c_title'];?></td>
                                                <td><?php echo $value['s_title'];?></td>
                                                <td><?php echo ucwords($value['username']);?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


