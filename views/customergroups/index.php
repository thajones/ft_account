<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <?php include HOME . DS . 'includes' . DS . 'menu.inc.php'; ?>
    <div class="content-wrapper">
      <section class="content">
        <div class="container-fluid pb-5">
          <div class="row mt-3">
            <div class="col-12">
              <div class="card card-primary card-outline card-outline-tabs">
                <div class="card-header p-0 border-bottom-0">
                  <ul
                    class="nav nav-tabs"
                    id="custom-tabs-four-tab"
                    role="tablist"
                  >
                    <li class="nav-item">
                      <a
                        class="nav-link active"
                        id="customergroup_tab"
                        data-toggle="pill"
                        href="#customergroup"
                        role="tab"
                        aria-controls="customergroup"
                        aria-selected="true"
                      >
                        Customer Group
                      </a>
                    </li>
                    <li class="nav-item">
                      <a
                        class="nav-link"
                        id="customer_tab"
                      >
                        Customer
                      </a>
                    </li>
                    <li class="nav-item">
                      <a
                        class="nav-link"
                        id="customer_tab"
                      >
                        Company
                      </a>
                    </li>
                  </ul>
                </div>
                <div class="card-body">
                  <div class="tab-content" id="custom-tabs-four-tabContent">
                    <div
                      class="tab-pane fade show active"
                      id="customergroup"
                      role="tabpanel"
                      aria-labelledby="customergroup_tab"
                    >
                      <form method="post" id="customergroup">
                        <div class="row">
                          <div class="col-sm-12 col-lg-5 form-group">
                            <label for="id_group_id"></label>
                            <input
                              type="text"
                              class="form-control ftsm"
                              required=""
                              name="name"
                              id="id_group_id"
                            />
                          </div>
                          <div class="col-sm-12 col-lg-3 pt-2">
                            <div class="btn-group">
                              <button
                                type="submit"
                                id="add"
                                class="btn btn-default"
                              >
                                Add
                              </button>
                              <button
                                type="submit"
                                id="update"
                                style="display: none"
                                class="btn btn-default"
                              >
                                Update
                              </button>
                              <button
                                type="reset"
                                id="cancel"
                                class="btn btn-default"
                              >
                                Cancel
                              </button>
                            </div>
                          </div>
                        </div>
                      </form>
                      <table
                        id="customergroup_list"
                        class="table table-striped"
                      >
                        <thead>
                          <tr>
                            <th>ID</th>
                            <th>Customer Group</th>
                            <th style="width: 100px"></th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php if($customergroups && count($customergroups)) : 
                                  foreach ($customergroups as $groups) :
                            ?>
                          <tr>
                            <td
                              class="id customer"
                              data-id="<?php echo $groups['id']?>"
                            >
                              <?php echo $groups['id']?>
                            </td>
                            <td
                              class="name customer"
                              data-id="<?php echo $groups['id']?>"
                            >
                              <?php echo $groups['name']?>
                            </td>
                            <td>
                              <button
                                type="button"
                                class="btn btn-primary btn-sm groupy"
                                data-id="<?php echo $groups['id']?>"
                                data-name="<?php echo $groups['name']?>"
                              >
                                Edit
                              </button>
                            </td>
                          </tr>
                          <?php endforeach; endif; ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <button
          type="button"
          id="modelactivate"
          style="display: none"
          data-toggle="modal"
          data-target="#modal-default"
        ></button>
        <div class="modal fade" id="modal-default">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <div class="modal-title">Customers</div>
                <button
                  type="button"
                  class="close"
                  data-dismiss="modal"
                  aria-label="Close"
                >
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body p-0">
                <table class="table mb-0" id="customerbody"></table>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
    <?php include HOME . DS . 'includes' . DS . 'footer.inc.php'; ?>
  </div>
</body>
