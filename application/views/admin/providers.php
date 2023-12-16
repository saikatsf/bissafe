                  <div class="content-wrapper">
                    <div class="row">
                      <div class="col-sm-12">
                        <div class="home-tab">

                            <div class="col-lg-12 grid-margin stretch-card">
                                <div class="card">
                                  <div class="card-body">
                                    <h4 class="card-title">Service Providers List</h4>
                                    <div class="table-responsive">
                                      <table class="table table-hover" id="myTable">
                                        <thead>
                                          <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Business Name</th>
                                            <th>Business Type</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                          <?php
                                            foreach($providers as $provider){
                                          ?>
                                              <tr>
                                                <td><?php echo $provider['full_name']?></td>
                                                <td><?php echo $provider['email']?></td>
                                                <td><?php echo $provider['business_name']?></td>
                                                <td>
                                                  <?php if($provider['business_type'] == 0): ?>
                                                    Construction
                                                  <?php elseif($provider['business_type'] == 1): ?>
                                                    Non-Construction
                                                  <?php elseif($provider['business_type'] == 2): ?>
                                                    Both
                                                  <?php endif; ?>
                                                </td>
                                                <td>
                                                  <?php if($provider['provider_status'] == 0): ?>
                                                          <button class="btn btn-secondary btn-rounded btn-fw">Inactive</button>
                                                  <?php elseif($provider['provider_status'] == 1): ?>
                                                          <button class="btn btn-info btn-rounded btn-fw">Active</button>
                                                  <?php elseif($provider['provider_status'] == 2): ?>
                                                          <button class="btn btn-danger btn-rounded btn-fw">Rejected</button>
                                                  <?php endif; ?>
                                                </td>
                                                <td>
                                                  <div class="btn-group">
                                                    <button type="button" class="btn btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Action
                                                    </button>
                                                    <div class="dropdown-menu">
                                                      <?php if($provider['provider_status'] == 0){ ?>
                                                        <a class="dropdown-item" href="<?php echo base_url(); ?>admin/changeProviderStatus/<?php echo $provider['id']?>/1">Activate</a>
                                                        <div class="dropdown-divider"></div>
                                                        <a class="dropdown-item" href="<?php echo base_url(); ?>admin/changeProviderStatus/<?php echo $provider['id']?>/2">Reject</a>
                                                      <?php }else{ ?>
                                                        <a class="dropdown-item" href="<?php echo base_url(); ?>admin/changeProviderStatus/<?php echo $provider['id']?>/0">Deactivate</a>
                                                      <?php } ?>
                                                    </div>
                                                  </div>
                                                </td>
                                              </tr>
                                          <?php
                                            }
                                          ?>
                                        </tbody>
                                      </table>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            
                        </div>
                      </div>
                    </div>
                  </div>

        

